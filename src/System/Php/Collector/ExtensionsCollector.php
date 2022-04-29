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

namespace BadPixxel\Paddock\System\Php\Collector;

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\System\Php\Models\AbstractPhpCollector;
use Exception;

class ExtensionsCollector extends AbstractPhpCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function getCode(): string
    {
        return "php-ext";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect list of installed extensions";
    }

    //====================================================================//
    // LOCAL PHP INI COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function getLocalValue(string $key): string
    {
        //====================================================================//
        // Override Rule Name for Logs
        LogManager::getInstance()->setContextRule("PHP EXT");
        //====================================================================//
        // Get Extension Version from Current Php Session
        $value = phpversion($key);

        return (string) $value;
    }

    //====================================================================//
    // EXTERNAL PHP INI COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function getExternalValue(string $binary, string $key): string
    {
        //====================================================================//
        // Override Rule Name for Logs
        LogManager::getInstance()->setContextRule(ucfirst(basename($binary))." EXT");
        //====================================================================//
        // Get Ini Value from Shell
        $value = shell_exec($binary.' -r "echo phpversion(\''.$key.'\');"');

        return (string) $value;
    }
}
