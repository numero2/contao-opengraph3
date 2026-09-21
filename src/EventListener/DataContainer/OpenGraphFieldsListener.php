<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\EventListener\DataContainer;

use Contao\BackendUser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Image\ImageSizes;
use Contao\CoreBundle\Intl\Countries;
use Contao\DataContainer;
use Symfony\Bundle\SecurityBundle\Security;


class OpenGraphFieldsListener {


    /**
     * @var Contao\CoreBundle\Intl\Countries
     */
    private Countries $countries;

    /**
     * @var Contao\CoreBundle\Image\ImageSizes
     */
    private ImageSizes $imageSizes;

    /**
     * @var Symfony\Bundle\SecurityBundle\Security
     */
    private Security $security;


    public function __construct( Countries $countries, ImageSizes $imageSizes, Security $security ) {

        $this->countries = $countries;
        $this->imageSizes = $imageSizes;
        $this->security = $security;
    }


    /**
     * Returns the available og:type options, based on the og_subpalettes and
     * restricted by the allowedOpenGraphTypes of the current table
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getTypes( DataContainer $dc ): array {

        $types = array_keys($GLOBALS['TL_DCA']['opengraph_fields']['og_subpalettes'] ?? []);
        $types = array_values(array_diff($types, ['__basic__', '__all__']));

        $allowedTypes = $GLOBALS['TL_DCA'][$dc->table]['config']['allowedOpenGraphTypes'] ?? [];

        if( !empty($allowedTypes) ) {
            $types = array_values(array_intersect($types, $allowedTypes));
        }

        return array_combine($types, $types);
    }


    /**
     * Returns the list of countries indexed by their ISO code
     *
     * @return array
     */
    public function getCountries(): array {

        return $this->countries->getCountries();
    }


    /**
     * Returns the image sizes available to the current user
     *
     * @return array
     */
    #[AsCallback('tl_settings', target: 'fields.og_image_size.options')]
    #[AsCallback('tl_settings', target: 'fields.twitter_image_size.options')]
    public function getImageSizes(): array {

        $user = $this->security->getUser();

        if( !$user instanceof BackendUser ) {
            return [];
        }

        return $this->imageSizes->getOptionsForUser($user);
    }
}
