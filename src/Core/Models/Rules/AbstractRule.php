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

namespace BadPixxel\Paddock\Core\Models\Rules;

use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Models\RulesAwareTrait;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TypeError;

/**
 * Base Class for Paddock Rule / Constraint.
 */
abstract class AbstractRule implements RuleInterface
{
    use LoggerAwareTrait;
    use RulesAwareTrait;

    /**
     * List of Core Rule Options
     *
     * @var array
     */
    const CORE_OPTIONS = array("enabled", "description", "collector", "options", "key");

    /**
     * @var array
     */
    protected $options;

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function getCode(): string
    {
        throw new Exception(sprintf(
            "Rule %s must define an index code.",
            static::class
        ));
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return sprintf(
            "Rule %s provides no description...",
            static::class
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function getRuleDescription(array $configuration): string
    {
        return sprintf(
            "Rule %s provides no constraint description...",
            static::class
        );
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    //====================================================================//
    // EXECUTION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    final public function execute(array $options, $value): void
    {
        try {
            //====================================================================//
            // Resolve Constraint Configuration
            $this->options = $this->resolveOptions($options);
            //====================================================================//
            // Execute Constraint Verifications
            $this->verify($value);
        } catch (Exception $ex) {
            $this->emergency(sprintf("Constraint verification Fail: %s", $ex->getMessage()));
        } catch (TypeError $ex) {
            $this->emergency(sprintf("Constraint verification Fail: %s", $ex->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    final public function validateOptions(array $options): bool
    {
        //====================================================================//
        // Resolve Constraint Configuration
        try {
            $this->resolveOptions($options);
        } catch (Exception $ex) {
            $this->emergency(sprintf("Invalid Rules Options: %s", $ex->getMessage()));

            return false;
        } catch (TypeError $ex) {
            $this->emergency(sprintf("Invalid Rules Options: %s", $ex->getMessage()));

            return false;
        }

        return true;
    }

    /**
     * @param array $options
     *
     * @throws Exception
     *
     * @return array
     */
    final protected function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        //====================================================================//
        // Configure Options Resolver for Final Rule
        $this->configureOptions($resolver);
        //====================================================================//
        // Verify None of Core Options are Defined by Rule
        $commonOptions = array_intersect(self::CORE_OPTIONS, $resolver->getDefinedOptions());
        if (!empty($commonOptions)) {
            throw new Exception(sprintf(
                "Rule %s define core rule options (%s), this is forbidden.",
                static::class,
                implode(", ", $commonOptions)
            ));
        }
        //====================================================================//
        // Configure Options Resolver for Final Rule
        //====================================================================//
        // Default Data Collector
        $resolver->setDefault("collector", null);
        $resolver->setAllowedTypes("collector", array("string"));
        //====================================================================//
        // Enabled
        $resolver->setDefault("enabled", true);
        $resolver->setAllowedTypes("enabled", array("bool"));
        //====================================================================//
        // Description
        $resolver->setDefault("description", "");
        $resolver->setAllowedTypes("description", array("string"));
        //====================================================================//
        // Options
        $resolver->setDefault("options", array());
        $resolver->setAllowedTypes("options", array("array"));
        //====================================================================//
        // Key
        $resolver->setDefault("key", null);
        $resolver->setAllowedTypes("key", array("string"));

        return $resolver->resolve($options);
    }
}
