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

namespace BadPixxel\Paddock\Apps\Nrpe\Services;

use BadPixxel\Paddock\Core\Loader\EnvLoader;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Services\TracksManager;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Paddock Nrpe Commands Manager
 */
class CommandsManager
{
    use LoggerAwareTrait;

    const NRPE_CFG_PATH = "/etc/nagios/nrpe.d";
    const NRPE_CFG_FILE = "paddock.cfg";
    const NRPE_BIN = "php";

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var TracksManager
     */
    private $tracks;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Service Constructor
     *
     * @param string $projectDir
     */
    public function __construct(string $projectDir, TracksManager $tracks)
    {
        $this->projectDir = $projectDir;
        $this->tracks = $tracks;
        //====================================================================//
        // Init Filesystem
        $this->filesystem = new Filesystem();
    }

    /**
     * Deploy Paddock Nrpe Configuration
     */
    public function deploy(): bool
    {
        //====================================================================//
        // Build Configuration File
        $rawConfig = $this->buildConfigFile($this->getBinaryPath());

        try {
            //====================================================================//
            // Ensure path Exists
            if (!$this->filesystem->exists($this->getLocalCfgPath())) {
                $this->filesystem->mkdir($this->getLocalCfgPath());
            }
            //====================================================================//
            // Write Configuration
            $fullPath = $this->getLocalCfgPath()."/".self::NRPE_CFG_FILE;
            $this->filesystem->dumpFile($fullPath, $rawConfig);
        } catch (IOException $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->warning("Nrpe Config written in ".$fullPath);
    }

    /**
     * Check Paddock Nrpe Configuration
     */
    public function check(): bool
    {
        $fullPath = $this->getLocalCfgPath()."/".self::NRPE_CFG_FILE;
        //====================================================================//
        // Build Configuration File
        $rawConfig = $this->buildConfigFile($this->getBinaryPath());
        //====================================================================//
        // Ensure File Exists
        if (!$this->filesystem->exists($fullPath)) {
            return $this->error(sprintf("File %s doesn't Exists", $fullPath));
        }
        //====================================================================//
        // Check File Contents
        if (md5($rawConfig) != md5_file($fullPath)) {
            return $this->error(sprintf("File %s is not Up-To-Date", $fullPath));
        }

        return true;
    }

    /**
     * Build Paddock Nrpe Check Command string
     */
    public function buildConfigFile(string $binary = self::NRPE_BIN): string
    {
        $rawConfig = $this->buildHeader();
        //====================================================================//
        // Add Static Commands
        $rawConfig .= "# Paddock Static Commands".PHP_EOL;
        $rawConfig .= $this->buildCommand("paddock", "\$ARG1\$", $binary).PHP_EOL;
        $rawConfig .= $this->buildCommand("paddock_full", "all", $binary).PHP_EOL;

        //====================================================================//
        // Load List of Available Tracks
        $allTracks = $this->tracks->getAll();
        $rawConfig .= "# Paddock Tracks Commands".PHP_EOL;
        foreach ($allTracks as $code => $track) {
            $rawConfig .= $this->buildCommand("paddock_".$code, $code, $binary).PHP_EOL;
        }
        //====================================================================//
        // Reset Logger Context
        $this->getLogger()->resetContext();

        return $rawConfig;
    }

    /**
     * Get Nrpe Local Configuration Path
     */
    private function getLocalCfgPath(): string
    {
        //====================================================================//
        // Load Nrpe Config Path from Env
        $cfgPath = EnvLoader::get("NRPE_CFG_PATH", self::NRPE_CFG_PATH);
        if (empty($cfgPath)) {
            $this->error("No Nrpe Configuration Path Identified");

            return "";
        }

        return $cfgPath;
    }

    /**
     * Get Nrpe Binary Path
     */
    private function getBinaryPath(): string
    {
        //====================================================================//
        // Load Nrpe Config Path from Env
        $cfgPath = EnvLoader::get("NRPE_BIN", self::NRPE_BIN);
        if (empty($cfgPath)) {
            $this->error("No Nrpe Binary Path Identified");

            return "";
        }

        return $cfgPath;
    }

    /**
     * Build Nrpe Config Header
     */
    private function buildHeader(): string
    {
        return PHP_EOL
            ."######################################".PHP_EOL
            ."# Paddock Nrpe Configuration (generated)".PHP_EOL
            ."######################################".PHP_EOL
            .PHP_EOL
        ;
    }

    /**
     * Build Paddock Nrpe Check Command string
     *
     * @param string $name
     * @param string $track
     * @param string $binary
     *
     * @return string
     */
    private function buildCommand(string $name, string $track, string $binary = "php"): string
    {
        return sprintf(
            "command[check_%s]=%s %s/bin/console paddock:run %s -f=nrpe -n --no-debug",
            trim($name),
            trim($binary),
            trim($this->projectDir),
            trim($track)
        );
    }
}
