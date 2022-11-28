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

namespace BadPixxel\Paddock\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class PaddockProjectExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function prepend(ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        /** @var array<string, class-string> $bundles */
        $bundles = $container->getParameter('kernel.bundles');
        //====================================================================//
        // Register Default Doctrine ORM Configuration
        if (isset($bundles['DoctrineBundle'])) {
            $loader->load('doctrine_orm.yml');
        }
        //====================================================================//
        // Register Default Doctrine ODM Configuration
        if (isset($bundles['DoctrineMongoDBBundle'])) {
            $loader->load('doctrine_odm.yml');
        }
    }
}
