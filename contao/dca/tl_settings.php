<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


use Contao\CoreBundle\DataContainer\PaletteManipulator;


PaletteManipulator::create()
    ->addLegend('opengraph_twitter_legend', null, PaletteManipulator::POSITION_APPEND, true)
    ->addField(['og_image_size', 'twitter_image_size'], 'opengraph_twitter_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;


$GLOBALS['TL_DCA']['tl_settings']['fields']['og_image_size'] = [
    'inputType'         => 'imageSize'
,   'reference'         => &$GLOBALS['TL_LANG']['MSC']
,   'eval'              => ['rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50']
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['twitter_image_size'] = [
    'inputType'         => 'imageSize'
,   'reference'         => &$GLOBALS['TL_LANG']['MSC']
,   'eval'              => ['rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50']
];
