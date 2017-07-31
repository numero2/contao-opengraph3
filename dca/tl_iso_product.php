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


\System::loadLanguageFile('tl_opengraph_fields');
\Controller::loadDataContainer('tl_opengraph_fields');


/**
 * Modify fields
 */
$GLOBALS['TL_DCA']['tl_iso_product']['fields'] = array_merge(
    $GLOBALS['TL_DCA']['tl_iso_product']['fields']
,   $GLOBALS['TL_DCA']['tl_opengraph_fields']['fields']
);


/**
 * Add legends
 */
array_walk(
    $GLOBALS['TL_LANG']['opengraph_fields']['legends']
,   function( $translation, $key ) {
        $GLOBALS['TL_LANG']['tl_iso_product'][$key] = $translation;
    }
);