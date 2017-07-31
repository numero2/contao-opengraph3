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

use \numero2\StoreLocator\StoresModel;


class OpenGraphStoreLocator {


    /**
     * Appends OpenGraph data from news articles
     *
     * @param $objModule
     */
    public static function addModuleData( $objModule ) {

        $alias = NULL;
		$alias = \Input::get('auto_item') ? \Input::get('auto_item') : \Input::get('store');

        $objStore = NULL;
        $objStore = StoresModel::findByIdOrAlias( $alias );

        if( null !== $objStore ) {
            OpenGraph3::addTagsToPage( $objStore );
        }
    }
}