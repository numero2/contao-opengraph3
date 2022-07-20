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


namespace numero2\OpenGraph3;

use Contao\CalendarEventsModel;
use Contao\Input;
use Contao\StringUtil;


class OpenGraphCalendarEvents {


    /**
     * Appends OpenGraph data from news articles
     *
     * @param $objModule
     */
    public static function addModuleData( $objModule ): void {

        $calendars = StringUtil::deserialize($objModule->cal_calendar, true);
        $event = CalendarEventsModel::findPublishedByParentAndIdOrAlias(Input::get('auto_item'), $calendars);

        // Check if the calendar event could get loaded from the database
        if (null === $event) {
            return;
        }

        OpenGraph3::addProperty('og_type', 'website', $event);

        OpenGraph3::addTagsToPage($event);
    }
}
