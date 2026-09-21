<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


use Contao\ArrayUtil;
use Contao\System;


if( !empty($GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options']) ) {

    System::loadLanguageFile('opengraph_fields');

    /**
     * Make our legends available for product attributes
     */
    $options = &$GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'];
    $position = array_search('meta_legend', $options);
    $position = $position === false ? count($options) : $position + 1;

    ArrayUtil::arrayInsert($options, $position, ['opengraph_legend', 'twitter_legend']);

    foreach( ['opengraph_legend', 'twitter_legend'] as $legend ) {
        $GLOBALS['TL_LANG']['tl_iso_product'][$legend] = &$GLOBALS['TL_LANG']['opengraph_fields']['legends'][$legend];
    }

    unset($options);
}
