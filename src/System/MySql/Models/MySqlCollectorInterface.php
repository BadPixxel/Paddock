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

namespace BadPixxel\Paddock\System\MySql\Models;

use Doctrine\DBAL\Connection;

/**
 * Generic MySql Server Collector Interface
 */
interface MySqlCollectorInterface
{
    /**
     * Get a Local Php Ini Value
     *
     * @param Connection $connexion
     * @param string     $key
     *
     * @return string
     */
    public function getValue(Connection $connexion, string $key): string;
}
