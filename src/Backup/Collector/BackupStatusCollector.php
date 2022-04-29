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

namespace BadPixxel\Paddock\Backup\Collector;

use BadPixxel\Paddock\Backup\Helpers\StatusStorage;
use BadPixxel\Paddock\Backup\Services\BackupManager;
use BadPixxel\Paddock\Core\Collector\AbstractCollector;

/**
 * Backup Locations Status Collectors
 */
class BackupStatusCollector extends AbstractCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "backup-status";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Backup Locations Status Collector";
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        $result = true;
        //====================================================================//
        // Load List of Available Backup Operations
        $allOperations = BackupManager::getInstance()->getAllOperations();
        //====================================================================//
        // An Operation Code is Specified
        if (in_array($key, array_keys($allOperations), true)) {
            foreach ($allOperations[$key]->getLocations() as $locationPath) {
                $result &= StatusStorage::isSuccessful($key, $locationPath);
            }

            return $result ? "Ok" : "";
        }
        //====================================================================//
        // Check All Operations Status
        foreach ($allOperations as $code => $operation) {
            foreach ($operation->getLocations() as $locationPath) {
                $result &= StatusStorage::isSuccessful($code, $locationPath);
            }
        }

        return $result ? "All Ok!" : "";
    }
}
