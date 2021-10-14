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

namespace BadPixxel\Paddock\Backup\Helpers;

use Exception;
use Symfony\Component\Finder\Finder;

/**
 * Build Directories & Files Control Checksums
 */
class PathInfosBuilder
{
    /**
     * Count Number of Files in Directory
     *
     * @param string $path
     *
     * @throws Exception
     *
     * @return int
     */
    public static function getFilesCount(string $path): int
    {
        //====================================================================//
        // Ensure Target Path is a Directory
        $path = self::toDir($path);
        //====================================================================//
        // Count Files
        $finder = new Finder();
        $finder->files()->in($path);

        return $finder->count();
    }

    /**
     * Size of Files in Directory
     *
     * @param string $path
     *
     * @throws Exception
     *
     * @return string
     */
    public static function getFilesSize(string $path): string
    {
        //====================================================================//
        // Ensure Target Path is a Directory
        $path = self::toDir($path);
        //====================================================================//
        // Count Files
        $finder = new Finder();
        $finder->files()->in($path);
        $bytes = 0;
        foreach ($finder as $file) {
            $bytes += $file->getSize();
        }

        return self::toFormattedSize($bytes);
    }

    /**
     * Generate Unique Md5 Checksum for Contents of a Local Path
     *
     * @param string $path
     *
     * @throws Exception
     *
     * @return string
     */
    public static function getPathMd5(string $path): string
    {
        //====================================================================//
        // Ensure Target Path is a Directory
        $path = self::toDir($path);
        //====================================================================//
        // Compute Checksum
        $finder = new Finder();
        $finder->files()->sortByName()->in($path);
        $checksum = "";
        foreach ($finder as $file) {
            $checksum .= md5_file((string) $file->getRealPath());
        }

        return md5($checksum);
    }

    /**
     * Ensure Target Path is a Directory or Use Parent Dir
     *
     * @param string $path
     *
     * @throws Exception
     *
     * @return string
     */
    private static function toDir(string $path): string
    {
        //====================================================================//
        // Ensure Target Path is a Directory
        if (!is_dir($path)) {
            if (is_file($path)) {
                return dirname($path);
            }

            throw new Exception(sprintf("Invalid Path for Checksum: %s", $path));
        }

        return $path;
    }

    /**
     * Convert File size in Bytes to Human Readable Size
     *
     * @param float|int $bytes
     * @param int       $precision
     *
     * @return string
     */
    private static function toFormattedSize($bytes, $precision = 2): string
    {
        $base = log($bytes, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }
}
