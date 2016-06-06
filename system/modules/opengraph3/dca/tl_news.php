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


\Controller::loadDataContainer('tl_page');

$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace
(
	'{expert_legend',
	'{opengraph_legend:hide},og_title,og_type,og_description,og_site_name,og_locality,og_country_name,og_image;{twitter_legend:hide},twitter_site,twitter_creator,twitter_card,twitter_title,twitter_description,twitter_image;{expert_legend',
	$GLOBALS['TL_DCA']['tl_news']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_news']['fields']['og_title'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_title'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_type'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_type'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_description'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_description'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_site_name'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_site_name'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_locality'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_locality'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_country_name'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_country_name'];
$GLOBALS['TL_DCA']['tl_news']['fields']['og_image'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_image'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_site'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_site'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_creator'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_creator'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_card'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_card'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_title'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_title'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_description'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_description'];
$GLOBALS['TL_DCA']['tl_news']['fields']['twitter_image'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_image'];