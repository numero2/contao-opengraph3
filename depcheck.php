<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;


return (new Configuration())
    ->ignoreErrorsOnPackage('contao/manager-plugin', [ErrorType::DEV_DEPENDENCY_IN_PROD])

    // ignore classes these will be checked during runtime
    // numero2/calendar-bundle
    ->ignoreUnknownClasses([
        'Contao\CalendarBundle\ContaoCalendarBundle',
        'Contao\CalendarEventsModel',
    ])
    // contao/faq-bundle
    ->ignoreUnknownClasses([
        'Contao\FaqBundle\ContaoFaqBundle',
        'Contao\FaqModel',
    ])
    // contao/news-bundle
    ->ignoreUnknownClasses([
        'Contao\NewsBundle\ContaoNewsBundle',
        'Contao\NewsModel',
    ])
    // isotope/isotope-core
    ->ignoreUnknownClasses([
        'Isotope\Isotope',
        'Isotope\Model\Product',
        'Haste\Units\Mass\Scale',
        'Haste\Units\Mass\Unit',
        'Haste\Units\Mass\Weight',
    ])
    // numero2/contao-storelocator
    ->ignoreUnknownClasses([
        'numero2\StoreLocatorBundle\StoreLocatorBundle',
        'numero2\StoreLocator\StoresModel',
    ])
;





