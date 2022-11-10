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

use BadPixxel\Paddock\System\Php\Models\AbstractPhpCollector;
use Exception;

/**
 * PHP Environment Variable Collector
 */
class EnvironmentCollector extends AbstractPhpCollector
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
        return "php-env";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect PHP Environment Value";
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
        // Get Ini Value from Current Php Session
        $value = getenv($key);
        if (false === $value) {
            $this->error(sprintf("Environment Variable %s doesn't exists!", $key));

            return "";
        }

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
        // Get PHP Constant from Shell
        $value = shell_exec($binary.' -r "echo getenv(\''.$key.'\');"');
        if (null === $value) {
            $this->error(sprintf("Environment Variable %s doesn't exists!", $key));
        }

        return (string) $value;
    }
}
