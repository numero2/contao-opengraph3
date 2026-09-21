<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\EventListener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Event\LayoutEvent;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\LayoutModel;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\PageRegular;
use numero2\Opengraph3Bundle\OpenGraph\OpenGraphManager;
use numero2\Opengraph3Bundle\OpenGraph\Provider\ProviderInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;


class OpenGraphListener {


    /**
     * @var Symfony\Component\HttpFoundation\RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @var Contao\CoreBundle\Routing\ScopeMatcher
     */
    private ScopeMatcher $scopeMatcher;

    /**
     * @var numero2\Opengraph3Bundle\OpenGraph\OpenGraphManager
     */
    private OpenGraphManager $openGraphManager;

    /**
     * @var iterable<numero2\Opengraph3Bundle\OpenGraph\Provider\ProviderInterface>
     */
    private iterable $providers;


    public function __construct( RequestStack $requestStack, ScopeMatcher $scopeMatcher, OpenGraphManager $openGraphManager, iterable $providers ) {

        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
        $this->openGraphManager = $openGraphManager;
        $this->providers = $providers;
    }


    /**
     * Adds the OpenGraph tags to pages using a legacy page layout,
     * this hook is executed after all modules have been generated
     *
     * @param Contao\PageModel $page
     * @param Contao\LayoutModel $layout
     * @param Contao\PageRegular $pageRegular
     */
    #[AsHook('generatePage')]
    public function onGeneratePage( PageModel $page, LayoutModel $layout, PageRegular $pageRegular ): void {

        $this->openGraphManager->addTagsToPage($page);
    }


    /**
     * Adds the OpenGraph tags to pages using a modern page layout, the tags
     * will be updated if a reader module provides more specific data later on
     *
     * @param Contao\CoreBundle\Event\LayoutEvent $event
     */
    #[AsEventListener]
    public function onLayout( LayoutEvent $event ): void {

        $this->openGraphManager->addTagsToPage($event->getPage());
    }


    /**
     * Uses the record displayed by a supported reader module
     * (e.g. a news article) as source for the OpenGraph tags
     *
     * @param mixed $model
     * @param string $buffer
     * @param Contao\Module $module
     *
     * @return string
     */
    #[AsHook('getFrontendModule')]
    public function onGetFrontendModule( $model, string $buffer, $module ): string {

        if( !$model instanceof ModuleModel ) {
            return $buffer;
        }

        $request = $this->requestStack->getCurrentRequest();

        if( !$request || !$this->scopeMatcher->isFrontendRequest($request) ) {
            return $buffer;
        }

        /** @var ProviderInterface $provider */
        foreach( $this->providers as $provider ) {

            if( !$provider->supports($model) ) {
                continue;
            }

            if( $reference = $provider->getReference($model) ) {
                $this->openGraphManager->setReference($reference);
            }

            break;
        }

        return $buffer;
    }
}
