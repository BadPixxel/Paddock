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

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as Registry;
use MongoDB\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base Class for MongoDb Server Collectors
 */
abstract class AbstractMongoDbCollector extends AbstractCollector implements MongoDbCollectorInterface
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var array<Client|false>
     */
    private static $connexions = array();

    /**
     * AbstractMySqlCollector constructor.
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->doctrine = $registry;
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        //====================================================================//
        // Use Specific Doctrine Entity Manager
        $resolver->setDefault("connexion", "default");
        $resolver->setAllowedTypes("connexion", array("null", "string"));
        //====================================================================//
        // Use Specific Doctrine Connexion
        $resolver->setDefault("url", null);
        $resolver->setAllowedTypes("url", array("null", "string"));
        //====================================================================//
        // Use Specific Database Name
        $resolver->setDefault("database", null);
        $resolver->setAllowedTypes("database", array("null", "string"));
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function get(string $key): string
    {
        $connexion = null;
        //====================================================================//
        // Verify Value on External Connexion
        if (!empty($this->config["url"])) {
            $connexion = $this->getExternalConnexion($this->config["url"]);

            return $connexion ? $this->getValue($connexion, $key) : '';
        }
        //====================================================================//
        // Verify Value on Local Connexion
        if (empty($connexion) && !empty($this->config["connexion"])) {
            $connexion = $this->getLocalConnexion($this->config["connexion"]);

            return $connexion ? $this->getValue($connexion, $key) : '';
        }

        return '';
    }

    //====================================================================//
    // DOCTRINE CONNEXIONS CHECKS
    //====================================================================//

    /**
     * Check if Doctrine Connexion Exists
     *
     * @param string $connexionName Doctrine Connexion Name
     *
     * @return null|Client
     */
    protected function getLocalConnexion(string $connexionName): ?Client
    {
        if (!isset(self::$connexions[$connexionName])) {
            //====================================================================//
            // Verify Doctrine Connexion Exists
            $connexions = $this->doctrine->getConnectionNames();
            if (!isset($connexions[$connexionName])) {
                self::$connexions[$connexionName] = false;
                $this->error(sprintf("Doctrine Connexion %s not found!", $connexionName));

                return null;
            }
            //====================================================================//
            // Load Doctrine Connexion
            $connexion = $this->doctrine->getConnection($connexionName);
            if (!($connexion instanceof Client)) {
                self::$connexions[$connexionName] = false;
                $this->error(sprintf("Unexpected Mongo Db Connexion: %s", get_class($connexion)));

                return null;
            }

            self::$connexions[$connexionName] = $connexion;
        }

        return self::$connexions[$connexionName] ?: null;
    }

    /**
     * Check if External Connexion Exists
     *
     * @param string $connexionUrl Doctrine Connexion Name
     *
     * @return null|Client
     */
    protected function getExternalConnexion(string $connexionUrl): ?Client
    {
        $md5 = md5($connexionUrl);
        if (!isset(self::$connexions[$md5])) {
            try {
                //====================================================================//
                // Create new Connexion
                self::$connexions[$md5] = new Client($connexionUrl, array(), array('typeMap' => array(
                    "array" => "array",
                    "root" => "array",
                    "document" => "array",
                )));
            } catch (\Throwable $throwable) {
                self::$connexions[$md5] = false;
                $this->error(sprintf("Unable to create connexion: %s", $throwable->getMessage()));

                return null;
            }
        }

        return self::$connexions[$md5] ?: null;
    }

    /**
     * Get Database Name
     *
     * @param Client $connexion
     *
     * @return null|string
     */
    protected function getDatabaseName(Client $connexion): ?string
    {
        //====================================================================//
        // From Configuration
        if (!empty($this->config["database"])) {
            return $this->config["database"];
        }
        //====================================================================//
        // From Connexion
        $dbName = basename((string) parse_url((string) $connexion, PHP_URL_PATH));
        if (!empty($dbName)) {
            return $dbName;
        }

        $this->error("Unable to detect MongoDb Database Name!");

        return null;
    }
}
