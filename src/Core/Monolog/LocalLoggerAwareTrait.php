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

namespace BadPixxel\Paddock\Core\Monolog;

use BadPixxel\Paddock\Core\Monolog\Handler\LocalHandler;
use Exception;
use Monolog\Logger;

/**
 * Make a Class Aware of Paddock Log Manager
 */
trait LocalLoggerAwareTrait
{
    /**
     * @var null|Logger
     */
    private $logger;

    /**
     * @var string
     */
    private static $logPrefix = '';

    //====================================================================//
    // LOGGER MANAGEMENT
    //====================================================================//

    /**
     * Get Local Logger
     *
     * @return Logger
     */
    public function getLogger(): Logger
    {
        if (!isset($this->logger)) {
            $this->logger = new Logger(
                basename(static::class),
                array(new LocalHandler())
            );
        }

        return $this->logger;
    }

    /**
     * Set Local Logger
     *
     * @param Logger $logger
     *
     * @return self
     */
    public function setLogger(Logger $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Get Local Logger Handler
     *
     * @throws Exception
     *
     * @return LocalHandler
     */
    public function getHandler(): LocalHandler
    {
        foreach ($this->getLogger()->getHandlers() as $handler) {
            if ($handler instanceof LocalHandler) {
                return $handler;
            }
        }

        throw new Exception('No Test Logger Handler');
    }

    /**
     * Get Local Logger Records
     *
     * @throws Exception
     *
     * @return array[]
     */
    public function getRecords(): array
    {
        return $this->getHandler()->getRecords();
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
     *
     * @return self
     */
    public function setContext(?string $trackCode, ?string $ruleCode, ?string $key = null): self
    {
        //====================================================================//
        // Build Message Prefix
        self::$logPrefix = $trackCode ? '['.$trackCode."]" : '';
        if ($ruleCode && ("value" != $ruleCode)) {
            self::$logPrefix .= '['.$ruleCode."]";
        }
        self::$logPrefix .= $key ? '['.$key."]": '';
        self::$logPrefix = self::$logPrefix ? self::$logPrefix.' ' : '';

        return $this;
    }

    //====================================================================//
    // PUSH LOG MESSAGES
    //====================================================================//

    /**
     * Adds a log record at the DEBUG level.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function debug(string $message, array $context = null): bool
    {
        return $this->log(Logger::DEBUG, $message, $context);
    }

    /**
     * Adds a log record at the INFO level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function info(string $message, array $context = null): bool
    {
        return $this->log(Logger::INFO, $message, $context);
    }

    /**
     * Adds a log record at the NOTICE level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function notice(string $message, array $context = null): bool
    {
        return $this->log(Logger::NOTICE, $message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function warning(string $message, array $context = null): bool
    {
        return $this->log(Logger::WARNING, $message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function error(string $message, array $context = null): bool
    {
        return $this->log(Logger::ERROR, $message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function critical(string $message, array $context = null): bool
    {
        return $this->log(Logger::CRITICAL, $message, $context);
    }

    /**
     * Adds a log record at the ALERT level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function alert(string $message, array $context = null): bool
    {
        return $this->log(Logger::ALERT, $message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param string  $message The log message
     * @param mixed[] $context The log context
     *
     * @return bool
     */
    protected function emergency(string $message, array $context = null): bool
    {
        return $this->log(Logger::EMERGENCY, (string) $message, $context);
    }

    /**
     * Add a Log Message.
     *
     * @param int        $level
     * @param string     $message
     * @param null|array $context
     *
     * @return bool
     */
    protected function log(int $level, string $message, ?array $context = null): bool
    {
        $this->getLogger()->log($level, self::$logPrefix.$message, $context ?? array());

        return ($level < Logger::ERROR);
    }
}
