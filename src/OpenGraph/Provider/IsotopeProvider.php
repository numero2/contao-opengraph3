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
use Isotope\Isotope;
use Isotope\Model\Product;
use Isotope\Units\Mass\Unit;
use Isotope\Units\Mass\Weight;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;
use Symfony\Component\HttpFoundation\RequestStack;


class IsotopeProvider implements ProviderInterface {


    /**
     * @var Symfony\Component\HttpFoundation\RequestStack
     */
    private RequestStack $requestStack;


    public function __construct( RequestStack $requestStack ) {

        $this->requestStack = $requestStack;
    }


    /**
     * {@inheritdoc}
     */
    public function supports( ModuleModel $model ): bool {

        return $model->type === 'iso_productreader' && class_exists(Product::class);
    }


    /**
     * {@inheritdoc}
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference {

        $product = Product::findAvailableByIdOrAlias((string) Input::get('auto_item'));

        if( $product === null ) {
            return null;
        }

        $defaults = [
            'og_type' => 'product'
        ];

        if( $price = $product->getPrice() ) {

            $defaults['og_product_price_amount'] = number_format($price->getAmount(1), 2, '.', '');
            $defaults['og_product_price_currency'] = Isotope::getConfig()->currency;
        }

        if( isset($product->shipping_weight) && ($weight = Weight::createFromTimePeriod($product->shipping_weight)) ) {

            // use grams for small weights and kilograms for larger ones
            $unit = $weight->toUnit(Unit::GRAM) < 1000 ? Unit::GRAM : Unit::KILOGRAM;

            $defaults['og_product_shipping_weight_value'] = number_format($weight->toUnit($unit), 2, '.', '');
            $defaults['og_product_shipping_weight_unit'] = $unit;
        }

        if( $request = $this->requestStack->getMainRequest() ) {
            $defaults['og_product_product_link'] = $request->getSchemeAndHttpHost().$request->getRequestUri();
        }

        return new OpenGraphReference($product, $defaults);
    }
}
