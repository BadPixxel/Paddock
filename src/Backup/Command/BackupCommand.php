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

use BadPixxel\Paddock\Backup\Models\AbstractBackupCommand;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execute a Backup Operation
 */
class BackupCommand extends AbstractBackupCommand
{
    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:backup')
            ->setDescription('Execute Backup Operations')
            ->addOption(
                'operation',
                "o",
                InputOption::VALUE_OPTIONAL,
                'Backup Operation to Execute'
            )
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Response Format')
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
        // Init Paddock Command
        $this->init($input, $output);
        //====================================================================//
        // Select Operation to Execute
        $operation = $this->selectOperation($input, $output);
        if (empty($operation)) {
            return 0;
        }
        //====================================================================//
        // Execute Backup Operation
        $this->manager->doBackup($operation)
            ? $this->logger->getLogger()->info("Backup Completed")
            : $this->logger->getLogger()->error("Backup Failed")
        ;
        //====================================================================//
        // Close Paddock Command
        return $this->close($input, $output);
    }
}
