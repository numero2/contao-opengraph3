<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   Commercial
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\Twig\Extension;

use numero2\OpenGraph3\OpenGraph3;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


final class OpenGraph3Extension extends AbstractExtension {


    public function getFunctions(): array {

        return [
            new TwigFunction(
                'opengraph3_insert'
            ,   [$this, 'generate']
            ,   ['is_safe' => ['html']]
            )
        ];
    }


    public function generate(): string {

        OpenGraph3::addTagsToPage(null);
        return '';
    }
}