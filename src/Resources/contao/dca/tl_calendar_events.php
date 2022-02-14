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
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
 */


if(!empty($GLOBALS['TL_DCA']['tl_calendar_events'])) {

    \Contao\System::loadLanguageFile('opengraph_fields');
    \Contao\Controller::loadDataContainer('opengraph_fields');

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
