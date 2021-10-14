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

namespace BadPixxel\Paddock\System\Shell\Helpers;

use BadPixxel\Paddock\Core\Services\LogManager;
use Monolog\Logger;
use Symfony\Component\Process\Process;

/**
 * Just a few tooling Class to Execute Shell Commands
 */
class CmdRunner
{
    /**
     * @var Process
     */
    private static $process;

    /**
     * Get Last Command Outputs
     *
     * @return null|string
     */
    public static function getCommandLine(): ?string
    {
        return self::$process->getCommandLine();
    }

    /**
     * Get Last Command Outputs
     *
     * @return null|string
     */
    public static function getResult(): ?string
    {
        return self::$process->getOutput();
    }

    /**
     * Search Last Command Outputs for Line Starting by Keyword
     *
     * @param string $pattern
     * @param bool   $removePattern
     *
     * @return null|string
     */
    public static function searchInResults(string $pattern, bool $removePattern = false): ?string
    {
        //====================================================================//
        // Explode Command Outputs to Array
        $resArray = explode("\n", (string) CmdRunner::getResult());
        //====================================================================//
        // Search for Pattern
        foreach ($resArray as $result) {
            if (0 === strpos($result, $pattern)) {
                //====================================================================//
                // Remove Pattern from Result Line
                if ($removePattern) {
                    return trim(substr($result, strlen($pattern)));
                }

                return $result;
            }
        }

        return null;
    }

    /**
     * Get Last Command Exit Code
     *
     * @return null|int
     */
    public static function getExitCode(): ?int
    {
        return self::$process->getExitCode();
    }

    /**
     * Get Last Command Exit Text
     *
     * @return null|string
     */
    public static function getExitCodeText(): ?string
    {
        return self::$process->getExitCodeText();
    }

    /**
     * Execute Console Command
     */
    public static function run(array $command): bool
    {
        //====================================================================//
        // Execute Shell Command
        self::$process = new Process($command);
        self::$process->setPty(true)->run();
        //====================================================================//
        // Check Command Worked
        if (self::$process->isSuccessful()) {
            return true;
        }
        //====================================================================//
        // Report Error
        return self::getLogger()->error("Shell command fail", array(
            "command" => self::getCommandLine(),
            "code" => self::getExitCode(),
            "text" => self::getExitCodeText()
        ));
    }

    //====================================================================//
    // VARIOUS TOOLS
    //====================================================================//

    /**
     * Search for Binary Real Path on Local System
     *
     * @param string $binary
     *
     * @return null|string
     */
    public static function findBinary(string $binary): ?string
    {
        foreach (self::getBinLocations() as $path) {
            if (is_file($path."/".$binary)) {
                return $path."/".$binary;
            }
        }
        self::getLogger()->error(sprintf("No binary found for '%s'", $binary));

        return null;
    }

    /**
     * Get List of Possible Path for Binaries on Local System
     *
     * @return string[]
     */
    public static function getBinLocations(): array
    {
        static $paths;

        if (!isset($paths)) {
            /** @var null|false|string $sysPaths */
            $sysPaths = filter_input(INPUT_ENV, "PATH");

            $paths = array_unique(array_merge_recursive(
                array("", "/bin", "/usr/bin"),
                $sysPaths ? explode(":", $sysPaths) : array()
            ));
        }

        return $paths;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Get Logger
     *
     * @return Logger
     */
    private static function getLogger(): Logger
    {
        return LogManager::getInstance()->getLogger();
    }
}
