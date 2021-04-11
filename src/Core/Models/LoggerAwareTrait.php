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

namespace BadPixxel\Paddock\Core\Models;

use BadPixxel\Paddock\Core\Services\LogManager;
use Monolog\Logger;

/**
 * Make a Class Aware of Paddock Log Manager
 */
trait LoggerAwareTrait
{
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
    public function debug(string $message, array $context = null): bool
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
    public function info(string $message, array $context = null): bool
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
    public function notice(string $message, array $context = null): bool
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
    public function warning(string $message, array $context = null): bool
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
    public function error(string $message, array $context = null): bool
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
    public function critical(string $message, array $context = null): bool
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
    public function alert(string $message, array $context = null): bool
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
    public function emergency(string $message, array $context = null): bool
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
    public function log(int $level, string $message, ?array $context = null): bool
    {
        $this->getLogger()->log($level, $message, $context);

        return ($level < Logger::ERROR);
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
    protected function setContext(?string $trackCode, ?string $ruleCode, ?string $key = null, $value = null): void
    {
        $this->getLogger()->setContext($trackCode, $ruleCode, $key, $value);
    }

    //====================================================================//
    // LOGGER MANAGEMENT
    //====================================================================//

    /**
     * Get Log Manager
     *
     * @return LogManager
     */
    protected function getLogger(): LogManager
    {
        return LogManager::getInstance();
    }
}
