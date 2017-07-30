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


array_insert(
    $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'],
    array_search('meta_legend', $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'])+1,
    'opengraph_legend'
);

array_insert(
    $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'],
    array_search('meta_legend', $GLOBALS['TL_DCA']['tl_iso_attribute']['fields']['legend']['options'])+2,
    'twitter_legend'
);