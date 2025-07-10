<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\OpenGraph3\DCAHelper;

use Contao\BackendUser;
use Contao\DC_Table;
use Contao\System;


class OpengraphFields {


    /**
     * Generate options for og:type
     *
     * @param Contao\DC_Table $dcTable
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


    /**
     * Generate options for countries
     *
     * @return array
     */
    public static function getCountries(): array {

        $countries = [];

        if( System::getContainer()->has('contao.intl.countries') ) {
            $countries = System::getContainer()->get('contao.intl.countries')->getCountries();
        } else {
            $countries = System::getCountries();
        }

        $countries = array_change_key_case($countries, CASE_UPPER);

        return $countries;
    }


    /**
     * Generate options for image sizes
     *
     * @return array
     */
    public static function getImageSizes(): array {

        if( System::getContainer()->has('contao.image.sizes') ) {
            return System::getContainer()->get('contao.image.sizes')->getOptionsForUser(BackendUser::getInstance());
        } else {
            return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
        }
    }
}
