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

namespace BadPixxel\Paddock\System\MySql\Collector;

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\System\MySql\Models\AbstractMySqlCollector;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

/**
 * MySql Server Variable Collector
 */
class VariableCollector extends AbstractMySqlCollector
{
    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function getCode(): string
    {
        return "mysql-variable";
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return "Collect MySql Server Parameters";
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function getValue(Connection $connexion, string $key): string
    {
        //====================================================================//
        // Override Rule Name for Logs
        LogManager::getInstance()->setContextRule("VARIABLE");
        //====================================================================//
        // Execute My SQl Query
        $result = $connexion->prepare("SELECT ".$key.";")->executeQuery();
        //====================================================================//
        // Extract value from Results
        /** @var null|scalar[] $results */
        $results = $result->fetchAssociative();
        if (!$results || !isset($results[$key])) {
            $this->error(sprintf("MySql key %s doesn't exists!", $key));

            return '';
        }

        return (string) $results[$key];
    }
}
