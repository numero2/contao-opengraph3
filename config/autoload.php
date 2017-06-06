<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für Internetdienstleistungen
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
	'numero2\OpenGraph3\OpenGraph3' => 'system/modules/opengraph3/classes/OpenGraph.php',

    // Modules
    'numero2\OpenGraph3\ModuleNewsReader' => 'system/modules/opengraph3/modules/ModuleNewsReader.php',
));