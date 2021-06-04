<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2021 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
<<<<<<< HEAD:src/Resources/contao/config/config.php
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
=======
 * @copyright 2017 numero2 - Agentur für digitales Marketing
>>>>>>> master:config/config.php
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
 * Backend Form Fields
 */
$GLOBALS['BE_FFL']['openGraphProperties'] = '\numero2\OpenGraph3\OpenGraphProperties';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = ['numero2\OpenGraph3\OpenGraph3', 'findCompatibleModules'];
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = ['numero2\OpenGraph3\OpenGraph3', 'appendTagsByModule'];
$GLOBALS['TL_HOOKS']['generatePage'][] = ['numero2\OpenGraph3\OpenGraph3', 'addTagsToPage'];