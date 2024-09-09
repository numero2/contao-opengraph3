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
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\System;


if( !empty($GLOBALS['TL_DCA']['tl_page']) ) {

    System::loadLanguageFile('opengraph_fields');
    Controller::loadDataContainer('opengraph_fields');

    /**
     * Modify palettes
     */
    $GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace(
        '{dns_legend'
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{dns_legend'
    ,   $GLOBALS['TL_DCA']['tl_page']['palettes']['root']
    );

    if( defined('VERSION') && version_compare(VERSION, '4.9', '==') ) {

        $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] = str_replace(
            '{dns_legend'
        ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{dns_legend'
        ,   $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback']
        );

    } else if( (defined('VERSION') && version_compare(VERSION, '4.9', '>')) || version_compare(ContaoCoreBundle::getVersion(), '4.9', '>') ) {

        $GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace(
            '{url_legend'
        ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{url_legend'
        ,   $GLOBALS['TL_DCA']['tl_page']['palettes']['root']
        );

        $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] = str_replace(
            '{url_legend'
        ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{url_legend'
        ,   $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback']
        );
    }

    $GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace(
        '{protected_legend'
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{protected_legend'
    ,   $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
    );

    /**
     * Modify fields
     */
    $GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
        $GLOBALS['TL_DCA']['tl_page']['fields']
    ,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
    );

    /**
     * Add legends
     */
    array_walk(
        $GLOBALS['TL_LANG']['opengraph_fields']['legends']
    ,   function( $translation, $key ) {
            $GLOBALS['TL_LANG']['tl_page'][$key] = $translation;
        }
    );
}
