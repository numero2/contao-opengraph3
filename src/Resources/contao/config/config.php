<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2022 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2022 numero2 - Agentur für digitales Marketing GbR
 */


use numero2\OpenGraph3\OpenGraphProperties;


/**
 * OpenGraph compatible modules
 */
$GLOBALS['TL_OG_MODULES'] = [
    [
        'iso_productreader'
    ,   'Isotope\Module\ProductReader'
    ,   'numero2\OpenGraph3\OpenGraphIsotope'
    ]
,   [
        'newsreader'
    ,   'Contao\ModuleNewsReader'
    ,   'numero2\OpenGraph3\OpenGraphNews'
    ]
,   [
        'eventreader'
    ,   'Contao\ModuleEventReader'
    ,   'numero2\OpenGraph3\OpenGraphCalendarEvents'
    ]
,   [
        'storelocator_details'
    ,   'numero2\StoreLocator\ModuleStoreLocatorDetails'
    ,   'numero2\OpenGraph3\OpenGraphStoreLocator'
    ]
];


/**
 * Backend Form Fields
 */
$GLOBALS['BE_FFL']['openGraphProperties'] = OpenGraphProperties::class;