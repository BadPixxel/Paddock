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

namespace BadPixxel\Paddock\System\Shell\Collector;

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use BadPixxel\Paddock\Core\Models\RulesAwareTrait;
use BadPixxel\Paddock\System\Shell\Helpers\CmdRunner;

/**
 * Linux Debian/Ubuntu Release Information Collectors
 */
class LsbReleaseCollector extends AbstractCollector
{
    use RulesAwareTrait;

    /**
     * List of Available Infos Codes
     */
    const KEYS = array(
        "id" => "Distributor ID:",
        "release" => "Release:",
        "codename" => "Codename:",
    );

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "lsb-release";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Linux Debian/Ubuntu Release Information Collector";
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
        // Safety check
        if (!in_array($key, array_keys(self::KEYS), true)) {
            return (string) $this->error(sprintf(
                "Key %s does not exists? Try on of \\'%s\\'",
                $key,
                implode(", ", array_keys(self::KEYS))
            ));
        }
        //====================================================================//
        // Verify Apt Binary Exists
        $binary = CmdRunner::findBinary("lsb_release");
        if (empty($binary)) {
            return (string) $this->error("Are you working on Debian/Ubuntu Linux?");
        }
        //====================================================================//
        // Run Apt Show Command
        if (!CmdRunner::run(array($binary, '--'.$key))) {
            return "";
        }
        //====================================================================//
        // Extract Value from Results
        return (string) CmdRunner::searchInResults(self::KEYS[$key], true);
    }
}
