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

use Gaufrette\Filesystem;
use Monolog\Logger;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlLoader
{
    /**
     * Parses a YAML from Path with imports.
     *
     * @param Filesystem $filesystem
     * @param string     $path
     * @param Logger     $logger
     *
     * @return array
     */
    public static function parseWithImports(Filesystem $filesystem, string $path, Logger $logger): array
    {
        //====================================================================//
        // Load File Contents
        $fileContents = FileLoader::load($filesystem, $path, $logger);
        if (!$fileContents) {
            return array();
        }
        //====================================================================//
        // Parse Yaml Contents
        $file = Yaml::parse($fileContents, 0);
        //====================================================================//
        // Check if Has Imports
        if (!isset($file["imports"]) || !is_array($file["imports"])) {
            return $file;
        }
        //====================================================================//
        // Load Imports
        $imports = array();
        foreach ($file["imports"] as $import) {
            try {
                $imports = array_replace_recursive(
                    $imports,
                    self::parseWithImports($filesystem, $import, $logger)
                );
            } catch (ParseException $exception) {
                continue;
            }
        }
        unset($file["imports"]);

        return array_replace_recursive($imports, $file);
    }
}
