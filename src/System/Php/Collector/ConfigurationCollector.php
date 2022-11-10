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
 * Php INI Configuration Collector
 */
class ConfigurationCollector extends AbstractPhpCollector
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
        return "php-config";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect PHP INI Parameters";
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
        $value = ini_get($key);
        if (false === $value) {
            $this->error(sprintf("Configuration key %s doesn't exists!", $key));
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
        // Get Ini Value from Shell
        $value = shell_exec($binary.' -r "echo ini_get(\''.$key.'\');"');
        if (null === $value) {
            $this->error(sprintf("Configuration key %s doesn't exists!", $key));
        }

        return (string) $value;
    }
}
