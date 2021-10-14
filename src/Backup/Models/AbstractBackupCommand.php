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

namespace BadPixxel\Paddock\Backup\Models;

use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use BadPixxel\Paddock\Backup\Services\BackupManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base Command for Backup & Restore Operations
 */
abstract class AbstractBackupCommand extends Command
{
    /**
     * @var BackupManager
     */
    protected $manager;

    /**
     * @var LogManager
     */
    protected $logManager;

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
     * Select Backup Operation to Execute.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return null|AbstractOperation
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function selectOperation(InputInterface $input, OutputInterface $output): ?AbstractOperation
    {
        //====================================================================//
        // Load List of Available Backup Operations
        $allOperations = $this->manager->getAllOperations();
        //====================================================================//
        // A Operation is Requested from Console
        $operationCode = $input->getOption("operation");
        if (!empty($operationCode) && in_array($operationCode, array_keys($allOperations), true)) {
            return $allOperations[$operationCode];
        }
        //====================================================================//
        // No Interactions
        if (!empty($input->getOption("no-interaction"))) {
            return null;
        }
        //====================================================================//
        // User Question
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select operation to execute',
            $allOperations
        );
        $question->setErrorMessage('Operation code is invalid.');
        $operationCode = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: '.(string) $allOperations[$operationCode]);

        return $allOperations[$operationCode];
    }
}
