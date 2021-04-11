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
            // Load Value from Data Collector
            try {
                $value = $this->collectors
                    ->getByCode($ruleOptions["collector"])
                    ->getData($ruleOptions["options"], $ruleOptions["key"])
                ;
            } catch (\Throwable $throwable) {
                //====================================================================//
                // If Data Collector Failed
                $this->logger->setContext($trackCode, $ruleOptions["rule"], $ruleOptions["key"]);
                $this->logger->log(Logger::EMERGENCY, $throwable->getMessage());

                continue;
            }
            //====================================================================//
            // Load Paddock Rule
            $rule = $this->rules->getByCode($ruleOptions["rule"]);
            //====================================================================//
            // Execute Rule Validation
            $rule->execute($ruleOptions, $value);
        }

        return $this->logger->hasRecordsAboveLevel($minLogLevel);
    }

    /**
     * Execute One Validator by Class.
     *
     * @param string $section        Analyze Mode
     * @param string $validatorClass Validator Class
     *
     * @throws Exception
     *
     * @return null|array
     */
    public function verifyOne(string $section, string $validatorClass): ?array
    {
        //====================================================================//
        // Init the Analyser
        $this->init($section);

        return $this->verifyCore($section, $validatorClass);
    }
}
