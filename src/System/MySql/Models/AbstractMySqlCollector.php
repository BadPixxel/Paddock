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

use BadPixxel\Paddock\Core\Collector\AbstractCollector;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\Persistence\ManagerRegistry as Registry;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base Class for MySql Server Collectors
 */
abstract class AbstractMySqlCollector extends AbstractCollector implements MySqlCollectorInterface
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var array<Connection|false>
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
        $resolver->setDefault("dbal", "default");
        $resolver->setAllowedTypes("dbal", array("null", "string"));
        //====================================================================//
        // Use Specific Doctrine Connexion
        $resolver->setDefault("url", null);
        $resolver->setAllowedTypes("url", array("null", "string"));
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
        if (empty($connexion) && !empty($this->config["dbal"])) {
            $connexion = $this->getLocalConnexion($this->config["dbal"]);

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
     * @return null|Connection
     */
    public function getLocalConnexion(string $connexionName): ?Connection
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
            if (!($connexion instanceof Connection)) {
                self::$connexions[$connexionName] = false;
                $this->error(sprintf("Unexpected Doctrine Connexion: %s", get_class($connexion)));

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
     * @return null|Connection
     */
    public function getExternalConnexion(string $connexionUrl): ?Connection
    {
        $md5 = md5($connexionUrl);
        if (!isset(self::$connexions[$md5])) {
            try {
                //====================================================================//
                // Create new Connexion
                self::$connexions[$md5] = DriverManager::getConnection(array('url' => $connexionUrl));
            } catch (\Throwable $throwable) {
                self::$connexions[$md5] = false;
                $this->error(sprintf("Unable to create connexion: %s", $throwable->getMessage()));

                return null;
            }
        }

        return self::$connexions[$md5] ?: null;
    }
}
