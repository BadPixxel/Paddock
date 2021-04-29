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

namespace BadPixxel\Paddock\Core\Models\Tracks;

use BadPixxel\Paddock\Core\Loader\EnvLoader;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Models\RulesAwareTrait;
use BadPixxel\Paddock\Core\Services\LogManager;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Monolog\Logger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TypeError;

/**
 * Base Class for Tracks / Rules Collections
 */
abstract class AbstractTrack
{
    use LoggerAwareTrait;
    use RulesAwareTrait;

    /**
     * Rules Options Overrides
     *
     * @var array
     */
    protected $overrides = array();

    /**
     * Track Identifier
     *
     * @var string
     */
    private $code;

    /**
     * Enabled Flag
     *
     * @var bool
     */
    private $enabled = true;

    /**
     * Track Description
     *
     * @var string
     */
    private $description = "This track as no description.";

    /**
     * Default Data Collector Code
     *
     * @var string
     */
    private $collector;

    /**
     * Default Data Collector Options
     *
     * @var string[]
     */
    private $options = array();

    /**
     * Default Rule Code
     *
     * @var string
     */
    private $rule;

    /**
     * Rules / Constraints Collection
     *
     * @var ArrayCollection
     */
    private $rules;

    /**
     * Child Tracks
     *
     * @var ArrayCollection
     */
    private $children;

