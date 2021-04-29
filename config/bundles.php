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

return array(
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => array('all' => true),
    BadPixxel\Paddock\Core\CoreBundle::class => array('all' => true),
    BadPixxel\Paddock\System\Php\PaddockPhpBundle::class => array('all' => true),
    BadPixxel\Paddock\System\MySql\PaddockMySqlBundle::class => array('all' => true),
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => array('all' => true),
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => array('all' => true),
);
