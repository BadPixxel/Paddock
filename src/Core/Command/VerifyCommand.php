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

use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\Core\Services\TracksManager;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Run One or All Defined Tracks
 */
class VerifyCommand extends Command
{
    /** @var TracksManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * @param TracksManager $tracksManager
     */
    public function __construct(TracksManager $tracksManager, LogManager $logManager)
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
            ->setName('paddock:run')
            ->setDescription('Run One or All Defined Tracks')
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
        // Load List of Available Tracks
        $tracks = $this->manager->getAll();
        //====================================================================//
        // Show Constraints List
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Collector', 'Constraints', 'Description'));
        foreach ($tracks as $code => $constraint) {
            $table->addRow(array(
                $code,
                $constraint->getCollector(),
                $constraint->countRules(),
                $constraint->getDescription()
            ));
        }
        $table->render();

        return 0;
    }
}
