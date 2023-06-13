<?php
namespace pluginone\framework\Forms;
use pluginone\framework\Globals;
if (!defined('ABSPATH')) {
    exit;
}

/**
 * FormHtml
 *  třída pro zobrazení formulářů
 *  
 * 
 */

if (!class_exists('FormHtml')) {

    class FormHtml
    {
        /**
         * id formuláře
         *
         * @var string
         */
        private  $form_id;


        /**
         * celkové html formuláře
         *
         * @var string
         */
        private  $html = '';

        /**
         * pole formuláře
         *
         * @var object
         */
        private  $formObject;


        /**
         * konstruktor
         *
         * @param string $form_id
         * @param string $enctype
         * @return void
         */
        Public  function __construct(formObject $formObject ){
            $this->form_id = $formObject->get_form_id();
            $this->formObject = $formObject;
           
          
        }

        /**
         * získaní html formuláře
         *
         * @return void
         */
        public function render(){
            $this->html =  $this->header_form();
            $this->html .= $this->section_form();
            $this->html .= $this->button_form();
            $this->html .= $this->footer_form();
            return $this->html;
        }
       
        /**
         * vytvoření hlavičky formuláře
         * 
         * @return string
         */
        private function header_form(){
            $html = file_get_contents(__DIR__.'/html/FormHeader.php', true);
            $html .= '<form method="post" id='. $this->form_id .'_form" class="d1g1-form" action="" enctype="'.$this->formObject->get_enctype().'" novalidate data-abide>';
            $html .= '<div class="form-section">';
            $html .= $this->headline($this->formObject->get_headline(),'2');
            $html .= $this->description($this->formObject->get_description());

            return $html;
        }



        /**
         * vytvoření html formuláře
         * 
         * @return string
         */
        private function section_form(){
            $html = '';
            $sections = $this->formObject->get_sections();
           
            foreach($sections as $section){
                $html .= '<div class="form-section">';
                $html .= $this->headline($section->get_headline(),'3');
                $html .= $this->description($section->get_description());
                foreach($section->get_fields() as $fields_id =>  $field){

                    $html .= $field;
                }
                $html .= '</div>';
            }
            return $html;
        }

        /**
         * vytvoření patičky formuláře
         * 
         * @return string
         */
        private function footer_form(){
            $html = file_get_contents(__DIR__.'/html/FormFooter.php', true);
            return $html;
        }

        /**
         * vytvoření tlačítka formuláře
         * 
         * @return string
         */
        private function button_form(){
            $filter_button_name = apply_filters('d1g1_button_form-'.$this->form_id, 'Odeslat');
            $html = '</div>'; // ukončení "form-section"
            $html = '<p class="submit">';
            $html .= '<input type="hidden" name="form_id" value="'.$this->form_id.'">';
            $html .= '<button type="submit" class="button button-primary" name="submit" value="'.Globals::$FWDIGI_PLUGINID.'-submit">'.__($filter_button_name, Globals::$FWDIGI_PLUGINID).'</button>';
            $html .= '</p>';
          
            return $html;
        }

        /**
         * vytvoření popisku
         * 
         * @return string
         */
        private function description($description){
            $html = '';
            if($description){
                $html .= '<p class="description">'.$description.'</p>';
            }
            return $html;
        }

        /**
         * vytvoření nadpisu
         * 
         * @return string
         */
        private function headline($headline,$size) {
            $html = '';
            if ($headline) {
                $html .= '<h'.$size.'>' . $headline . '</h'.$size.'>';
            }
            return $html;
        }
        /**
         * vytvoření popisku
         * 
         * @return string
         */
        private function label($label,$name){
            $html = '';
            if($label != null){
                $html .= '<label for="'.$name.'">'.$label.'</label>';
            }
            return $html;
        }
    }
        
}