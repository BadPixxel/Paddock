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
 * Check if Value is Not Empty
 */
class isNotEmpty extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "not-empty";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check if value is Not Empty";
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

        RulesHelper::addScalarOption($resolver, "ne");  // Value is NOT empty
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        $result = 1;
        foreach (RulesHelper::getLevelCriteria($this->options, "ne") as $level => $constraint) {
            if (!$constraint) {
                continue;
            }
            if (!empty($value)) {
                $this->info("Value is not empty", array($value));

                continue;
            }
            $result &= $this->log($level, "Value is empty", array($value));
            if (!$result) {
                return false;
            }
        }

        return (bool) $result;
    }
}
