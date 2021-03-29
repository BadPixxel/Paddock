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

namespace BadPixxel\Paddock\Core\Services;

use BadPixxel\Paddock\Core\Events\GetConstraintsEvent;
use BadPixxel\Paddock\Core\Models\Rules\AbstractRule;
use Exception;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Manager for Paddock Rules / Constraints
 */
class RulesManager
{
    /**
     * @var RulesManager
     */
    private static $instance;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var LogManager
     */
    private $logManager;

    /**
     * @var AbstractRule[]
     */
    private $constraints;

    //====================================================================//
    // CONSTRUCTOR
    //====================================================================//

    /**
     * Service Constructor
     *
     * @param EventDispatcherInterface $dispatcher
     * @param LogManager               $logManager
     */
    public function __construct(EventDispatcherInterface $dispatcher, LogManager $logManager)
    {
        $this->dispatcher = $dispatcher;
        $this->logManager = $logManager;
        //====================================================================//
        // Setup Static Access
        static::$instance = $this;
    }

    //====================================================================//
    // CONSTRAINTS MANAGEMENT
    //====================================================================//

    /**
     * Has a Rule by Code
     *
     * @param string $code
     *
     * @return bool
     */
    public function has(string $code): bool
    {
        $this->loadRules();

        return isset($this->constraints[$code]);
    }

    /**
     * Get a Rule by Code
     *
     * @param string $code
     *
     * @throws Exception
     *
     * @return AbstractRule
     */
    public function getByCode(string $code): AbstractRule
    {
        $this->loadRules();

        if (!isset($this->constraints[$code])) {
            throw new Exception(sprintf("Rule with code %s  was not found.", $code));
        }

        return $this->constraints[$code];
    }

    /**
     * Get List of All Available Rules / Constraints
     *
     * @return AbstractRule[]
     */
    public function getAll(): array
    {
        $this->loadRules();

        return $this->constraints;
    }

    /**
     * Get Static Instance
     */
    public static function getInstance(): RulesManager
    {
        return static::$instance;
    }

    /**
     * Initialize List of Available Rules / Constraints
     */
    private function loadRules(): int
    {
        if (!isset($this->constraints)) {
            /** @var GetConstraintsEvent $event */
            $event = $this->dispatcher->dispatch(new GetConstraintsEvent());

            $this->constraints = array();
            $constraintsList = $event->all();
            foreach ($constraintsList as $code => $constraintClass) {
                if (is_subclass_of($constraintClass, AbstractRule::class)) {
                    $this->constraints[$code] = new $constraintClass($this, $this->logManager->getLogger());
                }
            }
        }

        return count($this->constraints);
    }
}
