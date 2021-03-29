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

namespace BadPixxel\Paddock\Core\Rules;

use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * THE Basic Scalar Value Validator
 *
 * Check Value of a bool|string|int|float
 */
class Value extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "value";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check of a scalar value";
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        RulesHelper::addScalarOption($resolver, "empty");  // Value is empty
        RulesHelper::addScalarOption($resolver, "eq");     // Value is equal
        RulesHelper::addScalarOption($resolver, "same");   // Value is same
        RulesHelper::addScalarOption($resolver, "gt");     // Value is greater
        RulesHelper::addScalarOption($resolver, "gte");    // Value is greater or equal
        RulesHelper::addScalarOption($resolver, "lt");     // Value is lower
        RulesHelper::addScalarOption($resolver, "lte");    // Value is lower or equal
    }

    /**
     * Verify a Raw Value vs Constraint.
     *
     * @param bool|float|int|string $value Current Value
     *
     * @return void
     */
    public function verify($value): void
    {
        //====================================================================//
        // WHATEVER => Scalar Value Required
        if (!is_scalar($value)) {
            $this->error("Value is not a scalar", array($value));

            return;
        }
        //====================================================================//
        // Empty Value Required
        foreach (RulesHelper::getLevelCriteria($this->options, "empty") as $level => $value) {
            if (!empty($value)) {
                $this->log($level, "Value is not empty", array($value));

                return;
            }
            $this->notice("Value is empty", array($value));
        }

//        dump(ConstraintHelper::getLevelCriteria(array("eq" => array("error" => 1)),"eq"));
//
//        dump($this->logger->toMonologLevel("error"));
//        dump($this->logger);
//        dump(ConstraintHelper::getErrorCriteria($this->config, "eq"));
//        dump($this->config);

//        //====================================================================//
//        // Simple Value Required
//        if (is_scalar($const)) {
//            $const = array("eq" => (string) $const);
//        }
//        //====================================================================//
//        // Detect Size Values
//        if (isset($const["mb"])) {
//            $value = self::toMegaBytes((string) $value);
//        }
//        //====================================================================//
//        // Check Minimum
//        if (isset($const["min"]) && ($value < $const["min"])) {
//            $this->addConstraintResult($name, $const, 'Should be above '.$const["min"].', but is '.$value);
//        }
//        //====================================================================//
//        // Check Equals
//        if (isset($const["eq"]) && ($value != $const["eq"])) {
//            $this->addConstraintResult($name, $const, 'Expected '.$const["eq"].' but found '.$value);
//        }
//        //====================================================================//
//        // Check Maximum
//        if (isset($const["max"]) && ($value > $const["max"])) {
//            $this->addConstraintResult($name, $const, 'Should be below '.$const["max"].', but is '.$value);
//        }
//        //====================================================================//
//        // Check Recommended
//        if (isset($const["suggest"]) && ($value < $const["suggest"])) {
//            $suggested = array_replace($const, array("warn" => true));
//            $this->addConstraintResult($name, $suggested, 'Suggested above '.$const["suggest"].', but is '.$value);
//        }
    }
}
