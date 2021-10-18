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

use BadPixxel\Paddock\Core\Formatter;
use BadPixxel\Paddock\Core\Models\Formatter\AbstractFormatter;
use Exception;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\TestHandler;
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
     * @var array
     */
    private $context;

    /**
     * @var array<string, int>
     */
    private $counters = array();

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var TestHandler
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
        $this->logHandler = new TestHandler(Logger::DEBUG);
        $this->logger->pushHandler($this->logHandler);
        //====================================================================//
        // Setup Static Access
        static::$instance = $this;
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
        // Build Message Prefix
        $prefix = '';
        if (isset($this->context['track'])) {
            $prefix .= '['.$this->context['track']."]";
        }
        if (isset($this->context['rule'])) {
            $prefix .= '['.$this->context['rule']."]";
        }
        if (isset($this->context['key'])) {
            $prefix .= '['.$this->context['key']."]";
        }
        $prefix = $prefix ? $prefix.' ' : '';
        //====================================================================//
        // Build Message Context
        $context = $this->getLoggerContext($context);
        //====================================================================//
        // Push to Logger
        $this->logger->log($level, $prefix.$message, $context);
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
    // CONTEXT MANAGEMENT
    //====================================================================//

    /**
     * Setup Log Context
     *
     * @param null|string $trackCode
     * @param null|string $ruleCode
     * @param null|string $key
     * @param null|mixed  $value
     */
    public function setContext(?string $trackCode, ?string $ruleCode, ?string $key = null, $value = null): void
    {
        $this->context = array(
            'track' => $trackCode ? self::toName($trackCode) : null,
            'rule' => $ruleCode ? self::toName($ruleCode) : null,
            'key' => $key,
            'value' => $value,
        );
    }

    /**
     * Override Log Context Rule Code
     * May be used by Collector to detail what we are reading!
     *
     * @param string $ruleCode
     */
    public function setContextRule(string $ruleCode): void
    {
        if (isset($this->context["rule"])) {
            $this->context["rule"] = $ruleCode;
        }
    }

    /**
     * Reset Logger Context
     */
    public function resetContext(): void
    {
        $this->context = array();
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
        //====================================================================//
        // Select Formatter
        switch ($formatterCode) {
            case "nrpe":
            default:
                return new Formatter\NrpeFormatter($records, $counters);
        }
    }

    //====================================================================//
    // COUNTERS MANAGEMENT
    //====================================================================//

    /**
     * Get All Counters Values
     *
     * @return int[]
     */
    public function getAllCounters(): array
    {
        return $this->counters;
    }

    /**
     * Increment Counter Value
     *
     * @param string $key
     * @param int    $offest
     *
     * @return $this
     */
    public function incCounter(string $key, int $offest = 1): self
    {
        if (isset($this->counters[$key])) {
            $this->counters[$key] += $offest;
        } else {
            $this->counters[$key] = $offest;
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
        return static::$instance;
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
    public function getHandler(): TestHandler
    {
        return $this->logHandler;
    }

    /**
     * Check if There was Errors.
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        foreach (Logger::getLevels() as $level) {
            if ($level >= Logger::ERROR) {
                if ($this->logHandler->hasRecords($level)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if There was Warnings.
     *
     * @return bool
     */
    public function hasWarnings(): bool
    {
        foreach (Logger::getLevels() as $level) {
            if (($level < Logger::ERROR) && ($level >= Logger::WARNING)) {
                if ($this->logHandler->hasRecords($level)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if There was Warnings.
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

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Convert Tracks
     *
     * @param string $code
     *
     * @return string
     */
    private static function toName(string $code): string
    {
        $code = str_replace("-", " ", $code);
        $code = str_replace("_", " ", $code);

        return ucwords($code);
    }

    /**
     * Convert Tracks
     *
     * @param null|array $context
     *
     * @return array
     */
    private function getLoggerContext(?array $context): array
    {
        //====================================================================//
        // IF Context is Forced
        if (!empty($context)) {
            return $context;
        }
        //====================================================================//
        // IF Context Value is Defined
        if (!empty(isset($this->context['value']))) {
            return is_array($this->context['value'])
                ? $this->context['value']
                : array($this->context['value']);
        }

        return array();
    }
}
