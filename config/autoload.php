<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für digitales Marketing
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'numero2\OpenGraph3',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array(

    // Classes
    'numero2\OpenGraph3\OpenGraph3'             => 'system/modules/opengraph3/classes/OpenGraph.php',
    'numero2\OpenGraph3\OpenGraphIsotope'       => 'system/modules/opengraph3/classes/OpenGraphIsotope.php',
    'numero2\OpenGraph3\OpenGraphNews'          => 'system/modules/opengraph3/classes/OpenGraphNews.php',
    'numero2\OpenGraph3\OpenGraphStoreLocator'  => 'system/modules/opengraph3/classes/OpenGraphStoreLocator.php',

    // Widgets
    'numero2\OpenGraph3\OpenGraphProperties'    => 'system/modules/opengraph3/widgets/OpenGraphProperties.php',
));
