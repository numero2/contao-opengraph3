<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2020 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2020 numero2 - Agentur für digitales Marketing GbR
 */


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
        'storelocator_details'
    ,   'numero2\StoreLocator\ModuleStoreLocatorDetails'
    ,   'numero2\OpenGraph3\OpenGraphStoreLocator'
    ]
];


if( 'BE' === TL_MODE ) {
    $GLOBALS['TL_CSS'][] = 'bundles/opengraph3/backend.css';
}


/**
 * BACK END FORM FIELDS
 */
$GLOBALS['BE_FFL']['openGraphProperties'] = '\numero2\OpenGraph3\OpenGraphProperties';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = ['numero2\OpenGraph3\OpenGraph3', 'findCompatibleModules'];
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = ['numero2\OpenGraph3\OpenGraph3', 'appendTagsByModule'];
$GLOBALS['TL_HOOKS']['generatePage'][]      = ['numero2\OpenGraph3\OpenGraph3', 'addTagsToPage'];
