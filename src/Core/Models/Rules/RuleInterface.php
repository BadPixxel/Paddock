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

use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paddock Constraint Interface
 */
interface RuleInterface
{
    /**
     * Get Constraint Code.
     *
     * @return string
     */
    public static function getCode(): string;

    /**
     * Get Constraint Description.
     *
     * @return string
     */
    public static function getDescription(): string;

    /**
     * Describe Rule Configuration.
     *
     * Use this function to details what will be checked with this given config.
     *
     * @param array $options
     *
     * @return string
     */
    public static function getRuleDescription(array $options): string;

    /**
     * Configure Resolver for Constraints Configuration
     *
     * @param OptionsResolver $resolver
     */
    public static function configureOptions(OptionsResolver $resolver): void;

    /**
     * Execute Constraint Validation for Configuration
     *
     * @param array $options Rule Options
     * @param mixed $value   Value to Validate
     *
     * @return bool
     */
    public function execute(array $options, $value): bool;

    /**
     * Forward Constraint Validation to another rule
     *
     * @param string     $ruleCode Rule to Execute
     * @param mixed      $value    Value to Validate
     * @param null|array $options  Override Rule Options
     *
     * @return bool
     */
    public function forward(string $ruleCode, $value, array $options = null): bool;

    /**
     * Verify Value
     *
     * @param mixed $value Value to Validate
     *
     * @throws Exception
     *
     * @return bool
     */
    public function verify($value): bool;

    /**
     * Validate Options Pass Resolver Resolution
     *
     * @param array $options Rule Options
     *
     * @return bool
     */
    public function validateOptions(array $options): bool;

    /**
     * Get Name of Metric for this Value
     *
     * @return null|string
     */
    public function getMetricName(): ?string;

    /**
     * Get Options of Metric for this Value
     *
     * @return array
     */
    public function getMetricOptions(): array;
}
