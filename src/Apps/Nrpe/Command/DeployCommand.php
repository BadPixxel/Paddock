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

namespace BadPixxel\Paddock\Apps\Nrpe\Command;

use BadPixxel\Paddock\Apps\Nrpe\Services\CommandsManager;
use BadPixxel\Paddock\Core\Services\ConfigurationManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Nagios Nrpe Commands Install
 */
class DeployCommand extends Command
{
    /** @var CommandsManager */
    private $commands;

    /** @var ConfigurationManager */
    private $config;

    /** @var LogManager */
    private $logger;

    /**
     * Command Constructor
     *
     * @param CommandsManager      $commands
     * @param ConfigurationManager $config
     * @param LogManager           $logger
     */
    public function __construct(CommandsManager $commands, ConfigurationManager $config, LogManager $logger)
    {
        parent::__construct();

        $this->commands = $commands;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:nrpe:deploy')
            ->setDescription('Setup Nrpe Paddock Local Commands')
        ;
    }

    /**
     * Execute Command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //====================================================================//
        // Setup Console Log
        $this->logger->pushHandler(new ConsoleHandler($output));
        //====================================================================//
        // Check Current Configuration
        if (!$this->commands->check()) {
            //====================================================================//
            // Deploy Configuration
            $this->commands->deploy();
        }
        //====================================================================//
        // Check Current Configuration
        return $this->commands->check() ? 0 : 1;
    }
}
