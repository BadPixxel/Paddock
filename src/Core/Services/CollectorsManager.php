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

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Exception;

/**
 * Manager for Paddock Data Collectors
 */
class CollectorsManager
{
    /**
     * @var AbstractCollector[]
     */
    private $collectors = array();

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     *
     * @param iterable $collectors
     *
     * @throws Exception
     */
    public function __construct(iterable $collectors)
    {
        //====================================================================//
        // Load Collectors
        $this->loadCollectors($collectors);
    }

    //====================================================================//
    // COLLECTORS MANAGEMENT
    //====================================================================//

    /**
     * Get a Collector by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractCollector
     */
    public function getByCode(string $code): AbstractCollector
    {
        if (!isset($this->collectors[$code])) {
            throw new Exception(sprintf("Collector with code %s  was not found.", $code));
        }

        return $this->collectors[$code];
    }

    /**
     * Get List of All Available Collector
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->collectors;
    }

    /**
     * Initialize List of Available Collectors
     *
     * @param iterable $collectors
     *
     * @throws Exception
     *
     * @return int
     */
    private function loadCollectors(iterable $collectors): int
    {
        foreach ($collectors as $code => $collector) {
            if ($collector instanceof AbstractCollector) {
                $this->collectors[$code] = $collector;

                continue;
            }

            throw new Exception(sprintf(
                "Collector %s must extends %s.",
                get_class($collector),
                AbstractCollector::class
            ));
        }

        return count($this->collectors);
    }
}
