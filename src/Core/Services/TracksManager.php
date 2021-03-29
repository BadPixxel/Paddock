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

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;
use BadPixxel\Paddock\Core\Tracks\Track;
use Exception;
use Symfony\Component\Yaml\Yaml;

class TracksManager
{
    /** @var LogManager */
    private $logManager;

    /**
     * @var Track[]
     */
    private $tracks;

    /**
     * Service Constructor
     *
     * @param LogManager $logManager
     */
    public function __construct(LogManager $logManager)
    {
        $this->logManager = $logManager;
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
        $config = Yaml::parseFile(getcwd().'/paddock.yml');
        //====================================================================//
        // Safety Check - Tracks are Defined
        if (!is_array($config) || !isset($config["tracks"])) {
            throw new Exception(sprintf(
                "No Tracks identified in %s.",
                getcwd().'/paddock.yml'
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

        return count($this->tracks);
    }
}
