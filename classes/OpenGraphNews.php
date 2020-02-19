<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für digitales Marketing
 */


/**
 * Namespace
 */
namespace numero2\OpenGraph3;

use Contao\Config;
use Contao\Input;
use Contao\NewsModel;


class OpenGraphNews {


    /**
     * Appends OpenGraph data from news articles
     *
     * @param $objModule
     */
    public static function addModuleData( $objModule ) {

        $newsArchives = array();
        $newsArchives = deserialize($objModule->news_archives);

        $objArticle = NULL;
        $objArticle = NewsModel::findPublishedByParentAndIdOrAlias(Input::get('items'), $newsArchives);

        if( null !== $objArticle ) {

            OpenGraph3::addProperty('og_type','article',$objArticle);

            // add published time
            if( $objArticle->time ) {

                $date = new \DateTime();
                $date->setTimestamp($objArticle->time);
                $date = $date->format(Config::get('datimFormat'));

                OpenGraph3::addProperty('og_article_published_time',$date,$objArticle);
            }

            // add modified time
            if( $objArticle->tstamp ) {

                $date = new \DateTime();
                $date->setTimestamp($objArticle->tstamp);
                $date = $date->format(Config::get('datimFormat'));

                OpenGraph3::addProperty('og_article_modified_time',$date,$objArticle);
            }

            OpenGraph3::addTagsToPage( $objArticle );
        }
    }
}