    /**
     * Abstract Track Constructor.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
        $this->rules = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * Import Track Options Array
     *
     * @param array $options
     *
     * @throws Exception
     *
     * @return bool
     */
    final public function importOptions(array $options): bool
    {
        //====================================================================//
        // Resolve Options
        $resolvedOptions = $this->validateOptions($options, $this->getLogger());
        if (!$resolvedOptions) {
            return false;
        }
        //====================================================================//
        // Detect Default Data Collector
        if ($resolvedOptions["collector"]) {
            $this->collector = (string) $resolvedOptions["collector"];
        }
        //====================================================================//
        // Detect Enabled Flag
        if (is_bool($resolvedOptions["enabled"])) {
            $this->enabled = (bool) $resolvedOptions["enabled"];
        }
        //====================================================================//
        // Detect Descriptions
        if ($resolvedOptions["description"]) {
            $this->description = (string) $resolvedOptions["description"];
        }
        //====================================================================//
        // Detect Default Data Collector Options
        if ($resolvedOptions["options"]) {
            //====================================================================//
            // Replace Options with Environment variables
            $this->options = EnvLoader::replace($resolvedOptions["options"]);
        }
        //====================================================================//
        // Detect Rules Options Overrides
        if ($resolvedOptions["overrides"]) {
            $this->overrides = $resolvedOptions["overrides"];
        }
        //====================================================================//
        // Detect Child Tracks
        if ($resolvedOptions["children"] && is_array($resolvedOptions["children"])) {
            foreach ($resolvedOptions["children"] as $child) {
                $this->addChildren($child);
            }
        }
        //====================================================================//
        // Load Constraints
        foreach ($resolvedOptions["rules"] as $key => $contraint) {
            if (!$this->addRule($key, $contraint)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Import Child Tracks Rules
     *
     * @param AbstractTrack[] $tracks
     *
     * @throws Exception
     *
     * @return bool
     */
    final public function importChildRules(array $tracks): bool
    {
        //====================================================================//
        // Walk on Child Tracks
        foreach ($this->getChildren() as $child) {
            //====================================================================//
            // Safety Check
            if (!isset($tracks[$child['track']]) || !($tracks[$child['track']] instanceof AbstractTrack)) {
                $this->emergency(sprintf("Child track with Code %s not found.", $child['track']));

                return false;
            }
            $childTrack = $tracks[$child['track']];
            //====================================================================//
            // Walk on Child Track Rules
            foreach ($childTrack->getRules() as $rule) {
                //====================================================================//
                // Build Rule Options
                $ruleOptions = array_replace_recursive(
                    $rule,
                    array(
                        'options' => $this->options,
                    ),
                    array(
                        'options' => $child['options'],
                    )
                );
                //====================================================================//
                // Add Rule to Collection
                $this->rules->add($ruleOptions);
            }
        }

        return true;
    }

    /**
     * Validate Track Options Array
     *
     * @param array      $options
     * @param LogManager $logger
     *
     * @return null|array
     */
    final public static function validateOptions(array $options, LogManager $logger): ?array
    {
        $resolver = new OptionsResolver();
        //====================================================================//
        // Configure Options Resolver for Track
        self::configureOptions($resolver);
        //====================================================================//
        // Resolve Options
        try {
            return $resolver->resolve($options);
        } catch (Exception $ex) {
            $logger->log(Logger::EMERGENCY, sprintf("Invalid Rules Options: %s", $ex->getMessage()));
        } catch (TypeError $ex) {
            $logger->log(Logger::EMERGENCY, sprintf("Invalid Rules Options: %s", $ex->getMessage()));
        }

        return null;
    }

    //====================================================================//
    // BASICS GETTERS
    //====================================================================//

    /**
     * Get Track Code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Check if Track is Enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Get Track Description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get Track Default Collector
     *
     * @return null|string
     */
    public function getCollector(): ?string
    {
        return $this->collector;
    }

    /**
     * Get Track Default Rule Code
     *
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule ?: "value";
    }

    /**
     * Get Rules / Constraints
     *
     * @return array[]
     */
    public function getRules(): array
    {
        return $this->rules->toArray();
    }

    /**
     * Get Child Tracks
     *
     * @return array[]
     */
    public function getChildren(): array
    {
        return $this->children->toArray();
    }

    /**
     * Get Rules / Constraints Count
     *
     * @return int
     */
    public function countRules(): int
    {
        return $this->rules->count();
    }

    //====================================================================//
    // BASICS SETTERS
    //====================================================================//

    /**
     * Add a Rule to this Track
     *
     * @param string $key
     * @param array  $definition
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function addRule(string $key, array $definition): bool
    {
        //====================================================================//
        // Detect & Validate Rule Code
        $ruleCode = (isset($definition['rule']) && is_string($definition['rule']))
            ?  $definition['rule']
            : $this->getRule();
        if (!$this->hasRule($ruleCode)) {
            $this->emergency(sprintf("Rule with Code %s not found.", $ruleCode));

            return false;
        }
        //====================================================================//
        // Build Rule Options
        $ruleOptions = array_replace_recursive(
            array(
                'rule' => $ruleCode,
                'key' => $key,
                'collector' => $this->collector,
                'options' => $this->options,
            ),
            $definition,
            $this->overrides
        );

        //====================================================================//
        // Validate Rule Options
        $this->setContext($this->getCode(), $ruleCode, "Rule Options", $ruleOptions);
        if (!$this->getRuleByCode($ruleCode)->validateOptions($ruleOptions)) {
            return false;
        }
        //====================================================================//
        // Add Rule to Collection
        $this->rules->add($ruleOptions);

        return true;
    }

    /**
     * Add Child Track
     *
     * @param mixed $child
     *
     * @return void
     */
    protected function addChildren($child): void
    {
        $trackCode = "undefined";
        $options = array();
        //====================================================================//
        // Detect Child Track Code
        if (is_string($child)) {
            $trackCode = $child;
        }
        if (is_array($child) && isset($child["track"]) && is_string($child["track"])) {
            $trackCode = $child["track"];
            $options = (isset($child["options"]) && is_array($child["options"]))
                ? $child["options"]
                : array()
            ;
        }
        //====================================================================//
        // Store Child Config
        $this->children[] = array(
            "track" => $trackCode,
            "options" => $options,
        );
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Configure Options Resolver
     *
     * @param OptionsResolver $resolver
     */
    final protected static function configureOptions(OptionsResolver $resolver): void
    {
        // Default Data Collector
        $resolver->setDefault("collector", null);
        $resolver->setAllowedTypes("collector", array("null", "string"));
        // Enabled
        $resolver->setDefault("enabled", true);
        $resolver->setAllowedTypes("enabled", array("bool"));
        // Description
        $resolver->setDefault("description", null);
        $resolver->setAllowedTypes("description", array("string"));
        // Options
        $resolver->setDefault("options", array());
        $resolver->setAllowedTypes("options", array("array"));
        // Rules
        $resolver->setDefault("rules", array());
        $resolver->setAllowedTypes("rules", array("array"));
        // Rules Overrides
        $resolver->setDefault("overrides", array());
        $resolver->setAllowedTypes("overrides", array("array"));
        // Child Tracks
        $resolver->setDefault("children", array());
        $resolver->setAllowedTypes("children", array("array"));
    }
}
