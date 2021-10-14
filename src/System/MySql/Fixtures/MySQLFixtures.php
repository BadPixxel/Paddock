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

namespace BadPixxel\Paddock\System\MySql\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class MySQLFixtures extends Fixture implements ORMFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param EntityManagerInterface $manager
     *
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // Bundle to manage file and directories
        $finder = new Finder();
        $finder->in(__DIR__.'/../Resources/fixtures');
        $finder->name('*.sql');
        $finder->files();
        $finder->sortByName();

        foreach ($finder as $file) {
            print "Importing: {$file->getBasename()} ".PHP_EOL;

            $sql = $file->getContents();

            $manager->getConnection()->exec($sql);  // Execute native SQL

            $manager->flush();
        }
    }
}
