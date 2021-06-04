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


namespace numero2\OpenGraph3\DCAHelper;

use Contao\Backend;
use Contao\DC_Table;


class OpengraphFields extends Backend {


    /**
     * Generate options for og:type
     *
     * @param \Contao\DC_Table $dcTable
     *
     * @return array
     */
    public function getTypes( DC_Table $dcTable ): array {

        $options = [];

        // add options based on og_subpalettes
        foreach( $GLOBALS['TL_DCA']['opengraph_fields']['og_subpalettes'] as $key => $value) {

            if( $key === "__basic__" || $key === "__all__" ) {
                continue;
            }

            $options[$key] = $key;
        }

        // check if we need to filter some types
        if( !empty($GLOBALS['TL_DCA'][$dcTable->table]['config']['allowedOpenGraphTypes']) && !empty($options) ) {

            foreach( $options as $option ) {

                if( !in_array($option, $GLOBALS['TL_DCA'][$dcTable->table]['config']['allowedOpenGraphTypes']) ) {
                    unset($options[$option]);
                }
            }
        }

        return $options;
    }


    /**
     * Generate options for given type
     *
     * @param string type
     *
     * @return array
     */
    public static function getEnumsFromLanguage( string $types ): array {

        if( !empty($GLOBALS['TL_LANG']['opengraph_fields'][$types]) && is_array($GLOBALS['TL_LANG']['opengraph_fields'][$types]) ) {
            return $GLOBALS['TL_LANG']['opengraph_fields'][$types];
        }

        return [];
    }
}
