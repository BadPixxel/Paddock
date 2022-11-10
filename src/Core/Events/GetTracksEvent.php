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

namespace BadPixxel\Paddock\Core\Events;

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;
use Exception;
use Symfony\Contracts\EventDispatcher\Event;

class GetTracksEvent extends Event
{
    /**
     * @var array<string, AbstractTrack>
     */
    private $tracks = array();

    /**
     * Add Track.
     *
     * @param class-string $trackClass
     *
     * @throws Exception
     *
     * @return self
     */
    public function add(string $trackClass): self
    {
        $track = self::validate($trackClass);
        $this->tracks[$track->getCode()] = $track;

        return $this;
    }

    /**
     * Get All Tracks.
     *
     * @return array<string, AbstractTrack>
     */
    public function all(): array
    {
        return $this->tracks;
    }

    /**
     * Validate Tracks.
     *
     * @param class-string $trackClass
     *
     *@throws Exception
     *
     * @return AbstractTrack
     */
    private static function validate(string $trackClass): AbstractTrack
    {
        //====================================================================//
        // Safety Check - Class Exists
        if (!class_exists($trackClass)) {
            throw new Exception(sprintf("Class %s was not found.", $trackClass));
        }
        //====================================================================//
        // Safety Check - Implement Abstract Track
        if (!is_subclass_of($trackClass, AbstractTrack::class)) {
            throw new Exception(sprintf(
                "Contraint/Rule %s must extends %s.",
                $trackClass,
                AbstractTrack::class
            ));
        }

        return new $trackClass;
    }
}
