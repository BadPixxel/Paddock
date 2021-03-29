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
     * @param array $configuration
     *
     * @return string
     */
    public static function getRuleDescription(array $configuration): string;

    /**
     * Configure Resolver for Constraints Configuration
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void;

    /**
     * Execute Constraint Validation for Configuration
     *
     * @param array $options
     * @param mixed $value
     */
    public function execute(array $options, $value): void;

    /**
     * Verify Value
     *
     * @param mixed $value
     */
    public function verify($value): void;

    /**
     * Validate Options Pass Resolver Résolution
     *
     * @param array $options
     *
     * @return bool
     */
    public function validateOptions(array $options): bool;
}
