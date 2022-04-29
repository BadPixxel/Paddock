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

namespace BadPixxel\Paddock\System\Shell\Collector;

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use BadPixxel\Paddock\Core\Models\RulesAwareTrait;
use BadPixxel\Paddock\System\Shell\Helpers\CmdRunner;

/**
 * Linux Services Status Collectors
 */
class ServicesCollector extends AbstractCollector
{
    use RulesAwareTrait;

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "service";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Linux Service Status Collector";
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        //====================================================================//
        // Verify Apt Binary Exists
        $binary = CmdRunner::findBinary("systemctl");
        if (empty($binary)) {
            return (string) $this->error("Is package installed?");
        }
        //====================================================================//
        // Run Service Status Check Command
        if (!CmdRunner::run(array($binary, 'is-active', $key))) {
            return "";
        }
        //====================================================================//
        // Extract Status from Results
        if (0 === strpos("active", (string) CmdRunner::getResult())) {
            $this->error(sprintf("Service %s is not running...", $key));

            return "";
        }

        return "active";
    }
}
