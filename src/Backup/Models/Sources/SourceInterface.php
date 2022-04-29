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

namespace BadPixxel\Paddock\Backup\Models\Sources;

use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Paddock Backup Source Interface
 *
 * Define how Paddock Access to Data Source
 */
interface SourceInterface
{
    //====================================================================//
    // GENERAL INFORMATIONS
    //====================================================================//

    /**
     * Get Source Type Code.
     *
     * @return string
     */
    public static function getCode(): string;

    /**
     * Get Source Type Description.
     *
     * @return string
     */
    public static function getDescription(): string;

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
     * @return SourceInterface
     */
    public function setOptions(array $options);

    /**
     * Configure Resolver for Source Configuration
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
     * Before Backup: Execute any Data Extract | Convert | Cleanup | Zip Operation
     *
     * @return string
     */
    public function getSourcePath(): string;

    /**
     * Collect Information about Files in Source Path
     *
     * @return string
     */
    public function getSourceInformations(): string;

    /**
     * After Backup: Execute any Data Operation
     * Export | Convert | Cleanup | Zip Operation
     *
     * @return bool
     */
    public function beforeBackup(): bool;

    /**
     * After Backup: Clear all Temporary Backup Data
     *
     * @return bool
     */
    public function afterBackup(): bool;

    /**
     * Before Restore: Clear all Temporary Data before Backup data are Imported to Source Path
     *
     * @return bool
     */
    public function beforeRestore(): bool;

    /**
     * After Restore: Execute any Data Operation
     * Imports | Convert | Cleanup | Zip Operation
     *
     * @return bool
     */
    public function afterRestore(): bool;
}
