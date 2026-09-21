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

use Contao\Input;
use Contao\ModuleModel;
use Contao\NewsModel;
use Contao\StringUtil;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;


class NewsProvider implements ProviderInterface {


    /**
     * {@inheritdoc}
     */
    public function supports( ModuleModel $model ): bool {

        return $model->type === 'newsreader' && class_exists(NewsModel::class);
    }


    /**
     * {@inheritdoc}
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference {

        $article = NewsModel::findPublishedByParentAndIdOrAlias(
            (string) Input::get('auto_item')
        ,   StringUtil::deserialize($model->news_archives, true)
        );

        if( $article === null ) {
            return null;
        }

        return new OpenGraphReference($article, [
            'og_type' => 'article'
        ,   'og_article_published_time' => $article->time ?: null
        ,   'og_article_modified_time' => $article->tstamp ?: null
        ]);
    }
}
