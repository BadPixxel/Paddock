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

namespace BadPixxel\Paddock\Core\Command;

use BadPixxel\Paddock\Core\Models\Command\AbstractCommand;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Run One or All Defined Tracks
 */
class RunOneCommand extends AbstractCommand
{
    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:runOne')
            ->setDescription('Verify One Rule with Options')
            ->addArgument('options', InputArgument::REQUIRED, 'Rule Options (json)')
            ->addArgument('track', InputArgument::OPTIONAL, 'Track Code')
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Response Format', 'json')
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
        // Init Paddock Command
        $this->init($input, $output);
        //====================================================================//
        // Load Arguments
        /** @var string $options */
        $options = $input->getArgument("options");
        /** @var string $trackCode */
        $trackCode = $input->getArgument("track");
        $track = $this->tracks->getByCode($trackCode);
        //====================================================================//
        // Try to decode Rule Options
        $ruleOptions = json_decode($options, true);
        if (!is_array($ruleOptions)) {
            $this->error(json_last_error_msg());
            //====================================================================//
            // Close Paddock Command
            return $this->close($input, $output);
        }
        //====================================================================//
        // Execute Rule Verification in a Sandbox
        try {
            $testHandler = $this->runner->executeRule($track, $ruleOptions);
            //====================================================================//
            // Import results to Logger
            $this->logger->importLogs($testHandler->getRecords());
        } catch (\Throwable $throwable) {
            $this->error($throwable->getMessage());
        }
        //====================================================================//
        // Close Paddock Command
        return $this->close($input, $output);
    }
}
