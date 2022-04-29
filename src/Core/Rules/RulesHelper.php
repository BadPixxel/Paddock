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

namespace BadPixxel\Paddock\Core\Rules;

use Exception;
use Monolog\Logger;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Helper for Setup & Parsing of Constraints Configs
 */
class RulesHelper
{
    //====================================================================//
    // OPTION RESOLVER CONFIGURATION
    //====================================================================//

    /**
     * Add a Scalar Option to Resolver with Mode Config
     *
     * @param null|mixed $default
     */
    public static function addScalarOption(OptionsResolver $resolver, string $name, $default = null): void
    {
        $resolver->setDefault($name, $default);
        $resolver->setAllowedTypes($name, array('null', 'bool', 'string', 'int', 'float', 'array'));
    }

    //====================================================================//
    // CONFIGURATION READING
    //====================================================================//

    /**
     * Decode Options to Get Log Level Indexed Value
     *
     * @param array  $options
     * @param string $name
     *
     * @throws Exception
     *
     * @return array<int, scalar>
     */
    public static function getLevelCriteria(array $options, string $name): array
    {
        //====================================================================//
        // Ensure Option Exists
        if (!array_key_exists($name, $options)) {
            throw new Exception(sprintf(
                "Rule Option %s not found... You should add it at resolving stage.",
                $name
            ));
        }
        //====================================================================//
        // Null Option => Nothing to Check Here
        if (is_null($options[$name])) {
            return array();
        }
        //====================================================================//
        // Scalar Option => Error Detection Only
        if (is_scalar($options[$name])) {
            return array(Logger::toMonologLevel("error") => $options[$name]);
        }
        //====================================================================//
        // Iterable Option => Detect Levels by Names
        $criteria = array();
        foreach ($options[$name] as $level => $value) {
            try {
                $monologLevel = Logger::toMonologLevel($level);
            } catch (Exception $exception) {
                continue;
            }
            $criteria[$monologLevel] = $value;
        }
        //====================================================================//
        // Safety Check => Option MUSt define at least One Value
        if (empty($criteria)) {
            throw new Exception(sprintf(
                "Contraint Option %s define no valid criteria.",
                $name
            ));
        }

        return $criteria;
    }

    /**
     * Detect Size Values and Convert ty Bytes
     *
     * @param mixed $value
     *
     * @throws Exception
     *
     * @return mixed
     */
    public static function parse($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        //====================================================================//
        // Detect Size Values
        $size = array('b','k','m','g','t','p');
        $lastChar = strtolower($value[strlen($value) - 1]);
        $position = array_search($lastChar, $size, true);
        if ($position > 0) {
            return pow(1024, $position) * (int) trim($value);
        }

        return $value;
    }
}
