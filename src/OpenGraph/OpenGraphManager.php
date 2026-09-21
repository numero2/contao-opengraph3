<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\OpenGraph;

use Contao\Config;
use Contao\Controller;
use Contao\CoreBundle\Image\ImageFactoryInterface;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Intl\Countries;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\CoreBundle\Util\LocaleUtil;
use Contao\FilesModel;
use Contao\Model;
use Contao\PageModel;
use Contao\StringUtil;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Service\ResetInterface;


class OpenGraphManager implements ResetInterface {


    /**
     * @var Symfony\Component\HttpFoundation\RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @var Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor
     */
    private ResponseContextAccessor $responseContextAccessor;

    /**
     * @var Contao\CoreBundle\InsertTag\InsertTagParser
     */
    private InsertTagParser $insertTagParser;

    /**
     * @var Contao\CoreBundle\Image\ImageFactoryInterface
     */
    private ImageFactoryInterface $imageFactory;

    /**
     * @var Contao\CoreBundle\Intl\Countries
     */
    private Countries $countries;

    /**
     * @var string
     */
    private string $projectDir;

    /**
     * The record providing the most specific data (e.g. a news article)
     *
     * @var numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference|null
     */
    private ?OpenGraphReference $reference = null;

    /**
     * The page the tags have been added to
     *
     * @var Contao\PageModel|null
     */
    private ?PageModel $page = null;

    /**
     * The meta tags added to the HtmlHeadBag by this service
     *
     * @var list<Contao\CoreBundle\String\HtmlAttributes>
     */
    private array $tags = [];


    public function __construct( RequestStack $requestStack, ResponseContextAccessor $responseContextAccessor, InsertTagParser $insertTagParser, ImageFactoryInterface $imageFactory, Countries $countries, string $projectDir ) {

        $this->requestStack = $requestStack;
        $this->responseContextAccessor = $responseContextAccessor;
        $this->insertTagParser = $insertTagParser;
        $this->imageFactory = $imageFactory;
        $this->countries = $countries;
        $this->projectDir = $projectDir;
    }


    /**
     * Sets the record that provides the OpenGraph data for the current page,
     * its values take precedence over the ones of the page and the root page.
     * Only the first reference set during a request will be used.
     *
     * @param numero2\Opengraph3Bundle\OpenGraph\OpenGraphReference $reference
     */
    public function setReference( OpenGraphReference $reference ): void {

        if( $this->reference !== null ) {
            return;
        }

        $this->reference = $reference;

        // modern page layouts add the tags before the modules are rendered,
        // so we have to update them with the data of the reference
        if( $this->page !== null ) {
            $this->addTagsToPage($this->page);
        }
    }


    /**
     * Adds the OpenGraph tags for the given page to the HtmlHeadBag,
     * replacing the ones previously added by this service
     *
     * @param Contao\PageModel $page
     */
    public function addTagsToPage( PageModel $page ): void {

        $responseContext = $this->responseContextAccessor->getResponseContext();

        if( !$responseContext || !$responseContext->has(HtmlHeadBag::class) ) {
            return;
        }

        /** @var HtmlHeadBag $headBag */
        $headBag = $responseContext->get(HtmlHeadBag::class);

        $this->page = $page;

        if( !empty($this->tags) ) {

            $headBag->setMetaTags(array_values(array_filter(
                $headBag->getMetaTags()
            ,   fn( HtmlAttributes $tag ): bool => !in_array($tag, $this->tags, true)
            )));

            $this->tags = [];
        }

        Controller::loadDataContainer('opengraph_fields');

        $fields = $GLOBALS['TL_DCA']['opengraph_fields']['fields'] ?? [];
        $values = $this->collectValues($page, $fields);

        foreach( $fields as $name => $field ) {

            $property = $field['og_property'] ?? null;

            if( !$property || empty($values[$name]) || $this->isDefinedElsewhere($headBag, $property) ) {
                continue;
            }

            foreach( $values[$name] as $value ) {
                foreach( $this->generateTags($property, $name, $field, $value, $page) as [$tagProperty, $tagValue] ) {
                    $this->addTag($headBag, $tagProperty, $tagValue);
                }
            }
        }

        if( !$this->isDefinedElsewhere($headBag, 'og:locale') && !$this->hasTag('og:locale') ) {
            $this->addTag($headBag, 'og:locale', $this->getDefaultLocale($page));
        }

        $request = $this->requestStack->getMainRequest();

        if( $request && !$this->isDefinedElsewhere($headBag, 'og:url') && !$this->hasTag('og:url') ) {
            $this->addTag($headBag, 'og:url', $headBag->getCanonicalUriForRequest($request));
        }
    }


