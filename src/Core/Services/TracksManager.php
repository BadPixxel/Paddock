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

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;
use BadPixxel\Paddock\Core\Tracks\Track;
use Exception;

class TracksManager
{
    /**
     * @var ConfigurationManager
     */
    private $configuration;

    /**
     * @var TracksManager
     */
    private static $instance;

    /** @var LogManager */
    private $logManager;

    /**
     * @var null|Track[]
     */
    private $tracks;

    /**
     * Service Constructor
     *
     * @param ConfigurationManager $configuration
     * @param LogManager           $logManager
     */
    public function __construct(ConfigurationManager $configuration, LogManager $logManager)
    {
        $this->configuration = $configuration;
        $this->logManager = $logManager;
        //====================================================================//
        // Setup Static Access
        self::$instance = $this;
    }

    /**
     * Get a Track by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractTrack
     */
    public function getByCode(string $code): AbstractTrack
    {
        $this->loadTracks();

        if (!isset($this->tracks[$code])) {
            throw new Exception(sprintf("Track with code %s was not found.", $code));
        }

        return $this->tracks[$code];
    }

    /**
     * Get List of All Available Tracks
     *
     * @throws Exception
     *
     * @return Track[]
     */
    public function getAll(): array
    {
        $this->loadTracks();

        return $this->tracks ?? array();
    }

    /**
     * Get Static Instance
     */
    public static function getInstance(): TracksManager
    {
        return self::$instance;
    }

    /**
     * Initialize List of Available Tracks
     *
     * @throws Exception
     */
    private function loadTracks(): int
    {
        //====================================================================//
        // Tracks Already Loaded
        if (isset($this->tracks)) {
            return count($this->tracks);
        }
        //====================================================================//
        // Load Paddock Configuration Yaml File
        $config = $this->configuration->load();
        //====================================================================//
        // Safety Check - Tracks are Defined
        if (!is_array($config) || !isset($config["tracks"])) {
            throw new Exception(sprintf(
                "No Tracks identified in %s.",
                $this->configuration->getConfigPath()
            ));
        }
        //====================================================================//
        // Walk on Defined Tracks
        $this->tracks = array();
        foreach ($config["tracks"] as $code => $track) {
            $this->logManager->setContext($code, null, "definition", $track);
            if (!Track::validateOptions($track, $this->logManager)) {
                continue;
            }
            $this->tracks[$code] = Track::fromArray($code, $track);
        }
        //====================================================================//
        // Complete Tracks with Children Rules
        foreach ($this->tracks as $track) {
            $track->importChildRules($this->tracks);
        }

        return count($this->tracks);
    }
}
