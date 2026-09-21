<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


use numero2\Opengraph3Bundle\DataContainer\OpenGraphFields;


if( !empty($GLOBALS['TL_DCA']['tl_faq']) ) {
    OpenGraphFields::addToTable('tl_faq', ['default'=>'answer_legend']);
}
