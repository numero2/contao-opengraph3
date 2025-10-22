<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\OpenGraph3;

use Contao\Config;
use Contao\Controller;
use Contao\Environment;
use Contao\File;
use Contao\FilesModel;
use Contao\InsertTags;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use DateTime;
use Exception;
use numero2\OpenGraph3\DCAHelper\OpengraphFields;


class OpenGraph3 {


    /**
     * Add OpenGraph tags to the current page
     *
     * @param Contao\Model|null $ref
     */
    public static function addTagsToPage( $ref=null ): void {

        Controller::loadDataContainer('opengraph_fields');
        System::loadLanguageFile('opengraph_fields');

        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if( $request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request) ) {
            return;
        }

        $objPage = System::getContainer()->get('request_stack')->getCurrentRequest()->get('pageModel');

        if( !($objPage instanceof PageModel) ){
            $objPage = PageModel::findById($objPage);
        }

        $objRef = !$ref ? $objPage : $ref;
        $objRootPage = ($objRef instanceof PageModel) ? PageModel::findById($objPage->rootId) : null;

        self::parseAdditionalProperties( $objRef );
        self::parseAdditionalProperties( $objRootPage );

        // add og tags
        if( !empty($GLOBALS['TL_DCA']['opengraph_fields']['fields']) ) {

            foreach( $GLOBALS['TL_DCA']['opengraph_fields']['fields'] as $fieldName => $field ) {

                // add tag if missing
                if( (($objRef && !empty($objRef->{$fieldName})) || ($objRootPage && !empty($objRootPage->{$fieldName}))) && !self::checkTag($field['label'][0]) ) {

                    $tag = $field['label'][0];

                    $value = null;
                    $value = !empty($objRef->{$fieldName}) ? $objRef->{$fieldName} : $objRootPage->{$fieldName};

                    $resized = null;

                    // get value based on inputType
                    switch( $field['inputType'] ) {

                        case 'textarea':
                        case 'select':
                        case 'text':

                            switch( $fieldName ) {

                                case 'og_country_name':
                                case 'og_business_contact_data_country_name':

                                    $arrCountries = [];
                                    $arrCountries = OpengraphFields::getCountries();

                                    $value = $arrCountries[strtoupper($value)];

                                break;
                            }

                            if( !empty($field['eval']['rgxp']) ) {

                                switch( $field['eval']['rgxp'] ) {

                                    case 'datim':

                                        $date = null;
                                        $date = DateTime::createFromFormat( Config::get('datimFormat'), $value );

                                        $value = $date->format('Y-m-d\TH:i:s');

                                    break;
                                }
                            }

                        break;

                        case 'fileTree':

                            $objFile = null;
                            $objFile = FilesModel::findByUuid( $value );

                            if( $objFile ) {

                                $value = Environment::get('base') . $objFile->path;

                                $size = Config::get($fieldName.'_size');
                                if( $size ) {

                                    $oFile = new File($objFile->path);

                                    $size = StringUtil::deserialize($size);
                                    if( is_numeric($size) ){
                                        $size = [0, 0, (int) $size];
                                    } else if( !is_array($size) ) {
                                        $size = [];
                                    }

                                    $size += [0, 0, 'crop'];

                                    if( $oFile && $oFile->exists() && $oFile->isGdImage ) {
                                        try {
                                            $resized = System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $objFile->path, $size);
                                            $src = $resized->getUrl(TL_ROOT);

                                            if( $src !== $objFile->path ) {
                                                $value = Environment::get('base') . $src;
                                            }

                                        } catch( Exception $e ) {
                                        }
                                    }
                                }
                            } else {
                                continue 2;
                            }

                        break;

                        case 'openGraphProperties':
                            continue 2;
                        break;

                        default:
                            throw new Exception("Unhandled field type ".$field['inputType']);
                        break;
                    }

                    // add og:image:secure_url and image size tags if applicable
                    if( $tag === 'og:image' && $resized ) {
                        $resizedSize = $resized->getDimensions()->getSize();

                        self::addTag('og:image:width', $resizedSize->getWidth());
                        self::addTag('og:image:height', $resizedSize->getHeight());

                        if ( strpos($value,'https:') !== false ) {
                            self::addTag('og:image:secure_url', $value);
                        }
                    }

                    self::addTag($tag, $value);
                }
            }

