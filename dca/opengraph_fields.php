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
        'default' => '{opengraph_legend:hide},og_title,og_type,og_description,og_site_name,og_locale,og_locality,og_country_name,og_image,og_properties;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;'
    )

,   'fields' => array(
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
        ,   'eval'              => array( 'chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'og_description' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_description']
        ,   'inputType'         => 'textarea'
        ,   'eval'              => array( 'style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "text NULL"
        )
    ,   'og_site_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50', 'rgxp'=> 'digit' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'og_locale' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>5, 'tl_class'=>'w50', 'placeholder'=>'en_US' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(5) NOT NULL default ''"
        )
    ,   'og_locality' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locality']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    ,   'og_country_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_country_name']
        ,   'inputType'         => 'select'
        ,   'options'           => System::getCountries()
        ,   'eval'              => array( 'chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(2) NOT NULL default ''"
        )
    ,   'og_image' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_image']
        ,   'inputType'         => 'fileTree'
        ,   'eval'              => array( 'extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "binary(16) NULL"
        )
    ,   'og_properties' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_properties']
        ,   'inputType'         => 'openGraphProperties'
        ,   'eval'              => array( 'tl_class'=>'clr' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "blob NULL"
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
        ,   'options_callback'  => array( 'opengraph_fields','getTwitterCards' )
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


    public function getTypes() {

        return array (
            'website'               => 'website'
        ,   'article'               => 'article'
        ,   'book'                  => 'book'
        ,   'profile'               => 'profile'
        ,   'music.song'            => 'music.song'
        ,   'music.album'           => 'music.album'
        ,   'music.playlist'        => 'music.playlist'
        ,   'music.radio_station'   => 'music.radio_station'
        ,   'video.movie'           => 'video.movie'
        ,   'video.episode'         => 'video.episode'
        ,   'video.tv_show'         => 'video.tv_show'
        ,   'video.other'           => 'video.other'
        );
    }


    public function getTwitterCards() {

        return array(
            'summary_large_image'   => 'summary_large_image',
            'summary'               => 'summary'
        );
    }
}
