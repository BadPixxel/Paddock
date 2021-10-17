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

use BadPixxel\Paddock\Core\Services\ConfigurationManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\Core\Services\TracksManager;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display List of Available Tracks (Test Suites)
 */
class TracksCommand extends Command
{
    /** @var ConfigurationManager */
    private $configurationManager;

    /** @var TracksManager */
    private $tracksManager;

    /** @var LogManager */
    private $logManager;

    /**
     * Command Constructor
     *
     * @param TracksManager $tracksManager
     * @param LogManager    $logManager
     */
    public function __construct(ConfigurationManager $configurationManager, TracksManager $tracksManager, LogManager $logManager)
    {
        parent::__construct();

        $this->configurationManager = $configurationManager;
        $this->tracksManager = $tracksManager;
        $this->logManager = $logManager;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:tracks')
            ->setDescription('Display list of Available Tracks (Rules Collection)')
            ->addOption('all', 'a', InputOption::VALUE_OPTIONAL, 'Show all')
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
        $tracks = $this->tracksManager->getAll();
        //====================================================================//
        // Show Constraints List
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Collector', 'Rules', 'Rules', 'Description'));
        foreach ($tracks as $code => $constraint) {
            //====================================================================//
            // Show Only Enabled Tracks
            if (!$constraint->isEnabled() && empty($input->getOption("all"))) {
                continue;
            }
            $table->addRow(array(
                $code,
                $constraint->getCollector(),
                $constraint->isEnabled() ? "<info>Enabled</info>" : "<comment>Disabled</comment>",
                $constraint->countRules(),
                $constraint->getDescription()
            ));
        }
        $table->render();
        //====================================================================//
        // Show Tracks Configuration Source
        $output->writeln(sprintf(
            "<comment>Configured %d tracks from %s</comment>",
            count($tracks),
            $this->configurationManager->getConfigPath()
        ));

        return 0;
    }
}
