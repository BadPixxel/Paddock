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

namespace BadPixxel\Paddock\Core\Tracks;

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;

class Track extends AbstractTrack
{
    public static function fromArray(string $code, array $definition): Track
    {
        $track = new Track($code);
        //====================================================================//
        // Detect Definition
        $track->importOptions($definition);

        return $track;
    }
}
