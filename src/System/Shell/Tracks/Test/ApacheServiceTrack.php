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

namespace BadPixxel\Paddock\System\Shell\Tracks\Test;

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;

class ApacheServiceTrack extends AbstractTrack
{
    /**
     * Track Constructor
     */
    public function __construct()
    {
        parent::__construct("test-apache-service");
        //====================================================================//
        // Track Configuration
        $this->enabled = false;
        $this->description = "[TEST] Check Apache Service";
        $this->collector = "service";

        //====================================================================//
        // Add Rules
        $this->addRule("apache2", array(
            "ne" => true
        ));
    }
}
