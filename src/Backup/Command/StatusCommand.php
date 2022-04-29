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

use BadPixxel\Paddock\Backup\Helpers\StatusStorage;
use BadPixxel\Paddock\Backup\Services\BackupManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Exception;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display Status of Available Backup Operations
 */
class StatusCommand extends Command
{
    /** @var BackupManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * Command Constructor
     *
     * @param BackupManager $backupManager
     * @param LogManager    $logManager
     */
    public function __construct(BackupManager $backupManager, LogManager $logManager)
    {
        parent::__construct();

        $this->manager = $backupManager;
        $this->logManager = $logManager;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:backup:status')
            ->setDescription('Display Status of Available Backup Operations')
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //====================================================================//
        // Setup Console Log
        $this->logManager->pushHandler(new ConsoleHandler($output));
        //====================================================================//
        // Load List of Available Backup Operations
        $allOperations = $this->manager->getAllOperations();
        //====================================================================//
        // Show Operations Status
        $table = new Table($output);
        $table->setHeaders(array('Code', 'Enabled', 'Source', 'Target', 'Status', 'Description'));
        foreach ($allOperations as $code => $operation) {
            foreach ($operation->getLocations() as $locationPath) {
                $table->addRow(array(
                    $code,
                    $operation->isEnabled() ? "<info>Enabled</info>" : "<comment>Disabled</comment>",
                    $operation->getSource(),
                    $locationPath,
                    StatusStorage::isSuccessful($operation->getCode(), $locationPath)
                        ? "<info>OK</info>"
                        : "<error>In Error</error>",
                    $operation->getDescription(),
                ));
            }
        }
        $table->render();

        return 0;
    }
}
