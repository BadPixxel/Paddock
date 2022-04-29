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

namespace BadPixxel\Paddock\System\Shell\Rules;

use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use BadPixxel\Paddock\Core\Rules;
use BadPixxel\Paddock\System\Shell\Helpers\CmdRunner;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Shell Command Execution Validator
 */
class Command extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "cmd";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Check shell command works";
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

        Rules\RulesHelper::addScalarOption($resolver, "cmd");   // Specify Command tu Execute
    }

    /**
     * {@inheritDoc}
     */
    public function verify($value): bool
    {
        //====================================================================//
        // Detect Command from Key or Options
        $value = $this->options['cmd'] ?? $value;
        //====================================================================//
        // WHATEVER => Non Empty Value Required
        if (!$this->forward(Rules\isEmpty::getCode(), $value)) {
            return false;
        }
        //====================================================================//
        // WHATEVER => Array or Scalar Value Required
        if (!is_array($value) && !is_scalar($value)) {
            return $this->error("Command is not an array or scalar", array($value));
        }
        $command = is_array($value) ? $value : (array) explode(" ", (string) $value);
        //====================================================================//
        // Verify All Parts Are Scalar
        foreach ($command as $commandPart) {
            if (!$this->forward(Rules\isScalar::getCode(), $commandPart)) {
                return false;
            }
        }

        return CmdRunner::run($command);
    }
}
