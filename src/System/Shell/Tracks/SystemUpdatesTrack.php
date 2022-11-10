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

namespace BadPixxel\Paddock\System\Shell\Tracks;

use BadPixxel\Paddock\Core\Models\Tracks\AbstractTrack;

class SystemUpdatesTrack extends AbstractTrack
{
    /**
     * Track Constructor
     */
    public function __construct()
    {
        parent::__construct("apt-updates");
        //====================================================================//
        // Track Configuration
        $this->enabled = false;
        $this->description = "Check Apt Updates";
        $this->collector = "apt-updates";

        //====================================================================//
        // Add Rules
        $this->addRule("all", array(
            "lt" => array("error" => 50, "warning" => 25),
            "metric" => "available_upgrades"
        ));
        $this->addRule("security", array(
            "lt" => array("error" => 10, "warning" => 5),
            "metric" => "critical_updates"
        ));
    }
}
