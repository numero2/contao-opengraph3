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


/**
 * Namespace
 */
namespace numero2\OpenGraph3;


class OpenGraph3 extends \Frontend {


	/**
	 * Sets OpenGraph tags for the current page
	 *
	 * @param obj $ref
	 */
	public static function setPageOGTags( $ref=NULL )
	{

		if( \Environment::get('isMobile') )
			return false;

		global $objPage;

		$objRef = !$ref ? $objPage : $ref;
		$objRootPage = ($objRef instanceof \Contao\PageModel) ? \PageModel::findById( $objPage->rootId ) : NULL;

		// og:title
		if( ($objRef->og_title || $objRootPage->og_title) && !self::checkTag('og:title') )
		{
			$value = $objRef->og_title ? $objRef->og_title : $objRootPage->og_title;
			self::addTag( 'og:title', $value );
		}

		// og:type
		if( ($objRef->og_type || $objRootPage->og_type) && !self::checkTag('og:type') )
		{
			$value = $objRef->og_type ? $objRef->og_type : $objRootPage->og_type;
			self::addTag( 'og:type', $value );
		}

		// og:description
		if( ($objRef->og_description || $objRootPage->og_description) && !self::checkTag('og:description') )
		{
			$value = $objRef->og_description ? $objRef->og_description : $objRootPage->og_description;
			self::addTag( 'og:description', $value );
		}

		// og:site_name
		if( ($objRef->og_site_name || $objRootPage->og_site_name) && !self::checkTag('og:site_name') )
		{
			$value = $objRef->og_site_name ? $objRef->og_site_name : $objRootPage->og_site_name;
			self::addTag( 'og:site_name', $value );
		}

		// og:locality
		if( ($objRef->og_locality || $objRootPage->og_locality) && !self::checkTag('og:locality') )
		{
			$value = $objRef->og_locality ? $objRef->og_locality : $objRootPage->og_locality;
			self::addTag( 'og:locality', $value );
		}

		// og:country_name
		if( ($objRef->og_country_name || $objRootPage->og_country_name) && !self::checkTag('og:country_name') )
		{
			$arrCountries = \System::getCountries();
			$value = $objRef->og_country_name ? $objRef->og_country_name : $objRootPage->og_country_name;
			self::addTag( 'og:country_name', $arrCountries[ $value ] );
		}

		// og:image
		if( ($objRef->og_image || $objRootPage->og_image) && !self::checkTag('og:image') )
		{
			$file = $objRef->og_image ? $objRef->og_image : $objRootPage->og_image;

			$objFile = \FilesModel::findByUuid( $file );
			$value = $objFile->path;

			if( $objFile !== null )
				self::addTag( 'og:image', \Environment::get('url').'/'.$value );
		}

        // og:url added automatically
        if( !self::checkTag('og:url') ) {
        	self::addTag( 'og:url', \Environment::get('url') . \Environment::get('requestUri') );
        }

		// twitter:site
		if( ($objRef->twitter_site || $objRootPage->twitter_site) && !self::checkTag('twitter:site') )
		{
			$value = $objRef->twitter_site ? $objRef->twitter_site : $objRootPage->twitter_site;
			self::addTag( 'twitter:site', $value );
		}

		// twitter:creator
		if( ($objRef->twitter_creator || $objRootPage->twitter_creator) && !self::checkTag('twitter:creator') )
		{
			$value = $objRef->twitter_creator ? $objRef->twitter_creator : $objRootPage->twitter_creator;
			self::addTag( 'twitter:creator', $value );
		}

		// twitter:title
		if( ($objRef->twitter_title || $objRootPage->twitter_title) && !self::checkTag('twitter:title') )
		{
			$value = $objRef->twitter_title ? $objRef->twitter_title : $objRootPage->twitter_title;
			self::addTag( 'twitter:title', $value );

			// twitter:card
			if( $objRef->twitter_card || $objRootPage->twitter_card )
			{
				$value = $objRef->twitter_card ? $objRef->twitter_card : $objRootPage->twitter_card;
				self::addTag( 'twitter:card', $value );
			}
		}

		// twitter:description
		if( ($objRef->twitter_description || $objRootPage->twitter_description) && !self::checkTag('twitter:description') )
		{
			$value = $objRef->twitter_description ? $objRef->twitter_description : $objRootPage->twitter_description;
			self::addTag( 'twitter:description', $value );
		}

		// twitter:image
		if( ($objRef->twitter_image || $objRootPage->twitter_image) && !self::checkTag('twitter:image') )
		{
			$file = $objRef->twitter_image ? $objRef->twitter_image : $objRootPage->twitter_image;

			$objFile = \FilesModel::findByUuid( $file );
			$value = $objFile->path;

			if( $objFile !== null )
				self::addTag( 'twitter:image', \Environment::get('url').'/'.$value );
		}
	}


	/**
	 * Adds a specific opengraph tag to the head
	 *
	 * @param string $tagName
	 * @param string $tagValue
	 */
	private static function addTag( $tagName=NULL, $tagValue=NULL )
	{
		if( empty($tagName) )
			return false;

		$GLOBALS['TL_HEAD'][] = sprintf(
			'<meta property="%s" content="%s" />',
			$tagName,
			self::replaceInsertTags($tagValue)
		);
	}


	/**
	 * Checks if a specific opengraph tag already exists
	 *
	 * @param string $tagName
	 * @param string $tagValue
	 */
	private static function checkTag( $tagName=NULL )
	{
		if( empty($tagName) )
			return false;

		if( $GLOBALS['TL_HEAD'] ) {

			foreach( $GLOBALS['TL_HEAD'] as $i => $v ) {

				if( strpos($v, $tagName) !== FALSE )
					return true;
			}
		}

		return false;
	}
}