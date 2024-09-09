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


if( !empty($GLOBALS['TL_DCA']['tl_calendar_events']) ) {

    System::loadLanguageFile('opengraph_fields');
    Controller::loadDataContainer('opengraph_fields');

    /**
     * Modify palettes
     */
    $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace(
        '{expert_legend'
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{expert_legend'
    ,   $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
    );

    /**
     * Modify fields
     */
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields'] = array_merge(
        $GLOBALS['TL_DCA']['tl_calendar_events']['fields']
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
    );

    /**
     * Add legends
     */
    array_walk(
        $GLOBALS['TL_LANG']['opengraph_fields']['legends']
    ,   static function( $translation, $key ) {
            $GLOBALS['TL_LANG']['tl_calendar_events'][$key] = $translation;
        }
    );

    /**
     * Restrict available types
     */
    $GLOBALS['TL_DCA']['tl_calendar_events']['config']['allowedOpenGraphTypes'] = ['website'];
}
