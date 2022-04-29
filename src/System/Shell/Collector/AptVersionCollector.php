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
 * Linux Apt Package Version Collectors
 */
class AptVersionCollector extends AbstractCollector
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
        return "apt-version";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Linux Apt Installed Packages Version Collector";
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
        $binary = CmdRunner::findBinary("apt");
        if (empty($binary)) {
            return (string) $this->error("Is package installed?");
        }
        //====================================================================//
        // Run Apt Show Command
        if (!CmdRunner::run(array($binary, 'show', $key))) {
            return "";
        }
        //====================================================================//
        // Extract Version from Results
        $version = CmdRunner::searchInResults("Version:", true);
        if (empty($version)) {
            return (string) $this->error(sprintf("Is package %s installed?", $key));
        }

        return $version;
    }
}