    /**
     * Resets the state of this service for the next request
     */
    public function reset(): void {

        $this->reference = null;
        $this->page = null;
        $this->tags = [];
    }


    /**
     * Collects the values of all fields, the reference takes precedence over
     * the page which takes precedence over the root page
     *
     * @param Contao\PageModel $page
     * @param array $fields
     *
     * @return array<string, list<mixed>>
     */
    private function collectValues( PageModel $page, array $fields ): array {

        $sources = [];

        if( $this->reference !== null ) {
            $sources[] = [$this->reference->model, $this->reference->defaults];
        }

        $sources[] = [$page, []];

        if( $page->rootId && (int) $page->rootId !== (int) $page->id ) {

            $rootPage = PageModel::findById($page->rootId);

            if( $rootPage ) {
                $sources[] = [$rootPage, []];
            }
        }

        $values = [];

        foreach( $sources as [$model, $defaults] ) {
            foreach( $this->getModelValues($model, $fields, $defaults) as $name => $value ) {
                $values[$name] ??= $value;
            }
        }

        return $values;
    }


    /**
     * Returns the values of all fields for the given record, including the
     * additional properties (og_properties) and the given defaults
     *
     * @param Contao\Model $model
     * @param array $fields
     * @param array $defaults
     *
     * @return array<string, list<mixed>>
     */
    private function getModelValues( Model $model, array $fields, array $defaults ): array {

        $values = [];

        foreach( $fields as $name => $field ) {

            if( empty($field['og_property']) ) {
                continue;
            }

            $value = $model->{$name};

            if( $value !== null && $value !== '' ) {
                $values[$name] = [$value];
            }
        }

        foreach( StringUtil::deserialize($model->og_properties, true) as $row ) {

            $name = $row[0] ?? null;
            $value = $row[1] ?? null;

            if( !\is_string($name) || empty($fields[$name]['og_property']) || $value === null || $value === '' || \is_array($value) ) {
                continue;
            }

            // only allow multiple values for properties supporting it
            if( isset($values[$name]) && empty($fields[$name]['eval']['og_multiple']) ) {
                continue;
            }

            $values[$name][] = $value;
        }

        foreach( $defaults as $name => $value ) {

            if( isset($values[$name]) || $value === null || $value === '' ) {
                continue;
            }

            $values[$name] = [$value];
        }

        return $values;
    }


    /**
     * Generates the tags for the given field value as a list of [property, value] pairs
     *
     * @param string $property
     * @param string $name
     * @param array $field
     * @param mixed $value
     * @param Contao\PageModel $page
     *
     * @return list<array{0: string, 1: string}>
     */
    private function generateTags( string $property, string $name, array $field, $value, PageModel $page ): array {

        if( ($field['inputType'] ?? null) === 'fileTree' ) {

            $image = $this->getImage((string) $value, Config::get($name.'_size'));

            if( $image === null ) {
                return [];
            }

            $tags = [[$property, $image['url']]];

            if( $property === 'og:image' ) {

                if( str_starts_with($image['url'], 'https:') ) {
                    $tags[] = ['og:image:secure_url', $image['url']];
                }

                if( $image['width'] && $image['height'] ) {
                    $tags[] = ['og:image:width', (string) $image['width']];
                    $tags[] = ['og:image:height', (string) $image['height']];
                }
            }

            return $tags;
        }

        if( $name === 'og_business_contact_data_country_name' ) {
            $value = $this->getCountryName((string) $value, $page);
        }

        if( ($field['eval']['rgxp'] ?? null) === 'datim' ) {
            $value = $this->formatDate($value);
        }

        return [[$property, (string) $value]];
    }


    /**
     * Adds a single meta tag to the HtmlHeadBag
     *
     * @param Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag $headBag
     * @param string $property
     * @param string $value
     */
    private function addTag( HtmlHeadBag $headBag, string $property, string $value ): void {

        $value = $this->insertTagParser->replaceInline($value);
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = trim(preg_replace('/\s+/u', ' ', $value) ?? '');

        if( $value === '' ) {
            return;
        }

        $tag = (new HtmlAttributes())
            ->set(str_starts_with($property, 'twitter:') ? 'name' : 'property', $property)
            ->set('content', $value)
        ;

        $headBag->addMetaTag($tag);
        $this->tags[] = $tag;
    }


