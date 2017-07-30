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


\Controller::loadDataContainer('tl_page');

$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_title'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_title'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_type'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_type'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_description'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_description'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_site_name'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_site_name'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_locality'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_locality'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_country_name'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_country_name'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_image'] = $GLOBALS['TL_DCA']['tl_page']['fields']['og_image'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_site'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_site'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_creator'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_creator'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_card'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_card'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_title'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_title'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_description'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_description'];
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_image'] = $GLOBALS['TL_DCA']['tl_page']['fields']['twitter_image'];

$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_title']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_type']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_description']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_site_name']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_locality']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_country_name']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['og_image']['attributes'] = array( 'legend'=>'opengraph_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_site']['attributes'] = array( 'legend'=>'twitter_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_creator']['attributes'] = array( 'legend'=>'twitter_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_card']['attributes'] = array( 'legend'=>'twitter_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_title']['attributes'] = array( 'legend'=>'twitter_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_description']['attributes'] = array( 'legend'=>'twitter_legend' );
$GLOBALS['TL_DCA']['tl_iso_product']['fields']['twitter_image']['attributes'] = array( 'legend'=>'twitter_legend' );