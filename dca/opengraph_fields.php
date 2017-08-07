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


$GLOBALS['TL_DCA']['opengraph_fields'] = array(

    'palettes' => array(
        'default' => '{opengraph_legend:hide},og_title,og_type,og_image,og_properties;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;'
    )
,   'og_subpalettes' => array(
        '__basic__' => 'og_title,og_type,og_image'
    ,   '__all__' => 'og_description'
    ,   'website' => 'og_locale,og_site_name'
    ,   'article' => 'article_author,article_section' // article_published_time,article_modified_time
    ,   'book' => 'book_author,book_isbn,book_release_date,book_tag'
    ,   'business.business' => 'business_contact_data_street_address,business_contact_data_locality,business_contact_data_postal_code,business_contact_data_country_name,place_location_latitude,place_location_longitude'
    ,   'music.album' => 'music_musician,music_release_date,music_release_type'
    ,   'music.song' => 'music_album_url,music_album_disc,music_album_track,music_duration,music_musician,music_preview_url_url,music_release_date,music_release_type'
    ,   'place' => 'place_location_latitude,place_location_longitude,place_location_altitude'
    ,   'product' => 'product_age_group,product_availability,product_brand,product_category,product_color,product_condition,product_ean,product_isbn,product_material,product_mfr_part_no,product_pattern,product_plural_title,product_price_amount,product_price_currency,product_size,product_target_gender,product_upc,product_weight' // product:product_link
    ,   'profile' => 'profile_first_name,profile_last_name,profile_username,profile_gender'
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
        ,   'eval'              => array( 'style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr' )
        )
        // website field
    ,   'og_locale' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>5, 'tl_class'=>'w50', 'placeholder'=>'en_US' )
        )
    ,   'og_site_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
        // article fields
    ,   'article_author' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['article_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'tl_class'=>'w50' )
        )
    ,   'article_section' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['article_section']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
        // book fields
    ,   'book_author' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['book_author']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'tl_class'=>'w50' )
        )
    ,   'book_isbn' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['book_isbn']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
    ,   'book_release_date' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['book_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard' )
        )
    ,   'book_tag' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['book_tag']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'tl_class'=>'w50' )
        )
        // business.business fields
    ,   'business_contact_data_street_address' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['business_contact_data_street_address']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
    ,   'business_contact_data_locality' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['business_contact_data_locality']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
    ,   'business_contact_data_postal_code' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['business_contact_data_postal_code']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
    ,   'business_contact_data_country_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['business_contact_data_country_name']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
        // music.album fields
    ,   'music_musician' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_musician']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'tl_class'=>'w50' )
        )
    ,   'music_release_date' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_release_date']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard' )
        )
    ,   'music_release_type' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_release_type']
        ,   'inputType'         => 'select'
        ,   'options'           => opengraph_fields::getEnumsFromLanguage('music_release_types')
        ,   'eval'              => array( 'tl_class'=>'w50' )
        )
        // music.song fields
    ,   'music_album_url' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_album_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'og_multiple'=>true, 'rgxp'=>'url', 'tl_class'=>'w50' )
        )
    ,   'music_album_disc' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_album_disc']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural', 'tl_class'=>'w50' )
        )
    ,   'music_album_track' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_album_track']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural', 'tl_class'=>'w50' )
        )
    ,   'music_duration' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_duration']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'natural', 'tl_class'=>'w50' )
        )
    ,   'music_preview_url_url' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['music_preview_url_url']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'rgxp'=>'url', 'tl_class'=>'w50' )
        )
        // place fields
    ,   'place_location_latitude' => array(
    )
    ,   'place_location_longitude' => array(
    )
    ,   'place_location_altitude' => array(
    )
        // product fields
    ,   'product_age_group' => array(
    )
    ,   'product_availability' => array(
    )
    ,   'product_brand' => array(
    )
    ,   'product_category' => array(
    )
    ,   'product_color' => array(
    )
    ,   'product_condition' => array(
    )
    ,   'product_ean' => array(
    )
    ,   'product_isbn' => array(
    )
    ,   'product_material' => array(
    )
    ,   'product_mfr_part_no' => array(
    )
    ,   'product_pattern' => array(
    )
    ,   'product_plural_title' => array(
    )
    ,   'product_price_amount' => array(
    )
    ,   'product_price_currency' => array(
    )
    ,   'product_size' => array(
    )
    ,   'product_target_gender' => array(
    )
    ,   'product_upc' => array(
    )
    ,   'product_weight' => array(
    )
        // profile fields
    ,   'profile_first_name' => array(
    )
    ,   'profile_last_name' => array(
    )
    ,   'profile_username' => array(
    )
    ,   'profile_gender' => array(
    )


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
     * Generate options for og:type
     *
     * @param  DC_Table $dcTable
     *
     * @return array
     */
    public function getEnumsFromLanguage( $types) {

        return $GLOBALS['TL_LANG']['opengraph_fields'][$types];
    }
}
