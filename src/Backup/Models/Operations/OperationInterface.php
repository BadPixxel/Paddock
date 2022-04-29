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

namespace BadPixxel\Paddock\Backup\Models\Operations;

use BadPixxel\Paddock\Backup\Models\Locations\AbstractLocation;
use BadPixxel\Paddock\Backup\Models\Sources\AbstractSource;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paddock Backup Operation Interface
 *
 * Define how Paddock Dose a Backup from ONE Data Source to MULTIPLE Locations
 */
interface OperationInterface
{
    //====================================================================//
    // GENERAL INFORMATIONS
    //====================================================================//

    /**
     * Get Backup Operation Type Code.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Get Backup Operation is Active.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Get Backup Operation Type Description.
     *
     * @return string
     */
    public function getDescription(): string;

    //====================================================================//
    // OPTIONS MANAGEMENT
    //====================================================================//

    /**
     * Configure Resolver for Backup Operation Configuration
     *
     * @param OptionsResolver $resolver
     */
    public static function configureOptions(OptionsResolver $resolver): void;

//    /**
//     * Validate Options Pass Resolver Resolution
//     *
//     * @param array $options Rule Options
//     *
//     * @return bool
//     */
//    public function validateOptions(array $options): bool;

    //====================================================================//
    // OPERATION DEFINITIONS
    //====================================================================//

    /**
     * Get Backup Source Path
     *
     * @return string
     */
    public function getSource(): string;

    /**
     * Get Backup Source Type Code
     *
     * @return string
     */
    public function getSourceType(): string;

    /**
     * Get Backup Source Path
     *
     * @return string
     */
    public function getSourcePath(): string;

    /**
     * Get Backup Source Options
     *
     * @return array
     */
    public function getSourceOptions(): array;

    /**
     * Get Backup Location Path
     *
     * @return null|string
     */
    public function getTarget(): ?string;

    /**
     * Get Backup Location Options
     *
     * @return array
     */
    public function getTargetOptions(): array;

    /**
     * Get Backup Location Paths
     *
     * @return string[]
     */
    public function getTargetPaths(): array;

    /**
     * Get Backup Locations
     *
     * @return string[]
     */
    public function getLocations(): array;

    /**
     * Get Backup Location Options
     *
     * @param AbstractSource     $sourceService
     * @param AbstractLocation[] $targetServices
     *
     * @return void
     */
    public function configure(AbstractSource $sourceService, array $targetServices): void;

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * Execute Backup: Save Data from Source Path to Target Location
     *
     * @throws Exception
     *
     * @return bool
     */
    public function doBackup(): bool;

    /**
     * Execute Restore: Restore Data from Target Location to Source Path
     *
     * @param string $locationPath
     *
     * @throws Exception
     *
     * @return bool
     */
    public function doRestore(string $locationPath): bool;
}
