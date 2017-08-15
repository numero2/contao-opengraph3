<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   OpenGraph3
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Namespace
 */
namespace numero2\OpenGraph3;

use Contao\Backend;
use Contao\Config;
use Contao\Controller;
use Contao\Date;
use Contao\Image;
use Contao\Input;
use Contao\System;


class OpenGraphProperties extends \Widget {


    /**
     * Submit user input
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Add a for attribute
     * @var boolean
     */
    protected $blnForAttribute = false;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';


    /**
     * Initialize the FileUpload object
     *
     * @param array $arrAttributes
     */
    public function __construct( $arrAttributes=null ) {

        parent::__construct($arrAttributes);

        System::loadLanguageFile('opengraph_fields');
        Controller::loadDataContainer('opengraph_fields');
    }


    /**
     * Trim values
     *
     * @param mixed $varInput
     *
     * @return mixed
     */
    protected function validator( $varInput ) {

        $dcas = array();
        $dcas = self::generateWidgetsDCA($varInput);

        if( $varInput && !empty($varInput) ) {

            foreach( $dcas as $i => $row ) {

                foreach( $row as $j => $field ) {

                    $strClass = $GLOBALS['BE_FFL'][$field['inputType']];

                    if( !class_exists($strClass) ) {
                        continue;
                    }

                    try {

                        $cField = new $strClass($strClass::getAttributesFromDca(
                            $field,
                            $this->arrConfiguration['strField'].'['.$i.']['.$j.']',
                            (!empty($this->value[$i][$j])?$this->value[$i][$j]:null),
                            $this->strField,
                            $this->strTable,
                            $this->objDca
                        ));

                    } catch( \Exception $e ) {

                        $cField = new $strClass($strClass::getAttributesFromDca(
                            $field,
                            $this->arrConfiguration['strField'].'['.$i.']['.$j.']',
                            null,
                            $this->strField,
                            $this->strTable,
                            $this->objDca
                        ));
                    }

                    // do not validate when submitOnchange was triggered
                    if( Input::post('SUBMIT_TYPE')!=='auto' ) {

                        $cField->validate();

                        if( $cField->hasErrors() ) {
                            $this->class = 'error';
                            $this->arrErrors[$i][$j] = $cField->arrErrors;
                        }

                        $this->blnHasError = $this->blnHasError || $cField->hasErrors();
                    }
                }
            }
        }

        return ($this->blnHasError) ? false : empty($varInput)?'':serialize($varInput);
    }


