<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2014 numero2 - Agentur für Internetdienstleistungen
 */

class OpenGraph3 extends \Frontend {


	/**
	 * Generates all opengraph meta tags for the current page
	 */
	public function generateMetaTags()
	{

		if( \Environment::get('isMobile') )
			return false;

		global $objPage;

		$objRoot = \PageModel::findById( $objPage->rootId );

		// og:title
		if( $objPage->og_title || $objRoot->og_title )
		{
			$value = $objPage->og_title ? $objPage->og_title : $objRoot->og_title;
			$this->addTag( 'og:title', $value );
		}

		// og:type
		if( $objPage->og_type || $objRoot->og_type )
		{
			$value = $objPage->og_type ? $objPage->og_type : $objRoot->og_type;
			$this->addTag( 'og:type', $value );
		}

		// og:description
		if( $objPage->og_description || $objRoot->og_description )
		{
			$value = $objPage->og_description ? $objPage->og_description : $objRoot->og_description;
			$this->addTag( 'og:description', $value );
		}

		// og:site_name
		if( $objPage->og_site_name || $objRoot->og_site_name )
		{
			$value = $objPage->og_site_name ? $objPage->og_site_name : $objRoot->og_site_name;
			$this->addTag( 'og:site_name', $value );
		}

		// og:locality
		if( $objPage->og_locality || $objRoot->og_locality )
		{
			$value = $objPage->og_locality ? $objPage->og_locality : $objRoot->og_locality;
			$this->addTag( 'og:locality', $value );
		}

		// og:country_name
		if( $objPage->og_country_name || $objRoot->og_country_name )
		{
			$arrCountries = System::getCountries();
			$value = $objPage->og_country_name ? $objPage->og_country_name : $objRoot->og_country_name;
			$this->addTag( 'og:country_name', $arrCountries[ $value ] );
		}

		// og:image
		if( $objPage->og_image || $objRoot->og_image )
		{
			$file = $objPage->og_image ? $objPage->og_image : $objRoot->og_image;

			$objFile = FilesModel::findByUuid( $file );
			$value = $objFile->path;

			if( $objFile !== null )
				$this->addTag( 'og:image', \Environment::get('url').'/'.$value );
		}

        // og:url added automatically
        $this->addTag( 'og:url', \Environment::get('url') . \Environment::get('requestUri') );

		// twitter:card added automatically
        $this->addTag( 'twitter:card', 'summary' );

		// twitter:site
		if( $objPage->twitter_site || $objRoot->twitter_site )
		{
			$value = $objPage->twitter_site ? $objPage->twitter_site : $objRoot->twitter_site;
			$this->addTag( 'twitter:site', $value );
		}

		// twitter:creator
		if( $objPage->twitter_creator || $objRoot->twitter_creator )
		{
			$value = $objPage->twitter_creator ? $objPage->twitter_creator : $objRoot->twitter_creator;
			$this->addTag( 'twitter:creator', $value );
		}

		// twitter:title
		if( $objPage->twitter_title || $objRoot->twitter_title )
		{
			$value = $objPage->twitter_title ? $objPage->twitter_title : $objRoot->twitter_title;
			$this->addTag( 'twitter:title', $value );
		}

		// twitter:description
		if( $objPage->twitter_description || $objRoot->twitter_description )
		{
			$value = $objPage->twitter_description ? $objPage->twitter_description : $objRoot->twitter_description;
			$this->addTag( 'twitter:description', $value );
		}

		// twitter:image
		if( $objPage->twitter_image || $objRoot->twitter_image )
		{
			$file = $objPage->twitter_image ? $objPage->twitter_image : $objRoot->twitter_image;

			$objFile = FilesModel::findByUuid( $file );
			$value = $objFile->path;

			if( $objFile !== null )
				$this->addTag( 'twitter:image', \Environment::get('url').'/'.$value );
		}
	}


	/**
	 * Adds a specific opengraph tag to the head
	 */
	private function addTag( $tagName=NULL, $tagValue=NULL )
	{
		if( empty($tagName) )
			return false;

		$GLOBALS['TL_HEAD'][] = sprintf(
			'<meta property="%s" content="%s" />',
			$tagName,
			$this->replaceInsertTags($tagValue)
		);
	}
}