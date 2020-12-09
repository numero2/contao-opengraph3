<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2020 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2020 numero2 - Agentur für digitales Marketing GbR
 */


$GLOBALS['TL_DCA']['opengraph_fields'] = [

    'palettes' => [
        'default' => '{opengraph_legend:hide},og_title,og_type,og_image,og_properties;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;'
    ]
,   'og_subpalettes' => [
        '__basic__' => 'og_title,og_type,og_image'
    ,   '__all__' => 'og_description'
    ,   'website' => 'og_locale,og_site_name'
    ,   'article' => 'og_article_author,og_article_section'
    ,   'book' => 'og_book_author,og_book_isbn,og_book_release_date,og_book_tag'
    ,   'business.business' => 'og_business_contact_data_street_address,og_business_contact_data_locality,og_business_contact_data_postal_code,og_business_contact_data_country_name,og_place_location_latitude,og_place_location_longitude'
    ,   'music.album' => 'og_music_musician,og_music_release_date,og_music_release_type'
    ,   'music.song' => 'og_music_album_url,og_music_album_disc,og_music_album_track,og_music_duration,og_music_musician,og_music_preview_url_url,og_music_release_date,og_music_release_type'
    ,   'place' => 'og_place_location_latitude,og_place_location_longitude,og_place_location_altitude'
    ,   'product' => 'og_product_age_group,og_product_availability,og_product_brand,og_product_category,og_product_color,og_product_condition,og_product_ean,og_product_isbn,og_product_material,og_product_mfr_part_no,og_product_pattern,og_product_plural_title,og_product_price_amount,og_product_price_currency,og_product_shipping_weight_value,og_product_shipping_weight_unit,og_product_size,og_product_target_gender,og_product_upc,og_product_weight_value,og_product_weight_unit'
    ,   'profile' => 'og_profile_first_name,og_profile_last_name,og_profile_username,og_profile_gender'
    ]

,   'fields' => [
    // __basic__ fields
        'og_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_title']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'og_type' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_type']
        ,   'inputType'         => 'select'
        ,   'options_callback'  => ['opengraph_fields','getTypes']
        ,   'eval'              => ['chosen'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "varchar(32) NOT NULL default ''"
        ]
    ,   'og_image' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_image']
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => ['extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "binary(16) NULL"
        ]
    // all optional properties
    ,   'og_properties' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_properties']
        ,   'inputType'         => 'openGraphProperties'
        ,   'eval'              => ['tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "blob NULL"
        ]
    // __all__ fields
    ,   'og_description' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_description']
        ,   'inputType'         => 'textarea'
        ,   'eval'              => ['style'=>'height: 60px;', 'decodeEntities'=>true]
        ]
        // website field
    ,   'og_locale' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>5, 'placeholder'=>'en_US']
        ]
    ,   'og_site_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'inputType'         => 'text'
        ]
        // article fields
    ,   'og_article_author' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_article_section' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_section']
        ,   'inputType'         => 'text'
        ]
    ,   'og_article_published_time' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_published_time']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_article_modified_time' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_modified_time']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
        // book fields
    ,   'og_book_author' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_book_isbn' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_isbn']
        ,   'inputType'         => 'text'
        ]
    ,   'og_book_release_date' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_book_tag' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_tag']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
        // business.business fields
    ,   'og_business_contact_data_street_address' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_street_address']
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_locality' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_locality']
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_postal_code' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_postal_code']
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_country_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_country_name']
        ,   'inputType'         => 'select'
        ,   'options'           => System::getCountries()
        ]
        // music.album fields
    ,   'og_music_musician' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_musician']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_music_release_date' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_music_release_type' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_type']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_music_release_types')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
        // music.song fields
    ,   'og_music_album_url' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true, 'rgxp'=>'url']
        ]
    ,   'og_music_album_disc' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_disc']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_album_track' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_track']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_duration' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_duration']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_preview_url_url' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_preview_url_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'url']
        ]
        // place fields
    ,   'og_place_location_latitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_latitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_place_location_longitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_longitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_place_location_altitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_altitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
        // product fields
    ,   'og_product_age_group' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_age_group']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_age_groups')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_availability' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_availability']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_availabilities')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_brand' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_brand']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_category' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_category']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_color' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_color']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_condition' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_condition']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_conditions')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_ean' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_ean']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_isbn' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_isbn']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_material' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_material']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_mfr_part_no' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_mfr_part_no']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_pattern' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_pattern']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_plural_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_plural_title']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_price_amount' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_amount']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true, 'rgxp'=>'digit']
        ]
    ,   'og_product_price_currency' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_currency']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_product_shipping_weight_value' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_value']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_product_shipping_weight_unit' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_unit']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_weight_units')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_size' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_size']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_target_gender' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_target_gender']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_target_genders')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_upc' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_upc']
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_weight_value' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_value']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_product_weight_unit' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_unit']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_weight_units')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_product_link' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_product_link']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'url']
        ]
        // profile fields
    ,   'og_profile_first_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_first_name']
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_last_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_last_name']
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_username' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_username']
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_gender' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_gender']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_profile_genders')
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
        // twitter
    ,   'twitter_site' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_site']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@page']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_creator' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_creator']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@author']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_card' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_card']
        ,   'inputType'         => 'select'
        ,   'options'           => ['summary_large_image', 'summary']
        ,   'eval'              => ['includeBlankOption'=>false, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_title']
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'clr long']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_description' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_description']
        ,   'inputType'         => 'textarea'
        ,   'search'            => true
        ,   'eval'              => ['style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "text NULL"
        ]
    ,   'twitter_image' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_image']
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => ['extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "binary(16) NULL"
        ]
    ]
];


class opengraph_fields {


    /**
     * Generate options for og:type
     *
     * @param  DC_Table $dcTable
     *
     * @return array
     */
    public function getTypes( \DC_Table $dcTable) {

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
     * @param  String type
     *
     * @return array
     */
    public static function getEnumsFromLanguage($types) {

        return $GLOBALS['TL_LANG']['opengraph_fields'][$types];
    }
}
