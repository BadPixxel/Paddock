<?php

/*
 *  Copyright (C) BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Paddock\Core\Services;

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack as Track;
use BadPixxel\Paddock\Core\Monolog\Handler\LocalHandler;
use Exception;
use Monolog\Logger;
use Symfony\Component\Process\Process;

/**
 * Paddock Tracks Runner Service.
 */
class TracksRunner
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var RulesManager
     */
    private $rules;

    /**
     * @var CollectorsManager
     */
    private $collectors;

    /**
     * @var LogManager
     */
    private $logger;

    /**
     * @var array<null|Process>
     */
    private $processes = array();

    /**
     * Tracks Runner Constructor.
     *
     * @param string            $env
     * @param RulesManager      $rules
     * @param CollectorsManager $collectors
     * @param LogManager        $logger
     */
    public function __construct(string $env, RulesManager $rules, CollectorsManager $collectors, LogManager $logger)
    {
        $this->environment = $env;
        $this->rules = $rules;
        $this->collectors = $collectors;
        $this->logger = $logger;
    }

    //====================================================================//
    // TRACKS RUNNER
    //====================================================================//

    /**
     * Execute a Single Rule Verification.
     *
     * @param null|Track $track
     * @param array      $ruleOptions
     *
     * @throws Exception
     *
     * @return LocalHandler
     */
    public function executeRule(?Track $track, array $ruleOptions): LocalHandler
    {
        //====================================================================//
        // Load Paddock Rule
        $rule = $this->rules->getByCode($ruleOptions["rule"]);
        //====================================================================//
        // Reset Local Logger
        $rule->getLogger()->reset();
        $rule->setContext($track ? $track->getDescription() : null, $ruleOptions["rule"], $ruleOptions["key"]);
        //====================================================================//
        // Load Value from Data Collector
        try {
            $value = $this->collectors
                ->getByCode($ruleOptions["collector"])
                ->setLogger($rule->getLogger())
                ->getData($ruleOptions["options"] ?? array(), $ruleOptions["key"])
            ;
        } catch (\Throwable $throwable) {
            $rule->getLogger()->log(Logger::EMERGENCY, $throwable->getMessage());

            return $rule->getHandler();
        }

        //====================================================================//
        // Execute Rule Validation
        $rule->execute($ruleOptions, $value);
        //====================================================================//
        // Add Counter Results to Logs
        if (is_scalar($value) && !empty($rule->getMetricName())) {
            $this->logger->incCounter($rule->getMetricName(), (int) $value, $rule->getMetricOptions());
        }

        return $rule->getHandler();
    }

    //====================================================================//
    // PROCESS RUNNER
    //====================================================================//

    /**
     * Execute a Single Rule Verification with Isolation.
     *
     * @param Track $track
     * @param array $ruleOptions
     *
     * @throws Exception
     *
     * @return LocalHandler
     */
    public function executeRuleIsolated(Track $track, array $ruleOptions): LocalHandler
    {
        //====================================================================//
        // Build Sub-Process
        $process = $this->buildProcess($track, $ruleOptions);
        //====================================================================//
        // Execute Sub-Process
        $process->run();
        //====================================================================//
        // Close Sub-Process
        return $this->closeProcess($process);
    }

    /**
     * Setup Number of Parallel Processes limited by Number of CPU on Current System
     *
     * @param null|int $nbProcess
     *
     * @return int
     */
    public function setupMaxProcess(?int $nbProcess): int
    {
        //====================================================================//
        // Get Total Number of CPU on Current System
        $nbCpu = (int) (
            (PHP_OS_FAMILY == 'Windows')
            ? ((int) getenv("NUMBER_OF_PROCESSORS") + 0)
            : substr_count((string) file_get_contents("/proc/cpuinfo"), "processor")
        );
        //====================================================================//
        // Get User Given Nb Process
        $nbProcess = $nbProcess ? (int) $nbProcess : $nbCpu;
        //====================================================================//
        // Init Processes Array
        $this->processes = array();
        for ($i = 0;$i < min($nbProcess, $nbCpu);$i++) {
            $this->processes[$i] = null;
        }

        return $nbProcess;
    }

    /**
     * Refresh Processes Status & Return Terminated Results
     *
     * @return null|LocalHandler
     */
    public function refreshProcesses(): ?LocalHandler
    {
        //====================================================================//
        // Close All Terminated Processes
        foreach ($this->processes as $index => $process) {
            //====================================================================//
            // Process is Empty or Running
            if (!$process || !$process->isTerminated()) {
                continue;
            }
            //====================================================================//
            // Process is Terminated
            $this->processes[$index] = null;

            return $this->closeProcess($process);
        }
        //====================================================================//
        // wait for the given time
        usleep(1000);

        return null;
    }

    /**
     * Try to Start a new Isolated Rule Verification
     *
     * @throws Exception
     *
     * @return bool true if Sub-Process Started
     */
    public function startRuleProcess(Track $track, ?array $ruleOption): bool
    {
        //====================================================================//
        // Use First Available Slot for Process
        foreach ($this->processes as $index => $process) {
            //====================================================================//
            // Process Slot is Available
            if (!$process && $ruleOption) {
                //====================================================================//
                // Start a New Process
                $this->processes[$index] = $this->buildProcess($track, $ruleOption);
                $this->processes[$index]->start();

                return true;
            }
        }

        return false;
    }

    /**
     * Get Number of Active Process
     *
     * @return int
     */
    public function countActiveProcesses(): int
    {
        return count(array_filter($this->processes));
    }

    //====================================================================//
    // PROCESS RUNNER PRIVATE
    //====================================================================//

    /**
     * Build Subprocess for Single Rule Verification.
     *
     * @param Track $track
     * @param array $ruleOptions
     *
     * @throws Exception
     *
     * @return Process
     */
    private function buildProcess(Track $track, array $ruleOptions): Process
    {
        //====================================================================//
        // Build Sub-Process Options
        $processOptions = array(
            // Get Current Php Script Binary
            PHP_BINARY,
            // Get Current Console
            filter_input(INPUT_SERVER, "SCRIPT_NAME") ?: "bin/console",
            // Paddock Command to Execute
            "paddock:runOne",
            // Paddock Options
            json_encode($ruleOptions),
            // Paddock Track
            (string) $track->getCode(),
            // Use Same Environment
            "--env=".$this->environment,
            // Include Infos
            "-vv",
            // Disable Debug
            "--no-debug"
        );
        //====================================================================//
        // Create Sub-Process
        return new Process($processOptions);
    }

    /**
     * End of Isolated Rule Verification.
     * - Collect Log records
     * - Collect Counters
     *
     * @param Process $process
     *
     * @return LocalHandler
     */
    private function closeProcess(Process $process): LocalHandler
    {
        //====================================================================//
        // Create Temporary Log Handler
        $handler = new LocalHandler();
        //====================================================================//
        // Process Failed
        if (!$process->isSuccessful()) {
            $this->logger->log(Logger::EMERGENCY, $process->getErrorOutput());
        }
        //====================================================================//
        // Import Results
        $results = json_decode($process->getOutput(), true);
        $results = is_array($results) ? $results : array();
        //====================================================================//
        // Import Records
        foreach ($results['logs'] ?? array() as $record) {
            $handler->handle($record);
        }
        //====================================================================//
        // Import Counter Results
        foreach ($results['counters'] ?? array() as $name => $value) {
            if (!is_scalar($value)) {
                continue;
            }
            $this->logger->incCounter(
                $name,
                (int) $value,
                $results['options'][$name] ?? array()
            );
        }

        return $handler;
    }
}
