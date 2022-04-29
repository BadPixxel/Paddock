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

namespace BadPixxel\Paddock\Apps\Nrpe\Collector;

use BadPixxel\Paddock\Apps\Nrpe\Services\CommandsManager;
use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Nrpe Server Status Collectors
 */
class NrpeStatusCollector extends AbstractCollector
{
    /**
     * @var CommandsManager
     */
    private $manager;

    /**
     * Nrpe Collector constructor.
     *
     * @param CommandsManager $manager
     */
    public function __construct(CommandsManager $manager)
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
        return "nrpe-status";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect Nrpe Server Status";
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
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        switch ($key) {
            case "config":
                return $this->manager->check() ? "ok" : "ko";
        }

        $this->error("Requested Status key not found.");

        return '';
    }
}
