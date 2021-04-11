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

namespace BadPixxel\Paddock\System\Php\Models;

interface PhpCollectorInterface
{
    //====================================================================//
    // LOCAL PHP INI COLLECTOR
    //====================================================================//

    /**
     * Get a Local Php Ini Value
     *
     * @param string $key
     *
     * @return string
     */
    public function getLocalValue(string $key): string;

    //====================================================================//
    // EXTERNAL PHP INI COLLECTOR
    //====================================================================//

    /**
     * Get a Php Ini Value from Binary
     *
     * @param string $binary
     * @param string $key
     *
     * @return string
     */
    public function getExternalValue(string $binary, string $key): string;
}
