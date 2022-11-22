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

namespace BadPixxel\Paddock\Apps\Sentry\Collector;

use BadPixxel\Paddock\Apps\Sentry\Services\StatsManager;
use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use BadPixxel\Paddock\Core\Loader\EnvLoader;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Nrpe Server Status Collectors
 */
class SentryStatsCollector extends AbstractCollector
{
    /**
     * @var string[]
     *
     * @see https://docs.sentry.io/product/stats/
     */
    private static $outcome = array(
        "accepted",
        "filtered",
        "rate_limited",
        "invalid",
        "abuse",
        "client_discard",
    );

    /**
     * @var StatsManager
     */
    private $manager;

    /**
     * Sentry Stats Collector constructor.
     *
     * @param StatsManager $manager
     */
    public function __construct(StatsManager $manager)
    {
        $this->manager = $manager;
    }

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "sentry-stats";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect Sentry Statistics";
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $dotEnvUrl = EnvLoader::get("SENTRY_URL");
        //====================================================================//
        // Sentry Generic Connexion Url
        $resolver->setDefault("url", $dotEnvUrl ?: "https://sentry.io/api/0");
        $resolver->setAllowedTypes("url", array("null", "string"));
        //====================================================================//
        // User API Token
        $resolver->setDefault("token", $dotEnvUrl ? parse_url($dotEnvUrl, PHP_URL_PASS) : null);
        $resolver->setAllowedTypes("token", array("null", "string"));
        //====================================================================//
        // User Organization Slug
        $resolver->setDefault("organization", $dotEnvUrl ? parse_url($dotEnvUrl, PHP_URL_USER) : null);
        $resolver->setAllowedTypes("organization", array("null", "string"));
        //====================================================================//
        // Statistics Period
        $resolver->setDefault("period", "1h");
        $resolver->setAllowedTypes("period", array("string"));
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): int
    {
        try {
            //====================================================================//
            // Execute API Request with Outcome Filter
            if (in_array($key, self::$outcome, true)) {
                return (int) $this->manager->getLastHourErrors($this->getOptions(), $key);
            }
            //====================================================================//
            // Execute API Request without Filter
            return (int) $this->manager->getLastHourErrors($this->getOptions());
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        return 0;
    }
}
