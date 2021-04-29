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
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Export Tracks Configuration
 */
class ExportCommand extends Command
{
    /** @var ConfigurationManager */
    private $manager;

    /** @var LogManager */
    private $logManager;

    /**
     * Command Constructor
     *
     * @param ConfigurationManager $configurationManager
     * @param LogManager           $logManager
     */
    public function __construct(ConfigurationManager $configurationManager, LogManager $logManager)
    {
        parent::__construct();

        $this->manager = $configurationManager;
        $this->logManager = $logManager;
    }

    /**
     * Configure Command.
     */
    protected function configure(): void
    {
        $this
            ->setName('paddock:export')
            ->setDescription('Export Tracks (Rules Collection)')
            ->addArgument('target', InputArgument::REQUIRED, 'Target file path')
            ->addArgument('config', InputArgument::OPTIONAL, 'Source Config to Use')
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
        $this->logManager->pushHandler(new ConsoleHandler($output));
        //====================================================================//
        // Load Source Configuration
        $configPath = $input->getArgument("config");
        $configuration = (!empty($configPath) && is_string($configPath))
            ? $this->manager->loadFromPath($configPath)
            : $this->manager->load()
        ;
        //====================================================================//
        // Safety Check
        if (empty($configuration)) {
            return 1;
        }
        //====================================================================//
        // Export Configuration
        return $this->export($input, $configuration);
    }

    /**
     * Export Configuration.
     *
     * @param InputInterface $input
     * @param array          $configuration
     *
     * @return int
     */
    private function export(InputInterface $input, array $configuration): int
    {
        //====================================================================//
        // Load target path
        $targetPath = $input->getArgument("target");
        if (empty($targetPath) || !is_string($targetPath)) {
            return 1;
        }
        $fullPath = getcwd()."/".$targetPath;
        //====================================================================//
        // Ensure target dir exists
        if (!is_dir(dirname($fullPath))) {
            $this->logManager->getLogger()->error("Target dir doesn't Exists");

            return 1;
        }
        //====================================================================//
        // Export Configuration
        $rawYaml = Yaml::dump($this->manager->export($configuration), 4);
        file_put_contents($fullPath, $rawYaml);
        //====================================================================//
        // Verify
        if (md5($rawYaml) != md5_file($fullPath)) {
            $this->logManager->getLogger()->error(
                sprintf("Failed to write file %s", $fullPath)
            );

            return 1;
        }
        //====================================================================//
        // Export Successful
        $this->logManager->getLogger()->warning(
            sprintf("Export do to file %s", $fullPath)
        );

        return 0;
    }
}
