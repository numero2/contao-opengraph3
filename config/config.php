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


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('numero2\OpenGraph3\OpenGraph3', 'findCompatibleModules');
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('numero2\OpenGraph3\OpenGraph3', 'appendTagsByModule');
$GLOBALS['TL_HOOKS']['generatePage'][]      = array('numero2\OpenGraph3\OpenGraph3', 'addTagsToPage');