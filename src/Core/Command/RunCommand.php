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

namespace BadPixxel\Paddock\Core\Command;

use BadPixxel\Paddock\Core\Models\Command\AbstractCommand;
use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack as Track;
use BadPixxel\Paddock\Core\Monolog\Handler\LocalHandler;
use Exception;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as Inputs;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as Outputs;
use Throwable;

/**
 * Run One or All Defined Tracks
 */
class RunCommand extends AbstractCommand
{
    /**
     * @var array[]
     */
    private $records = array();

    /**
     * @var int
     */
    private $warnings = 0;

    /**
     * @var int
     */
    private $errors = 0;

    /**
     * @var int
     */
    private $nbProcess = 0;

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:run')
            ->setDescription('Run One or All Defined Tracks')
            ->addArgument('track', InputArgument::OPTIONAL, 'Track Code to Execute')
            ->addOption(
                'process',
                'p',
                InputOption::VALUE_OPTIONAL,
                'Number of Parallel Processes',
                'auto'
            )
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Response Format')
        ;
    }

    /**
     * Execute Master Command.
     *
     * @param Inputs  $input
     * @param Outputs $output
     *
     * @throws Exception
     *
     * @return int
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(Inputs $input, Outputs $output): int
    {
        //====================================================================//
        // Init Paddock Command
        $this->init($input, $output);
        //====================================================================//
        // Setup Parallelization Mode
        /** @var scalar $nbProcess */
        $nbProcess = $input->getOption("process");
        $this->nbProcess = $this->runner->setupMaxProcess(
            ("auto" == $nbProcess) ? null : (int) $nbProcess
        );
        //====================================================================//
        // Execute Command in a Sandbox
        try {
            //====================================================================//
            // Detect Tracks to Execute
            $tracks = $this->getTracks($input);
            //====================================================================//
            // Run All Active Tracks
            foreach ($tracks as $track) {
                //====================================================================//
                // Run ONE Track
                $this->executeTrack($output, $track);
            }
        } catch (Throwable $throwable) {
            $this->error($throwable->getMessage());
        }
        //====================================================================//
        // Close Paddock Command
        return $this->close($input, $output);
    }

    /**
     * Load List of Tracks to Execute.
     *
     * @param Inputs $input
     *
     * @throws Exception
     *
     * @return Track[]
     */
    private function getTracks(Inputs $input): array
    {
        //====================================================================//
        // Detect Tracks to Execute
        $trackCode = $input->getArgument("track");
        if (!empty($trackCode) && ("all" != $trackCode)) {
            //====================================================================//
            // Run ONE Track
            if (!is_string($trackCode)) {
                $this->error("Track Code is not a string!");

                return array();
            }
            //====================================================================//
            // Load requested Track
            return array(
                $trackCode => $this->tracks->getByCode($trackCode)
            );
        }
        //====================================================================//
        // Run All Active Tracks
        $tracks = array();
        foreach ($this->tracks->getAll() as $trackCode => $track) {
            if ($track->isEnabled()) {
                $tracks[$trackCode] = $track;
            }
        }

        return $tracks;
    }

    /**
     * Verify All Rules of a Track.
     *
     * @param Outputs $output
     * @param Track   $track
     *
     * @throws Exception
     *
     * @return void
     */
    private function executeTrack(Outputs $output, Track $track): void
    {
        //====================================================================//
        // Init Track Checks
        $this->records = array();
        $this->warnings = $this->errors = 0;
        $progressBar = $this->initProgressBar($output, $track);
        //====================================================================//
        // Execute All Track Rules
        $iterator = $track->getRulesIterator();
        $iterator->rewind();
        while ($iterator->valid()) {
            switch ($this->nbProcess) {
                case 0:
                    //====================================================================//
                    // NO Process - Directly Execute Rule Validation
                    $testHandler = $this->runner->executeRule($track, $iterator->current());
                    $this->importResults($testHandler, $progressBar);
                    $iterator->next();

                    break;
                case 1:
                    //====================================================================//
                    // Only ONE Process - Directly Process Rule Validation
                    $testHandler = $this->runner->executeRuleIsolated($track, $iterator->current());
                    $this->importResults($testHandler, $progressBar);
                    $iterator->next();

                    break;
                default:
                    //====================================================================//
                    // XX Processes - Refresh Status of Parallel Processes
                    if ($localHandler = $this->runner->refreshProcesses()) {
                        $this->importResults($localHandler, $progressBar);
                    }
                    //====================================================================//
                    // XX Processes - Start Rule Validation with Parallel Processing
                    if ($this->runner->startRuleProcess($track, $iterator->current())) {
                        $iterator->next();
                    }

                    break;
            }
        }
        //====================================================================//
        // Ensures All SubProcess are Terminated
        while (!empty($this->runner->countActiveProcesses())) {
            if ($localHandler = $this->runner->refreshProcesses()) {
                $this->importResults($localHandler, $progressBar);
            }
        }
        //====================================================================//
        // Ensures that the progress bar is at 100% & Close
        $this->closeProgressBar($output, $progressBar);
        //====================================================================//
        // Import results to Logger
        $this->logger->importLogs($this->records);
    }

    /**
     * Create Progress Bar.
     *
     * @param Outputs $output
     * @param Track   $track
     *
     * @return null|ProgressBar
     */
    private function initProgressBar(Outputs $output, Track $track): ?ProgressBar
    {
        if (!$output->isDecorated()) {
            return null;
        }
        //====================================================================//
        // Creates a new Progress Bar
        $progressBar = new ProgressBar($output, $track->getRulesCount());
        $progressBar->setFormat('[%message%] [%bar%] %percent%% | %current%/%max% | %track% ');
        $progressBar->setMessage($track->getDescription(), 'track');
        $progressBar->setMessage('<info> Ok </info>');

        return $progressBar;
    }

    /**
     * Finish Progress Bar.
     *
     * @param Outputs          $output
     * @param null|ProgressBar $progressBar
     *
     * @return void
     */
    private function closeProgressBar(Outputs $output, ?ProgressBar $progressBar): void
    {
        if ($progressBar) {
            $progressBar->finish();
            $output->writeln('');
        }
    }

    /**
     * Verify All Rules of a Track.
     *
     * @param LocalHandler     $localHandler
     * @param null|ProgressBar $progressBar
     *
     * @return void
     */
    private function importResults(LocalHandler $localHandler, ?ProgressBar $progressBar): void
    {
        //====================================================================//
        // Merge Rule Records
        $this->records = array_merge($this->records, $localHandler->getRecords());
        //====================================================================//
        // Catch Errors
        if ($localHandler->hasErrors()) {
            $this->errors++;
        }
        //====================================================================//
        // Catch Warnings
        if ($localHandler->hasWarnings()) {
            $this->warnings++;
        }
        //====================================================================//
        // Update Progress Bar
        if ($progressBar) {
            if ($this->errors) {
                $progressBar->setMessage('<error> Ko </error>');
            } elseif ($this->warnings) {
                $progressBar->setMessage('<comment>Warn</comment>');
            }
            //====================================================================//
            // Advances the Progress Bar
            $progressBar->advance();
        }
    }
}
