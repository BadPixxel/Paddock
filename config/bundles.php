<?php

//====================================================================//
// CORE BUNDLES
//====================================================================//
$bundles = array(
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Knp\Bundle\GaufretteBundle\KnpGaufretteBundle::class => ['all' => true],
    BadPixxel\Paddock\Core\PaddockCoreBundle::class => ['all' => true],
    BadPixxel\Paddock\PaddockProjectBundle::class => ['all' => true],
    BadPixxel\Paddock\Backup\BackupBundle::class => ['all' => true],
);

//====================================================================//
// MYSQL BUNDLES
//====================================================================//

if (extension_loaded("pdo_mysql")) {
    $bundles = array_merge($bundles, array(
        Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
        BadPixxel\Paddock\System\MySql\PaddockMySqlBundle::class => ['all' => true],
    ));
}

//====================================================================//
// MONGODB BUNDLES
//====================================================================//

if (extension_loaded("mongodb")) {
    $bundles = array_merge($bundles, array(
        Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle::class => ['all' => true],
        BadPixxel\Paddock\System\MongoDb\PaddockMongoDbBundle::class => ['all' => true],
    ));
}

//====================================================================//
// SYSTEM BUNDLES
//====================================================================//

$bundles = array_merge($bundles, array(
    BadPixxel\Paddock\Apps\Nrpe\PaddockNrpeBundle::class => ['all' => true],
    BadPixxel\Paddock\Apps\Sentry\PaddockSentryBundle::class => ['all' => true],
));

//====================================================================//
// APPS BUNDLES
//====================================================================//

$bundles = array_merge($bundles, array(
    BadPixxel\Paddock\System\Php\PaddockPhpBundle::class => ['all' => true],
    BadPixxel\Paddock\System\Shell\PaddockShellBundle::class => ['all' => true],
));

return $bundles;
