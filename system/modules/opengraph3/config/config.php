<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2016 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['news']['newsreader'] = 'numero2\OpenGraph3\ModuleNewsReader';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = array('numero2\OpenGraph3\OpenGraph3', 'setPageOGTags');