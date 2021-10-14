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

namespace BadPixxel\Paddock\Backup\Models\Locations;

use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paddock Backup Location Interface
 *
 * Manage Backup & Restore from Data Source
 */
interface LocationInterface
{
    //====================================================================//
    // GENERAL INFORMATIONS
    //====================================================================//

    /**
     * Get Location Type Code.
     *
     * @return string
     */
    public static function getCode(): string;

    /**
     * Get Location Description.
     *
     * @param array $options
     *
     * @return string
     */
    public static function getDescription(array $options = array()): string;

    //====================================================================//
    // OPTIONS MANAGEMENT
    //====================================================================//

    /**
     * Set Source Configuration
     *
     * @param array $options
     *
     * @throws Exception
     *
     * @return LocationInterface
     */
    public function setOptions(array $options);

    /**
     * Configure Resolver for Location Configuration
     *
     * @param OptionsResolver $resolver
     */
    public static function configureOptions(OptionsResolver $resolver): void;

    /**
     * Validate Options Pass Resolver Resolution
     *
     * @param array $options Rule Options
     *
     * @return bool
     */
    public function validateOptions(array $options): bool;

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * Get Final Backup Target Path
     *
     * @param string            $backupPath
     * @param AbstractOperation $operation
     *
     * @return string
     */
    public function getTargetPath(string $backupPath, AbstractOperation $operation): string;

    /**
     * Collect Information about Backup results
     *
     * @return string
     */
    public function getBackupLog(): string;

    /**
     * Execute Backup: Save Data from Source Path to Target Location
     *
     * @param AbstractOperation $operation
     *
     * @return bool
     */
    public function doBackup(AbstractOperation $operation): bool;

    /**
     * Restoration: Restore Data from a Given Operation
     * Imports | Convert | Cleanup | Zip Operation
     *
     * @param AbstractOperation $operation
     *
     * @return bool
     */
    public function doRestore(AbstractOperation $operation): bool;
}
