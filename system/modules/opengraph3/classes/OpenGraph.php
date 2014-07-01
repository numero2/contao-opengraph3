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

class OpenGraph3 {


	/**
	 * Generates all opengraph meta tags for the current page
	 */
	public function generateMetaTags()
	{

		if( \Environment::get('isMobile') )
			return false;

		global $objPage;

		$PageObj = \PageModel::findById( $objPage->id );
		$objRoot = \PageModel::findById( $objPage->rootId );

		// og:title
		if( $PageObj->og_title || $objRoot->og_title )
		{
			$value = $PageObj->og_title ? $PageObj->og_title : $objRoot->og_title;
			$this->addTag( 'title', $value );
		}

		// og:type
		if( $PageObj->og_type || $objRoot->og_type )
		{
			$value = $PageObj->og_type ? $PageObj->og_type : $objRoot->og_type;
			$this->addTag( 'type', $value );
		}

		// og:description
		if( $PageObj->og_description || $objRoot->og_description )
		{
			$value = $PageObj->og_description ? $PageObj->og_description : $objRoot->og_description;
			$this->addTag( 'description', $value );
		}

		// og:site_name
		if( $PageObj->og_site_name || $objRoot->og_site_name )
		{
			$value = $PageObj->og_site_name ? $PageObj->og_site_name : $objRoot->og_site_name;
			$this->addTag( 'site_name', $value );
		}

		// og:locality
		if( $PageObj->og_locality || $objRoot->og_locality )
		{
			$value = $PageObj->og_locality ? $PageObj->og_locality : $objRoot->og_locality;
			$this->addTag( 'locality', $value );
		}

		// og:country_name
		if( $PageObj->og_country_name || $objRoot->og_country_name )
		{
			$arrCountries = System::getCountries();
			$value = $PageObj->og_country_name ? $PageObj->og_country_name : $objRoot->og_country_name;
			$this->addTag( 'country_name', $arrCountries[ $value ] );
		}

		// og:image
		if( $PageObj->og_image || $objRoot->og_image )
		{
			$file = $PageObj->og_image ? $PageObj->og_image : $objRoot->og_image;

			$objFile = FilesModel::findByUuid( $file );
			$value = $objFile->path;

			if( $objFile !== null )
				$this->addTag( 'image', \Environment::get('uri').$value );
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
			'<meta property="og:%s" content="%s" />',
			$tagName,
			$tagValue
		);
	}
}