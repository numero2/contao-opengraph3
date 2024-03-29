<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2022 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2022 numero2 - Agentur für digitales Marketing GbR
 */

use Contao\Controller;
use Contao\System;


if( !empty($GLOBALS['TL_DCA']['tl_iso_attribute']) ) {

    System::loadLanguageFile('opengraph_fields');
    Controller::loadDataContainer('opengraph_fields');

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
