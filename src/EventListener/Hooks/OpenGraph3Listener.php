<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2022 Leo Feyer
 *
 * @package   Opengraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2022 numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\EventListener\Hooks;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use numero2\OpenGraph3\OpenGraph3;


class OpenGraph3Listener {


    /**
     * Checks if the given Content Element is a module and tries to use it
     * for OpenGraph data
     *
     * @param Model $objRow
     * @param String $strBuffer
     * @param Contao\ContentElement $objElement
     *
     * @return String
     *
     * @Hook("getContentElement")
     */
    public function findCompatibleModules( $objRow, $strBuffer, $objElement ): string {

        return OpenGraph3::findCompatibleModules($objRow, $strBuffer, $objElement);
    }


    /**
     * Appends OpenGraph data for the given module
     *
     * @param Model $objRow
     * @param String $strBuffer
     * @param Module $objModule
     *
     * @return String
     *
     * @Hook("getFrontendModule")
     */
    public function appendTagsByModule( $objRow, $strBuffer, $objModule ): string {

        return OpenGraph3::appendTagsByModule($objRow, $strBuffer, $objModule);
    }


    /**
     * Add OpenGraph tags to the current page
     *
     * @param Model $ref
     *
     * @Hook("generatePage")
     */
    public static function addTagsToPage( $ref=null ): void {

        OpenGraph3::addTagsToPage($ref);
    }
}
