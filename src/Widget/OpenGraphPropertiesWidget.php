<?php

/**
 * OpenGraph3 Bundle for Contao Open Source CMS
 *
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL-3.0-or-later
 * @copyright Copyright (c) 2026, numero2 - Agentur für digitales Marketing GbR
 */


namespace numero2\Opengraph3Bundle\Widget;

use Contao\Config;
use Contao\Controller;
use Contao\Date;
use Contao\DC_Table;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\Widget;
use Exception;


/**
 * Provides a list of additional OpenGraph properties, the input type of
 * each value depends on the selected property
 */
class OpenGraphPropertiesWidget extends Widget {


    /**
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * @var bool
     */
    protected $blnForAttribute = false;

    /**
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Errors of the value widgets, indexed by row
     *
     * @var array<int, list<string>>
     */
    private array $rowErrors = [];


    public function __construct( $arrAttributes=null ) {

        parent::__construct($arrAttributes);

        System::loadLanguageFile('opengraph_fields');
        Controller::loadDataContainer('opengraph_fields');
    }


    /**
     * Validates the value of each row
     */
    public function validate(): void {

        $rows = $this->getPost($this->strId.'[_rows]');
        $rows = \is_array($rows) ? \count($rows) : 0;

        $options = $this->getPropertyOptions();

        // do not validate if the form was submitted by changing a select (submitOnChange)
        $skipValidation = Input::post('SUBMIT_TYPE') === 'auto';

        $values = [];

        for( $i=0; $i < $rows; ++$i ) {

            $property = $this->getPost($this->strId.'['.$i.'][0]');

            if( !\is_string($property) || !isset($options[$property]) ) {
                continue;
            }

            $index = \count($values);
            $name = $this->strId.'['.$i.'][1]';
            $field = $GLOBALS['TL_DCA']['opengraph_fields']['fields'][$property];
            $value = $this->getPost($name);

            if( !$skipValidation ) {

                $widget = $this->createWidget($field, $name, null);
                $widget->validate();

                if( $widget->hasErrors() ) {

                    $this->rowErrors[$index] = $widget->getErrors();
                    $this->addError(sprintf($GLOBALS['TL_LANG']['opengraph_fields']['og_property']['error'], $index+1));

                } else {

                    $value = $widget->value;

                    // store dates as timestamps so they don't depend on the date format
                    if( $value !== '' && \in_array($field['eval']['rgxp'] ?? null, ['date', 'time', 'datim'], true) ) {
                        $value = (new Date($value, Date::getFormatFromRgxp($field['eval']['rgxp'])))->tstamp;
                    }
                }
            }

            $values[] = [$property, $value];
        }

        if( $this->hasErrors() ) {
            $this->class = 'error';
        }

        $this->varValue = empty($values) ? '' : $values;
    }


    /**
     * Generates the widget
     *
     * @return string
     */
    public function generate(): string {

        $options = $this->getPropertyOptions();
        $rows = [];

        // drop properties not available for the current og:type
        foreach( StringUtil::deserialize($this->varValue, true) as $index => $row ) {

            if( !\is_array($row) || !isset($options[$row[0] ?? '']) ) {
                continue;
            }

            $rows[] = [
                'property' => $row[0]
            ,   'value' => $row[1] ?? null
            ,   'errors' => $this->rowErrors[$index] ?? []
            ];
        }

        $valuesEmpty = empty($rows);

        if( $valuesEmpty ) {
            $rows[] = ['property' => '', 'value' => null, 'errors' => []];
        }

        $propertyField = [
            'inputType' => 'select'
        ,   'options' => $options
        ,   'eval' => ['includeBlankOption'=>true, 'submitOnChange'=>true]
        ];

        $valueField = [
            'inputType' => 'text'
        ];

        $templateRows = [];

        foreach( $rows as $i => $row ) {

            $field = $row['property'] !== '' ? $GLOBALS['TL_DCA']['opengraph_fields']['fields'][$row['property']] : $valueField;

            // use the description of the property as placeholder
            if( empty($field['eval']['placeholder']) && !empty($field['label'][1]) ) {
                $field['eval']['placeholder'] = $field['label'][1];
            }

            $propertyWidget = $this->createWidget($propertyField, $this->strId.'['.$i.'][0]', $row['property']);
            $valueWidget = $this->createWidget($field, $this->strId.'['.$i.'][1]', $row['value']);

            foreach( $row['errors'] as $error ) {
                $valueWidget->addError($error);
            }

            $templateRows[] = [
                'columns' => [
                    ['widget' => $propertyWidget->generateWithError(true), 'cell_class' => 'og_property']
                ,   ['widget' => $valueWidget->generateWithError(true).$this->getDatePicker($field, $valueWidget), 'cell_class' => 'og_value']
                ]
            ,   'controls' => []
            ];
        }

        return System::getContainer()->get('twig')->render('@Contao/backend/widget/row_wizard.html.twig', [
            'id' => $this->strId
        ,   'style' => null
        ,   'header' => [
                ['label' => $GLOBALS['TL_LANG']['opengraph_fields']['og_property']['property'] ?? '']
            ,   ['label' => $GLOBALS['TL_LANG']['opengraph_fields']['og_property']['value'] ?? '']
            ]
        ,   'showHeader' => true
        ,   'footer' => []
        ,   'showFooter' => false
        ,   'rows' => $templateRows
        ,   'min_rows' => null
        ,   'max_rows' => null
        ,   'sortable' => true
        ,   'actions' => ['copy', 'delete']
        ,   'values_empty' => $valuesEmpty
        ]);
    }


