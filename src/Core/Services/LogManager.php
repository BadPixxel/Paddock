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

use BadPixxel\Paddock\Core\Formatter;
use BadPixxel\Paddock\Core\Models\Formatter\AbstractFormatter;
use BadPixxel\Paddock\Core\Monolog\Handler\LocalHandler;
use Exception;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;

/**
 * Manager for Paddock Logs
 */
class LogManager
{
    /**
     * @var LogManager
     */
    private static $instance;

    /**
     * @var array<string, int>
     */
    private $counters = array();

    /**
     * @var array<string, array>
     */
    private $countersOptions = array();

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var LocalHandler
     */
    private $logHandler;

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     */
    public function __construct()
    {
        //====================================================================//
        // Configure Logger
        $this->logger = new Logger('paddock');
        $this->logHandler = new LocalHandler(Logger::DEBUG);
        $this->logger->pushHandler($this->logHandler);
        //====================================================================//
        // Setup Static Access
        self::$instance = $this;
    }

    //====================================================================//
    // LOGGER MANAGEMENT
    //====================================================================//

    /**
     * Add a Log Message.
     *
     * @param int        $level
     * @param string     $message
     * @param null|array $context
     *
     * @return void
     */
    public function log(int $level, string $message, ?array $context = null): void
    {
        //====================================================================//
        // Push to Logger
        $this->logger->log($level, $message, $context ?? array());
    }

    /**
     * Import Track Results to Logger.
     *
     * @param array $records
     *
     * @return void
     */
    public function importLogs(array $records): void
    {
        foreach ($records as $record) {
            $this->log($record["level"], $record["message"], $record["context"]);
        }
    }

    /**
     * Pushes a handler on to the stack.
     *
     * @param HandlerInterface $handler
     *
     * @return self
     */
    public function pushHandler(HandlerInterface $handler): self
    {
        $this->logger->pushHandler($handler);

        return $this;
    }

    /**
     * Reset Logger.
     *
     * @return self
     */
    public function reset(): self
    {
        $this->logger->reset();

        return $this;
    }

    //====================================================================//
    // FORMATTERS MANAGEMENT
    //====================================================================//

    /**
     * Get Results Logs Formatter
     *
     * @param string $formatterCode
     *
     * @throws Exception
     *
     * @return AbstractFormatter
     */
    public function getFormatter(string $formatterCode): AbstractFormatter
    {
        $records = $this->getHandler()->getRecords();
        $counters = $this->getAllCounters();
        $options = $this->getAllCountersOptions();
        //====================================================================//
        // Select Formatter
        switch ($formatterCode) {
            case "json":
                return new Formatter\JsonFormatter($records, $counters, $options);
            case "nrpe":
            default:
                return new Formatter\NrpeFormatter($records, $counters, $options);
        }
    }

    //====================================================================//
    // COUNTERS MANAGEMENT
    //====================================================================//

    /**
     * Get All Counters Values
     *
     * @return array<string, int>
     */
    public function getAllCounters(): array
    {
        return $this->counters;
    }

    /**
     * Get All Counters Options
     *
     * @return array<string, array>
     */
    public function getAllCountersOptions(): array
    {
        return $this->countersOptions;
    }

    /**
     * Increment Counter Value
     *
     * @param string $key
     * @param int    $offest
     * @param array  $options
     *
     * @return $this
     */
    public function incCounter(string $key, int $offest = 1, array $options = array()): self
    {
        if (isset($this->counters[$key])) {
            $this->counters[$key] += $offest;
        } else {
            $this->counters[$key] = $offest;
        }

        if (!isset($this->countersOptions[$key])) {
            $this->countersOptions[$key] = $options;
        }

        return $this;
    }

    /**
     * Reset Counter Value
     *
     * @param string $key
     *
     * @return $this
     */
    public function resetCounter(string $key): self
    {
        $this->counters[$key] = 0;

        return $this;
    }

    //====================================================================//
    // BASIC GETTERS
    //====================================================================//

    /**
     * Get Static Instance
     */
    public static function getInstance(): LogManager
    {
        return self::$instance;
    }

    /**
     * Get Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * Get Log Handler
     */
    public function getHandler(): LocalHandler
    {
        return $this->logHandler;
    }

    /**
     * Check if There are Errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->logHandler->hasErrors();
    }

    /**
     * Check if There are Warnings.
     *
     * @return bool
     */
    public function hasWarnings(): bool
    {
        return $this->logHandler->hasWarnings();
    }

    /**
     * Check if There Logs Above Given Level.
     *
     * @param int $minLevel
     *
     * @return bool
     */
    public function hasRecordsAboveLevel(int $minLevel): bool
    {
        foreach (Logger::getLevels() as $level) {
            if ($level >= $minLevel) {
                if ($this->logHandler->hasRecords($level)) {
                    return true;
                }
            }
        }

        return false;
    }
}
