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

namespace BadPixxel\Paddock\Backup\Services;

use BadPixxel\Paddock\Backup\Models\Sources\AbstractSource;
use Exception;

/**
 * Manage Backup Sources for Assessing Data to back up
 */
class SourcesManager
{
    /**
     * @var AbstractSource[]
     */
    private $sources;

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     *
     * @param iterable $sources
     *
     * @throws Exception
     */
    public function __construct(iterable $sources)
    {
        //====================================================================//
        // Load Sources
        $this->loadSources($sources);
    }

    //====================================================================//
    // CONSTRAINTS MANAGEMENT
    //====================================================================//

    /**
     * Get a Sources by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractSource
     */
    public function getByCode(string $code): AbstractSource
    {
        if (!isset($this->sources[$code])) {
            throw new Exception(sprintf("Sources with code %s  was not found.", $code));
        }

        return $this->sources[$code];
    }

    /**
     * Get List of All Available Sources
     *
     * @return AbstractSource[]
     */
    public function getAll(): array
    {
        return $this->sources;
    }

    /**
     * Initialize List of Available Sources
     *
     * @param iterable $sources
     *
     * @throws Exception
     *
     * @return int
     */
    private function loadSources(iterable $sources): int
    {
        foreach ($sources as $code => $source) {
            if ($source instanceof AbstractSource) {
                $this->sources[$code] = $source;

                continue;
            }

            throw new Exception(sprintf(
                "Backup Sources %s must extends %s.",
                get_class($source),
                AbstractSource::class
            ));
        }

        return count($this->sources);
    }
}
