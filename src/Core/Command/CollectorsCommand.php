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

namespace BadPixxel\Paddock\Core\Command;

use BadPixxel\Paddock\Core\Services\CollectorsManager;
use BadPixxel\Paddock\Core\Services\LogManager;
//use BadPixxel\Paddock\Core\Services\Analyzer;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display List of Available Collectors
 */
class CollectorsCommand extends Command
{
    /** @var CollectorsManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * @param CollectorsManager $tracksManager
     */
    public function __construct(CollectorsManager $tracksManager, LogManager $logManager)
    {
        parent::__construct();

        $this->manager = $tracksManager;
        $this->logManager = $logManager;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:collectors')
            ->setDescription('Display list of Available Collectors')
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
        // Load List of Available Collectors
        $collectors = $this->manager->getAll();
        //====================================================================//
        // Show Constraints List
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Class', 'Description'));
        foreach ($collectors as $code => $collector) {
            $table->addRow(array(
                $code,
                get_class($collector),
                $collector::getDescription()
            ));
        }
        $table->render();

        return 0;
    }
}
