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

namespace BadPixxel\Paddock\Backup\Models\Operations;

use BadPixxel\Paddock\Backup\Helpers\StatusStorage;
use BadPixxel\Paddock\Backup\Helpers\UrlParser;
use BadPixxel\Paddock\Backup\Models\Locations\AbstractLocation;
use BadPixxel\Paddock\Backup\Models\Sources\AbstractSource;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base Class for Paddock Backup Operation Descriptions.
 */
abstract class AbstractOperation implements OperationInterface
{
    use LoggerAwareTrait;

    /**
     * List of Core Rule Options
     *
     * @var array
     */
    const CORE_OPTIONS = array("enabled", "description", "source", "source-options", "target", "target-options" );

    /**
     * @var string
     */
    protected $code;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var AbstractSource
     */
    protected $source;

    /**
     * @var array<string, AbstractLocation>
     */
    protected $locations;

    /**
     * Backup Operation Constructor
     *
     * @param string $code
     * @param array  $options
     *
     * @throws Exception
     */
    public function __construct(string $code, array $options)
    {
        $this->code = $code;
        $this->options = $this->resolveOptions($options);
    }

    //====================================================================//
    // DEFINITION
    //====================================================================//

    /**
     * Convert to String
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return $this->getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled(): bool
    {
        return $this->options['enabled'];
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        if (!empty($this->options['description'])) {
            return $this->options['description'];
        }

        return sprintf(
            "Backup Operation %s provides no description...",
            static::class
        );
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public static function configureOptions(OptionsResolver $resolver): void
    {
        //====================================================================//
        // Enabled
        $resolver->setDefault("enabled", true);
        $resolver->setAllowedTypes("enabled", array("bool"));
        //====================================================================//
        // Description
        $resolver->setDefault("description", "");
        $resolver->setAllowedTypes("description", array("string"));
        //====================================================================//
        // Source
        $resolver->setDefault("source", null);
        $resolver->setAllowedTypes("source", array("string"));
        $resolver->setDefault("source-options", array());
        $resolver->setAllowedTypes("source-options", array("array"));
        //====================================================================//
        // Target
        $resolver->setDefault("target", null);
        $resolver->setAllowedTypes("target", array("null", "string"));
        $resolver->setDefault("target-options", array());
        $resolver->setAllowedTypes("target-options", array("array"));
    }

    /**
     * {@inheritDoc}
     */
    final public function getSource(): string
    {
        return $this->options['source'];
    }

    /**
     * {@inheritDoc}
     */
    final public function getSourceType(): string
    {
        return (string) UrlParser::toType($this->options['source']);
    }

    /**
     * {@inheritDoc}
     */
    final public function getSourcePath(): string
    {
        return $this->source->getSourcePath();
    }

    /**
     * {@inheritDoc}
     */
    final public function getSourceOptions(): array
    {
        return array_replace_recursive(
            UrlParser::toOptions($this->options['source']),
            $this->options['source-options']
        );
    }

    /**
     * {@inheritDoc}
     */
    final public function getTarget(): ?string
    {
        return $this->options['target'];
    }

    /**
     * {@inheritDoc}
     */
    final public function getTargetOptions(): array
    {
        return $this->options['target-options'];
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    final public function getTargetPaths(): array
    {
        $paths = array();
        foreach ($this->locations as $backupPath => $location) {
            //====================================================================//
            // Setup Location Service
            $location->setOptions(array_replace_recursive(
                UrlParser::toOptions($backupPath),
                $this->getTargetOptions()
            ));

            $paths[] = $location->getTargetPath($backupPath, $this);
        }

        return $paths;
    }

    /**
     * {@inheritDoc}
     */
    final public function getLocations(): array
    {
        return array_keys($this->locations);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(AbstractSource $sourceService, array $targetServices): void
    {
        $this->source = $sourceService;
        $this->locations = $targetServices;
    }

    //====================================================================//
    // BACKUPS MANAGEMENT
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    public function doBackup(): bool
    {
        //====================================================================//
        // Setup Source Service
        $this->source->setOptions($this->getSourceOptions());
        //====================================================================//
        // Execute Before Operation on Source
        if (!$this->source->beforeBackup()) {
            return false;
        }
        $sourceLog = $this->source->getSourceInformations();
        //====================================================================//
        // Walk on Target Locations
        foreach ($this->locations as $backupPath => $location) {
            //====================================================================//
            // Setup Location Service
            $location->setOptions(array_replace_recursive(
                UrlParser::toOptions($backupPath),
                $this->getTargetOptions()
            ));
            //====================================================================//
            // Execute Backup Operation on Location
            if (!$location->doBackup($this)) {
                return StatusStorage::onError(
                    $this->getCode(),
                    $backupPath,
                    $sourceLog.PHP_EOL.$location->getBackupLog()
                );
            }
            $this->warning(sprintf("%s done for %s", $this->getCode(), $backupPath));
            //====================================================================//
            // Store Backup Results
            StatusStorage::onSuccess(
                $this->getCode(),
                $backupPath,
                $sourceLog.PHP_EOL.$location->getBackupLog()
            );
        }
        //====================================================================//
        // Execute After Operation on Source
        if (!$this->source->afterBackup()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function doRestore(string $locationPath): bool
    {
        //====================================================================//
        // Safety Check
        $location = $this->locations[$locationPath] ?? null;
        if (!$location instanceof AbstractLocation) {
            return $this->error(sprintf("%s is not a valid Backup Location", $locationPath));
        }

        //====================================================================//
        // Setup Source Service
        $this->source->setOptions($this->getSourceOptions());
        //====================================================================//
        // Execute Before Operation on Source
        if (!$this->source->beforeRestore()) {
            return false;
        }
        //====================================================================//
        // Setup Location Service
        $location->setOptions(array_replace_recursive(
            UrlParser::toOptions($locationPath),
            $this->getTargetOptions()
        ));
        //====================================================================//
        // Execute Restore Operation from Location
        if (!$location->doRestore($this)) {
            return false;
        }
        //====================================================================//
        // Execute After Operation on Source
        if (!$this->source->afterRestore()) {
            return false;
        }

        return true;
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
        //====================================================================//
        // Verify None of Core Options are Defined by Rule
        $missingOptions = array_diff(self::CORE_OPTIONS, $resolver->getDefinedOptions());
        if (!empty($missingOptions)) {
            throw new Exception(sprintf(
                "Core options (%s) are missing in Backup Operation %s, did you forgot parent::configureOptions ??",
                implode(", ", $missingOptions),
                static::class
            ));
        }

        return $resolver->resolve($options);
    }
}
