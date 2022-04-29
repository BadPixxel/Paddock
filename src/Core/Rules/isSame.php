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
 * Check if Value is Same
 */
class isSame extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "same";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check if value is Same to Constraint";
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

        RulesHelper::addScalarOption($resolver, "same");   // Value is same
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        $result = 1;
        foreach (RulesHelper::getLevelCriteria($this->options, "same") as $level => $constraint) {
            if ($constraint === $value) {
                $this->info("Value is same as ".print_r($constraint, true), array($value));

                continue;
            }
            $result &= $this->log($level, "Value is not same as ".print_r($constraint, true), array($value));
            if (!$result) {
                return false;
            }
        }

        return (bool) $result;
    }
}
