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

use \Isotope\Model\Product;
use Contao\Input;


class OpenGraphIsotope {


    /**
     * Appends OpenGraph data from Isotope products
     *
     * @param $objModule
     */
    public static function addModuleData( $objModule ) {

        $objProduct = NULL;
        $objProduct = Product::findAvailableByIdOrAlias( Input::get('auto_item') );

        if( null !== $objProduct ) {
            OpenGraph3::addTagsToPage( $objProduct );
        }
    }
}