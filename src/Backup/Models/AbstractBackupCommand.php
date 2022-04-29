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

namespace BadPixxel\Paddock\Backup\Models;

use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use BadPixxel\Paddock\Backup\Services\BackupManager;
use BadPixxel\Paddock\Core\Models\Command\AbstractCommand;
use BadPixxel\Paddock\Core\Services\CollectorsManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\Core\Services\TracksManager;
use BadPixxel\Paddock\Core\Services\TracksRunner;
use Exception;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base Command for Backup & Restore Operations
 */
abstract class AbstractBackupCommand extends AbstractCommand
{
    /**
     * @var BackupManager
     */
    protected $manager;

    /**
     * Command Constructor
     *
     * @param TracksRunner      $runner
     * @param TracksManager     $tracks
     * @param CollectorsManager $collectors
     * @param LogManager        $logManager
     * @param BackupManager     $backupManager
     */
    public function __construct(TracksRunner $runner, TracksManager $tracks, CollectorsManager $collectors, LogManager $logManager, BackupManager $backupManager)
    {
        parent::__construct($runner, $tracks, $collectors, $logManager);

        $this->manager = $backupManager;
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
        /** @var  QuestionHelper $helper  */
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

    /**
     * @throws Exception
     */
    protected function selectLocation(InputInterface $input, OutputInterface $output, AbstractOperation $operation): ?string
    {
        //====================================================================//
        // Load List of Available Backup Locations Paths
        $allLocationPaths = $operation->getLocations();
        //====================================================================//
        // A Location is Requested from Console
        $locationPath = $input->getOption("location");
        if (!empty($locationPath) && in_array($locationPath, $allLocationPaths, true)) {
            return $locationPath;
        }
        //====================================================================//
        // No Interactions
        if (!empty($input->getOption("no-interaction"))) {
            return null;
        }
        //====================================================================//
        // User Question
        /** @var  QuestionHelper $helper  */
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select location to use',
            $allLocationPaths
        );
        $question->setErrorMessage('Location is invalid.');
        /** @var scalar $locationPath */
        $locationPath = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: '.$locationPath);

        return (string) $locationPath;
    }
}
