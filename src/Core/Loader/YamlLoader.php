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

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlLoader
{
    /**
     * Parses a YAML file with imports.
     *
     * @param string $filename
     * @param int    $flags
     *
     * @return array
     */
    public static function parseFileWithImports(string $filename, int $flags = 0): array
    {
        //====================================================================//
        // Load Configuration Yaml File
        $file = Yaml::parseFile($filename, $flags);
        //====================================================================//
        // Check if Has Imports
        if (!isset($file["imports"]) || !is_array($file["imports"])) {
            return $file;
        }
        //====================================================================//
        // Load Imports
        $imports = array();
        foreach ($file["imports"] as $importFile) {
            $realPath = realpath(\dirname($filename)."/".$importFile);
            if (!$realPath || !is_file($realPath)) {
                continue;
            }

            try {
                $imports = array_replace_recursive(
                    $imports,
                    Yaml::parseFile($realPath, $flags)
                );
            } catch (ParseException $exception) {
                continue;
            }
        }
        unset($file["imports"]);

        return array_replace_recursive($imports, $file);
    }
}