    /**
     * Generate the widget and returns it as a string
     *
     * @return string
     */
    public function generate() {

        if( count($this->value) == 0 ) {
            $this->value = array(array());
        }

        if( is_string($this->value) ) {
            $this->value = deserialize($this->value);
        }

        // set icons and classes based on Contao version
        $theme = Backend::getTheme();
        $path = 'icons';
        $iconExt = 'svg';
        $classVersion = 'cto4';
        $isCTO4 = true;

        if( version_compare(VERSION,'4.0','<') ) {

            $path = 'images';
            $iconExt = 'gif';
            $classVersion = 'cto3';
            $isCTO4 = false;
        }

        // generate table
        $dcas = array();
        $dcas = self::generateWidgetsDCA($this->value);
        $numFields = 2;

        $html = '<div class="'.$this->strField.'">';
        $html .= '<table class="'.$classVersion.'">';
        $html .= '<tr>';

        foreach( $dcas as $i => $row ) {

            $j = 0;

            foreach( $row as $key => $field ) {

                $strClass = $GLOBALS['BE_FFL'][$field['inputType']];

                if( !class_exists($strClass) ) {
                    continue;
                }

                if( is_array($field['label']) && !empty($field['label'][1]) ) {

                    if( empty($field['eval']) ) {
                        $field['eval'] = array();
                    }

                    if( empty($field['eval']['placeholder']) ) {
                        $field['eval']['placeholder'] = $field['label'][1];
                    }
                }

                try {

                    $cField = new $strClass($strClass::getAttributesFromDca(
                        $field,
                        $this->arrConfiguration['strField'].'['.$i.']['.$j.']',
                        (!empty($this->value[$i][$j])?$this->value[$i][$j]:null),
                        $this->strField,
                        $this->strTable,
                        $this->objDca
                    ));

                } catch( \Exception $e ) {

                    $cField = new $strClass($strClass::getAttributesFromDca(
                        $field,
                        $this->arrConfiguration['strField'].'['.$i.']['.$j.']',
                        null,
                        $this->strField,
                        $this->strTable,
                        $this->objDca
                    ));
                }

                if( is_array($this->arrErrors[$i] ) && !empty($this->arrErrors[$i][$j]) ) {
                    $cField->class = 'error';
                    $cField->blnHasError = true;
                    $cField->arrErrors = $this->arrErrors[$i][$j];
                }

                $sField = $cField->generateWithError(true);

                // add datepicker
                if( $field['eval']['datepicker'] ) {

                    $rgxp = $field['eval']['rgxp'];
                    $format = Date::formatToJs(Config::get($rgxp.'Format'));

                    switch( $rgxp ) {

                        case 'datim':   $time = ", timePicker: true";   break;
                        case 'time':    $time = ", pickOnly: \"time\""; break;
                        default:        $time = ''; break;
                    }

                    $strOnSelect = '';

                    // Trigger the auto-submit function (see #8603)
                    if( $field['eval']['submitOnChange'] ) {
                        $strOnSelect = ", onSelect: function() { Backend.autoSubmit(\"" . $this->strTable . "\"); }";
                    }

                    $icon = 'assets/datepicker/images/icon.svg';

                    if( !$isCTO4 ) {
                        $icon =  'assets/mootools/datepicker/' . $GLOBALS['TL_ASSETS']['DATEPICKER'] . '/icon.gif';
                    }

                    $wizard = ' ' . Image::getHtml($icon, '', 'title="'.specialchars($GLOBALS['TL_LANG']['MSC']['datepicker']).'" id="toggle_' . $cField->id . '" style="vertical-align:-6px;cursor:pointer"') . '
                        <script>
                            window.addEvent("domready", function() {
                                new Picker.Date($("ctrl_' . $cField->id . '"), {
                                    draggable: false,
                                    toggle: $("toggle_' . $cField->id . '"),
                                    format: "' . $format . '",
                                    positionOffset: {x:-211,y:-209}' . $time . ',
                                    pickerClass: "datepicker_bootstrap",
                                    useFadeInOut: !Browser.ie' . $strOnSelect . ',
                                    startDay: ' . $GLOBALS['TL_LANG']['MSC']['weekOffset'] . ',
                                    titleFormat: "' . $GLOBALS['TL_LANG']['MSC']['titleFormat'] . '"
                                });
                            });
                        </script>';

                    $sField .= $wizard;
                    $cField->class = $cField->class.' wizard';
                }

                $html .= '<td class="w50 '.$cField->class.'">'.$sField.'</td>';
                $j += 1;
            }

            $html .= '<td class="operations">';
            $html .=    '<a rel="copy" href="#" class="widgetImage" title="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['copy'].'">
                            <img src="system/themes/'.$theme.'/'.$path.'/copy.'.$iconExt.'" width="14" height="16" alt="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['copy'].'" class="tl_listwizard_img">
                        </a>';
            $html .=    '<a rel="up" href="#" class="widgetImage" title="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['up'].'">
                            <img src="system/themes/'.$theme.'/'.$path.'/up.'.$iconExt.'" width="13" height="16" alt="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['up'].'" class="tl_listwizard_img">
                        </a>';
            $html .=    '<a rel="down" href="#" class="widgetImage" title="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['down'].'">
                            <img src="system/themes/'.$theme.'/'.$path.'/down.'.$iconExt.'" width="13" height="16" alt="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['down'].'" class="tl_listwizard_img">
                        </a>';
            $html .=    '<a rel="delete" href="#" class="widgetImage" title="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['delete'].'">
                            <img src="system/themes/'.$theme.'/'.$path.'/delete.'.$iconExt.'" width="14" height="16" alt="'.$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['operations']['delete'].'" class="tl_listwizard_img">
                        </a>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
        $html .= '
        <script>
            var clickHandler = function(e) {

                e.preventDefault();

                var row = this.parentElement.parentElement;
                var table = row.parentElement;

                if( this.rel == "copy" ) {

                    var clone = row.cloneNode(true);
                    table.insertBefore(clone, row.nextSibling);

                    var as = clone.querySelectorAll("a");
                    for( var i=0; i < as.length; i++ ) {
                        as[i].addEventListener("click", clickHandler);
                    }

                    var chosen = clone.querySelectorAll("div.tl_chosen");
                    for( var i=0; i < chosen.length; i++ ) {
                        chosen[i].parentNode.removeChild(chosen[i]);
                    }

                } else if( this.rel == "up" ) {

                    if( row.previousSibling == null ) return;
                    table.insertBefore(row, row.previousSibling);

                } else if( this.rel == "down" ) {

                    if( row.nextSibling == null ) return;
                    table.insertBefore(row.nextSibling, row);

                } else if( this.rel == "delete" ) {
                    table.removeChild(row);
                }

                var inputs = table.querySelectorAll("td > input, td > select, td > textarea");
                for( var i=0; i < inputs.length; i++ ) {
                    var iRow = Math.floor(i/'.$numFields.');
                    inputs[i].id = inputs[i].id.replace(/\[\d\]/, "["+iRow+"]");
                    inputs[i].name = inputs[i].name.replace(/\[\d\]/, "["+iRow+"]");
                }

                var chosen = table.querySelectorAll("select.tl_chosen:last-child");
                for( var i=0; i < chosen.length; i++ ) {
                    new Chosen($(chosen[i]));
                }
            }

            var anchors=document.querySelectorAll(".'.$this->strField.' td.operations > a");
            for( var i=0; i < anchors.length; i++ ) {
                anchors[i].addEventListener("click", clickHandler );
            }

        </script>';

        $html .= '</div>';

        return $html;
    }


    /**
     * Generates all necessary input fields
     * based on their original dca`s
     *
     * @param string $value
     *
     * @return array
     */
    protected function generateWidgetsDCA( $value=null ) {

        $widgetDCA = array();

        $template = array(
            'property' => array(
                'label'                 => &$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['property']
                ,   'inputType'         => 'select'
                ,   'options_callback'  => array( 'OpenGraphProperties', 'getProperties' )
                ,   'eval'              => array( 'mandatory'=>false, 'maxlength'=>255, 'includeBlankOption'=>true, 'chosen'=>true, 'submitOnChange'=>true )
            )
        ,   'value' => array(
                'label'                 => &$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['value']
                ,   'inputType'         => 'text'
                ,   'eval'              => array( 'mandatory'=>false )
            )
        );

        $options = OpenGraphProperties::getProperties($this->objDca);

        $removedValues = false;
        if( $value && !empty($value) && !empty($value[0]) ) {

            foreach( $value as $keyRow => $row ) {

                if( !array_key_exists($row[0], $options) ){
                    unset($this->varValue[$keyRow]);
                    $removedValues = true;
                    continue;
                }

                $add = array(
                    $template['property']
                ,   $row[0]===""?$template['value']:$GLOBALS['TL_DCA']['opengraph_fields']['fields'][$row[0]]
                );

                $widgetDCA[] = $add;
            }

            if( $removedValues && is_array($this->varValue) ) {
                $this->varValue = array_values($this->varValue);
            }
        }

        if( count($widgetDCA) === 0 ) {

            $widgetDCA[] = array(
                $template['property']
            ,   $template['value']
            );
        }

        return $widgetDCA;
    }


    /**
     * Return a particular error as HTML string
     *
     * @param integer $intIndex The message index
     *
     * @return string The HTML markup of the corresponding error message
     */
    public function getErrorAsHTML( $intIndex=0 ) {

        $errorMsg = '';

        if( $this->hasErrors() ) {

            if( is_array(array_values($this->arrErrors)[0]) ) {

                $errorMsg .= '<p class="tl_error tl_tip">';
                $errorMsg .= sprintf($GLOBALS['TL_LANG']['opengraph_fields']['og_property']['error'], join(", ", array_keys($this->arrErrors)));
                $errorMsg .= '</p>';

            } else {
                $errorMsg = parent::getErrorAsHTML();
            }
        }

        return $errorMsg;
    }


    /**
     * Return a particular error as HTML string
     *
     * @param integer $intIndex The message index
     *
     * @return string The HTML markup of the corresponding error message
     */
    public function getProperties( $dcTable ) {

        $type = $dcTable->activeRecord->og_type;
        $subpalettes = $GLOBALS['TL_DCA']['opengraph_fields']['og_subpalettes'];

        $fields = $GLOBALS['TL_LANG']['opengraph_fields'];

        $palette = $subpalettes['__all__'];

        if( !empty($type) && array_key_exists($type, $subpalettes) && !empty($subpalettes[$type]) ) {
            $palette = $subpalettes[$type].','.$palette;
        }

        $palette = explode(',', $palette);

        $options = array();

        foreach( $palette as $value) {

            $options[$value] = $value;

            if( !empty($fields[$value][0]) ) {
                $options[$value] = $fields[$value][0];
            }
        }

        return $options;
    }
}
