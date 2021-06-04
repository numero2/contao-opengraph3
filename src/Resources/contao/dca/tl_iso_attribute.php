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
<<<<<<< HEAD:src/Resources/contao/dca/tl_iso_attribute.php
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
=======
 * @copyright 2017 numero2 - Agentur für digitales Marketing
>>>>>>> master:dca/tl_iso_attribute.php
 */


if( !empty($GLOBALS['TL_DCA']['tl_iso_attribute']) ) {

    \Controller::loadDataContainer('opengraph_fields');

    /**
     * Add legends
     */
<<<<<<< HEAD:src/Resources/contao/dca/tl_iso_attribute.php
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
=======
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
>>>>>>> master:dca/tl_iso_attribute.php
