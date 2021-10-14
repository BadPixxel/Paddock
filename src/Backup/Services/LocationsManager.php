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

namespace BadPixxel\Paddock\Backup\Services;

use BadPixxel\Paddock\Backup\Helpers\UrlParser;
use BadPixxel\Paddock\Backup\Models\Locations\AbstractLocation;
use BadPixxel\Paddock\Core\Services\ConfigurationManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Exception;

/**
 * Manage Backup Location for Pushing Data to back up
 */
class LocationsManager
{
    /**
     * @var LogManager
     */
    private $logManager;

    /**
     * @var ConfigurationManager
     */
    private $configuration;

    /**
     * @var AbstractLocation[]
     */
    private $locations = array();

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     *
     * @param iterable             $locations
     * @param ConfigurationManager $configuration
     * @param LogManager           $logManager
     *
     * @throws Exception
     */
    public function __construct(iterable $locations, ConfigurationManager $configuration, LogManager $logManager)
    {
        $this->configuration = $configuration;
        $this->logManager = $logManager;
        //====================================================================//
        // Load Locations
        $this->loadLocations($locations);
    }

    //====================================================================//
    // LOCATIONS MANAGEMENT
    //====================================================================//

    /**
     * Get a Location by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractLocation
     */
    public function getByCode(string $code): AbstractLocation
    {
        if (!isset($this->locations[$code])) {
            throw new Exception(sprintf("Location with code %s  was not found.", $code));
        }

        return $this->locations[$code];
    }

    /**
     * Get List of All Available Location
     *
     * @return AbstractLocation[]
     */
    public function getAll(): array
    {
        dump($this->configuration->getBackupLocations());

        return $this->locations;
    }

    /**
     * Get Locations by Target Path
     *
     * @param null|string $path
     *
     * @throws Exception
     *
     * @return array<string, AbstractLocation>
     */
    public function getConfigurationFromPath(?string $path = null): array
    {
        //====================================================================//
        // Default => Load Backup Locations Paths from Env
        if (empty($path) || ('auto' == $path)) {
            $path = $this->configuration->getBackupLocations();
        }
        if (empty($path)) {
            $this->logManager->getLogger()->error("No Default Backup Path Identified");

            return array();
        }
        //====================================================================//
        // Explode Locations Path
        $locationsPaths = array_map(
            function (string $path): string {
                return trim($path);
            },
            (array) explode(";", $path)
        );
        //====================================================================//
        // Walk on Backup Locations
        $configurations = array();
        foreach ($locationsPaths as $locationsPath) {
            $type = UrlParser::toType($locationsPath);
            if (empty($type)) {
                $this->logManager->getLogger()->error(sprintf(
                    "Backup Path %s is Invalid",
                    $locationsPath
                ));

                continue;
            }
            $locationService = $this->getByCode($type);
            $options = UrlParser::toOptions($locationsPath);
            if (!$locationService->validateOptions($options)) {
                continue;
            }
            $configurations[$locationsPath] = $locationService;
        }

        return $configurations;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Initialize List of Available Locations
     *
     * @param iterable $locations
     *
     * @throws Exception
     *
     * @return int
     */
    private function loadLocations(iterable $locations): int
    {
        foreach ($locations as $code => $location) {
            if ($location instanceof AbstractLocation) {
                $this->locations[$code] = $location;

                continue;
            }

            throw new Exception(sprintf(
                "Backup Location %s must extends %s.",
                get_class($location),
                AbstractLocation::class
            ));
        }

        return count($this->locations);
    }
}
