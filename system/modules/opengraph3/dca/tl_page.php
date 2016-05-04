<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2016 numero2 - Agentur für Internetdienstleistungen
 */


$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace
(
	'{dns_legend',
	'{opengraph_legend:hide},og_type,og_description,og_site_name,og_locality,og_country_name,og_image;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;{dns_legend',
	$GLOBALS['TL_DCA']['tl_page']['palettes']['root']
);

$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace
(
	'{protected_legend',
	'{opengraph_legend:hide},og_title,og_type,og_description,og_site_name,og_locality,og_country_name,og_image;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;{protected_legend',
	$GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_title'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_title'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_type'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_page']['og_type'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_page_og3','getTypes'),
	'eval'				=> array('chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_description'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_description'],
	'exclude'		=> true,
	'inputType'     => 'textarea',
	'search'        => true,
	'eval'          => array('style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr'),
	'sql'           => "text NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_site_name'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_site_name'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'clr long'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_locality'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_locality'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_country_name'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_country_name'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options'       => System::getCountries(),
	'eval'			=> array('chosen'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'			=> "varchar(2) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['og_image'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['og_image'],
	'exclude'		=> true,
	'inputType'		=> 'fileTree',
	'eval'			=> array('extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'			=> "binary(16) NULL"
);


$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_site'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_site'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50', 'placeholder'=>'@page'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_creator'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_creator'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50', 'placeholder'=>'@author'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_card'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_card'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback'	=> array('tl_page_og3','getTwitterCards'),
	'eval'			=> array('includeBlankOption'=>false, 'tl_class'=>'w50'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_title'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_title'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'clr long'),
	'sql'			=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_description'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_description'],
	'exclude'		=> true,
	'inputType'     => 'textarea',
	'search'        => true,
	'eval'          => array('style'=>'height: 60px;', 'decodeEntities'=>true, 'tl_class'=>'clr'),
	'sql'           => "text NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['twitter_image'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_page']['twitter_image'],
	'exclude'		=> true,
	'inputType'		=> 'fileTree',
	'eval'			=> array('extensions'=>'png,gif,jpg,jpeg', 'files'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'			=> "binary(16) NULL"
);


class tl_page_og3
{

	public function getTypes()
	{
		return array
		(
			'website' 				=> 'website',
			'article' 				=> 'article',
			'book' 					=> 'book',
			'profile' 				=> 'profile',
			'music.song' 			=> 'music.song',
			'music.album' 			=> 'music.album',
			'music.playlist' 		=> 'music.playlist',
			'music.radio_station'	=> 'music.radio_station',
			'video.movie' 			=> 'video.movie',
			'video.episode' 		=> 'video.episode',
			'video.tv_show' 		=> 'video.tv_show',
			'video.other' 			=> 'video.other'
		);
	}

	public function getTwitterCards()
	{
		return array(
			'summary_large_image'	=> 'summary_large_image',
			'summary' 				=> 'summary'
		);
	}
}