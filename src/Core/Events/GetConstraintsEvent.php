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

namespace BadPixxel\Paddock\Core\Events;

use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use Exception;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Symfony Event for Collecting Available Tracks Rules
 */
class GetConstraintsEvent extends Event
{
    /**
     * @var array<string, AbstractRule>
     */
    private $constraints = array();

    /**
     * Add Constraint.
     *
     * @param class-string $constraintClass
     *
     * @throws Exception
     *
     * @return self
     */
    public function add(string $constraintClass): self
    {
        $constraint = self::validate($constraintClass);
        $this->constraints[$constraint::getCode()] = $constraint;

        return $this;
    }

    /**
     * Get All Constraints.
     *
     * @return array<string, AbstractRule>
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
     * @return AbstractRule
     */
    private static function validate(string $constraintClass): AbstractRule
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
                "Contraint/Rule %s must extends %s.",
                $constraintClass,
                AbstractRule::class
            ));
        }

        return new $constraintClass;
    }
}
