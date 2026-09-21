<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\DependencyInjection;

use numero2\Opengraph3Bundle\OpenGraph\Provider\ProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class Opengraph3Extension extends Extension {


    /**
     * {@inheritdoc}
     */
    public function load( array $mergedConfig, ContainerBuilder $container ): void {

        $container
            ->registerForAutoconfiguration(ProviderInterface::class)
            ->addTag('numero2_opengraph3.provider')
        ;

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );

        $loader->load('listener.yaml');
        $loader->load('services.yaml');
    }
}
