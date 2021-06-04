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
<<<<<<< HEAD:src/Resources/contao/dca/tl_iso_product.php
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
=======
 * @copyright 2017 numero2 - Agentur für digitales Marketing
>>>>>>> master:dca/tl_iso_product.php
 */


if( !empty($GLOBALS['TL_DCA']['tl_iso_product']) ) {

    \Controller::loadDataContainer('opengraph_fields');

    /**
     * Modify fields
     */
    if( !empty($GLOBALS['TL_DCA']['tl_iso_product']['fields']) ) {

        $GLOBALS['TL_DCA']['tl_iso_product']['fields'] = array_merge(
            $GLOBALS['TL_DCA']['tl_iso_product']['fields']
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
                $GLOBALS['TL_LANG']['tl_iso_product'][$key] = $translation;
            }
        );
    }

    /**
     * Restrict available types
     */
    $GLOBALS['TL_DCA']['tl_iso_product']['config']['allowedOpenGraphTypes'] = ['product'];
}
