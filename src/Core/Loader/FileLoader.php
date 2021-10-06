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

namespace BadPixxel\Paddock\Core\Loader;

use Gaufrette\Adapter\Local;
use Gaufrette\Adapter\PhpseclibSftp;
use Gaufrette\Filesystem;
use Monolog\Logger;
use phpseclib\Net\SFTP;

/**
 * Raw Files Loader: Load files from a full path Url
 *
 * @example http://usr:pss@example.com:81/mypath/myfile.yml
 */
class FileLoader
{
    /**
     * Detect Adapter to Use for Connecting this File & return Filesystem
     *
     * @param string $url    Complete Filesystem Url
     * @param Logger $logger Logger
     *
     * @return null|Filesystem
     */
    public static function getFilesystem(string $url, Logger $logger): ?Filesystem
    {
        //====================================================================//
        // Parse Full Path
        $parsedUrl = self::parseFilesystemUrl($url, $logger);
        $filesystem = null;
        if (is_null($parsedUrl)) {
            return null;
        }

        try {
            //====================================================================//
            // Local Adapter
            if (!isset($parsedUrl["scheme"]) || ("local" == $parsedUrl["scheme"])) {
                $filesystem = self::createLocalFilesystem();
            }
            //====================================================================//
            // Sftp Adapter
            if (isset($parsedUrl["scheme"]) && ("sftp" == $parsedUrl["scheme"])) {
                $filesystem = self::createSftpFilesystem($parsedUrl);
            }
            //====================================================================//
            // Safety Checks
            if (!isset($filesystem)) {
                $logger->error("Unable to detect filesystem for ".$url);

                return null;
            }
            $filesystem->isDirectory("./");

            return $filesystem;
        } catch (\Exception $exception) {
            $logger->error($exception->getMessage());

            return null;
        }
    }

    /**
     * Detect File Path
     *
     * @param string $url Complete Filesystem Url
     *
     * @return null|string
     */
    public static function getPath(string $url): ?string
    {
        //====================================================================//
        // Parse Url
        $parsedUrl = parse_url($url);
        if (!is_array($parsedUrl) || empty($parsedUrl["path"])) {
            return null;
        }

        return $parsedUrl["path"] ?? null;
    }

    /**
     * Load File Contents from Local Filesystem or Remote Url
     *
     * @param Filesystem $filesystem
     * @param string     $fullPath   Complete Unparsed File Path
     * @param Logger     $logger     Logger
     *
     * @return null|string
     */
    public static function load(Filesystem $filesystem, string $fullPath, Logger $logger): ?string
    {
        //====================================================================//
        // If File is a Remote File
        $parsedUrl = self::isRemoteFilePath($fullPath);
        if ($parsedUrl) {
            //====================================================================//
            // Load Remote File via Curl
            return self::loadFromRemote($parsedUrl, $logger);
        }

        try {
            //====================================================================//
            // Load Filesystem File via Gaufrette
            $file = $filesystem->get($fullPath);
            //====================================================================//
            // Get File Contents
            return $file->getContent();
        } catch (\Exception $exception) {
            $logger->error($exception->getMessage());

            return null;
        }
    }

    /**
     * Detect if File Path is a Remote Url
     *
     * @param string $fullPath Complete Unparsed File Path
     *
     * @return null|array
     */
    public static function isRemoteFilePath(string $fullPath): ?array
    {
        //====================================================================//
        // Parse Full Path
        $parsedUrl = parse_url($fullPath);
        if (!is_array($parsedUrl)) {
            return null;
        }
        //====================================================================//
        // If No Host Defined
        if (!isset($parsedUrl["host"]) && isset($parsedUrl["path"])) {
            return null;
        }
        //====================================================================//
        // If No Http Schema Defined
        if (!isset($parsedUrl["scheme"])) {
            return null;
        }
        if (!in_array($parsedUrl["scheme"], array("http", "https"), true)) {
            return null;
        }

        return $parsedUrl;
    }

    /**
     * Load File Contents from Remote Url
     *
     * @param array  $parsedUrl
     * @param Logger $logger
     *
     * @return null|string
     */
    private static function loadFromRemote(array $parsedUrl, Logger $logger): ?string
    {
        //====================================================================//
        // Prepare Stream Context
        $context = null;
        if (isset($parsedUrl["user"], $parsedUrl["pass"])) {
            $auth = base64_encode($parsedUrl["user"].":".$parsedUrl["pass"]);
            $context = stream_context_create(array(
                "http" => array(
                    "header" => "Authorization: Basic ".$auth
                )
            ));
        }

        try {
            //====================================================================//
            // Build File from Url
            $fileUrl = ($parsedUrl['scheme'] ?: 'https').'://';
            $fileUrl .= $parsedUrl['host'] ?? '';
            $fileUrl .= isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '';
            $fileUrl .= $parsedUrl['path'] ?? '';
            //====================================================================//
            // Get File from Url
            return file_get_contents($fileUrl, false, $context) ?: null;
        } catch (\Throwable $throwable) {
            $logger->error(sprintf("Unable to read remote file: %s.", $throwable->getMessage()));
        }

        return null;
    }

    /**
     * Parse Url to Detect Filesystem to Use
     *
     * @param string $url    Complete Filesystem Url
     * @param Logger $logger Logger
     *
     * @return null|array
     */
    private static function parseFilesystemUrl(string $url, Logger $logger): ?array
    {
        //====================================================================//
        // Parse Full Path
        $parsedUrl = parse_url($url);
        if (!is_array($parsedUrl)) {
            $logger->error("Unable to decode filesystem url: ".$url);

            return null;
        }
        //====================================================================//
        // Safety Check
        if (empty($parsedUrl["path"])) {
            $logger->error("No filesystem path found on url: ".$url);

            return null;
        }

        return $parsedUrl;
    }

    /**
     * Build Local Filesystem Adapter
     *
     * @return Filesystem
     */
    private static function createLocalFilesystem(): Filesystem
    {
        //====================================================================//
        // Create Local Filesystem
        $filesystem = new Filesystem(
            new Local((string) EnvLoader::get("PADDOCK_DIR"))
        );
        //====================================================================//
        // Safety Check
        $filesystem->isDirectory("./");

        return $filesystem;
    }

    /**
     * Build Local Filesystem Adapter
     *
     * @param array $parsedUrl Parsed Filesystem Url
     *
     * @return Filesystem
     */
    private static function createSftpFilesystem(array $parsedUrl): Filesystem
    {
        //====================================================================//
        // Create Sftp Connexion
        $sftp = new SFTP(
            $parsedUrl["host"] ?? 'localhost',
            $parsedUrl["port"] ?? 22
        );
        //====================================================================//
        // Now you need to log manually with the lib
        if (!empty($parsedUrl["user"]) && !empty($parsedUrl["pass"])) {
            $sftp->login($parsedUrl["user"], $parsedUrl["pass"]);
        }
        //====================================================================//
        // Create Sftp Filesystem
        $filesystem = new Filesystem(
            new PhpseclibSftp($sftp, "/", false)
        );
        //====================================================================//
        // Safety Check
        $filesystem->isDirectory("./");

        return $filesystem;
    }
}
