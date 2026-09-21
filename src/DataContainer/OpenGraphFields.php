<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\DataContainer;

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\System;


class OpenGraphFields {


    /**
     * Adds the OpenGraph and X / Twitter fields to the given table
     *
     * @param string $table
     * @param array<string, string> $palettes The palettes to add the fields to and the legend to insert them before
     * @param list<string> $allowedTypes The og:types available in this table, all types if empty
     */
    public static function addToTable( string $table, array $palettes=[], array $allowedTypes=[] ): void {

        Controller::loadDataContainer('opengraph_fields');
        System::loadLanguageFile('opengraph_fields');

        foreach( $GLOBALS['TL_DCA']['opengraph_fields']['fields'] as $name => $field ) {

            // fields without sql are only used as additional properties
            if( !isset($field['sql']) ) {
                continue;
            }

            $GLOBALS['TL_DCA'][$table]['fields'][$name] = $field;
        }

        foreach( array_keys($GLOBALS['TL_LANG']['opengraph_fields']['legends'] ?? []) as $legend ) {
            $GLOBALS['TL_LANG'][$table][$legend] = &$GLOBALS['TL_LANG']['opengraph_fields']['legends'][$legend];
        }

        foreach( $palettes as $palette => $beforeLegend ) {

            if( !isset($GLOBALS['TL_DCA'][$table]['palettes'][$palette]) ) {
                continue;
            }

            $pm = PaletteManipulator::create();

            foreach( self::getLegends() as $legend => [$fields, $hide] ) {
                $pm
                    ->addLegend($legend, $beforeLegend, PaletteManipulator::POSITION_BEFORE, $hide)
                    ->addField($fields, $legend, PaletteManipulator::POSITION_APPEND)
                ;
            }

            $pm->applyToPalette($palette, $table);
        }

        if( !empty($allowedTypes) ) {
            $GLOBALS['TL_DCA'][$table]['config']['allowedOpenGraphTypes'] = $allowedTypes;
        }
    }


    /**
     * Returns the legends and their fields of the default palette
     *
     * @return array<string, array{0: list<string>, 1: bool}>
     */
    private static function getLegends(): array {

        $legends = [];

        foreach( explode(';', $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default']) as $group ) {

            if( !preg_match('/^\{(\w+)(:hide)?\},?(.*)$/', trim($group), $matches) ) {
                continue;
            }

            $legends[$matches[1]] = [array_filter(explode(',', $matches[3])), !empty($matches[2])];
        }

        return $legends;
    }
}
