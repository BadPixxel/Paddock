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

use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
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
     * @var array
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
     * Abstract Track Constructor.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
        $this->rules = new ArrayCollection();
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * Import Track Options Array
     *
     * @param array $options
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
            $this->options = $resolvedOptions["options"];
        }
        //====================================================================//
        // Detect Rules Options Overrides
        if ($resolvedOptions["overrides"]) {
            $this->options = $resolvedOptions["overrides"];
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
     * @return AbstractRule[]
     */
    public function getRules(): array
    {
        return $this->rules->toArray();
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
        // Build Rule Options
        $ruleOptions = array_replace_recursive(
            array(
                'key' => $key,
                'collector' => $this->collector,
                'options' => $this->options,
            ),
            $definition,
            $this->overrides
        );
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
    }
}
