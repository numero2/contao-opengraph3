<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   StoreLocator
 * @author    Benny Born <benny.born@numero2.de>
 * @author    Michael Bösherz <michael.boesherz@numero2.de>
 * @license   LGPL
 * @copyright 2016 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Namespace
 */
namespace numero2\OpenGraph3;


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
    public function __construct($arrAttributes=null) {
        parent::__construct($arrAttributes);

        \System::loadLanguageFile('tl_opengraph_fields');
        \Controller::loadDataContainer('tl_opengraph_fields');
    }


    /**
     * Trim values
     *
     * @param mixed $varInput
     *
     * @return mixed
     */
    protected function validator($varInput) {

        $dcas = array();
        $dcas = self::generateWidgetsDCA($varInput);

        if( $varInput && !empty($varInput) ){
            foreach( $varInput as $row => $rValue ) {
                foreach( $dcas as $key => $field ) {

                    $field['value'] = $rValue[$key];

                    $strClass = $GLOBALS['BE_FFL'][$field['inputType']];
                    if( !class_exists($strClass) ) {
                        continue;
                    }
                    $cField = new $strClass($strClass::getAttributesFromDca(
                        $field,
                        $this->arrConfiguration['strField'].'[0]['.$key.']',
                        ( !empty($rValue[$key])?$rValue[$key]:null )
                    ));

                    $cField->validate();
                    if( $cField->hasErrors() ){
                        $this->class = 'error';
                        $this->arrErrors[$row][$key] = $cField->arrErrors;
                    }
                    $this->blnHasError = $this->blnHasError || $cField->hasErrors();
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

        if( empty($GLOBALS['TL_CSS']) || array_search('system/modules/storelocator/assets/backend.css', $GLOBALS['TL_CSS']) === FALSE ) {
            $GLOBALS['TL_CSS'][] = 'system/modules/storelocator/assets/backend.css';
        }

        if( count($this->value) == 0 ){
            $this->value = array(array());
        }
        if( is_string($this->value) ){
            $this->value = deserialize($this->value);
        }

        $theme = \Backend::getTheme();
        $path = 'icons';
        $iconExt = 'svg';
        if( version_compare(VERSION,'4.3','<') ){
            $path = 'images';
            $iconExt = 'gif';
        }

        $dcas = array();
        $dcas = self::generateWidgetsDCA($this->value);
        $numFields = 2;

        $html = '<div class="'.$this->strField.'">';
        $html .= '<table>';
        $html .= '<tr>';
        foreach( $dcas as $i => $row ) {
            foreach( $row as $key => $field ) {

                $strClass = $GLOBALS['BE_FFL'][$field['inputType']];
                if( !class_exists($strClass) ) {
                    continue;
                }

                if( is_array($field['label']) && !empty($field['label'][1]) ){
                    if( empty($field['eval']) ){
                        $field['eval'] = array();
                    }
                    if( empty($field['eval']['placeholder']) ){
                        $field['eval']['placeholder'] = $field['label'][1];
                    }
                }
                $cField = new $strClass($strClass::getAttributesFromDca(
                    $field,
                    $this->arrConfiguration['strField'].'['.$i.']['.$key.']',
                    (!empty($this->value[$i][$key])?$this->value[$i][$key]:null),
                    $this->strField,
                    $this->strTable,
                    $this->objDca
                ));

                if( !empty($this->arrErrors[$i][$key]) ){
                    $cField->arrErrors = $this->arrErrors[$i][$key];
                }

                $sField = $cField->generateWithError();

                $html .= '<td class="w40">'.$sField.'</td>';
            }

            $html .= '<td class="operations w20">';
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
        var clickHandler = function(e){
            e.preventDefault();

            var row = this.parentElement.parentElement;
            var table = row.parentElement;
            if( this.rel == "copy" ){
                var clone = row.cloneNode(true);
                table.insertBefore(clone, row);
                var as=clone.querySelectorAll("a");
                for (i = 0; i < as.length; i++) {
                    as[i].addEventListener("click", clickHandler);
                }
                if( window.Stylect ) {
                    Stylect.convertSelects();
                }
            } else if( this.rel == "up" ){
                if( row.previousSibling == null ) return;
                table.insertBefore(row, row.previousSibling)
            } else if( this.rel == "down" ){
                if( row.nextSibling == null ) return;
                table.insertBefore(row.nextSibling, row)
            } else if( this.rel == "delete" ){
                table.removeChild(row)
            }
            var inputs = table.querySelectorAll("td > input, td > select, td > textarea");
            for (i = 0; i < inputs.length; i++) {
                var iRow = Math.floor(i/'.$numFields.');
                inputs[i].id = inputs[i].id.replace(/\[\d\]/, "["+iRow+"]");
                inputs[i].name = inputs[i].name.replace(/\[\d\]/, "["+iRow+"]");
            }
        }

        var anchors=document.querySelectorAll(".'.$this->strField.' td.operations > a");
        for (i = 0; i < anchors.length; i++) {
            anchors[i].addEventListener("click", clickHandler );
        }


        var changeHandler = function(e){

            var tag=this;

            while(tag.tagName !== "BODY"){
                tag=tag.parentNode;

                if( tag.tagName === "FORM" ){
                    Backend.autoSubmit(tag);
                    break;
                }
            }

        }

        var select=document.querySelectorAll(".'.$this->strField.' td:nth-child(1) select");
        for (i = 0; i < select.length; i++) {
            select[i].addEventListener("change", changeHandler );
        }

        </script>';

        $html .= '</div>';

        return $html;
    }


    /**
     * Generates all necessary checkboxes and input fields
     * based on their original dca`s
     *
     * @return array
     */
    protected function generateWidgetsDCA($value=null) {

        $widgetDCA = array();

        $template = array(
            'property' => array(
                'label'                 => &$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['property']
                ,   'inputType'             => 'select'
                ,   'options_callback'      => array( 'OpenGraphProperties', 'getProperties' )
                ,   'eval'                  => array( 'mandatory'=>true, 'maxlength'=>255, 'chosen'=>true, 'submitOnChange'=>true )
            )
        ,   'value' => array(
                'label'                 => &$GLOBALS['TL_LANG']['opengraph_fields']['og_property']['value']
                ,   'inputType'             => 'text'
                ,   'eval'                  => array( 'mandatory'=>false, 'maxlength'=>5 )
            )
        );

        if( $value && !empty($value) && !empty($value[0]) ){

            foreach( $value as $keyRow => $row) {
                $add = array(
                    $template['property'],
                    $GLOBALS['TL_DCA']['opengraph_fields']['fields'][$row[0]]
                );

                $widgetDCA[] = $add;

            }

        } else {
            $widgetDCA[] = $template;
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
    public function getErrorAsHTML($intIndex=0) {
        return $this->hasErrors() ? sprintf('<p class="%s">%s</p>', ((TL_MODE == 'BE') ? 'tl_error tl_tip' : 'error'), "FEHLER") : '';
    }


    /**
     * Return a particular error as HTML string
     *
     * @param integer $intIndex The message index
     *
     * @return string The HTML markup of the corresponding error message
     */
    public function getProperties() {

        $fields = $GLOBALS['TL_LANG']['opengraph_fields'];

        $options = array();
        foreach( $fields as $key => $value ) {

            if( substr($key, 0, 2) !== 'og' ){
                continue;
            }
            if( in_array($key, array('og_title', 'og_type', 'og_image', 'og_properties', 'og_property')) ){
                continue;
            }

            $options[$key] = $value[0];
        }

        return $options;
    }
}
