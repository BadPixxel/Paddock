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

namespace BadPixxel\Paddock\System\Php\Models;

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base Class for PHP Collectors
 */
abstract class AbstractPhpCollector extends AbstractCollector implements PhpCollectorInterface
{
    /**
     * @var array
     */
    private static $php_binaries = array();

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        //====================================================================//
        // Use Specific Php Binary
        $resolver->setDefault("bin", null);
        $resolver->setAllowedTypes("bin", array("null", "string"));
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        //====================================================================//
        // Get Local/Current Php Value
        if (empty($this->config["bin"])) {
            return $this->getLocalValue($key);
        }
        //====================================================================//
        // Ensure External Binary Exists
        if (!$this->hasBinary($this->config["bin"])) {
            return "";
        }
        //====================================================================//
        // Get External Php Value
        return $this->getExternalValue((string) $this->config["bin"], $key);
    }

    //====================================================================//
    // BINARY CHECKS
    //====================================================================//

    /**
     * Check if Php Binary Exists
     *
     * @param string $binary Php binary path
     *
     * @return bool
     */
    public function hasBinary(string $binary): bool
    {
        if (!isset(self::$php_binaries[$binary])) {
            self::$php_binaries[$binary] = !empty(shell_exec($binary.' -v 2>&-'));
            if (!self::$php_binaries[$binary]) {
                $this->error(sprintf("Php binary version %s not found!", $binary));
            }
        }

        return self::$php_binaries[$binary];
    }
}
