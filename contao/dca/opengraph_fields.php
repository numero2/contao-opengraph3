<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


/**
 * Definition of all OpenGraph and X / Twitter fields, these will be added to
 * the tables of the supported records. Fields without an sql definition are
 * only available as additional properties (og_properties).
 *
 * The key "og_property" contains the name of the generated meta tag.
 */
$GLOBALS['TL_DCA']['opengraph_fields'] = [

    'palettes' => [
        'default' => '{opengraph_legend:hide},og_title,og_type,og_image,og_properties;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image'
    ]
,   'og_subpalettes' => [
        '__basic__' => 'og_title,og_type,og_image'
    ,   '__all__' => 'og_description'
    ,   'website' => 'og_locale,og_site_name'
    ,   'article' => 'og_article_author,og_article_section,og_article_published_time,og_article_modified_time'
    ,   'book' => 'og_book_author,og_book_isbn,og_book_release_date,og_book_tag'
    ,   'business.business' => 'og_business_contact_data_street_address,og_business_contact_data_locality,og_business_contact_data_postal_code,og_business_contact_data_country_name,og_place_location_latitude,og_place_location_longitude'
    ,   'music.album' => 'og_music_musician,og_music_release_date,og_music_release_type'
    ,   'music.song' => 'og_music_album_url,og_music_album_disc,og_music_album_track,og_music_duration,og_music_musician,og_music_preview_url_url,og_music_release_date,og_music_release_type'
    ,   'place' => 'og_place_location_latitude,og_place_location_longitude,og_place_location_altitude'
    ,   'product' => 'og_product_age_group,og_product_availability,og_product_brand,og_product_category,og_product_color,og_product_condition,og_product_ean,og_product_isbn,og_product_material,og_product_mfr_part_no,og_product_pattern,og_product_plural_title,og_product_price_amount,og_product_price_currency,og_product_product_link,og_product_shipping_weight_value,og_product_shipping_weight_unit,og_product_size,og_product_target_gender,og_product_upc,og_product_weight_value,og_product_weight_unit'
    ,   'profile' => 'og_profile_first_name,og_profile_last_name,og_profile_username,og_profile_gender'
    ]

,   'fields' => [
        // __basic__ fields
        'og_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_title']
        ,   'og_property'       => 'og:title'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'og_type' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_type']
        ,   'og_property'       => 'og:type'
        ,   'inputType'         => 'select'
        ,   'options_callback'  => ['numero2_opengraph3.listener.data_container.opengraph_fields', 'getTypes']
        ,   'eval'              => ['chosen'=>true, 'includeBlankOption'=>true, 'submitOnChange'=>true, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'opengraph_legend']
        ,   'sql'               => "varchar(32) NOT NULL default ''"
        ]
    ,   'og_image' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_image']
        ,   'og_property'       => 'og:image'
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => ['extensions'=>'png,gif,jpg,jpeg,webp', 'files'=>true, 'filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr']
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
        ,   'og_property'       => 'og:description'
        ,   'inputType'         => 'textarea'
        ,   'eval'              => ['style'=>'height: 60px;', 'decodeEntities'=>true]
        ]
        // website fields
    ,   'og_locale' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'og_property'       => 'og:locale'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>5, 'placeholder'=>'en_US']
        ]
    ,   'og_site_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'og_property'       => 'og:site_name'
        ,   'inputType'         => 'text'
        ]
        // article fields
    ,   'og_article_author' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_author']
        ,   'og_property'       => 'article:author'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_article_section' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_section']
        ,   'og_property'       => 'article:section'
        ,   'inputType'         => 'text'
        ]
    ,   'og_article_published_time' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_published_time']
        ,   'og_property'       => 'article:published_time'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_article_modified_time' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_article_modified_time']
        ,   'og_property'       => 'article:modified_time'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
        // book fields
    ,   'og_book_author' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_author']
        ,   'og_property'       => 'book:author'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_book_isbn' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_isbn']
        ,   'og_property'       => 'book:isbn'
        ,   'inputType'         => 'text'
        ]
    ,   'og_book_release_date' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_release_date']
        ,   'og_property'       => 'book:release_date'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_book_tag' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_book_tag']
        ,   'og_property'       => 'book:tag'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
        // business.business fields
    ,   'og_business_contact_data_street_address' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_street_address']
        ,   'og_property'       => 'business:contact_data:street_address'
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_locality' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_locality']
        ,   'og_property'       => 'business:contact_data:locality'
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_postal_code' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_postal_code']
        ,   'og_property'       => 'business:contact_data:postal_code'
        ,   'inputType'         => 'text'
        ]
    ,   'og_business_contact_data_country_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_business_contact_data_country_name']
        ,   'og_property'       => 'business:contact_data:country_name'
        ,   'inputType'         => 'select'
        ,   'options_callback'  => ['numero2_opengraph3.listener.data_container.opengraph_fields', 'getCountries']
        ,   'eval'              => ['includeBlankOption'=>true, 'chosen'=>true]
        ]
        // music.album fields
    ,   'og_music_musician' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_musician']
        ,   'og_property'       => 'music:musician'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_music_release_date' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_date']
        ,   'og_property'       => 'music:release_date'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'datim', 'datepicker'=>true]
        ]
    ,   'og_music_release_type' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_type']
        ,   'og_property'       => 'music:release_type'
        ,   'inputType'         => 'select'
        ,   'options'           => ['original_release', 're_release', 'anthology']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_release_types']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
        // music.song fields
    ,   'og_music_album_url' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_url']
        ,   'og_property'       => 'music:album:url'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true, 'rgxp'=>'url']
        ]
    ,   'og_music_album_disc' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_disc']
        ,   'og_property'       => 'music:album:disc'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_album_track' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_album_track']
        ,   'og_property'       => 'music:album:track'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_duration' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_duration']
        ,   'og_property'       => 'music:duration'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'natural']
        ]
    ,   'og_music_preview_url_url' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_music_preview_url_url']
        ,   'og_property'       => 'music:preview_url:url'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'url']
        ]
        // place fields
    ,   'og_place_location_latitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_latitude']
        ,   'og_property'       => 'place:location:latitude'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_place_location_longitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_longitude']
        ,   'og_property'       => 'place:location:longitude'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_place_location_altitude' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_place_location_altitude']
        ,   'og_property'       => 'place:location:altitude'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
        // product fields
    ,   'og_product_age_group' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_age_group']
        ,   'og_property'       => 'product:age_group'
        ,   'inputType'         => 'select'
        ,   'options'           => ['kids', 'adult']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_age_groups']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_availability' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_availability']
        ,   'og_property'       => 'product:availability'
        ,   'inputType'         => 'select'
        ,   'options'           => ['instock', 'oos', 'pending']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_availabilities']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_brand' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_brand']
        ,   'og_property'       => 'product:brand'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_category' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_category']
        ,   'og_property'       => 'product:category'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_color' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_color']
        ,   'og_property'       => 'product:color'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_condition' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_condition']
        ,   'og_property'       => 'product:condition'
        ,   'inputType'         => 'select'
        ,   'options'           => ['new', 'refurbished', 'used']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_conditions']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_ean' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_ean']
        ,   'og_property'       => 'product:ean'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_isbn' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_isbn']
        ,   'og_property'       => 'product:isbn'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_material' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_material']
        ,   'og_property'       => 'product:material'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_mfr_part_no' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_mfr_part_no']
        ,   'og_property'       => 'product:mfr_part_no'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_pattern' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_pattern']
        ,   'og_property'       => 'product:pattern'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_plural_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_plural_title']
        ,   'og_property'       => 'product:plural_title'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_price_amount' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_amount']
        ,   'og_property'       => 'product:price:amount'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true, 'rgxp'=>'digit']
        ]
    ,   'og_product_price_currency' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_price_currency']
        ,   'og_property'       => 'product:price:currency'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['og_multiple'=>true]
        ]
    ,   'og_product_product_link' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_product_link']
        ,   'og_property'       => 'product:product_link'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'url']
        ]
    ,   'og_product_shipping_weight_value' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_value']
        ,   'og_property'       => 'product:shipping_weight:value'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_product_shipping_weight_unit' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_shipping_weight_unit']
        ,   'og_property'       => 'product:shipping_weight:units'
        ,   'inputType'         => 'select'
        ,   'options'           => ['Yg', 'Zg', 'Eg', 'Pg', 'Tg', 'Gg', 'Mg', 'kg', 'hg', 'dag', 'g', 'dg', 'cg', 'mg', 'μg', 'ng', 'pg', 'fg', 'ag', 'zg', 'yg', 'lb']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_units']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_size' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_size']
        ,   'og_property'       => 'product:size'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_target_gender' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_target_gender']
        ,   'og_property'       => 'product:target_gender'
        ,   'inputType'         => 'select'
        ,   'options'           => ['female', 'male', 'unisex']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_target_genders']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
    ,   'og_product_upc' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_upc']
        ,   'og_property'       => 'product:upc'
        ,   'inputType'         => 'text'
        ]
    ,   'og_product_weight_value' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_value']
        ,   'og_property'       => 'product:weight:value'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['rgxp'=>'digit']
        ]
    ,   'og_product_weight_unit' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_unit']
        ,   'og_property'       => 'product:weight:units'
        ,   'inputType'         => 'select'
        ,   'options'           => ['Yg', 'Zg', 'Eg', 'Pg', 'Tg', 'Gg', 'Mg', 'kg', 'hg', 'dag', 'g', 'dg', 'cg', 'mg', 'μg', 'ng', 'pg', 'fg', 'ag', 'zg', 'yg', 'lb']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_product_weight_units']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
        // profile fields
    ,   'og_profile_first_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_first_name']
        ,   'og_property'       => 'profile:first_name'
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_last_name' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_last_name']
        ,   'og_property'       => 'profile:last_name'
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_username' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_username']
        ,   'og_property'       => 'profile:username'
        ,   'inputType'         => 'text'
        ]
    ,   'og_profile_gender' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_gender']
        ,   'og_property'       => 'profile:gender'
        ,   'inputType'         => 'select'
        ,   'options'           => ['female', 'male']
        ,   'reference'         => &$GLOBALS['TL_LANG']['opengraph_fields']['og_profile_genders']
        ,   'eval'              => ['includeBlankOption'=>true]
        ]
        // X / Twitter fields
    ,   'twitter_site' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_site']
        ,   'og_property'       => 'twitter:site'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@page']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_creator' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_creator']
        ,   'og_property'       => 'twitter:creator'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'w50', 'placeholder'=>'@author']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_card' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_card']
        ,   'og_property'       => 'twitter:card'
        ,   'inputType'         => 'select'
        ,   'options'           => ['summary_large_image', 'summary']
        ,   'eval'              => ['includeBlankOption'=>false, 'tl_class'=>'w50']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_title' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_title']
        ,   'og_property'       => 'twitter:title'
        ,   'inputType'         => 'text'
        ,   'eval'              => ['maxlength'=>255, 'tl_class'=>'clr long']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        ]
    ,   'twitter_description' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_description']
        ,   'og_property'       => 'twitter:description'
        ,   'inputType'         => 'textarea'
        ,   'search'            => true
        ,   'eval'              => ['style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "text NULL"
        ]
    ,   'twitter_image' => [
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['twitter_image']
        ,   'og_property'       => 'twitter:image'
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => ['extensions'=>'png,gif,jpg,jpeg,webp', 'files'=>true, 'filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr']
        ,   'attributes'        => ['legend'=>'twitter_legend']
        ,   'sql'               => "binary(16) NULL"
        ]
    ]
];
