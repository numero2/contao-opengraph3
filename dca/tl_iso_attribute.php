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


if( !empty($GLOBALS['TL_DCA']['tl_iso_attribute']) ) {

    \System::loadLanguageFile('tl_opengraph_fields');
    \Controller::loadDataContainer('tl_opengraph_fields');


    /**
     * Add legends
     */
    array_walk(
        array_reverse($GLOBALS['TL_LANG']['opengraph_fields']['legends'])
    ,   function( $translation, $key ) {
            array_insert(
                $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options']
            ,   array_search('meta_legend', $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'])+1
            ,   $key
            );
        }
    );
}