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

// CORE BUNDLES
//====================================================================//
$bundles = array(
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => array('all' => true),
    Knp\Bundle\GaufretteBundle\KnpGaufretteBundle::class => array('all' => true),
    BadPixxel\Paddock\Core\PaddockCoreBundle::class => array('all' => true),
    BadPixxel\Paddock\PaddockProjectBundle::class => array('all' => true),
    BadPixxel\Paddock\Backup\PaddockBackupBundle::class => array('all' => true),
);

//====================================================================//
// MYSQL BUNDLES
//====================================================================//

if (extension_loaded("pdo_mysql")) {
    $bundles = array_merge($bundles, array(
        Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => array('all' => true),
        BadPixxel\Paddock\System\MySql\PaddockMySqlBundle::class => array('all' => true),
    ));
}

//====================================================================//
// MONGODB BUNDLES
//====================================================================//

if (extension_loaded("mongodb")) {
    $bundles = array_merge($bundles, array(
        Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle::class => array('all' => true),
        BadPixxel\Paddock\System\MongoDb\PaddockMongoDbBundle::class => array('all' => true),
    ));
}

//====================================================================//
// SYSTEM BUNDLES
//====================================================================//

$bundles = array_merge($bundles, array(
    BadPixxel\Paddock\Apps\Nrpe\PaddockNrpeBundle::class => array('all' => true),
    BadPixxel\Paddock\Apps\Sentry\PaddockSentryBundle::class => array('all' => true),
));

//====================================================================//
// APPS BUNDLES
//====================================================================//

$bundles = array_merge($bundles, array(
    BadPixxel\Paddock\System\Php\PaddockPhpBundle::class => array('all' => true),
    BadPixxel\Paddock\System\Shell\PaddockShellBundle::class => array('all' => true),
));

return $bundles;
