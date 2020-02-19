<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für digitales Marketing
 */


if( !empty($GLOBALS['TL_DCA']['tl_iso_attribute']) ) {

    \Controller::loadDataContainer('opengraph_fields');


    /**
     * Add legends
     */
    if( !empty($GLOBALS['TL_LANG']['opengraph_fields']['legends']) ) {

        array_walk(
            array_reverse($GLOBALS['TL_LANG']['opengraph_fields']['legends'])
            ,   function( $translation, $key ) {
                array_insert(
                    $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options']
                    ,   array_search('meta_legend', $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'])+1
                    ,   $key
                );
                $GLOBALS['TL_LANG']['tl_iso_product'][$key] = $translation;
            }
        );
    }
}