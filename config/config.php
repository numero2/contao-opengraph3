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


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('numero2\OpenGraph3\OpenGraph3', 'appendElementOGTags');
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('numero2\OpenGraph3\OpenGraph3', 'appendModuleOGTags');
$GLOBALS['TL_HOOKS']['generatePage'][]      = array('numero2\OpenGraph3\OpenGraph3', 'setPageOGTags');