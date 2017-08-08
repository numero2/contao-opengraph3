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

use Contao\Config;
use Contao\Controller;
use Contao\Environment;
use Contao\FilesModel;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\System;


class OpenGraph3 extends \Frontend {


    /**
     * Add OpenGraph tags to the current page
     *
     * @param Model $ref
     *
     * @return none
     */
    public static function addTagsToPage( $ref=NULL ) {

        if( Environment::get('isMobile') )
            return false;

        Controller::loadDataContainer('opengraph_fields');

        global $objPage;

        $objRef = !$ref ? $objPage : $ref;
        $objRootPage = ($objRef instanceof \Contao\PageModel) ? PageModel::findById( $objPage->rootId ) : NULL;

        self::parseAdditionalProperties( $objRef );
        self::parseAdditionalProperties( $objRootPage );

        // add og tags
        if( !empty($GLOBALS['TL_DCA']['opengraph_fields']['fields']) ) {

            foreach( $GLOBALS['TL_DCA']['opengraph_fields']['fields'] as $fieldName => $field ) {

                // add tag if missing
                if( ($objRef->{$fieldName} || $objRootPage->{$fieldName}) && !self::checkTag($field['label'][0]) ) {

                    $value = NULL;
                    $value = $objRef->{$fieldName} ? $objRef->{$fieldName} : $objRootPage->{$fieldName};

                    // get value based on inputType
                    switch( $field['inputType'] ) {

                        case 'textarea':
                        case 'select':
                        case 'text':

                            switch( $fieldName ) {

                                case 'og_country_name':
                                case 'og_business_contact_data_country_name':

                                    $arrCountries = array();
                                    $arrCountries = System::getCountries();

                                    $value = $arrCountries[$value];

                                break;
                            }

                            if( !empty($field['eval']['rgxp']) ) {

                                switch( $field['eval']['rgxp'] ) {

                                    case 'datim':

                                        $date = NULL;
                                        $date = \DateTime::createFromFormat( Config::get('datimFormat'), $value );

                                        $value = $date->format('Y-m-d\TH:i:s');

                                    break;
                                }
                            }

                        break;

                        case 'fileTree':

                            $objFile = NULL;
                            $objFile = FilesModel::findByUuid( $value );

                            if( $objFile ) {
                                $value = Environment::get('base') . $objFile->path;
                            } else {
                                continue 2;
                            }

                        break;

                        case 'openGraphProperties':
                            continue 2;
                        break;

                        default:
                            throw new \Exception("Unhandled field type ".$field['inputType']);
                        break;
                    }

                    self::addTag( $field['label'][0], $value );
                }
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

            // og:url added automatically
            if( !self::checkTag('og:url') ) {
                self::addTag( 'og:url', Environment::get('url') . Environment::get('requestUri') );
            }
        }
    }


    /**
     * Appends a property to the given object
     *
     * @param  string   $prop
     * @param  string   $value
     * @param  Model    $objRef
     */
    public static function addProperty( $prop, $value, $objRef ) {

        $aProperties = array();
        $aProperties = $objRef->og_properties ? deserialize($objRef->og_properties) : array();

        $aProperties[] = array($prop,$value);

        $objRef->og_properties = serialize($aProperties);
    }


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
     * @param Model             $objRow
     * @param String            $strBuffer
     * @param \ContentElement   $objElement
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
    * Adds the additional og_properties as individual attributes
    *
    * @param Model $ref
    *
    * @return none
    */
    private static function parseAdditionalProperties( $ref ) {

        if( !empty($ref->og_properties) ) {

            $props = NULL;
            $props = deserialize($ref->og_properties);

            if( !empty($props) ) {

                foreach( $props as $p ) {
                    if( !isset($ref->{$p[0]}) || empty($ref->{$p[0]}) ) {
                        $ref->{$p[0]} = $p[1];
                    }
                }
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
        ,   htmlspecialchars( self::replaceInsertTags($tagValue) )
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