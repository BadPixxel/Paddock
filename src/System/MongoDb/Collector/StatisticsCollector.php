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

namespace BadPixxel\Paddock\System\MongoDb\Collector;

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\System\MongoDb\Models\AbstractMongoDbCollector;
use MongoDB\Client;

/**
 * MongoDb Database Statistics Collector
 */
class StatisticsCollector extends AbstractMongoDbCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "mongo-stats";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect MongoDb Database Statistics";
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function getValue(Client $connexion, string $key): string
    {
        //====================================================================//
        // Override Rule Name for Logs
        LogManager::getInstance()->setContextRule("STATS");
        //====================================================================//
        // Select database
        $dbName = $this->getDatabaseName($connexion);
        if (empty($dbName)) {
            return ' ';
        }
        //====================================================================//
        // Execute Mongo Query
        try {
            $results = $connexion->selectDatabase("${dbName}")->command(array(
                "dbStats" => 1,
                "scale" => 1024,
            ))->toArray();
        } catch (\Exception $ex) {
            $this->error(sprintf("No Statistics for Db: %s", $dbName));

            return ' ';
        }
        //====================================================================//
        // Extract value from Results
        if (!is_array($results) || empty($results[0]["ok"]) || !isset($results[0][$key])) {
            $this->error(sprintf("No Statistics with key %s on Db: %s", $key, $dbName));

            return ' ';
        }

        return (string) $results[0][$key];
    }
}