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

namespace BadPixxel\Paddock\Core\Models\Command;

use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Services\CollectorsManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use BadPixxel\Paddock\Core\Services\TracksManager;
use BadPixxel\Paddock\Core\Services\TracksRunner;
use Exception;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base Command for Paddock Commands
 */
abstract class AbstractCommand extends Command
{
    use LoggerAwareTrait;

    /** @var TracksRunner */
    protected $runner;

    /** @var TracksManager */
    protected $tracks;

    /** @var CollectorsManager */
    protected $collectors;

    /** @var LogManager */
    protected $logger;

    /**
     * @param TracksRunner      $runner
     * @param TracksManager     $tracks
     * @param CollectorsManager $collectors
     * @param LogManager        $logManager
     */
    public function __construct(TracksRunner $runner, TracksManager $tracks, CollectorsManager $collectors, LogManager $logManager)
    {
        parent::__construct();

        $this->runner = $runner;
        $this->tracks = $tracks;
        $this->collectors = $collectors;
        $this->logger = $logManager;
    }

    /**
     * Init Paddock Command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function init(InputInterface $input, OutputInterface $output): void
    {
        //====================================================================//
        // Setup Console Log if NO Output format defined
        if (empty($input->getOption("format"))) {
            $this->logger->pushHandler(new ConsoleHandler($output));
        }
    }

    /**
     * Close Paddock Command & Return results.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return int
     */
    protected function close(InputInterface $input, OutputInterface $output): int
    {
        //====================================================================//
        // Detect Outputs Formatter
        $formatterCode = $input->getOption("format");
        if ($formatterCode && is_string($formatterCode)) {
            $formatter = $this->logger->getFormatter($formatterCode);
            $output->writeln($formatter->getStatus());

            return $formatter->getStatusCode();
        }

        return $this->logger->hasErrors() ? Command::FAILURE : Command::SUCCESS;
    }
}
