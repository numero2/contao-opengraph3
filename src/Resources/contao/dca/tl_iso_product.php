<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


use Contao\Controller;
use Contao\System;


if( !empty($GLOBALS['TL_DCA']['tl_iso_product']) ) {

    System::loadLanguageFile('opengraph_fields');
    Controller::loadDataContainer('opengraph_fields');

    /**
     * Modify fields
     */
    $GLOBALS['TL_DCA']['tl_iso_product']['fields'] = array_merge(
        $GLOBALS['TL_DCA']['tl_iso_product']['fields']
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
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

    /**
     * Restrict available types
     */
    $GLOBALS['TL_DCA']['tl_iso_product']['config']['allowedOpenGraphTypes'] = ['product'];
}
