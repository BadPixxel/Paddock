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

namespace BadPixxel\Paddock\System\Php\Collector;

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Exception;

class ExtensionsCollector extends AbstractCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function getCode(): string
    {
        return "php-ext";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect list of installed extensions";
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        return PHP_VERSION;
    }
}
