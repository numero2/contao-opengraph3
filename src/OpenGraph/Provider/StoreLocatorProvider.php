<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\OpenGraph\Provider;

use Contao\Input;
use Contao\ModuleModel;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;
use numero2\StoreLocator\StoresModel;


class StoreLocatorProvider implements ProviderInterface {


    /**
     * {@inheritdoc}
     */
    public function supports( ModuleModel $model ): bool {

        return $model->type === 'storelocator_details' && class_exists(StoresModel::class);
    }


    /**
     * {@inheritdoc}
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference {

        $alias = Input::get('auto_item') ?: Input::get('store');

        if( empty($alias) ) {
            return null;
        }

        $store = StoresModel::findByIdOrAlias($alias);

        if( $store === null ) {
            return null;
        }

        return new OpenGraphReference($store, [
            'og_type' => 'business.business'
        ,   'og_place_location_latitude' => $store->latitude
        ,   'og_place_location_longitude' => $store->longitude
        ,   'og_business_contact_data_street_address' => $store->street
        ,   'og_business_contact_data_locality' => $store->city
        ,   'og_business_contact_data_postal_code' => $store->postal
        ,   'og_business_contact_data_country_name' => $store->country
        ]);
    }
}
