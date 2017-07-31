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


\System::loadLanguageFile('opengraph_fields');
\Controller::loadDataContainer('opengraph_fields');


/**
 * Modify palettes
 */
$GLOBALS['TL_DCA']['tl_storelocator_stores']['palettes']['default'] = str_replace(
    '{adress_legend'
,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{adress_legend'
,   $GLOBALS['TL_DCA']['tl_storelocator_stores']['palettes']['default']
);


/**
 * Modify fields
 */
$GLOBALS['TL_DCA']['tl_storelocator_stores']['fields'] = array_merge(
    $GLOBALS['TL_DCA']['tl_storelocator_stores']['fields']
,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
);


/**
 * Add legends
 */
array_walk(
    $GLOBALS['TL_LANG']['opengraph_fields']['legends']
,   function( $translation, $key ) {
        $GLOBALS['TL_LANG']['tl_storelocator_stores'][$key] = $translation;
    }
);