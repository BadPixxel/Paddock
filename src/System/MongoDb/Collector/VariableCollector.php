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

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\System\MongoDb\Models\AbstractMongoDbCollector;
use MongoDB\Client;

/**
 * MongoDb Server Variable Collector
 */
class VariableCollector extends AbstractMongoDbCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "mongo-variable";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect MongoDb Server Parameters";
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(Client $connexion, string $key): string
    {
        //====================================================================//
        // Override Rule Name for Logs
        LogManager::getInstance()->setContextRule("PARAMS");
        //====================================================================//
        // Execute Mongo Query
        try {
            $results = $connexion->selectDatabase("admin")->command(array(
                "getParameter" => 1,
                $key => 1
            ))->toArray();
        } catch (\Exception $ex) {
            $this->error(sprintf("MongoDb parameter %s doesn't exists!", $key));

            return ' ';
        }
        //====================================================================//
        // Extract value from Results
        if (!is_array($results) || empty($results[0]["ok"]) || !isset($results[0][$key])) {
            $this->error(sprintf("MongoDb parameter %s doesn't exists!", $key));

            return ' ';
        }
        $result = $results[0][$key];
        //====================================================================//
        // Extract Array value from Results
        if (is_array($result)) {
            if (isset($result["version"])) {
                return (string) $result["version"];
                ;
            }
            if (isset($result["value"])) {
                return (string) $result["value"];
                ;
            }
            $this->error(sprintf("MongoDb parameter %s not allowed!", $key));

            return ' ';
        }

        return (string) $result;
    }
}
