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

namespace BadPixxel\Paddock\Core\Collector;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paddock Data Collector Interface
 */
interface CollectorInterface
{
    /**
     * Get Collector Code.
     *
     * @return string
     */
    public static function getCode(): string;

    /**
     * Get Collector Description.
     *
     * @return string
     */
    public static function getDescription(): string;

    /**
     * Configure Resolver for Collector Configuration
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void;

    /**
     * Get Data from Collector Service with Options
     *
     * @param array  $options
     * @param string $key
     *
     * @return mixed
     */
    public function getData(array $options, string $key);
}
