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

namespace BadPixxel\Paddock\Backup\Sources;

use BadPixxel\Paddock\Backup\Models\Sources\AbstractSource;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Manage Backup of Local Files from Specified Dir
 */
class FilesSource extends AbstractSource
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "file";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect files from local filesystem";
    }

    //====================================================================//
    // OPTIONS MANAGEMENT
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        //====================================================================//
        // Path to Sources Files
        $resolver->setDefault("path", null);
        $resolver->setAllowedTypes("path", array("string"));
    }

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function getSourcePath(): string
    {
        return $this->options["path"];
    }

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    final public function beforeBackup(): bool
    {
        $path = $this->getSourcePath();
        //====================================================================//
        // Ensure Directory Exists
        if (!is_dir($path)) {
            return $this->error(sprintf("Directory %s doesn't Exists", $path));
        }
        //====================================================================//
        // Ensure Directory is Readable
        if (!is_readable($path)) {
            return $this->error(sprintf("Directory %s is not Readable", $path));
        }

        return true;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//
}
