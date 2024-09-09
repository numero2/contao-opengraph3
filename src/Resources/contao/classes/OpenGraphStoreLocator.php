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

use Contao\Input;
use numero2\StoreLocator\StoresModel;


class OpenGraphStoreLocator {


    /**
     * Appends OpenGraph data from stores
     *
     * @param Contao\Module $objModule
     */
    public static function addModuleData( $objModule ): void {

        $alias = null;
        $alias = Input::get('auto_item') ? Input::get('auto_item') : Input::get('store');

        $objStore = null;
        $objStore = StoresModel::findByIdOrAlias( ($alias ?? '') );

        if( null !== $objStore ) {

            OpenGraph3::addProperty('og_type','business.business',$objStore);

            if( $objStore->latitude ) {
                OpenGraph3::addProperty('og_place_location_latitude',$objStore->latitude,$objStore);
            }

            if( $objStore->longitude ) {
                OpenGraph3::addProperty('og_place_location_longitude',$objStore->longitude,$objStore);
            }

            if( $objStore->street ) {
                OpenGraph3::addProperty('og_business_contact_data_street_address',$objStore->street,$objStore);
            }

            if( $objStore->city ) {
                OpenGraph3::addProperty('og_business_contact_data_locality',$objStore->city,$objStore);
            }

            if( $objStore->postal ) {
                OpenGraph3::addProperty('og_business_contact_data_postal_code',$objStore->postal,$objStore);
            }

            if( $objStore->country ) {
                OpenGraph3::addProperty('og_business_contact_data_country_name',$objStore->country,$objStore);
            }

            OpenGraph3::addTagsToPage( $objStore );
        }
    }
}
