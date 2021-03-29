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

use Monolog\Handler\AbstractProcessingHandler;
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
     * @var Logger
     */
    private $logger;

    /**
     * @var AbstractProcessingHandler
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
        $this->logHandler = new TestHandler(Logger::NOTICE);
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
     * @param int    $level
     * @param string $message
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
     * Reset Logger Context
     */
    public function resetContext(): void
    {
        $this->context = array();
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
    public function getHandler(): AbstractProcessingHandler
    {
        return $this->logHandler;
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
