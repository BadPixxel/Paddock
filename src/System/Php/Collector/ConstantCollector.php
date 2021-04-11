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

namespace BadPixxel\Paddock\System\Php\Collector;

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\System\Php\Models\AbstractPhpCollector;
use Exception;

/**
 * PHP Constant Collector
 */
class ConstantCollector extends AbstractPhpCollector
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
        return "php-constant";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect PHP Constant";
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
        LogManager::getInstance()->setContextRule("PHP CONST");
        //====================================================================//
        // Get Ini Value from Current Php Session
        if (!defined($key)) {
            $this->error(sprintf("Constant %s doesn't exists!", $key));

            return "";
        }

        return constant($key);
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
        LogManager::getInstance()->setContextRule(ucfirst(basename($binary))." CONST");
        //====================================================================//
        // Get PHP Constant from Shell
        $value = shell_exec($binary.' -r "echo constant(\''.$key.'\');"');
        if (null === $value) {
            $this->error(sprintf("Constant %s doesn't exists!", $key));
        }

        return (string) $value;
    }
}
