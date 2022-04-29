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
class VerifyCommand extends AbstractCommand
{
    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:run')
            ->setDescription('Run One or All Defined Tracks')
            ->addArgument('track', InputArgument::OPTIONAL, 'Track Code to Execute')
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
        // Execute Command in a Sandbox
        try {
            //====================================================================//
            // Detect Tracks to Execute
            $trackCode = $input->getArgument("track");
            if (!empty($trackCode) && ("all" != $trackCode)) {
                //====================================================================//
                // Run ONE Track
                if (!is_string($trackCode)) {
                    $this->error("Track Code is not a string!");
                    //====================================================================//
                    // Close Paddock Command
                    return $this->close($input, $output);
                }
                $this->runner->run($trackCode, 0);
                //====================================================================//
                // Close Paddock Command
                return $this->close($input, $output);
            }
            //====================================================================//
            // Run All Active Tracks
            foreach ($this->tracks->getAll() as $trackCode => $track) {
                if ($track->isEnabled()) {
                    $this->runner->run($trackCode, 0);
                }
            }
        } catch (\Throwable $throwable) {
            $this->error($throwable->getMessage());
        }
        //====================================================================//
        // Close Paddock Command
        return $this->close($input, $output);
    }
}
