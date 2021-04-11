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
 * Check if Value is Greater or Equal
 */
class isGreaterOrEqual extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "greaterOrEqual";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check if value is Greater or Equal to Constraint";
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

        RulesHelper::addScalarOption($resolver, "gte");    // Value is greater or equal
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        $result = 1;
        foreach (RulesHelper::getLevelCriteria($this->options, "gte") as $level => $constraint) {
            if ($value >= $constraint) {
                $this->info("Value is greater or equal to ".print_r($constraint, true), array($value));

                continue;
            }
            $result &= $this->log($level, "Value is not greater or equal to ".print_r($constraint, true), array($value));
            if (!$result) {
                return false;
            }
        }

        return (bool) $result;
    }
}
