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

namespace BadPixxel\Paddock\Core\Loader;

use Symfony\Component\Dotenv\Dotenv;

/**
 * Load & Parse Variables from Environnement
 */
class EnvLoader
{
    /**
     * @var array
     */
    private static $local = array();

    /**
     * Load Local Dot Env Variables
     */
    public static function loadDotEnv(string $projectDir): void
    {
        //====================================================================//
        // Init Dot Env Variables
        $envFilePath = realpath($projectDir.'/.env');
        if ($envFilePath && is_file($envFilePath)) {
            self::$local = (new Dotenv(true))->parse((string) file_get_contents($envFilePath));
        }
        //====================================================================//
        // Store Project Dir in Env
        if (!self::get("PADDOCK_DIR")) {
            self::$local["PADDOCK_DIR"] = $projectDir;
        }
    }

    /**
     * Replace Values by Env Variables
     */
    public static function replace(array $values): array
    {
        //====================================================================//
        // Walk on Input Values
        foreach ($values as &$value) {
            //====================================================================//
            // Safety check
            if (!is_string($value)) {
                continue;
            }
            //====================================================================//
            // Extract Env Value
            $value = self::get($value) ?: $value;
        }

        return $values;
    }

    /**
     * Get Env Variable from Local or System
     *
     * @param string      $key
     * @param null|string $default
     *
     * @return null|string
     */
    public static function get(string $key, string $default = null): ?string
    {
        return self::getFromLocal($key) ?: (self::getFromSystem($key) ?: $default);
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Get Env Variable from Local or System
     *
     * @param string $key
     *
     * @return null|string
     */
    private static function getFromLocal(string $key): ?string
    {
        return self::$local[$key] ?? null;
    }

    /**
     * Get Env Variable from Local or System
     *
     * @param string $key
     *
     * @return null|string
     */
    private static function getFromSystem(string $key): ?string
    {
        return getenv($key) ?: null;
    }
}
