<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\OpenGraph;

use Contao\Model;


/**
 * A record (e.g. a news article) that provides OpenGraph data for the
 * current page, along with default values for fields that are empty
 */
final class OpenGraphReference {


    /**
     * @param Contao\Model $model
     * @param array<string, mixed> $defaults Default values indexed by field name (e.g. "og_type")
     */
    public function __construct(
        public readonly Model $model,
        public readonly array $defaults = [],
    ) {
    }
}
