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

/**
 * Check if Value is Scalar
 */
class isScalar extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "scalar";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check if value is a Scalar (bool|int|float|string)";
    }

    //====================================================================//
    // EXECUTION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        //====================================================================//
        // WHATEVER => Scalar Value Required
        if (!is_scalar($value)) {
            return $this->error("Value is not a scalar", array($value));
        }

        return true;
    }
}
