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

namespace BadPixxel\Paddock\Backup\Locations;

use BadPixxel\Paddock\Backup\Helpers\PathInfosBuilder;
use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use Exception;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use ZipArchive;

/**
 * Manage Backup of Local Files from Specified Dir to Zip on Local System
 */
class ZipLocation extends FilesLocation
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "zip";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(array $options = array()): string
    {
        return "Copy source files to "
            .($options["path"] ?? "zip file")
        ;
    }

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function doBackup(AbstractOperation $operation): bool
    {
        try {
            $targetPath = $this->getTargetDirectory($operation);
            $targetFile = $targetPath."/zipBackup.zip";
            $filesystem = new Filesystem();
            //====================================================================//
            // Ensure Target Directory Exists & is Writable
            if (!$this->checkTargetDirectory($operation)) {
                return false;
            }
            //====================================================================//
            // Verify Zip Extension is Loaded
            if (!extension_loaded("zip")) {
                return $this->error('Zip PHP Extension is required to build Zip Backups.');
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
            // Create the archive
            $zip = new ZipArchive();
            if (true !== $zip->open($targetFile, ZIPARCHIVE::CREATE)) {
                return $this->error("Unable to Create Zip Archive: ".$targetFile);
            }
            //====================================================================//
            // Add the files
            if (self::addDir($zip, $operation->getSourcePath()) <= 0) {
                return $this->error("No Files found for Zip Archive.");
            }
            //====================================================================//
            // Close the zip -- done!
            $zip->close();
            //====================================================================//
            // Push Operation Results to Log
            $this->setBackupLog(sprintf(
                "Backup File %s (%s)",
                $targetFile,
                PathInfosBuilder::getFilesSize($targetFile)
            ));
        } catch (Exception $ex) {
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
            $targetFile = $targetPath."/zipBackup.zip";
            $sourcePath = $operation->getSourcePath();
            //====================================================================//
            // Ensure Target Zip Exists
            if (!is_file($targetFile)) {
                return $this->error('Backup file not found: '.$targetFile);
            }
            //====================================================================//
            // Verify Zip Extension is Loaded
            if (!extension_loaded("zip")) {
                return $this->error('Zip PHP Extension is required to restore Zip Backups.');
            }
            //====================================================================//
            // Open the archive
            $zip = new ZipArchive();
            if (true !== $zip->open($targetFile)) {
                return $this->error("Unable to Open Zip Archive: ".$targetFile);
            }

            //====================================================================//
            // Ensure Source Directory Exists
            if (!is_dir($sourcePath)) {
                return $this->error('Source Directory not found: '.$sourcePath);
            }
            //====================================================================//
            // Ensure Source Directory is Writable
            if (!is_writeable($sourcePath)) {
                return $this->error('Source Directory is not Writable: '.$sourcePath);
            }
            //====================================================================//
            // Extract the archive
            $zip->extractTo($sourcePath.'/');
            $zip->close();
        } catch (IOException $ex) {
            return $this->error($ex->getMessage());
        }

        return true;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Add Full Directory to Zip Archive
     *
     * @param ZipArchive $zip
     * @param string     $srcDirectory
     * @param string     $innerDirectory
     *
     * @return int
     */
    private static function addDir(ZipArchive $zip, string $srcDirectory, string $innerDirectory = ""): int
    {
        //====================================================================//
        // List Files to Add on Zip
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $finder->files()->in($srcDirectory);
        // check if there are any search results
        if (!$finder->hasResults()) {
            return 0;
        }

        //====================================================================//
        // Add the files
        foreach ($finder as $file) {
            $zip->addFile(
                (string) $file->getRealPath(),
                $innerDirectory.$file->getRelativePathname()
            );
        }

        return $finder->count();
    }
}