    /**
     * Checks if a tag for the given property was added by this service
     *
     * @param string $property
     *
     * @return bool
     */
    private function hasTag( string $property ): bool {

        foreach( $this->tags as $tag ) {
            if( ($tag['property'] ?? $tag['name'] ?? null) === $property ) {
                return true;
            }
        }

        return false;
    }


    /**
     * Checks if a tag for the given property was already added by someone else,
     * either to the HtmlHeadBag or to $GLOBALS['TL_HEAD']
     *
     * @param Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag $headBag
     * @param string $property
     *
     * @return bool
     */
    private function isDefinedElsewhere( HtmlHeadBag $headBag, string $property ): bool {

        foreach( $headBag->getMetaTags() as $tag ) {

            if( in_array($tag, $this->tags, true) ) {
                continue;
            }

            if( ($tag['property'] ?? $tag['name'] ?? null) === $property ) {
                return true;
            }
        }

        $pattern = '/\s(?:property|name)=["\']'.preg_quote($property, '/').'["\']/';

        foreach( (array) ($GLOBALS['TL_HEAD'] ?? []) as $head ) {
            if( \is_string($head) && preg_match($pattern, $head) ) {
                return true;
            }
        }

        return false;
    }


    /**
     * Returns the absolute URL and dimensions of the given image,
     * resized based on the given size configuration
     *
     * @param string $uuid
     * @param mixed $size
     *
     * @return array{url: string, width: int|null, height: int|null}|null
     */
    private function getImage( string $uuid, $size ): ?array {

        $file = FilesModel::findByUuid($uuid);

        if( !$file || $file->type !== 'file' ) {
            return null;
        }

        $url = $file->path;
        $width = null;
        $height = null;

        try {

            $image = $this->imageFactory->create($this->projectDir.'/'.$file->path, $this->normalizeImageSize($size));
            $dimensions = $image->getDimensions()->getSize();

            $url = $image->getUrl($this->projectDir);
            $width = $dimensions->getWidth();
            $height = $dimensions->getHeight();

        } catch( Exception $e ) {
        }

        return [
            'url' => $this->getAbsoluteUrl($url)
        ,   'width' => $width
        ,   'height' => $height
        ];
    }


    /**
     * Converts the value of an imageSize widget to a size configuration
     * understood by the image factory
     *
     * @param mixed $size
     *
     * @return array|int|null
     */
    private function normalizeImageSize( $size ): array|int|null {

        if( empty($size) ) {
            return null;
        }

        if( is_numeric($size) ) {
            return (int) $size;
        }

        $size = StringUtil::deserialize($size, true);

        return array_filter($size) ? $size : null;
    }


    /**
     * Makes the given URL absolute
     *
     * @param string $url
     *
     * @return string
     */
    private function getAbsoluteUrl( string $url ): string {

        if( preg_match('~^https?://~i', $url) ) {
            return $url;
        }

        $request = $this->requestStack->getMainRequest();

        if( !$request ) {
            return $url;
        }

        return $request->getSchemeAndHttpHost().$request->getBasePath().'/'.ltrim($url, '/');
    }


    /**
     * Returns the name of the country with the given ISO code in the language of the page
     *
     * @param string $code
     * @param Contao\PageModel $page
     *
     * @return string
     */
    private function getCountryName( string $code, PageModel $page ): string {

        $countries = $this->countries->getCountries(LocaleUtil::formatAsLocale((string) $page->language));

        return $countries[strtoupper($code)] ?? $code;
    }


    /**
     * Formats the given date as ISO 8601, supports timestamps as well as
     * dates in the configured date and time format
     *
     * @param mixed $value
     *
     * @return string
     */
    private function formatDate( $value ): string {

        try {

            if( is_numeric($value) ) {

                $date = (new DateTimeImmutable())->setTimestamp((int) $value);

            } else {

                $date = DateTimeImmutable::createFromFormat('!'.Config::get('datimFormat'), (string) $value) ?: new DateTimeImmutable((string) $value);
            }

        } catch( Exception $e ) {
            return '';
        }

        return $date->format(DateTimeInterface::ATOM);
    }


    /**
     * Returns the default og:locale for the given page based on its language
     *
     * @param Contao\PageModel $page
     *
     * @return string
     */
    private function getDefaultLocale( PageModel $page ): string {

        $language = (string) $page->language;

        if( \strlen($language) === 2 ) {
            return $language === 'en' ? 'en_US' : $language.'_'.strtoupper($language);
        }

        return LocaleUtil::formatAsLocale($language);
    }
}
