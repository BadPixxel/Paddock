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

use BadPixxel\Paddock\Backup\Services\SourcesManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display List of Available Backup Sources
 */
class SourcesCommand extends Command
{
    /** @var SourcesManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * Command Constructor
     *
     * @param SourcesManager $locationsManager
     * @param LogManager     $logManager
     */
    public function __construct(SourcesManager $locationsManager, LogManager $logManager)
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
            ->setName('paddock:backup:sources')
            ->setDescription('Display list of Available Backup Sources')
        ;
    }

    /**
     * Execute Master Command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //====================================================================//
        // Setup Console Log
        $this->logManager->pushHandler(new ConsoleHandler($output));
        //====================================================================//
        // Load List of Available Backup Sources
        $sources = $this->manager->getAll();
        //====================================================================//
        // Show Sources List
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Class', 'Description'));
        foreach ($sources as $code => $source) {
            $table->addRow(array(
                $code,
                get_class($source),
                $source::getDescription()
            ));
        }
        $table->render();

        return 0;
    }
}
