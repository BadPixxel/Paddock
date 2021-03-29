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

namespace BadPixxel\Paddock\Core\Events;

use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use Exception;
use Symfony\Contracts\EventDispatcher\Event;

class GetConstraintsEvent extends Event
{
    /**
     * @var class-string[]
     */
    private $constraints = array();

    /**
     * Add Constraint.
     *
     * @param class-string $constraintClass
     *
     * @return self
     */
    public function add(string $constraintClass): self
    {
        if (self::validate($constraintClass)) {
            $this->constraints[$constraintClass::getCode()] = $constraintClass;
        }

        return $this;
    }

    /**
     * Get All Constraints.
     *
     * @return array<string, class-string>
     */
    public function all(): array
    {
        return $this->constraints;
    }

    /**
     * Validate Constraints.
     *
     * @param class-string $constraintClass
     *
     * @throws Exception
     *
     * @return bool
     */
    private static function validate(string $constraintClass): bool
    {
        //====================================================================//
        // Safety Check - Class Exists
        if (!class_exists($constraintClass)) {
            throw new Exception(sprintf("Class %s was not found.", $constraintClass));
        }
        //====================================================================//
        // Safety Check - Implement Abstract Constraint
        if (!is_subclass_of($constraintClass, AbstractRule::class)) {
            throw new Exception(sprintf(
                "Contraint %s must extends %s.",
                $constraintClass,
                AbstractRule::class
            ));
        }

        return true;
    }
}
