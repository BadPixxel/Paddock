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
    public static function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        RulesHelper::addScalarOption($resolver, "empty");   // Value is empty
        RulesHelper::addScalarOption($resolver, "ne");      // Value is not empty
        RulesHelper::addScalarOption($resolver, "eq");      // Value is equal
        RulesHelper::addScalarOption($resolver, "same");    // Value is same
        RulesHelper::addScalarOption($resolver, "gt");      // Value is greater
        RulesHelper::addScalarOption($resolver, "gte");     // Value is greater or equal
        RulesHelper::addScalarOption($resolver, "lt");      // Value is lower
        RulesHelper::addScalarOption($resolver, "lte");     // Value is lower or equal
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        //====================================================================//
        // WHATEVER => Scalar Value Required
        if (!$this->forward(isScalar::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Empty Value Required
        if (!$this->forward(isEmpty::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Not Empty Value Required
        if (!$this->forward(isNotEmpty::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Equal Value Required
        if (!$this->forward(isEqual::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Same Value Required
        if (!$this->forward(isSame::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Greater Value Required
        if (!$this->forward(isGreater::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Greater or Equal Value Required
        if (!$this->forward(isGreaterOrEqual::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Lower Value Required
        if (!$this->forward(isLower::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // Lower or Equal Value Required
        if (!$this->forward(isLowerOrEqual::getCode(), $value)) {
            return false;
        }

        return true;
    }
}
