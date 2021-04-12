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

namespace BadPixxel\Paddock\Core\Services;

use BadPixxel\Paddock\Core\Loader\YamlLoader;
use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;
use BadPixxel\Paddock\Core\Tracks\Track;
use Exception;

class TracksManager
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var TracksManager
     */
    private static $instance;

    /** @var LogManager */
    private $logManager;

    /**
     * @var Track[]
     */
    private $tracks;

    /**
     * Service Constructor
     *
     * @param string     $projectDir
     * @param LogManager $logManager
     */
    public function __construct(string $projectDir, LogManager $logManager)
    {
        $this->projectDir = $projectDir;
        $this->logManager = $logManager;
        //====================================================================//
        // Setup Static Access
        static::$instance = $this;
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
     * @return Track[]
     */
    public function getAll(): array
    {
        $this->loadTracks();

        return $this->tracks;
    }

    /**
     * Get Static Instance
     */
    public static function getInstance(): TracksManager
    {
        return static::$instance;
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
        // TODO - Dev a real Track Loader Service!
        //====================================================================//

        //====================================================================//
        // Load Configuration Yaml File
        $config = YamlLoader::parseFileWithImports($this->projectDir.'/paddock.yml');
        //====================================================================//
        // Safety Check - Tracks are Defined
        if (!is_array($config) || !isset($config["tracks"])) {
            throw new Exception(sprintf(
                "No Tracks identified in %s.",
                $this->projectDir.'/paddock.yml'
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
