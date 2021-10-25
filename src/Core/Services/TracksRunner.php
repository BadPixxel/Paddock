<?php

/*
 *  Copyright (C) 2021 BadPixxel <www.badpixxel.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace BadPixxel\Paddock\Core\Services;

use Exception;
use Monolog\Logger;

/**
 * Paddock Tracks Runner Service.
 */
class TracksRunner
{
    /**
     * @var TracksManager
     */
    private $tracks;

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
     * Tracks Runner Constructor.
     *
     * @param TracksManager     $tracks
     * @param RulesManager      $rules
     * @param CollectorsManager $collectors
     * @param LogManager        $logger
     */
    public function __construct(TracksManager $tracks, RulesManager $rules, CollectorsManager $collectors, LogManager $logger)
    {
        $this->tracks = $tracks;
        $this->rules = $rules;
        $this->collectors = $collectors;
        $this->logger = $logger;
    }

    //====================================================================//
    // TRACKS RUNNER
    //====================================================================//

    /**
     * Execute a Verification Track.
     *
     * @param string $trackCode
     * @param int    $minLogLevel
     *
     * @throws Exception
     *
     * @return bool
     */
    public function run(string $trackCode, int $minLogLevel = Logger::ERROR): bool
    {
        //====================================================================//
        // Load Requested Track
        $track = $this->tracks->getByCode($trackCode);
        //====================================================================//
        // Init Track Context
        $this->logger->setContext($trackCode, null);
        //====================================================================//
        // Ensure Track is Enabled
        if (!$track->isEnabled()) {
            $this->logger->log(Logger::WARNING, "Track is Disabled");

            return false;
        }
        //====================================================================//
        // Execute All Track Rules
        foreach ($track->getRules() as $ruleOptions) {
            //====================================================================//
            // Setup Rule Context
            $this->logger->setContext($trackCode, $ruleOptions["rule"], $ruleOptions["key"]);
            //====================================================================//
            // Execute Rule Validation
            $this->runOne($ruleOptions, $trackCode);
        }

        return $this->logger->hasRecordsAboveLevel($minLogLevel);
    }

    /**
     * Execute a Single Rule Verification.
     *
     * @param array       $ruleOptions
     * @param null|string $trackCode
     *
     * @throws Exception
     *
     * @return bool
     */
    public function runOne(array $ruleOptions, string $trackCode = null): bool
    {
        //====================================================================//
        // Load Value from Data Collector
        try {
            $value = $this->collectors
                ->getByCode($ruleOptions["collector"])
                ->getData($ruleOptions["options"] ?? array(), $ruleOptions["key"])
            ;
        } catch (\Throwable $throwable) {
            //====================================================================//
            // If Data Collector Failed
            if ($trackCode) {
                $this->logger->setContext($trackCode, $ruleOptions["rule"], $ruleOptions["key"]);
            }
            $this->logger->log(Logger::EMERGENCY, $throwable->getMessage());

            return false;
        }
        //====================================================================//
        // Load Paddock Rule
        $rule = $this->rules->getByCode($ruleOptions["rule"]);
        //====================================================================//
        // Add Result to Logs
        if (is_scalar($value) && !empty($rule->getMetricName())) {
            $this->logger->incCounter($rule->getMetricName(), (int) $value);
        }
        //====================================================================//
        // Execute Rule Validation
        $rule->execute($ruleOptions, $value);

        return true;
    }
}
