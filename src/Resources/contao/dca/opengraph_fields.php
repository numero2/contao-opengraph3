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


$GLOBALS['TL_DCA']['opengraph_fields'] = array(

    'palettes' => array(
        'default' => '{opengraph_legend:hide},og_title,og_type,og_image,og_properties;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;'
    )
,   'og_subpalettes' => array(
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
    )

,   'fields' => array(
    // __basic__ fields
        'og_title' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_title']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'og_type' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_type']
        ,   'inputType'         => 'select'
        ,   'options_callback'  => array( 'opengraph_fields','getTypes' )
        ,   'eval'              => array( 'chosen'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(32) NOT NULL default ''"
        )
    ,   'og_image' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_image']
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => array( 'extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "binary(16) NULL"
        )
    // all optional properties
    ,   'og_properties' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_properties']
        ,   'inputType'         => 'openGraphProperties'
        ,   'eval'              => array( 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "blob NULL"
        )
    // __all__ fields
    ,   'og_description' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_description']
        ,   'inputType'         => 'textarea'
        ,   'eval'              => array( 'style'=>'height: 60px;', 'decodeEntities'=>true )
        )
        // website field
    ,   'og_locale' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>5, 'placeholder'=>'en_US' )
        )
    ,   'og_site_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'inputType'         => 'text'
        )
        // article fields
    ,   'og_article_author' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true )
        )
    ,   'og_article_section' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_section']
        ,   'inputType'         => 'text'
        )
    ,   'og_article_published_time' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_published_time']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true )
        )
    ,   'og_article_modified_time' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_modified_time']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true )
        )
        // book fields
    ,   'og_book_author' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true )
        )
    ,   'og_book_isbn' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_isbn']
        ,   'inputType'         => 'text'
        )
    ,   'og_book_release_date' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true )
        )
    ,   'og_book_tag' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_tag']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true )
        )
        // business.business fields
    ,   'og_business_contact_data_street_address' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_street_address']
        ,   'inputType'         => 'text'
        )
    ,   'og_business_contact_data_locality' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_locality']
        ,   'inputType'         => 'text'
        )
    ,   'og_business_contact_data_postal_code' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_postal_code']
        ,   'inputType'         => 'text'
        )
    ,   'og_business_contact_data_country_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_country_name']
        ,   'inputType'         => 'select'
        ,   'options'           => System::getCountries()
        )
        // music.album fields
    ,   'og_music_musician' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_musician']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true )
        )
    ,   'og_music_release_date' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true )
        )
    ,   'og_music_release_type' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_type']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_music_release_types')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
        // music.song fields
    ,   'og_music_album_url' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'rgxp'=>'url' )
        )
    ,   'og_music_album_disc' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_disc']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural' )
        )
    ,   'og_music_album_track' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_track']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural' )
        )
    ,   'og_music_duration' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_duration']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural' )
        )
    ,   'og_music_preview_url_url' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_preview_url_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'url' )
        )
        // place fields
    ,   'og_place_location_latitude' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_latitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'digit' )
        )
    ,   'og_place_location_longitude' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_longitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'digit' )
        )
    ,   'og_place_location_altitude' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_altitude']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'digit' )
        )
        // product fields
    ,   'og_product_age_group' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_age_group']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_age_groups')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_availability' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_availability']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_availabilities')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_brand' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_brand']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_category' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_category']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_color' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_color']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_condition' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_condition']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_conditions')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_ean' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_ean']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_isbn' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_isbn']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_material' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_material']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_mfr_part_no' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_mfr_part_no']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_pattern' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_pattern']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_plural_title' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_plural_title']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_price_amount' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_amount']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'rgxp'=>'digit' )
        )
    ,   'og_product_price_currency' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_currency']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true )
        )
    ,   'og_product_shipping_weight_value' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_value']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'digit' )
        )
    ,   'og_product_shipping_weight_unit' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_unit']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_weight_units')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_size' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_size']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_target_gender' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_target_gender']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_target_genders')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_upc' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_upc']
        ,   'inputType'         => 'text'
        )
    ,   'og_product_weight_value' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_value']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'digit' )
        )
    ,   'og_product_weight_unit' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_unit']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_product_weight_units')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
    ,   'og_product_product_link' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_product_link']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'url' )
        )
        // profile fields
    ,   'og_profile_first_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_first_name']
        ,   'inputType'         => 'text'
        )
    ,   'og_profile_last_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_last_name']
        ,   'inputType'         => 'text'
        )
    ,   'og_profile_username' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_username']
        ,   'inputType'         => 'text'
        )
    ,   'og_profile_gender' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_gender']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('og_profile_genders')
        ,   'eval'              => array( 'includeBlankOption'=>true )
        )
        // twitter
    ,   'twitter_site' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_site']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@page' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'twitter_creator' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_creator']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@author' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'twitter_card' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_card']
        ,   'inputType'         => 'select'
        ,   'options'           => array( 'summary_large_image', 'summary' )
        ,   'eval'              => array( 'includeBlankOption'=>false, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'twitter_title' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_title']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'clr long' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'twitter_description' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_description']
        ,   'inputType'         => 'textarea'
        ,   'search'            => true
        ,   'eval'              => array( 'style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "text NULL"
        )
    ,   'twitter_image' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_image']
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => array( 'extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'twitter_legend' )
        ,   'sql'               => "binary(16) NULL"
        ),
    )
);


class opengraph_fields {


    /**
     * Generate options for og:type
     *
     * @param  DC_Table $dcTable
     *
     * @return array
     */
    public function getTypes( \DC_Table $dcTable) {

        $options = array();

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
