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

namespace BadPixxel\Paddock\Backup\Models\Locations;

use BadPixxel\Paddock\Backup\Models\Operations\AbstractOperation;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use BadPixxel\Paddock\Core\Services\TracksRunner;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TypeError;

abstract class AbstractLocation implements LocationInterface
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var null|string
     */
    protected $log;

    /**
     * @var TracksRunner
     */
    protected $tracksRunner;

    public function __construct(TracksRunner $tracksRunner)
    {
        $this->tracksRunner = $tracksRunner;
    }

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function getCode(): string
    {
        throw new Exception(sprintf(
            "Backup Location %s must define an index code.",
            static::class
        ));
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(array $options = array()): string
    {
        return sprintf(
            "Backup Location %s provides no description...",
            static::class
        );
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options): self
    {
        $this->options = $this->resolveOptions($options);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public static function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * {@inheritDoc}
     */
    final public function validateOptions(array $options): bool
    {
        //====================================================================//
        // Resolve Constraint Configuration
        try {
            $this->resolveOptions($options);
        } catch (Exception|TypeError $ex) {
            $this->emergency(
                sprintf("Invalid Backup Location Options: %s", $ex->getMessage()),
                array(get_class($this))
            );

            return false;
        }

        return true;
    }

    //====================================================================//
    // BACKUP OPERATIONS
    //====================================================================//

    /**
     * Ensure Target Directory Exists & Is Writable
     *
     * @param string            $backupPath
     * @param AbstractOperation $operation
     *
     * @return string
     */
    public function getTargetPath(string $backupPath, AbstractOperation $operation): string
    {
        return $backupPath.'/'.$operation->getCode();
    }

    /**
     * {@inheritDoc}
     */
    public function getBackupLog(): string
    {
        return $this->log ?: "No Backup Log Provided";
    }

    /**
     * @param string $log
     *
     * @return self
     */
    public function setBackupLog(string $log): self
    {
        $this->log = $log;

        return $this;
    }

    //====================================================================//
    // PRIVATE METHODS
    //====================================================================//

    /**
     * @param array $options
     *
     * @throws Exception
     *
     * @return array
     */
    private function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        //====================================================================//
        // Configure Options Resolver for Final Rule
        $this->configureOptions($resolver);

        return $resolver->resolve($options);
    }
}
