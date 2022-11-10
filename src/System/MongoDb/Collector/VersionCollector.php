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

namespace BadPixxel\Paddock\System\MongoDb\Collector;

use BadPixxel\Paddock\System\MongoDb\Models\AbstractMongoDbCollector;
use MongoDB\Client;

/**
 * MongoDb Server Version Collector
 */
class VersionCollector extends AbstractMongoDbCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "mongo-version";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect MongoDb Server Version";
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(Client $connexion, string $key): string
    {
        //====================================================================//
        // Execute Mongo Query
        try {
            $results = $connexion->selectDatabase("admin")->command(array(
                "buildInfo" => 1,
            ))->toArray();
        } catch (\Exception $ex) {
            $this->error("Unable to read MongoDb server Version!");

            return ' ';
        }
        //====================================================================//
        // Extract value from Results
        if (!is_array($results) || empty($results[0]["ok"]) || !isset($results[0][$key])) {
            $this->error("Unable to read MongoDb server Version!");

            return ' ';
        }
        $result = $results[0];
        //====================================================================//
        // Extract Array value from Results
        if (is_array($result) && isset($result["version"])) {
            return (string) $result["version"];
        }

        return ' ';
    }
}
