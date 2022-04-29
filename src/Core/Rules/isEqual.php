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
 * Check if Value is Equal
 */
class isEqual extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "equal";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check if value is Equal to Constraint";
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

        RulesHelper::addScalarOption($resolver, "eq");     // Value is equal
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        $result = 1;
        foreach (RulesHelper::getLevelCriteria($this->options, "eq") as $level => $constraint) {
            if (RulesHelper::parse($constraint) == RulesHelper::parse($value)) {
                $this->info("Value is equal to ".print_r($constraint, true), array($value));

                continue;
            }
            $result &= $this->log($level, "Value is not equal to ".print_r($constraint, true), array($value));
            if (!$result) {
                return false;
            }
        }

        return (bool) $result;
    }
}
