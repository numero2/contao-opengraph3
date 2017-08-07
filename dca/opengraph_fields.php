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
    ,   '__all__' => 'og_description,og_locale,og_site_name'
    ,   'website' => ''
    ,   'article' => 'article_published_time,article_modified_time,article_expiration_time,article_author,article_section,article_tag'
    ,   'book' => 'book_author,book_isbn,book_release_date,book_tag'
    ,   'music.album' => 'music_song,music_song_disc,music_song_track,music_musician,music_release_date'
    ,   'music.playlist' => 'music_song,music_song_disc,music_song_track,music_creator'
    ,   'music.radio_station' => 'music_creator'
    ,   'music.song' => 'music_duration,music_album,music_album_disc,music_album_track,music_musician'
    ,   'profile' => 'profile_first_name,profile_last_name,profile_username,profile_gender'
    ,   'video.episode' => 'video_actor,video_actor_role,video_director,video_writer,video_duration,video_release_date,video_tag,video_series'
    ,   'video.movie' => 'video_actor,video_actor_role,video_director,video_writer,video_duration,video_release_date,video_tag'
    ,   'video.other' => 'video_actor,video_actor_role,video_director,video_writer,video_duration,video_release_date,video_tag'
    ,   'video.tv_show' => 'video_actor,video_actor_role,video_director,video_writer,video_duration,video_release_date,video_tag'
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
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        // ,   'sql'               => "text NULL"
        )
    ,   'og_locale' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_locale']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>5, 'tl_class'=>'w50', 'placeholder'=>'en_US' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(5) NOT NULL default ''"
        )
    ,   'og_site_name' => array(
            'label'             => &$GLOBALS['TL_LANG']['opengraph_fields']['og_site_name']
        ,   'inputType'         => 'text'
        ,   'eval'              => array( 'maxlength'=>255, 'tl_class'=>'w50' )
        ,   'attributes'        => array( 'legend'=>'opengraph_legend' )
        ,   'sql'               => "varchar(255) NOT NULL default ''"
        )
    // locale fields
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


    public function getTypes($dcTable) {

        $options = array();

        // og_subpalettes
        foreach( $GLOBALS['TL_DCA']['opengraph_fields']['og_subpalettes'] as $key => $value) {
            if( $key === "__basic__" || $key === "__all__" ){
                continue;
            }

            $options[$key] = $key;
        }

        return $options;
    }


    public function getTwitterCards() {

        return array(
            'summary_large_image'   => 'summary_large_image',
            'summary'               => 'summary'
        );
    }
}
