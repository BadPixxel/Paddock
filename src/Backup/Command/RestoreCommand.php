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

namespace BadPixxel\Paddock\Backup\Command;

use BadPixxel\Paddock\Backup\Models\AbstractBackupCommand;
use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use Exception;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Execute a Restore Operation
 */
class RestoreCommand extends AbstractBackupCommand
{
    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:restore')
            ->setDescription('Execute Restore Operations')
            ->addOption(
                'operation',
                "o",
                InputOption::VALUE_OPTIONAL,
                'Restore Operation to Execute'
            )
            ->addOption(
                'location',
                "l",
                InputOption::VALUE_OPTIONAL,
                'Location to Use'
            )
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
        // Select Operation to Execute
        $operation = $this->selectOperation($input, $output);
        if (empty($operation)) {
            return 0;
        }
        //====================================================================//
        // Select Location to Use
        $location = $this->selectLocation($input, $output, $operation);
        if (empty($location)) {
            return 0;
        }
        //====================================================================//
        // Execute Restore Operation
        $this->manager->doRestore($operation, $location)
            ? $this->logManager->getLogger()->info("Restoration Completed")
            : $this->logManager->getLogger()->error("Restoration Failed")
        ;

        return 0;
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
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select location to use',
            $allLocationPaths
        );
        $question->setErrorMessage('Location is invalid.');
        $locationPath = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: '.(string) $locationPath);

        return $locationPath;
    }
}
