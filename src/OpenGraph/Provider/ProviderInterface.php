<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\OpenGraph\Provider;

use Contao\ModuleModel;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;


/**
 * Provides the OpenGraph data of a reader module (e.g. the currently displayed
 * news article). Services implementing this interface are registered automatically.
 */
interface ProviderInterface {


    /**
     * Checks if the given frontend module is supported by this provider
     *
     * @param Contao\ModuleModel $model
     *
     * @return bool
     */
    public function supports( ModuleModel $model ): bool;


    /**
     * Returns the record displayed by the given frontend module
     *
     * @param Contao\ModuleModel $model
     *
     * @return numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference|null
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference;
}
