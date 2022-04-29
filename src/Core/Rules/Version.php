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
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * THE Basic Version Validator
 */
class Version extends AbstractRule
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "version";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Basic check of a Software Version";
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
        RulesHelper::addScalarOption($resolver, "eq");      // Version is equal
        RulesHelper::addScalarOption($resolver, "gt");      // Version is greater
        RulesHelper::addScalarOption($resolver, "gte");     // Version is greater or equal
        RulesHelper::addScalarOption($resolver, "lt");      // Version is lower
        RulesHelper::addScalarOption($resolver, "lte");     // Version is lower or equal
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
        /** @var scalar $value */
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
        $value = (string) $value;
        //====================================================================//
        // Equal Value Required
        if (!$this->versionCompare($value, "eq", "==", "equal")) {
            return false;
        }
        //====================================================================//
        // Greater Value Required
        if (!$this->versionCompare($value, "gt", ">", "greater")) {
            return false;
        }
        //====================================================================//
        // Greater or Equal Value Required
        if (!$this->versionCompare($value, "gte", ">=", "greater or equal")) {
            return false;
        }
        //====================================================================//
        // Lower Value Required
        if (!$this->versionCompare($value, "lt", "<", "lower")) {
            return false;
        }
        //====================================================================//
        // Lower or Equal Value Required
        if (!$this->versionCompare($value, "lte", "<=", "lower or equal")) {
            return false;
        }

        return true;
    }

    /**
     * Compare Software Versions
     *
     * @param string $value
     * @param string $name
     * @param string $operator
     * @param string $operatorName
     *
     * @throws Exception
     *
     * @return bool
     */
    private function versionCompare(string $value, string $name, string $operator, string $operatorName): bool
    {
        $result = 1;
        foreach (RulesHelper::getLevelCriteria($this->options, $name) as $level => $constraint) {
            if (version_compare($value, (string) $constraint, $operator)) {
                $this->info(
                    sprintf("Version is %s to %s", $operatorName, print_r($constraint, true)),
                    array($value)
                );

                continue;
            }
            $result &= $this->log(
                $level,
                sprintf("Version is not %s to %s", $operatorName, print_r($constraint, true)),
                array($value)
            );
            if (!$result) {
                return false;
            }
        }

        return (bool) $result;
    }
}
