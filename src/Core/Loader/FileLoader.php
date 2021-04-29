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

use Monolog\Logger;

/**
 * Raw Files Loader: Load files from a full path Url
 *
 * @example http://usr:pss@example.com:81/mypath/myfile.yml
 */
class FileLoader
{
    /**
     * Load File Contents from Local or Remote
     *
     * @param string      $fullPath Complete Unparsed File Path
     * @param null|string $basePath Base Path for Local Files
     * @param Logger      $logger   Logger
     *
     * @return null|string
     */
    public static function load(string $fullPath, Logger $logger, string $basePath = null): ?string
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
            $projectDir = $basePath ?? EnvLoader::get("PADDOCK_DIR");

            return self::loadFromFilesystem($parsedUrl["path"], $logger, (string) $projectDir);
        }

        return self::loadFromRemote($parsedUrl, $logger);
    }

    /**
     * Load File Contents from Local File System
     *
     * @param string $path
     * @param Logger $logger
     * @param string $basePath
     *
     * @return null|string
     */
    private static function loadFromFilesystem(string $path, Logger $logger, string $basePath): ?string
    {
        //====================================================================//
        // Ensure File Exists
        $realPath = realpath($basePath."/".$path);
        if (!$realPath || !is_file($realPath)) {
            $logger->error(sprintf("File %s not found.", $realPath));

            return null;
        }
        //====================================================================//
        // Ensure File Is Readable
        if (!is_readable($realPath)) {
            $logger->error(sprintf("File %s is unreadable.", $realPath));

            return null;
        }

        return file_get_contents($realPath, false) ?: null;
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
}
