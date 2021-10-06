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

namespace BadPixxel\Paddock\System\MongoDb\Models;

use MongoDB\Client;

/**
 * Generic MongoDb Server Collector Interface
 */
interface MongoDbCollectorInterface
{
    /**
     * Get a Local Configuration Value
     *
     * @param Client $connexion
     * @param string $key
     *
     * @return string
     */
    public function getValue(Client $connexion, string $key): string;
}
