<?php 
namespace pluginbrandslug\framework\gethtmlform;
/**
 * html content
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1GetHtmlform' ) )
{
	class d1g1GetHtmlform
	{

        //private $variable; 
        private $session;
        private $data;
        private $form_ID;
      
		public function __construct()
		{
            
            //set variable
            //$this->variable = '';
            $this->session = new \pluginbrandslug\framework\sessions\sessionClassD1G1;
            $this->data = new \pluginbrandslug\framework\forms_core\D1G1_Front_Form;

        }
        
        

         /**
         * Odeslat email s aktualizací
         *
         * @author digihood
         * @return true/false
         */

        public function getcaseform($type ,$name, $value, $args = [], $is_valid = true ,$form = ''){
            
            $showme = new \pluginbrandslug\framework\gethtmlform\d1g1GetHtmlform;
            $multiple = isset($args['multiple']) && $args['multiple'] == true ? 'multiple' : false;
            $atts = isset($args['required']) && $args['required'] == true ? 'required="required"' : '';
            $atts .= $multiple ? ' multiple' : '';
            $class = !$is_valid ? 'callout alert' : '';
            //$name = $this->get_field_name($name, $args['saveAs'], $type);
            $name = isset($args['name']) ? $args['name'] : false;
            $name = $name . ( ($type == 'image' && $multiple) ? '[]' : '');
            //$limit = isset($args['imagesLimit']) ? $args['imagesLimit'] : '999999';
            $is_required = isset($args['required']) && $args['required'] == true ? true : false;
            $required = $is_required == true ? ' <span class="required form-star">*</span>' : '';
            $label = isset($args['label']) ? $args['label'] : false;
            $placeholder = isset($args['placeholder']) ? $args['placeholder'] : $label;
            $description = isset($args['description']) ? $args['description'] : false;
            $help_text = isset($args['help_text']) ? $args['help_text'] : false;
            $floating_label_start = $label ? '<span class="floating-label">' : '';
            $floating_label_end = $label ? '</span>' : '';

            if ($is_required) {
                $placeholder = $placeholder . ' *';
            }

            switch($type){
                case 'email':
                case 'tel':
                case 'number':
                case 'password':
                case 'text':
                    $this->get_input($name, $description, $type, $is_valid, $floating_label_start, $value, $placeholder, $atts, $class, $required, $floating_label_end, $help_text );
                    break;
                case 'hidden': 

                    $this->get_hidden_input($name, $description, $type, $is_valid, $floating_label_start, $value, $placeholder, $atts, $class, $required, $floating_label_end, $help_text );
            
                break;
                case 'select': 
                    $this->get_select_input($description, $floating_label_start, $name, $atts, $class, $placeholder, $value, $label, $is_valid,$required, $floating_label_end, $help_text, $args);

                break;
                case 'url': 

                    $this->get_url_input($description, $is_valid, $floating_label_start, $value, $name, $placeholder, $atts, $class, $required , $floating_label_end, $help_text);


                break;
                case 'image': 
                    
                    $this->get_image_input($description, $is_valid, $floating_label_start, $value , $name , $placeholder , $atts, $class ,$label , $required, $help_Text);

                break;
                case 'radio':
                case 'radio_large': 

                    $this->get_radio_large_input($args, $type, $description, $is_valid, $value, $name, $atts, $help_text);

                break;
                case 'checkbox':
                case 'checkbox_large': 

                    $this->get_checkbox_large_input($args, $type, $name, $label, $class,$required, $is_valid, $description, $help_text , $form);

                break;
                case 'switch': 

                    $this->get_switch_input($name, $label, $value , $atts, $required, $is_valid, $description, $help_text, $form);

                break;
                case 'textarea': 

                    $this->get_textarea_input($args, $description, $is_valid, $floating_label_start, $type ,$name, $placeholder, $atts, $class, $value, $label, $required,$floating_label_end, $help_text);

                break;
                case 'range': 

                    $this->get_range_input($args, $name, $label, $required, $is_valid, $description, $value, $help_text);

                break;
                case 'editor': 

                    $this->get_editor_input($name, $class, $description, $value, $help_text, $args);

                break;
                case 'date':
                case 'datetime-local':
                case 'time':
                case 'month':
                case 'week':

                    $this->get_week_input($args, $type, $description, $is_valid, $floating_label_start, $name, $value, $label, $required, $floating_label_end, $help_text);

                break;
                case 'color':

                    $this->get_color_input($args, $required, $description, $is_valid, $name, $value, $help_text);

                break;
                case 'info_box':
                case 'warning_box': 
                    $this->get_warring_box_input($args, $type, $description);
                break;  

                case 'html': 
                    $this->get_html_input($args);
                break; 
                
                default:

                break;
            }
        }

         /**
         * ziskani hidden input
         * @param : 
         *  $name
         *  $description
         *  $type
         *  $is_valid
         *  $floating_label_start 
         *  $value, $placeholder 
         *  $atts 
         *  $class
         *  $required
         *  $floating_label_end
         *  $help_text
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_hidden_input($name, $description, $type, $is_valid, $floating_label_start, $value, $placeholder, $atts, $class, $required, $floating_label_end, $help_text  ) {
            $id_val = str_replace(']', '', str_replace('[', '', $name));
            if ($description) echo '<p>' . $description . '</p>';
            echo '<p>' . $floating_label_start;
            echo '<input type="' . $type . '" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" id="' . $id_val . '"/>';
            if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
            echo $floating_label_end . '</p>';
            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';     
        }

           /**
         * ziskani input
         * @param :  
         * $name
         * $description
         * $type
         * $is_valid
         * $floating_label_start 
         * $value
         * $placeholder 
         * $atts 
         * $class 
         * $required 
         * $floating_label_end
         * $help_text
         * 
         * @author digihood
         * @return true/false
         */ 

        private function get_input($name, $description, $type, $is_valid, $floating_label_start, $value, $placeholder, $atts, $class, $required, $floating_label_end, $help_text  ) {
            $id_val = str_replace(']', '', str_replace('[', '', $name));

                if ($description) echo '<p>' . $description . '</p>';
                if (!$is_valid) {

                    $er_mess = __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain');
                    if ($type == "email") $er_mess = __('Prosíme, zadejte platný email.', 'textdomain');
                    echo '<p class="form-error">' . $er_mess . '</p>';
                }
               
                
                echo '<p>' . $floating_label_start;
               
                echo '<input type="' . $type . '" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" id="' . $id_val . '"/>';
                if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
                
                echo $floating_label_end . '</p>';
               
                if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
               
        }

         /**
         * ziskani select input
         * 
         * @param 
         * $description 
         * $floating_label_start 
         * $name 
         * $atts 
         * $class 
         * $placeholder 
         * $value 
         * $label 
         * $is_valid
         * $required 
         * $floating_label_end 
         * $help_text 
         * $args
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_select_input($description, $floating_label_start, $name, $atts, $class, $placeholder, $value, $label, $is_valid,$required, $floating_label_end, $help_text, $args ){
            $options = isset($args['options']) ? $args['options'] : [];

               
            if (!empty($options)) {

                if ($description) echo '<p>' . $description . '</p>';

                if (!$is_valid) {
                    echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                }

                echo $floating_label_start;
                
                echo '<select name="' . $name . '" ' . $atts . ' class="selectize ' . $class . '" placeholder="' . $placeholder . '" id="' . $name . '">';
                foreach ($options as $option_key => $option_name) {
                    echo '<option value="' . $option_key . '" ' . ($option_key == $value ? 'selected="selected"' : '') . '>' . $option_name . '</option>';
                }
                echo '</select>';

                if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

                echo $floating_label_end;

                if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                //todo #3 Selectize.js zprovoznění vloženého scryptu s možnostmi výběru
                $selectize = isset($args['selectize']) ? $args['selectize'] : [];
                if (!empty($selectize)) {
                    
                    echo '<script>$("#' . $name . '").selectize({';
                    
                    foreach ($selectize as $selectize_key => $selectize_value) {
                        echo $selectize_key . ': ' . $selectize_value . ',';
                    }

                    echo '});</script>';
                }             
            }
        }

         /**
         * html URL input
         *
         * @param : 
         * $description
         * $is_valid
         * $floating_label_start
         * $value
         * $name
         * $placeholder 
         * $atts 
         * $class 
         * $required 
         * $floating_label_end
         * $help_text
         *
         * @author digihood
         * @return 
         */ 

        private function get_url_input($description, $is_valid, $floating_label_start, $value, $name, $placeholder, $atts, $class, $required , $floating_label_end, $help_text){
            if ($description) echo '<p>' . $description . '</p>';

            if (!$is_valid) {
                echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
            }

            echo '<div class="input-group">';
            echo '<span class="input-group-label">' . d1g1_get_svg(D1G1_URLSLUG . "assets/icons/link-line.svg") . '</span>';
            echo  $floating_label_start;

            echo '<input type="url" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />';

            if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

            echo $floating_label_end ;
            echo '</div>';

            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
        }

         /**
         * html image input
         * @param :
         * $description 
         * $is_valid 
         * $floating_label_start 
         * $value  
         * $name  
         * $placeholder  
         * $atts
         * $class 
         * $label  
         * $required
         * $help_Text
         *
         * @author digihood
         * @return echo 
         */ 

        private function get_image_input($description, $is_valid, $floating_label_start, $value , $name , $placeholder , $atts, $class ,$label , $required, $help_Text){
            //echo '<div id="media-uploader-' . $name . '" data-target="' . $name . '" data-limit="1" class="dropzone ' . $class . '"></div>';
            //echo '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $atts . ' />';
            //if (!empty($placeholder)) echo '<p>' . $placeholder . '</p>';

            if ($description) echo '<p>' . $description . '</p>';

            if (!$is_valid) {
                echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
            }
            
            echo '<div class="input-group">';
            echo '<span class="input-group-label">' . d1g1_get_svg(D1G1_URLSLUG . "assets/icons/link-line.svg") . '</span>';
            echo  $floating_label_start;

            echo '<input type="url" id="d1g1-media-url" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />';

            if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

            echo $floating_label_end ;

            echo '<a href="#" id="d1g1-media-upload" class="button">' . d1g1_get_svg(D1G1_URLSLUG . "assets/icons/upload-cloud-line.svg") . 'Nahrát</a>';


            echo '</div>';

            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
            
            if ($value) {
                echo '<p><div class=upload-img-preview>';
                echo '<img src="' . $value . '" width="300" height="200" alt="alt">';
                echo '<a href="#" class="button white icon">' . d1g1_get_svg(D1G1_URLSLUG . "assets/icons/trash-line.svg") . 'Odstranit</a>';
                echo '</div></p>';
            }
        }

         /**
         * html radio_large input
         * 
         * @param : $args, 
         * $type
         * $description
         * $is_valid 
         * $value 
         * $name 
         * $atts 
         * $help_text
         * 
         * @author digihood
         * @return true/false
         */ 

        private function get_radio_large_input($args, $type, $description, $is_valid, $value, $name, $atts, $help_text){
            $options = isset($args['options']) ? $args['options'] : [];

            if ($type == 'radio_large') {
                $class = 'radio-large ' . $class;
            }

            if (!empty($options)) {

                if ($description) echo '<p>' . $description . '</p>';

                if (!$is_valid) {
                    echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                }
                
                echo '<div class="radio-wrap">';

                //echo '<input type="' . $type . '" value=""  name="' . $name .'" checked class="hide"> ';
                foreach ($options as $option_key => $option_name) {
                    if ($option_key != '' && $option_name != '') {
                        $checked = $option_key == $value ? 'checked' : '';

                        echo '<label class="radio ' . $class . '">';
                        echo '<input type="radio" value="' . $option_key . '"  name="' . $name . '" ' . $checked . ' ' . $atts . '> ';
                        echo '<span class="checkmark"></span>';

                        if ($type == 'radio_large') echo '<h3>';
                        echo is_array($option_name)?  $option_name[0] :  $option_name ;
                        if ($type == 'radio_large') echo '</h3>';
                        echo is_array($option_name)? '<p class="help-text">' . $option_name[1] . '</p>' : '' ;

                        echo '</label>';
                    }
                }

                echo '</div>';

                if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

            }
        }

         /**
         * html checkbox large
         * 
         * @param : 
         * $args
         * $type
         * $name 
         * $label
         * $class
         * $value,
         * $required 
         * $is_valid
         * $description
         * $help_text
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_checkbox_large_input($args, $type, $name, $label, $class,$required, $is_valid, $description, $help_text ,$form){
            $label = isset($args['label']) ? $args['label'] : false;
            //$checked = (!empty($value) ? 'checked' : "");
            if ($type == 'checkbox_large') {
                $class = 'checkbox-large ' . $class;
            }
            $options = isset($args['options']) ? $args['options'] : [];
            $value = ($this->data->get_data($name,$form) ? $this->data->get_data($name,$form) : 0);
           
            
            if (empty($options)){
                $options[$name] = $label;
            }
        
            
            if ($label && $options)  {
                foreach ($options as $val => $text) {
                    $checked = ($value && in_array($val,$value) ? 'checked' : "");
                   
                    echo '<label class="checkbox ' . $class . '">';
                    echo '<input type="checkbox" value="' . $val . '"  name="' . $name. '['/*.$val*/ .']' . '" ' . $checked . ' ' . $atts . '>';
                    echo '<span class="checkmark"></span>';
                    if ($type == 'checkbox_large') echo '<h3>';
                    echo  $text . $required ;
                    if ($type == 'checkbox_large') echo '</h3>';
                    echo '</label>';
                 
                }
            };

            if (!$is_valid) {
                echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
            }

            if ($description) echo '<p>' . $description . '</p>';

            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

        }

         /**
         * html switch input 
         * @param : 
         * $name
         * $label
         * $value
         * $atts
         * $required 
         * $is_valid
         * $description
         * $help_text
         * 
         * @author digihood
         * @return true/false
         */ 

        private function get_switch_input($name, $label, $value , $atts, $required, $is_valid, $description, $help_text,$form){
            $value = ($this->data->get_data($name,$form) == 1 ? 0 : 1);
            $checked = ($this->data->get_data($name,$form) == 1 ? 'checked' : "");
           
            if ($label)  {
                echo '<label class="switch">';
                echo '<input type="checkbox" value="'.$value.'"  name="' . $name . '" ' . $checked . ' ' . $atts . '>';
                echo '<span class="slider"></span>';
                echo '<h3>' . $label . $required . '</h3></label>';
            };

            if (!$is_valid) {
                echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
            }

            if ($description) echo '<p>' . $description . '</p>';

            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

        }

         /**
         * html textarea input
         * 
         * @param : 
         * $args
         * $description 
         * $is_valid 
         * $floating_label_start
         * $type 
         * $name
         * $placeholder
         * $atts
         * $class
         * $value
         * $label
         * $required,
         * $floating_label_end
         * $help_text
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_textarea_input($args, $description, $is_valid, $floating_label_start, $type ,$name, $placeholder, $atts, $class, $value, $label, $required,$floating_label_end, $help_text ){
            $label = isset($args['label']) ? $args['label'] : false;
            if ($description) echo '<p>' . $description . '</p>';

            if (!$is_valid) {
                echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
            }

            echo $floating_label_start;

            echo '<textarea type="' . $type . '"  name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />' . $value . '</textarea>';
            if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
            echo $floating_label_end;

            if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

        }

         /**
         * html range input 
         * 
         * @param : 
         * $args
         * $name
         * $label
         * $required
         * $is_valid
         * $description
         * $value
         * $help_text
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_range_input($args, $name, $label, $required, $is_valid, $description, $value, $help_text){
            $max = isset($args['max']) ? 'max="' . $args['max'] . '" ' : '';
            $min = isset($args['min']) ? 'min="' . $args['min'] . '" ' : '';
            $step = isset($args['step']) ? 'step="' . $args['step'] . '" ' : '';
            $show_attr = isset($args['show_attr']) ? $args['show_attr'] : false;
            $unit = isset($args['unit']) ? $args['unit'] : '';
            $wrap_class = $unit ? 'val-right-large' : 'val-right';
            $wrap_class = $show_attr == true ? $wrap_class . ' show-attr' : $wrap_class;
            // přidání validace a uložení změny jednotek
            $validation_data = $this->session->getSession( $this->form_ID.'_validation' );
            $unit_value = ( $validation_data[$name.'_unit']['value'] ? $validation_data[$name.'_unit']['value'] : "");
            $unit_value = (empty($unit_value) && $this->data->get_data($name.'_unit') ? $this->data->get_data($name.'_unit') : $unit_value);

                
                if ($label) echo '<p>' . $label . $required . '</p>';

                if (!$is_valid) {
                    echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                }

                if ($description) echo '<p>' . $description . '</p>';

                echo '<div class="range-wrap ' . $wrap_class . '">';
                echo '<input name="' . $name . '" type="range" class="range" ' . $max . $min . $step . ' value="' . $value . '">';
                if ($unit) echo '<div class="input-group">';
                echo '<input class="outval small" type="number" ' . $max . $min . $step . ' value="' . $value . '" source="[name=' . $name . ']">';
                if (is_array($unit)){
                    echo '<div class="select-button small"><select name="'.$name.'_unit">';
                    foreach ($unit as $unit_key => $unit_name) {
                        echo '<option value="' . $unit_key . '" '.($unit_key == $unit_value ? 'selected="selected"' : '').'>' . $unit_name . '</option>';
                    }
                    echo '</select></div>';
                } else {
                    echo '<span class="input-group-label">' . $unit . '</span>';
                }
                if ($unit) echo '</div>';
                echo '</div>';

                if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
        }


         /**
         * html editor input
         * 
         * @param :
         *  $name
         *  $class 
         *  $description
         *  $value
         *  $help_text 
         *  $args
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_editor_input($name, $class, $description, $value, $help_text, $args){
                   // $class = $name;
                    
                    $settings =   array(
                        'wpautop' => true, // use wpautop?
                        'media_buttons' => false, // show insert/upload button(s)
                        'textarea_name' => $name, // set the textarea name to something different, square brackets [] can be used here
                        'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                        'tabindex' => '',
                        'editor_css' => '<style>.wp-core-ui .quicktags-toolbar input.button.button-small {
                           
                            width: 100px;
                          
                        }</style>', //  extra styles for both visual and HTML editors buttons,
                        'editor_class' => $class, // add extra class(es) to the editor textarea
                        'teeny' => false, // output the minimal editor config used in Press This
                        'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                        'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                    );
    
                    if ($description) echo '<p>' . $description . '</p>';
    
                    $editor_id = str_replace(']', '', str_replace('[', '', $name));
                    wp_editor($value, $editor_id, $settings);
    
                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
    
                    if (isset($args['length']) && $args['length']) {
                        echo "<p>Počet znaků: <span class='word-count' data-fieldname='" . $name . "' id='word-length-" . $name . "'>" . $this->valid_leght_string($value) . "</span>  / " . $args['length'] . '</p>';
                    }
    
                    //$editor_counter++;
        }

         /**
         * html week input
         * @param : 
         * $args
         * $type
         * $description
         * $is_valid
         * $floating_label_start
         * $name
         * $value
         * $label
         * $required
         * $floating_label_end 
         * $help_text
         * 
         * @author digihood
         * @return echo 
         */ 

        private function get_week_input($args, $type, $description, $is_valid, $floating_label_start, $name, $value, $label, $required, $floating_label_end, $help_text){
            $label = isset($args['label']) ? $args['label'] : false;
            /*if ($type == 'date') {
                        $now = date("Y-m-d");
                        (empty($value) ? $value = $now : '');
                        $value = date("Y-m-d", strtotime($value));
                    }*/

                    $icon = $type == 'time' ? "assets/icons/clock-line.svg" : "assets/icons/calendar-line.svg";

                    if ($description) echo '<p>' . $description . '</p>';
                    
                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    echo '<div class="input-group">';
                    echo '<span class="input-group-label">' . d1g1_get_svg(D1G1_URLSLUG . $icon) . '</span>';
                    echo $floating_label_start;
                    echo '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '">';
                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
                    echo $floating_label_end;
                    echo '</div>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

        }

         /**
         * html color input
         * 
         * @param : 
         * $args
         * $required
         * $description
         * $is_valid
         * $name
         * $value
         * $help_text
         * 
         * @author digihood
         * @return echo 
         */ 

        private function get_color_input($args, $required, $description, $is_valid, $name, $value, $help_text){
            $default = isset($args['value']) ? $args['value'] : '';
            $label = isset($args['label']) ? $args['label'] : false;

                if ($label)  echo '<p>' . $label . $required . '</p>';
                if ($description) echo '<p>' . $description . '</p>';

                if (!$is_valid) {
                    echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                }

                echo '<p><input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="' . $default . '" id="' . $name . '" name="' . $name . '" value="' . $value . '"></p>';

                if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
        }

         /**
         * html warring box input
         * @param : 
         * $args
         * $type 
         * $description
         * 
         * @author digihood
         * @return echo
         */ 


        private function get_warring_box_input($args, $type, $description){
             // Box s informací nebo varováním

             $headline = isset($args['headline']) ? $args['headline'] : false;
             $warning = $type == 'warning_box' ? ' warning' : '';
             $icon = $type == 'warning_box' ? 'assets/icons/warning-standard-line.svg' : 'assets/icons/info-standard-line.svg';


             echo '<div class="info-block' . $warning . '">';

             echo '<span class="icon">' . d1g1_get_svg(D1G1_URLSLUG . $icon) . '</span>';

             if ($headline) echo '<h3>' . $headline . '</h3>';
             if ($description) echo '<p>' . $description . '</p>';

             echo '</div>';
        }

         /**
         * html html input
         * @param : args
         * 
         * @author digihood
         * @return echo
         */ 

        private function get_html_input ($args){
             // Vlasní html obsah

             $content = isset($args['content']) ? $args['content'] : false;

             echo $content;
        }

         /**
         * Zobrazování formuláře pro cpt
         *
         * @param $data - array načtení polí z forms builderu
         * 
         * @author digihood
         * @return true/false
         */ 
        function get_html_form_cpt($data){
            global $post;
            if ($data){
                ?>
                <div class="d1g1-admin">
                    <div class="form-section">
                        <?php
                        foreach ($data as $field) {
                            if ($field && is_array($field)) {
                                $type = $field['type'];
                                $name = $field['name'];
                                $label = $field['label'];
                                $value = ($post && isset($post->ID) ? get_post_meta($post->ID, $name, true) : "");
                                ?>
                                <div class="form-item">
                                    <p><label for="<?= $name ?>" class="d1g1_post_meta_label"><?= $label ?></label></p>
                                    <?php 
                                    $this->get_input_html($type, $name, $value,$field,$this->form_ID); ?>
                                </div>
                                <?php
                                

                            }
                        }?>
                    </div>
                </div>
                <?php
            }

        }

   

    }
    new \pluginbrandslug\framework\gethtmlform\d1g1GetHtmlform;
}