            // og:locale
            if( !self::checkTag('og:locale') ) {

                $value = ($objRef && isset($objRef->og_locale) && $objRef->og_locale) ? $objRef->og_locale : (($objRootPage && isset($objRootPage->og_locale) && $objRootPage->og_locale) ? $objRootPage->og_locale : null);

                // set default locale based on the page´s language
                if( !$value ) {

                    if( strlen($objPage->language) === 2 ) {

                        switch( $objPage->language ) {
                            case 'en' :
                                $value = 'en_US';
                                break;
                            default :
                                $value = sprintf("%s_%s",$objPage->language,strtoupper($objPage->language));
                                break;
                        }

                    } else {

                        $value = $objPage->language;
                    }
                }

                self::addTag( 'og:locale', $value );
            }

            // og:url added automatically
            if( !self::checkTag('og:url') ) {
                self::addTag('og:url', Environment::get('url') . Environment::get('requestUri'));
            }
        }
    }


    /**
     * Appends a property to the given object
     *
     * @param string $prop
     * @param string $value
     * @param mixed $objRef
     */
    public static function addProperty( $prop, $value, $objRef ): void {

        $aProperties = [];
        $aProperties = $objRef->og_properties ? StringUtil::deserialize($objRef->og_properties) : [];

        $aProperties[] = [$prop, $value];

        $objRef->og_properties = serialize($aProperties);
    }


    /**
     * Appends OpenGraph data for the given module
     *
     * @param mixed $objRow
     * @param string $strBuffer
     * @param Contao\Module|Contao\ModuleModel $objModule
     *
     * @return string
     */
    public static function appendTagsByModule( $objRow, $strBuffer, $objModule ): string {

        $moduleClass = null;
        $moduleClass = get_class($objModule);

        // find and import a matching module to parse the OpenGraph data from
        foreach( $GLOBALS['TL_OG_MODULES'] as $module ) {

            if( $moduleClass === "Contao\ModuleModel" && $objModule->type === $module[0] || $moduleClass === $module[1] ) {
                $module[2]::addModuleData($objModule);
            }
        }

        return $strBuffer?:'';
    }


    /**
     * Checks if the given Content Element is a module and tries to use it
     * for OpenGraph data
     *
     * @param mixed $objRow
     * @param string $strBuffer
     * @param Contao\ContentElement $objElement
     *
     * @return string
     */
    public static function findCompatibleModules( $objRow, $strBuffer, $objElement ): string {

        if( get_class($objElement) === "Contao\ContentModule" ) {

            $objModule = null;
            $objModule = ModuleModel::findById($objElement->module);

            if( $objModule ) {
                self::appendTagsByModule(null, $strBuffer, $objModule);
            }
        }

        return $strBuffer?:'';
    }


    /**
    * Adds the additional og_properties as individual attributes
    *
    * @param Contao\Model $ref
    */
    private static function parseAdditionalProperties( $ref ): void {

        if( !empty($ref->og_properties) ) {

            $props = null;
            $props = StringUtil::deserialize($ref->og_properties);

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
    * Adds a specific OpenGraph tag to the head
    *
    * @param string $tagName
    * @param string $tagValue
    *
    * @return bool
    */
    private static function addTag( $tagName=null, $tagValue=null ): bool {

        if( empty($tagName) || empty($tagValue) ) {
            return false;
        }

        $attribute = 'property';

        if( strpos($tagName, 'twitter') === 0 ) {
            $attribute = 'name';
        }

        if( System::getContainer()->has('contao.insert_tag.parser') ) {

            $tagValue = System::getContainer()->get('contao.insert_tag.parser')->replace($tagValue);

        } else {

            $oInsertTags = null;
            $oInsertTags = new InsertTags();

            $tagValue = $oInsertTags->replace($tagValue);
        }

        $GLOBALS['TL_HEAD'][] = sprintf(
            '<meta %s="%s" content="%s">'
        ,   $attribute
        ,   $tagName
        ,   $tagValue
        );

        return true;
    }


    /**
     * Checks if a specific OpenGraph tag already exists
     *
     * @param string $tagName
     * @param string $tagValue
     *
     * @return bool
     */
    private static function checkTag( $tagName=null ): bool {

        if( empty($tagName) ) {
            return false;
        }

        if( !empty($GLOBALS['TL_HEAD']) && is_array($GLOBALS['TL_HEAD']) ) {

            foreach( $GLOBALS['TL_HEAD'] as $i => $v ) {

                if( strpos($v, $tagName) !== FALSE ) {
                    return true;
                }
            }
        }

        return false;
    }
}