    /**
     * Returns the properties available for the current og:type
     *
     * @return array<string, string>
     */
    private function getPropertyOptions(): array {

        $subpalettes = $GLOBALS['TL_DCA']['opengraph_fields']['og_subpalettes'] ?? [];
        $type = $this->getCurrentType();

        $palette = $subpalettes['__all__'] ?? '';

        if( $type !== '' && !empty($subpalettes[$type]) ) {
            $palette = $subpalettes[$type].','.$palette;
        }

        $options = [];

        foreach( StringUtil::trimsplit(',', $palette) as $name ) {

            if( !isset($GLOBALS['TL_DCA']['opengraph_fields']['fields'][$name]) ) {
                continue;
            }

            $options[$name] = $GLOBALS['TL_LANG']['opengraph_fields'][$name][0] ?? $name;
        }

        return $options;
    }


    /**
     * Returns the og:type of the current record, using the submitted value if available
     *
     * @return string
     */
    private function getCurrentType(): string {

        // in "edit multiple" mode the field names are suffixed with the record id
        $typeField = 'og_type'.substr($this->strName, \strlen($this->strField));

        if( Input::post('FORM_SUBMIT') === $this->strTable && Input::post($typeField) !== null ) {
            return (string) Input::post($typeField);
        }

        if( $this->objDca instanceof DC_Table ) {
            return (string) ($this->objDca->getActiveRecord()['og_type'] ?? '');
        }

        return '';
    }


    /**
     * Creates a sub widget based on the given field configuration
     *
     * @param array $field
     * @param string $name
     * @param mixed $value
     *
     * @return Contao\Widget
     */
    private function createWidget( array $field, string $name, $value ): Widget {

        $class = $GLOBALS['BE_FFL'][$field['inputType'] ?? 'text'] ?? $GLOBALS['BE_FFL']['text'];

        try {

            $attributes = $class::getAttributesFromDca($field, $name, $value, $this->strField, $this->strTable, $this->objDca);

        } catch( Exception $e ) {

            // the value could not be converted (e.g. an invalid date)
            $attributes = $class::getAttributesFromDca($field, $name, null, $this->strField, $this->strTable, $this->objDca);
        }

        $attributes['id'] = $name;
        $attributes['name'] = $name;

        return new $class($attributes);
    }


    /**
     * Returns the date picker for date fields
     *
     * @param array $field
     * @param Contao\Widget $widget
     *
     * @return string
     */
    private function getDatePicker( array $field, Widget $widget ): string {

        if( empty($field['eval']['datepicker']) ) {
            return '';
        }

        $rgxp = $field['eval']['rgxp'] ?? 'date';
        $format = Date::formatToJs(Config::get($rgxp.'Format'));

        $time = match( $rgxp ) {
            'datim' => ', timePicker: true'
        ,   'time' => ', pickOnly: "time"'
        ,   default => ''
        };

        return ' '.Image::getHtml('assets/datepicker/images/icon.svg', $GLOBALS['TL_LANG']['MSC']['datepicker'], 'id="toggle_'.$widget->id.'" style="cursor:pointer"').'
            <script>
                new Picker.Date($("ctrl_'.$widget->id.'"), {
                    draggable: false,
                    toggle: $("toggle_'.$widget->id.'"),
                    format: "'.$format.'",
                    positionOffset: {x:-211,y:-209}'.$time.',
                    pickerClass: "datepicker_bootstrap",
                    useFadeInOut: !Browser.ie,
                    startDay: '.$GLOBALS['TL_LANG']['MSC']['weekOffset'].',
                    titleFormat: "'.$GLOBALS['TL_LANG']['MSC']['titleFormat'].'"
                });
            </script>';
    }
}
