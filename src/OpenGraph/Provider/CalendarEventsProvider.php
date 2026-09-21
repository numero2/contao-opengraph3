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

use Contao\CalendarEventsModel;
use Contao\Input;
use Contao\ModuleModel;
use Contao\StringUtil;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;


class CalendarEventsProvider implements ProviderInterface {


    /**
     * {@inheritdoc}
     */
    public function supports( ModuleModel $model ): bool {

        return $model->type === 'eventreader' && class_exists(CalendarEventsModel::class);
    }


    /**
     * {@inheritdoc}
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference {

        $event = CalendarEventsModel::findPublishedByParentAndIdOrAlias(
            (string) Input::get('auto_item')
        ,   StringUtil::deserialize($model->cal_calendar, true)
        );

        if( $event === null ) {
            return null;
        }

        return new OpenGraphReference($event, [
            'og_type' => 'website'
        ]);
    }
}
