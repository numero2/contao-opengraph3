<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2023 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2023 numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\OpenGraph3;

use Contao\Environment;
use Contao\Input;
use Haste\Units\Mass\Scale;
use Haste\Units\Mass\Unit;
use Haste\Units\Mass\Weight;
use Isotope\Isotope;
use Isotope\Model\Product;


class OpenGraphIsotope {


    /**
     * Appends OpenGraph data from Isotope products
     *
     * @param $objModule
     */
    public static function addModuleData( $objModule ): void {

        $objProduct = null;
        $objProduct = Product::findAvailableByIdOrAlias( (Input::get('auto_item') ?? '') );

        if( null !== $objProduct ) {

            OpenGraph3::addProperty('og_type','product',$objProduct);

            // add price
            if ( $objPrice = $objProduct->getPrice() ) {

                $config = Isotope::getConfig();
                $price = number_format($objPrice->getAmount(1), 2, '.', '');

                OpenGraph3::addProperty('og_product_price_amount',$price,$objProduct);
                OpenGraph3::addProperty('og_product_price_currency',$config->currency,$objProduct);
            }

            // add shipping weight
            if( isset($objProduct->shipping_weight) ) {

                $weightProduct = null;
                $weightProduct = Weight::createFromTimePeriod($objProduct->shipping_weight);

                if( $weightProduct ) {

                    $weightMin = new Weight(1000,'g');

                    $objScale = new Scale();
                    $objScale->add($weightProduct);

                    // convert small weights to gram (g)
                    if( $objScale->isLessThan($weightMin) ) {

                        $convertedUnit = 'g';
                        $convertedWeight = Unit::convert($weightProduct->getWeightValue(), $weightProduct->getWeightUnit(), 'g');

                    // convert larger weights to kilogram (kg)
                    } else {

                        $convertedUnit = 'kg';
                        $convertedWeight = Unit::convert($weightProduct->getWeightValue(), $weightProduct->getWeightUnit(), 'kg');
                    }

                    $convertedWeight = number_format($convertedWeight, 2, '.', '');

                    OpenGraph3::addProperty('og_product_shipping_weight_value',$convertedWeight,$objProduct);
                    OpenGraph3::addProperty('og_product_shipping_weight_unit',$convertedUnit,$objProduct);
                }
            }

            OpenGraph3::addProperty('og_product_product_link',Environment::get('url') . Environment::get('requestUri'),$objProduct);

            OpenGraph3::addTagsToPage( $objProduct );
        }
    }
}
