<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2024, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\OpenGraph3;

use Contao\Config;
use Contao\Input;
use Contao\NewsModel;
use Contao\StringUtil;
use DateTime;


class OpenGraphNews {


    /**
     * Appends OpenGraph data from news articles
     *
     * @param Contao\Module $objModule
     */
    public static function addModuleData( $objModule ): void {

        $newsArchives = [];
        $newsArchives = StringUtil::deserialize($objModule->news_archives);

        $objArticle = null;
        $objArticle = NewsModel::findPublishedByParentAndIdOrAlias((Input::get('auto_item') ?? ''), $newsArchives);

        if( null !== $objArticle ) {

            OpenGraph3::addProperty('og_type','article',$objArticle);

            // add published time
            if( $objArticle->time ) {

                $date = new DateTime();
                $date->setTimestamp($objArticle->time);
                $date = $date->format(Config::get('datimFormat'));

                OpenGraph3::addProperty('og_article_published_time',$date,$objArticle);
            }

            // add modified time
            if( $objArticle->tstamp ) {

                $date = new DateTime();
                $date->setTimestamp($objArticle->tstamp);
                $date = $date->format(Config::get('datimFormat'));

                OpenGraph3::addProperty('og_article_modified_time',$date,$objArticle);
            }

            OpenGraph3::addTagsToPage( $objArticle );
        }
    }
}
