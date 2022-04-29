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

namespace BadPixxel\Paddock\Backup\Models\Sources;

use BadPixxel\Paddock\Backup\Helpers\PathInfosBuilder;
use BadPixxel\Paddock\Core\Models\LoggerAwareTrait;
//use BadPixxel\Paddock\Core\Models\Rules\SourceInterface;
use Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TypeError;

/**
 * Base Class for Paddock Backup Source Services.
 */
abstract class AbstractSource implements SourceInterface
{
    use LoggerAwareTrait;

    /**
     * List of Core Rule Options
     *
     * @var array
     */
    const CORE_OPTIONS = array();

    /**
     * @var array
     */
    protected $options;

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
            "Backup Source %s must define an index code.",
            static::class
        ));
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return sprintf(
            "Backup Source %s provides no description...",
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
        //====================================================================//
        // Force File Rights on Restore
        $resolver->setDefault("chmod", null);
        $resolver->setAllowedTypes("chmod", array("null", "string", "int"));
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
                sprintf("Invalid Backup Source Options: %s", $ex->getMessage()),
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
     * {@inheritDoc}
     */
    public function beforeBackup(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function afterBackup(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeRestore(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function afterRestore(): bool
    {
        //====================================================================//
        // Ensure Files Rights
        $this->forceFilesRights();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getSourceInformations(): string
    {
        return sprintf(
            "Source Dir includes %s files for %s of Data (Md5 %s)",
            PathInfosBuilder::getFilesCount($this->getSourcePath()),
            PathInfosBuilder::getFilesSize($this->getSourcePath()),
            PathInfosBuilder::getPathMd5($this->getSourcePath())
        );
    }

    /**
     * Ensure Files Rights
     */
    protected function forceFilesRights(): void
    {
        //====================================================================//
        // Safety Checks
        if (empty($this->options["chmod"]) || !is_dir($this->getSourcePath())) {
            return;
        }
        //====================================================================//
        // List Files
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $finder->in($this->getSourcePath());
        // check if there are any search results
        if (!$finder->hasResults()) {
            return;
        }
        //====================================================================//
        // Ensure Files Rights
        $filesystem = new Filesystem();
        $filesystem->chmod($finder, $this->options["chmod"]);
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
                "Core options (%s) are missing in source %s, did you forgot parent::configureOptions ??",
                implode(", ", $missingOptions),
                static::class
            ));
        }

        return $resolver->resolve($options);
    }
}
