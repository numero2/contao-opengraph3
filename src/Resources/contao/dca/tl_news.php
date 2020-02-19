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


if( !empty($GLOBALS['TL_DCA']['tl_news']) ) {

    \Controller::loadDataContainer('opengraph_fields');

    /**
     * Modify palettes
     */
    $GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace(
        '{expert_legend'
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{expert_legend'
    ,   $GLOBALS['TL_DCA']['tl_news']['palettes']['default']
    );

    /**
     * Modify fields
     */
    if( !empty($GLOBALS['TL_DCA']['opengraph_fields']['fields']) ) {

        $GLOBALS['TL_DCA']['tl_news']['fields'] = array_merge(
            $GLOBALS['TL_DCA']['tl_news']['fields']
            ,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
        );
    }

    /**
     * Add legends
     */
    if( !empty($GLOBALS['TL_LANG']['opengraph_fields']['legends']) ) {

        array_walk(
            $GLOBALS['TL_LANG']['opengraph_fields']['legends']
            ,   function( $translation, $key ) {
                $GLOBALS['TL_LANG']['tl_news'][$key] = $translation;
            }
        );
    }

    /**
     * Restrict available types
     */
    $GLOBALS['TL_DCA']['tl_news']['config']['allowedOpenGraphTypes'] = ['article'];
}
