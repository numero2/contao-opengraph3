<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2021 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2021 numero2 - Agentur für digitales Marketing GbR
 */


\System::loadLanguageFile('opengraph_fields');
\Controller::loadDataContainer('opengraph_fields');

/**
 * Modify palettes
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace(
    '{dns_legend'
,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{dns_legend'
,   $GLOBALS['TL_DCA']['tl_page']['palettes']['root']
);

$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace(
    '{protected_legend'
,   $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{protected_legend'
,   $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']
);

/**
 * Modify fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
    $GLOBALS['TL_DCA']['tl_page']['fields']
,   $GLOBALS['TL_DCA']['opengraph_fields']['fields']
);

/**
 * Add legends
 */
array_walk(
    $GLOBALS['TL_LANG']['opengraph_fields']['legends']
,   function( $translation, $key ) {
        $GLOBALS['TL_LANG']['tl_page'][$key] = $translation;
    }
);
