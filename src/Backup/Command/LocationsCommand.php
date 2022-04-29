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

namespace BadPixxel\Paddock\Backup\Command;

use BadPixxel\Paddock\Backup\Services\LocationsManager;
use BadPixxel\Paddock\Core\Services\LogManager;
//use BadPixxel\Paddock\Core\Services\Analyzer;
use Exception;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display List of Available Backup Locations
 */
class LocationsCommand extends Command
{
    /** @var LocationsManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * Command Constructor
     *
     * @param LocationsManager $locationsManager
     * @param LogManager       $logManager
     */
    public function __construct(LocationsManager $locationsManager, LogManager $logManager)
    {
        parent::__construct();

        $this->manager = $locationsManager;
        $this->logManager = $logManager;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:backup:locations')
            ->setDescription('Display list of Available Backup Locations')
        ;
    }

    /**
     * Execute Master Command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //====================================================================//
        // Setup Console Log
        $this->logManager->pushHandler(new ConsoleHandler($output));
        //====================================================================//
        // Load List of Available Backup Locations
        $locations = $this->manager->getAll();
        //====================================================================//
        // Show Available Backup Locations List
        $output->writeln("<comment>Available Backup Services</comment>");
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Class', 'Description'));
        foreach ($locations as $code => $source) {
            $table->addRow(array(
                $code,
                get_class($source),
                $source::getDescription()
            ));
        }
        $table->render();
        //====================================================================//
        // Load List of Default Backup Locations
        $locations = $this->manager->getConfigurationFromPath();
        //====================================================================//
        // Show Constraints List
        $output->writeln("<comment>Default Backup Locations</comment>");
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Path', 'Description'));
        foreach ($locations as $path => $service) {
            $table->addRow(array(
                $service->getCode(),
                $path,
                $service->getDescription()
            ));
        }
        $table->render();

        return 0;
    }
}
