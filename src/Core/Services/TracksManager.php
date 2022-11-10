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

use BadPixxel\Paddock\Core\Events\GetTracksEvent;
use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;
use BadPixxel\Paddock\Core\Tracks\Track;
use Exception;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /** @var LogManager */
    private $logManager;

    /**
     * @var null|AbstractTrack[]
     */
    private $tracks;

    /**
     * Service Constructor
     *
     * @param ConfigurationManager     $configuration
     * @param EventDispatcherInterface $dispatcher
     * @param LogManager               $logManager
     */
    public function __construct(
        ConfigurationManager $configuration,
        EventDispatcherInterface $dispatcher,
        LogManager $logManager
    ) {
        $this->configuration = $configuration;
        $this->dispatcher = $dispatcher;
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
     * @return AbstractTrack[]
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
    private function loadTracks(): void
    {
        //====================================================================//
        // Tracks Already Loaded
        if (isset($this->tracks)) {
            return;
        }
        //====================================================================//
        // Load Paddock Configuration Yaml File
        $config = $this->configuration->load();
        //====================================================================//
        // Safety Check - Tracks are Defined
        if (!isset($config["tracks"])) {
            throw new Exception(sprintf(
                "No Tracks identified in %s.",
                $this->configuration->getConfigPath()
            ));
        }
        //====================================================================//
        // Walk on Defined Tracks
        $this->tracks = array();
        foreach ($config["tracks"] as $code => $track) {
            if (!AbstractTrack::validateOptions($track, $this->logManager)) {
                continue;
            }
            $this->tracks[$code] = Track::fromArray($code, $track);
        }
        //====================================================================//
        // Load Tracks via Event Dispatcher
        /** @var GetTracksEvent $event */
        $event = $this->dispatcher->dispatch(new GetTracksEvent());
        $this->tracks = array_replace($this->tracks, $event->all());
        //====================================================================//
        // Complete Tracks with Children Rules
        foreach ($this->tracks as $track) {
            $track->importChildRules($this->tracks);
        }
    }
}
