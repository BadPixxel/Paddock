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

namespace BadPixxel\Paddock\Core\Collector;

use BadPixxel\Paddock\Core\Monolog\LocalLoggerAwareTrait;
use BadPixxel\Paddock\Core\Services\ConfigurationManager;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Cache\CacheInterface;
use TypeError;

/**
 * Base Class for Paddock Collector.
 */
abstract class AbstractCollector implements CollectorInterface
{
    use LocalLoggerAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var bool
     */
    protected static $enableCache = false;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Service Constructor
     *
     * @param CacheInterface $paddockCollectors
     */
    public function __construct(CacheInterface $paddockCollectors)
    {
        //====================================================================//
        // Init cache
        $this->cache = $paddockCollectors;
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
            "Collector %s has must define an index code.",
            static::class
        ));
    }

    /**
     * {@inheritDoc}
     */
    public static function getDescription(): string
    {
        return sprintf(
            "Collector %s provides no description...",
            static::class
        );
    }

    //====================================================================//
    // CONFIGURATION
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    final public function configure(array $options): void
    {
        $this->config = $this->resolveOptions($options);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    //====================================================================//
    // DATA COLLECTOR
    //====================================================================//

    /**
     * {@inheritDoc}
     */
    final public function getData(array $options, string $key)
    {
        //====================================================================//
        // Resolve Configuration
        $this->config = $this->resolveOptions($options);
        //====================================================================//
        // Load Data from Collector
        try {
            //====================================================================//
            // Load Collector Data without Cache Management
            if (!self::isCacheEnabled()) {
                return $this->get($key);
            }
            //====================================================================//
            // Load Collector Data with Cache Management
            $cacheKey = $key.md5(serialize($this->config));
            // The callable will only be executed on a cache miss.
            return $this->cache->get($cacheKey, function () use ($key) {
                return $this->get($key);
            });
        } catch (Exception $ex) {
            $this->emergency(sprintf("Data Collector Fail: %s", $ex->getMessage()));
        } catch (TypeError $ex) {
            $this->emergency(sprintf("Data Collector Fail: %s", $ex->getMessage()));
        }

        return null;
    }

    /**
     * Resolve Constraint Configuration
     *
     * @param array $options
     *
     * @return array
     */
    final protected function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        return $resolver->resolve($options);
    }

    /**
     * Get Data from Collector Service
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function get(string $key)
    {
        return sprintf("Collector must implement get(string ${key}) function!");
    }

    /**
     * Uses cache
     */
    protected static function isCacheEnabled(): bool
    {
        return static::$enableCache && ConfigurationManager::isCacheEnabled();
    }
}
