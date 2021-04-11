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
    const CORE_OPTIONS = array("rule", "enabled", "description", "collector", "options", "key");

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
    public static function getRuleDescription(array $options): string
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
    public static function configureOptions(OptionsResolver $resolver): void
    {
        //====================================================================//
        // Default Rule Code
        $resolver->setDefault("rule", "value");
        $resolver->setAllowedTypes("rule", array("string"));
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
    }

    //====================================================================//
    // EXECUTION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    final public function execute(array $options, $value): bool
    {
        try {
            //====================================================================//
            // Resolve Constraint Configuration
            $this->options = $this->resolveOptions($options);
            //====================================================================//
            // Execute Constraint Verifications
            return $this->verify($value);
        } catch (Exception $ex) {
            $this->emergency(sprintf("Constraint verification Fail: %s", $ex->getMessage()));
        } catch (TypeError $ex) {
            $this->emergency(sprintf("Constraint verification Fail: %s", $ex->getMessage()));
        }

        return false;
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
            $this->emergency(
                sprintf("Invalid Rules Options: %s", $ex->getMessage()),
                array(get_class($this))
            );

            return false;
        } catch (TypeError $ex) {
            $this->emergency(
                sprintf("Invalid Rules Options: %s", $ex->getMessage()),
                array(get_class($this))
            );

            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    final public function forward(string $ruleCode, $value, array $options = null): bool
    {
        try {
            //====================================================================//
            // Load Rule
            $rule = $this->getRuleByCode($ruleCode);
            //====================================================================//
            // Prepare Options for this Rule
            $resolver = new OptionsResolver();
            $rule->configureOptions($resolver);
            //====================================================================//
            // Execute Rule Verifications
            return $rule->execute(
                array_intersect_key($options ?? $this->options, array_flip($resolver->getDefinedOptions())),
                $value
            );
        } catch (Exception $ex) {
            $this->emergency(
                sprintf("Rule verification Fail: %s", $ex->getMessage()),
                array($ruleCode)
            );
        } catch (TypeError $ex) {
            $this->emergency(
                sprintf("Rule verification Fail: %s", $ex->getMessage()),
                array($ruleCode)
            );
        }

        return false;
    }

    /**
     * @param array $options
     *
     * @throws Exception
     *
     * @return array
     */
    private function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        //====================================================================//
        // Configure Options Resolver for Final Rule
        $this->configureOptions($resolver);
        //====================================================================//
        // Verify None of Core Options are Defined by Rule
        $missingOptions = array_diff(self::CORE_OPTIONS, $resolver->getDefinedOptions());
        if (!empty($missingOptions)) {
            throw new Exception(sprintf(
                "Core options (%s) are missing in rule %s, did you forgot parent::configureOptions ??",
                implode(", ", $missingOptions),
                static::class
            ));
        }

        return $resolver->resolve($options);
    }
}
