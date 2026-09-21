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

use Contao\FaqModel;
use Contao\Input;
use Contao\ModuleModel;
use Contao\StringUtil;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference;


class FaqProvider implements ProviderInterface {


    /**
     * {@inheritdoc}
     */
    public function supports( ModuleModel $model ): bool {

        return $model->type === 'faqreader' && class_exists(FaqModel::class);
    }


    /**
     * {@inheritdoc}
     */
    public function getReference( ModuleModel $model ): ?OpenGraphReference {

        $faq = FaqModel::findPublishedByParentAndIdOrAlias(
            (string) Input::get('auto_item')
        ,   StringUtil::deserialize($model->faq_categories, true)
        );

        if( $faq === null ) {
            return null;
        }

        return new OpenGraphReference($faq, [
            'og_type' => 'article'
        ,   'og_article_modified_time' => $faq->tstamp ?: null
        ]);
    }
}
