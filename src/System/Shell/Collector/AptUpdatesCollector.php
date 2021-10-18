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
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Linux Apt Package Updates Status Collectors
 */
class AptUpdatesCollector extends AbstractCollector
{
    use RulesAwareTrait;

    /**
     * @var string[]
     */
    private $resultArray;

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "apt-updates";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Linux Apt Packages Updates Status Collector";
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
        // Verify Request Key
        if (!in_array($key, array("all", "safety"), true)) {
            return (string) $this->error("Key MUST one of 'all' or 'safety'.");
        }
        //====================================================================//
        // Load Results from Cache
        $cache = new FilesystemAdapter();
        /** @var null|string[] $resultArray */
        $resultArray = $cache->get(md5(__CLASS__), function (ItemInterface $item) {
            //====================================================================//
            // Cache Expire After 60 Seconds
            $item->expiresAfter(2);
            //====================================================================//
            // Verify Apt Binary Exists
            $binary = CmdRunner::findBinary("apt-get");
            if (empty($binary)) {
                $this->error("Is package installed?");

                return null;
            }
            //====================================================================//
            // Run Apt Upgrade Command
            $command = array(
                $binary,
                'upgrade',
                '-u',
                '-o', 'Debug::NoLocking=true',
                '-o', 'APT::Get::Simulate=true',
                '-qq',
            );
            if (!CmdRunner::run($command)) {
                return null;
            }
            //====================================================================//
            // Explode Command Outputs to Array
            return explode("\n", (string) CmdRunner::getResult());
        });

        if (is_null($resultArray)) {
            return "";
        }

        return (string) $this->countInResults($resultArray, ("safety" == $key) ? "safety" : "");
    }

    /**
     * Count Packages in Last Command Outputs
     *
     * @param string[] $results
     * @param string   $pattern
     *
     * @return int
     */
    public function countInResults(array $results, string $pattern = ""): int
    {
        //====================================================================//
        // Search for Packages
        $count = 0;
        foreach ($results as $result) {
            //====================================================================//
            // This is NOT a Package Line
            if (0 !== strpos($result, "Inst")) {
                continue;
            }
            //====================================================================//
            // This is a Pattern Package Line
            if (!empty($pattern) && (false === strpos($result, $pattern))) {
                continue;
            }
            $count++;
        }

        return $count;
    }
}
