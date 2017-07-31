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


/**
 * Namespace
 */
namespace numero2\OpenGraph3;

use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Environment;
use Contao\FilesModel;
use Contao\System;


class OpenGraph3 extends \Frontend {


    /**
     * Appends OpenGraph data for the given module
     *
     * @param  Model    $objRow
     * @param  String   $strBuffer
     * @param  Module   $objModule
     *
     * @return String
     */
    public function appendTagsByModule( $objRow, $strBuffer, $objModule ) {

        $moduleClass = NULL;
        $moduleClass = get_class($objModule);

        // find and import a matching module to parse the OpenGraph data from
        foreach( $GLOBALS['TL_OG_MODULES'] as $module ) {

            if( $moduleClass === "Contao\ModuleModel" && $objModule->type === $module[0] || $moduleClass === $module[1] ) {

                $this->import($module[2]);
                $this->{$module[2]}->addModuleData($objModule);
            }
        }

        return $strBuffer;
    }


    /**
     * Checks if Content Element is a module and tries to use it
     * for OpenGraph data
     *
     * @param $objRow
     * @param $strBuffer
     * @param $objElement
     *
     * @return String
     */
    public function findCompatibleModules( $objRow, $strBuffer, $objElement ) {

        if( get_class($objElement) === "Contao\ContentModule" ) {

            $objModule = NULL;
            $objModule = ModuleModel::findById( $objElement->module );

            self::appendTagsByModule( NULL, NULL, $objModule );
        }

        return $strBuffer;
    }


    /**
     * Add OpenGraph tags to the current page
     *
     * @param obj $ref
     *
     * @return none
     */
    public static function addTagsToPage( $ref=NULL ) {

        if( Environment::get('isMobile') )
            return false;

        global $objPage;

        $objRef = !$ref ? $objPage : $ref;
        $objRootPage = ($objRef instanceof \Contao\PageModel) ? PageModel::findById( $objPage->rootId ) : NULL;

        // og:title
        if( ($objRef->og_title || $objRootPage->og_title) && !self::checkTag('og:title') ) {

            $value = $objRef->og_title ? $objRef->og_title : $objRootPage->og_title;
            self::addTag( 'og:title', $value );
        }

        // og:type
        if( ($objRef->og_type || $objRootPage->og_type) && !self::checkTag('og:type') ) {

            $value = $objRef->og_type ? $objRef->og_type : $objRootPage->og_type;
            self::addTag( 'og:type', $value );
        }

        // og:description
        if( ($objRef->og_description || $objRootPage->og_description) && !self::checkTag('og:description') ) {

            $value = $objRef->og_description ? $objRef->og_description : $objRootPage->og_description;
            self::addTag( 'og:description', $value );
        }

        // og:site_name
        if( ($objRef->og_site_name || $objRootPage->og_site_name) && !self::checkTag('og:site_name') ) {

            $value = $objRef->og_site_name ? $objRef->og_site_name : $objRootPage->og_site_name;
            self::addTag( 'og:site_name', $value );
        }

        // og:locale
        if( !self::checkTag('og:locale') ) {

            $value = $objRef->og_locale ? $objRef->og_locale : $objRootPage->og_locale;

            // set default locale based on the page´s language
            if( !$value ) {

                switch( $objPage->language ) {
                    case 'en' :
                        $value = 'en_US';
                        break;
                    default :
                        $value = sprintf("%s_%s",$objPage->language,strtoupper($objPage->language));
                        break;
                }
            }

            self::addTag( 'og:locale', $value );
        }

        // og:locality
        if( ($objRef->og_locality || $objRootPage->og_locality) && !self::checkTag('og:locality') ) {

            $value = $objRef->og_locality ? $objRef->og_locality : $objRootPage->og_locality;
            self::addTag( 'og:locality', $value );
        }

        // og:country_name
        if( ($objRef->og_country_name || $objRootPage->og_country_name) && !self::checkTag('og:country_name') ) {

            $arrCountries = System::getCountries();
            $value = $objRef->og_country_name ? $objRef->og_country_name : $objRootPage->og_country_name;
            self::addTag( 'og:country_name', $arrCountries[ $value ] );
        }

        // og:image
        if( ($objRef->og_image || $objRootPage->og_image) && !self::checkTag('og:image') ) {

            $file = $objRef->og_image ? $objRef->og_image : $objRootPage->og_image;

            $objFile = FilesModel::findByUuid( $file );
            $value = $objFile->path;

            if( $objFile !== null ) {
                self::addTag( 'og:image', Environment::get('base').$value );
            }
        }

        // og:url added automatically
        if( !self::checkTag('og:url') ) {
            self::addTag( 'og:url', Environment::get('url') . Environment::get('requestUri') );
        }

        // twitter:site
        if( ($objRef->twitter_site || $objRootPage->twitter_site) && !self::checkTag('twitter:site') ) {

            $value = $objRef->twitter_site ? $objRef->twitter_site : $objRootPage->twitter_site;
            self::addTag( 'twitter:site', $value );
        }

        // twitter:creator
        if( ($objRef->twitter_creator || $objRootPage->twitter_creator) && !self::checkTag('twitter:creator') ) {

            $value = $objRef->twitter_creator ? $objRef->twitter_creator : $objRootPage->twitter_creator;
            self::addTag( 'twitter:creator', $value );
        }

        // twitter:title
        if( ($objRef->twitter_title || $objRootPage->twitter_title) && !self::checkTag('twitter:title') ) {

            $value = $objRef->twitter_title ? $objRef->twitter_title : $objRootPage->twitter_title;
            self::addTag( 'twitter:title', $value );

            // twitter:card
            if( $objRef->twitter_card || $objRootPage->twitter_card ) {

                $value = $objRef->twitter_card ? $objRef->twitter_card : $objRootPage->twitter_card;
                self::addTag( 'twitter:card', $value );
            }
        }

        // twitter:description
        if( ($objRef->twitter_description || $objRootPage->twitter_description) && !self::checkTag('twitter:description') ) {

            $value = $objRef->twitter_description ? $objRef->twitter_description : $objRootPage->twitter_description;
            self::addTag( 'twitter:description', $value );
        }

        // twitter:image
        if( ($objRef->twitter_image || $objRootPage->twitter_image) && !self::checkTag('twitter:image') ) {

            $file = $objRef->twitter_image ? $objRef->twitter_image : $objRootPage->twitter_image;

            $objFile = FilesModel::findByUuid( $file );
            $value = $objFile->path;

            if( $objFile !== null ) {
                self::addTag( 'twitter:image', Environment::get('base').$value );
            }
        }
    }


    /**
    * Adds a specific opengraph tag to the head
    *
    * @param String $tagName
    * @param String $tagValue
    *
    * @return bool
    */
    private static function addTag( $tagName=NULL, $tagValue=NULL ) {

        if( empty($tagName) )
            return false;

        $GLOBALS['TL_HEAD'][] = sprintf(
            '<meta property="%s" content="%s" />'
        ,   $tagName
        ,   self::replaceInsertTags($tagValue)
        );

        return true;
    }


    /**
     * Checks if a specific opengraph tag already exists
     *
     * @param String $tagName
     * @param String $tagValue
     *
     * @return bool
     */
    private function checkTag( $tagName=NULL ) {

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