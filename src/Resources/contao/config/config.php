<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
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
,   [
        'faqreader'
    ,   'Contao\ModuleFaqReader'
    ,   'numero2\OpenGraph3\OpenGraphFaq'
    ]
];


/**
 * Backend Form Fields
 */
$GLOBALS['BE_FFL']['openGraphProperties'] = OpenGraphProperties::class;