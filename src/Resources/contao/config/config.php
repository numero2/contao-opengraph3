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
$GLOBALS['TL_OG_MODULES'] = array(
    array(
        'iso_productreader'
    ,   'Isotope\Module\ProductReader'
    ,   'numero2\OpenGraph3\OpenGraphIsotope'
    )
,   array(
        'newsreader'
    ,   'Contao\ModuleNewsReader'
    ,   'numero2\OpenGraph3\OpenGraphNews'
    )
,   array(
        'storelocator_details'
    ,   'numero2\StoreLocator\ModuleStoreLocatorDetails'
    ,   'numero2\OpenGraph3\OpenGraphStoreLocator'
    )
);


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
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('numero2\OpenGraph3\OpenGraph3', 'findCompatibleModules');
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('numero2\OpenGraph3\OpenGraph3', 'appendTagsByModule');
$GLOBALS['TL_HOOKS']['generatePage'][]      = array('numero2\OpenGraph3\OpenGraph3', 'addTagsToPage');
