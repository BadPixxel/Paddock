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

namespace BadPixxel\Paddock\Core\Services;

use BadPixxel\Paddock\Core\Loader\EnvLoader;
use BadPixxel\Paddock\Core\Loader\FileLoader;
use BadPixxel\Paddock\Core\Loader\YamlLoader;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Paddock Configuration Manager
 */
class ConfigurationManager
{
    use LoggerAwareTrait;

    const CACHE_KEY = "paddock_config";

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var null|array
     */
    private $config;

    /**
     * Service Constructor
     *
     * @param string         $projectDir
     * @param CacheInterface $paddockConfigs
     */
    public function __construct(string $projectDir, CacheInterface $paddockConfigs)
    {
        //====================================================================//
        // Init cache
        $this->cache = $paddockConfigs;
        //====================================================================//
        // Init Dot Env Variables
        EnvLoader::loadDotEnv($projectDir);
    }

    /**
     * Get Paddock Configuration Path
     */
    public function getConfigPath(): string
    {
        //====================================================================//
        // Load Main Config Path from Env
        $cfgPath = EnvLoader::get("PADDOCK_CONFIG", "paddock.yml");
        if (empty($cfgPath)) {
            $this->error("No Configuration Path Identified");

            return "";
        }

        return $cfgPath;
    }

    /**
     * Get Paddock Backup Locations Paths
     *
     * @return null|string
     */
    public function getBackupLocations(): ?string
    {
        //====================================================================//
        // Load Backup Locations Paths from Env
        $backupPaths = EnvLoader::get("PADDOCK_BACKUP", "");
        if (empty($backupPaths)) {
            return null;
        }

        return $backupPaths;
    }

    /**
     * Load Paddock Configuration
     */
    public function load(): array
    {
        //====================================================================//
        // Config Already Loaded
        if (isset($this->config)) {
            return $this->config;
        }
        //====================================================================//
        // Load Config with Cache Management
        if (self::isCacheEnabled()) {
            // The callable will only be executed on a cache miss.
            /** @var array $configCache */
            $configCache = $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) {
                return $this->loadFromPath();
            });

            return $this->config = $configCache;
        }
        //====================================================================//
        // Empty the cache
        $this->cache->delete(self::CACHE_KEY);
        //====================================================================//
        // Load Config from path
        return $this->loadFromPath();
    }

    /**
     * Load Paddock Configuration from Path
     */
    public function loadFromPath(string $path = null): array
    {
        global $filesystem;

        //====================================================================//
        // Detect Configuration Filesystem from Config Path
        if (!isset($filesystem)) {
            $filesystem = FileLoader::getFilesystem($this->getConfigPath(), $this->getLogger()->getLogger());
        }
        if (empty($filesystem)) {
            $this->error("No Configuration Loaded");

            return array();
        }
        //====================================================================//
        // Load Configuration
        $configuration = YamlLoader::parseWithImports(
            $filesystem,
            $path ?? (string) FileLoader::getPath($this->getConfigPath()),
            $this->getLogger()->getLogger()
        );
        //====================================================================//
        // Verify Config is Loaded
        if (empty($configuration)) {
            $this->error("No Configuration Loaded");

            return array();
        }

        return $configuration;
    }

    /**
     * Prepare Paddock Configuration for Export
     */
    public function export(array $configuration): array
    {
        return $configuration;
    }

    /**
     * Uses cache
     */
    public static function isCacheEnabled(): bool
    {
        if (!empty(EnvLoader::get("APP_DEBUG", "0"))) {
            return false;
        }

        if ("dev" == EnvLoader::get("APP_ENV", "prod")) {
            return false;
        }

        return true;
    }
}
