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

use BadPixxel\Paddock\Backup\Models\Locations\AbstractLocation;
use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use BadPixxel\Paddock\System\Shell\Helpers\CmdRunner;
use Exception;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Manage Backup of Local Files from Specified Dir to Rdiff Url
 */
class RdiffLocation extends AbstractLocation
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "rdiff";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(array $options = array()): string
    {
        return "Copy source files to "
            .($options["path"] ?? "rdiff backup server")
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
        // R diff backup Host
        $resolver->setDefault("host", null);
        $resolver->setAllowedTypes("host", array("string"));
        //====================================================================//
        // R diff backup User
        $resolver->setDefault("user", null);
        $resolver->setAllowedTypes("user", array("string"));
        //====================================================================//
        // R diff backup Password
        $resolver->setDefault("pass", null);
        $resolver->setAllowedTypes("pass", array("null", "string"));
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
            //====================================================================//
            // Ensure Binary is Installed
            if (!$this->ensureBinaryIsInstalled()) {
                return false;
            }
            //====================================================================//
            // Build Backup Command
            $command = array(
                "rdiff-backup",
                "-v5",
                "--print-statistics",
                "--force",
                $operation->getSourcePath(),
                $this->getTargetDirectorUrl($operation)
            );
            //====================================================================//
            // Execute Backup Command
            if (true !== CmdRunner::run($command)) {
                //====================================================================//
                // Push Operation Results to Log
                $this->setBackupLog((string) CmdRunner::getExitCodeText());

                return $this->error("Rdiff Backup Fail: ".CmdRunner::getResult());
            }
            //====================================================================//
            // Push Operation Results to Log
            $this->setBackupLog((string) CmdRunner::getResult());
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
            $sourcePath = $operation->getSourcePath();
            //====================================================================//
            // Ensure Source Directory Exists
            if (!is_dir($sourcePath)) {
                return $this->error('Source Directory not found: '.$sourcePath);
            }
            //====================================================================//
            // Build Restore Command
            $command = array(
                "rdiff-backup",
                "--restore-as-of",
                "now",
                "--force",
                $this->getTargetDirectorUrl($operation),
                $operation->getSourcePath()
            );
            //====================================================================//
            // Execute Restore Command
            if (true !== CmdRunner::run($command)) {
                return $this->error("Rdiff Restore Fail: ".CmdRunner::getResult());
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
     * Ensure R Diff Backup is Installed on Local System
     *
     * @throws Exception
     *
     * @return bool
     */
    private function ensureBinaryIsInstalled(): bool
    {
        return !$this->tracksRunner->executeRule(null, array(
            "collector" => "apt-version",
            "rule" => "version",
            "key" => "rdiff-backup",
            "ne" => true,
        ))->hasErrors();
    }

    /**
     * Get Remote Url
     *
     * @param AbstractOperation $operation
     *
     * @return string
     */
    private function getTargetDirectorUrl(AbstractOperation $operation): string
    {
        $url = (string) $this->options["user"];
        $url .= '@'.$this->options["host"];
        $url .= '::'.$this->options["path"];
        $url .= '/'.$operation->getCode();

        return $url;
    }
}
