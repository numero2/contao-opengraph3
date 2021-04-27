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


/**
 * Add palettes to tl_settings
 */
if( version_compare(VERSION.'.'.BUILD, '4.7', '<') ) {

    $GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(
        ';{timeout_legend'
    ,   ';{opengraph_twitter_legend:hide},og_image_size,twitter_image_size;{timeout_legend'
    ,   $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
    );

} else {

    $GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{opengraph_twitter_legend:hide},og_image_size,twitter_image_size';
}


/**
 * Add fields to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['og_image_size'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['og_image_size']
,   'exclude'               => true
,   'inputType'             => 'imageSize'
,   'reference'             => &$GLOBALS['TL_LANG']['MSC']
,   'eval'                  => ['rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50']
,   'options_callback' => function(){
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    }
,   'sql'                   => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['twitter_image_size'] = [
    'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['twitter_image_size']
,   'exclude'               => true
,   'inputType'             => 'imageSize'
,   'reference'             => &$GLOBALS['TL_LANG']['MSC']
,   'eval'                  => ['rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50']
,   'options_callback' => function(){
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    }
,   'sql'                   => "varchar(64) NOT NULL default ''"
];
