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

namespace BadPixxel\Paddock\Backup\Locations;

use BadPixxel\Paddock\Backup\Helpers\PathInfosBuilder;
use BadPixxel\Paddock\Backup\Models\Locations\AbstractLocation;
use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Manage Backup of Local Files from Specified Dir to Local Locations
 */
class FilesLocation extends AbstractLocation
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
    public static function getDescription(array $options = array()): string
    {
        return "Copy source files to "
            .($options["path"] ?? "local filesystem")
        ;
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
        //====================================================================//
        // File Mode
        $resolver->setDefault("mode", "755");
        $resolver->setAllowedTypes("mode", array("string"));
    }

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * Ensure Target Directory Exists & Is Writable
     *
     * @param AbstractOperation $operation
     *
     * @return string
     */
    public function getTargetDirectory(AbstractOperation $operation): string
    {
        return $this->options["path"].'/'.$operation->getCode();
    }

    /**
     * {@inheritDoc}
     */
    public function doBackup(AbstractOperation $operation): bool
    {
        try {
            $targetPath = $this->getTargetDirectory($operation);
            $filesystem = new Filesystem();
            //====================================================================//
            // Compute Checksum of Source Location
            $sourceMd5 = PathInfosBuilder::getPathMd5($operation->getSourcePath());
            //====================================================================//
            // Ensure Target Directory Exists & is Writable
            if (!$this->checkTargetDirectory($operation)) {
                return false;
            }
            //====================================================================//
            // Delete Target Directory
            if (is_dir($targetPath)) {
                $filesystem->remove($targetPath);
            }
            //====================================================================//
            // Re-Create Target Directory
            $filesystem->mkdir($targetPath, $this->options["mode"]);
            //====================================================================//
            // Copy Data to Target Directory
            $filesystem->mirror($operation->getSourcePath(), $targetPath, null, array(
                'override' => true,
                'delete' => true,
            ));
            //====================================================================//
            // Compute Checksum of Target Location
            $targetMd5 = PathInfosBuilder::getPathMd5($targetPath);
            if ($sourceMd5 != $targetMd5) {
                return $this->error("Backup Fail: Source & Target Directory are not similar");
            }
            //====================================================================//
            // Push Operation Results to Log
            $this->setBackupLog(sprintf(
                "Backup Dir includes %s files for %s of Data (Md5 %s)",
                PathInfosBuilder::getFilesCount($targetPath),
                PathInfosBuilder::getFilesSize($targetPath),
                $targetMd5
            ));
        } catch (IOException $ex) {
            return $this->error($ex->getMessage());
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function doRestore(AbstractOperation $operation): bool
    {
        try {
            $targetPath = $this->getTargetDirectory($operation);
            $filesystem = new Filesystem();
            //====================================================================//
            // Compute Checksum of Target Location
            $targetMd5 = PathInfosBuilder::getPathMd5($targetPath);
            //====================================================================//
            // Ensure Source Directory Exists & is Writable
            if (!$this->checkSourceDirectory($operation)) {
                return false;
            }
            //====================================================================//
            // Copy Data to Source Directory
            $filesystem->mirror($targetPath, $operation->getSourcePath(), null, array(
                'override' => true,
                'delete' => true,
            ));
            //====================================================================//
            // Compute Checksum of Source Location
            $sourceMd5 = PathInfosBuilder::getPathMd5($operation->getSourcePath());
            if ($sourceMd5 != $targetMd5) {
                return $this->error("Restore Fail: Source & Target Directory are not similar");
            }
        } catch (IOException $ex) {
            return $this->error($ex->getMessage());
        }

        return true;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Ensure Target Directory Exists & Is Writable
     *
     * @param AbstractOperation $operation
     *
     * @return bool
     */
    protected function checkTargetDirectory(AbstractOperation $operation): bool
    {
        $path = $this->getTargetDirectory($operation);
        $filesystem = new Filesystem();
        //====================================================================//
        // Ensure Directory Exists
        if (!is_dir($path)) {
            $filesystem->mkdir($path, $this->options["mode"]);
        }
        if (!is_dir($path)) {
            return $this->error(sprintf("Target Directory %s doesn't Exists", dirname($path)));
        }
        //====================================================================//
        // Ensure Directory is Writable
        if (!is_writeable($path)) {
            return $this->error(sprintf("Target Directory %s is not Writable", $path));
        }

        return true;
    }

    /**
     * Ensure Target Directory Exists & Is Writable
     *
     * @param AbstractOperation $operation
     *
     * @return bool
     */
    protected function checkSourceDirectory(AbstractOperation $operation): bool
    {
        $path = $operation->getSourcePath();
        //====================================================================//
        // Ensure Directory Exists
        if (!is_dir($path)) {
            return $this->error(sprintf("Source Directory %s doesn't Exists", $path));
        }
        //====================================================================//
        // Ensure Directory is Writable
        if (!is_writeable($path)) {
            return $this->error(sprintf("Source Directory %s is not Writable", $path));
        }

        return true;
    }
}
