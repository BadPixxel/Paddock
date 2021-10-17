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

namespace BadPixxel\Paddock\Backup\Services;

use BadPixxel\Paddock\Backup\Events\GetOperationsEvent;
use BadPixxel\Paddock\Backup\Models\Operation;
use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use BadPixxel\Paddock\Core\Services\ConfigurationManager;
use BadPixxel\Paddock\Core\Services\LogManager;
use Exception;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Manage Backup Operations
 */
class BackupManager
{
    /**
     * @var BackupManager
     */
    private static $instance;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var ConfigurationManager
     */
    private $configuration;

    /**
     * @var SourcesManager
     */
    private $sourcesManager;

    /**
     * @var LocationsManager
     */
    private $locationsManager;

    /**
     * @var LogManager
     */
    private $logManager;

    /**
     * @var array<string, AbstractOperation>
     */
    private $operations;

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     *
     * @param EventDispatcherInterface $dispatcher
     * @param ConfigurationManager     $configuration
     * @param SourcesManager           $sourcesManager
     * @param LocationsManager         $locationsManager
     * @param LogManager               $logManager
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        ConfigurationManager $configuration,
        SourcesManager $sourcesManager,
        LocationsManager $locationsManager,
        LogManager $logManager
    ) {
        $this->dispatcher = $dispatcher;
        $this->configuration = $configuration;
        $this->sourcesManager = $sourcesManager;
        $this->locationsManager = $locationsManager;
        $this->logManager = $logManager;
        //====================================================================//
        // Setup Static Access
        static::$instance = $this;
    }

    /**
     * Get Static Instance
     */
    public static function getInstance(): BackupManager
    {
        return static::$instance;
    }

    //====================================================================//
    // BACKUPS MANAGEMENT
    //====================================================================//

    /**
     * Execute a Backup Operation
     *
     * @param AbstractOperation $operation
     *
     * @throws Exception
     *
     * @return bool
     */
    public function doBackup(AbstractOperation $operation): bool
    {
        return $operation->doBackup();
    }

    /**
     * Execute a Restore Operation
     *
     * @param AbstractOperation $operation
     * @param string            $locationPath
     *
     * @throws Exception
     *
     * @return bool
     */
    public function doRestore(AbstractOperation $operation, string $locationPath): bool
    {
        return $operation->doRestore($locationPath);
    }

    //====================================================================//
    // OPERATIONS MANAGEMENT
    //====================================================================//

    /**
     * Get a Backup Operation by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractOperation
     */
    public function getOperationByCode(string $code): AbstractOperation
    {
        //====================================================================//
        // Ensure Load Operations
        $this->loadOperations();
        //====================================================================//
        // Search for Operation
        if (!isset($this->operations[$code])) {
            throw new Exception(sprintf("Backup Operation with code %s  was not found.", $code));
        }

        return $this->operations[$code];
    }

    /**
     * Get List of All Available Backup Operations
     *
     * @throws Exception
     *
     * @return array<string, AbstractOperation>
     */
    public function getAllOperations(): array
    {
        //====================================================================//
        // Ensure Load Operations
        $this->loadOperations();

        return $this->operations;
    }

    /**
     * Populate List of Available Backup Operations from Configuration
     *
     * @param GetOperationsEvent $event
     *
     * @return void
     */
    public function onGetOperationsEvent(GetOperationsEvent $event): void
    {
        //====================================================================//
        // Load Backup Operations from Static Configuration
        $config = $this->configuration->load();
        if (empty($config["backups"]) || !is_array($config["backups"])) {
            return;
        }
        //====================================================================//
        // Add Backup Operations
        foreach ($config["backups"] as $code => $definition) {
            if (is_scalar($code) && is_array($definition)) {
                $event->add((string) $code, $definition);
            }
        }
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * Initialize List of Available Backup Operations
     *
     * @throws Exception
     *
     * @return void
     */
    private function loadOperations(): void
    {
        //====================================================================//
        // Already Loaded
        if (isset($this->operations)) {
            return;
        }
        //====================================================================//
        // Dispatch Collect Backup Operations Event
        /** @var GetOperationsEvent $event */
        $event = $this->dispatcher->dispatch(new GetOperationsEvent());
        //====================================================================//
        // Populate Backup Operations Event
        $this->operations = array();
        $operations = $event->all();
        foreach ($operations as $code => $definition) {
            //====================================================================//
            // Build Backup Operations
            try {
                $operation = $this->buildOperation($code, $definition);
                if ($operation) {
                    $this->operations[$code] = $operation;
                }
            } catch (\Throwable $ex) {
                $this->logManager->getLogger()->emergency($ex->getMessage());
            }
        }
    }

    /**
     * Initialize a new Backup Operations
     *
     * @param string $code
     * @param array  $options
     *
     * @throws Exception
     *
     * @return null|Operation
     */
    private function buildOperation(string $code, array $options): ?Operation
    {
        //====================================================================//
        // Create New Operations
        $operation = new Operation($code, $options);
        //====================================================================//
        // Validate Backup Source
        $source = $this->sourcesManager->getByCode($operation->getSourceType());
        if (!$source->validateOptions($operation->getSourceOptions())) {
            return null;
        }
        //====================================================================//
        // Validate Backup Targets Locations
        $locations = $this->locationsManager->getConfigurationFromPath($operation->getTarget());
        //====================================================================//
        // Setup Operation Services
        $operation->configure($source, $locations);

        return $operation;
    }
}
