<?php
namespace pluginbrandslug\framework\forms_core;
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('D1G1_Front_Form')) {
    class D1G1_Front_Form 
    {

        private $fields;
        private $session;
        private $prefix;
        private $form_ID;
        private $validation;

        public function __construct($field_list = [])
        {
            $this->fields = $field_list;
            $this->prefix = '_d1g1_'.D1G1_BRANDING.'_';

        
            //ukládání metadat do kuponu (licence)
            add_action('save_post', [$this, 'save_cpt_meta']);

            $this->session = new \pluginbrandslug\framework\sessions\sessionClassD1G1;
            $this->validation = new \pluginbrandslug\framework\form_validation\D1G1validform;
            
        }

        private function check_if_fields_has($var)
        {
            if (empty($this->fields)) {
                return false;
            }

            foreach ($this->fields as $index => $field) {
                if ($field['type'] == $var || $field['name'] == $var) {
                    return true;
                }
            }
            return false;
        }

        public function get_form($formID = 'd1g1_admin_form')
        {

            $return = "";
            $query = filter_input_array(INPUT_GET);

            ?>
            <div class="wrap d1g1-admin">

                <?php settings_errors(); ?>

                <div class="row">
                    <div class="content">

                        <!-- místo pro taby -->

                        <div class="content-box">

                            <span class="form-star"><small><?= __('* povinné pole', 'textdomain'); ?></small></span>

                            <form method="post" id="<?= $formID ?>_form" class="d1g1-form" action="<?php // the_permalink(); 
                                                                                                                    ?>" enctype="multipart/form-data" novalidate data-abide>
                                <?php wp_nonce_field( $formID, 'nonce_' . $formID ); ?>
                                <input type="hidden" value="<?=$formID?>" name="form_id_d1g1" />
                                <input type="hidden" value="<?= D1G1_BRANDING?>" name="plugin_id_d1g1" />                                                             
                                <?php $this->get_form_fields($formID); ?>

                                <?php  submit_button(); ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        private function get_form_field_index($fields, $key)
        {
            return array_keys(array_column($fields, 'saveAs'), $key);
        }

        private function get_form_field_count($fields, $key)
        {
            return count($this->get_form_field_index($fields, $key));
        }

        private function get_form_field_featuredImages_index($fields)
        {
            return array_keys(array_column($fields, 'useAsFeatured'), 1);
        }

        private function get_form_field_featuredImages_count($fields)
        {
            return count($this->get_form_field_featuredImages_index($fields));
        }

        private function get_field_type_from_name($name)
        {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ($field['name'] == $name) {
                        if (isset($this->fields[$index]['type'])) {
                            return $this->fields[$index]['type'];
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        public function get_fields($fields, $key)
        {
            $return_fields = [];
            $indexes = $this->get_form_field_index($fields, $key);
            if (is_array($indexes) && !empty($indexes)) {
                foreach ($indexes as $index) {
                    $return_fields[] = $fields[$index];
                }
            }
            return $return_fields;
        }

        public function get_field_parameter($name, $parameter)
        {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ($field['name'] == $name) {
                        if (isset($this->fields[$index][$parameter])) {
                            return $this->fields[$index][$parameter];
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        /**
         * 	Description
         *
         * 	@param $arg = fce define_arg_form();
         *
         * 	@author digihood
         * 	@return echo
         */
        public function get_form_fields($formID = null)
        {
           
            if (empty($this->fields)) {
                die('Fields must be set..');
            }

            // get index
            // run some tests, all this under should be only once
            if ($this->get_form_field_count($this->fields, 'post_title') > 1) {
                die('Fields contain more than 1 post_title.');
            }
            if ($this->get_form_field_count($this->fields, 'post_content') > 1) {
                die('Fields contain more than 1 post_content.');
            }
            if ($this->get_form_field_count($this->fields, 'post_excerpt') > 1) {
                die('Fields contain more than 1 post_excerpt.');
            }
            if ($this->get_form_field_featuredImages_count($this->fields) > 1) {
                die('Fields contain more than 1 featured image.');
            }
            
            $this->form_ID = $formID;
            $validation_data = $this->session->getSession( $formID.'_validation' );
            $save_progress = $this->session->getSession( $formID.'_save' );
            if($this->fields[0]['save_option'] !== 'send_mail'){
                if (isset($validation_data['allvalid']) && !$validation_data['allvalid']) {
            

                // $this->validation->d1g1_notice_form('error');

                } else if ( $save_progress == 'success') {
                
                // $this->validation->d1g1_notice_form('success');

                }
            }
            
           
            foreach ($this->fields as $section) {

                $section_headline = isset($section['headline']) ? $section['headline'] : false;
                $section_description = isset($section['description']) ? $section['description'] : false;

                //Vše v array fields jsou automaticky sekce formuláře
                echo '<div class="form-section">';

                if ($section_headline) echo '<h2>' . $section_headline . '</h2>';
                if ($section_description) echo '<p>' . $section_description . '</p>';

                //Pole formuláře v sekcích
                foreach ($section as $item => $field) {
                    // Pokud je ve formuláři columns, zobrazí se zde, pokud je nařadě
                    if ($item === 'columns') {
                        echo '<div class="row xl">';
                        $row = $field;
                        foreach ($row as $column) {
                           
                            //preprint($column);
                            echo '<div class="column">';

                            //Pole formuláře v gridu
                            foreach ($column as $subfield) {

                                $type = isset($subfield['type']) ? $subfield['type'] : false;
                                $name = isset($subfield['name']) ? $subfield['name'] : false;

                                if ($name && $type) {

                                    $is_valid = true;

                                    //nejdřív přidáme skrytá pole
                                    if ($type == 'hidden') {

                                        $value = isset($subfield['value']) ? $subfield['value'] : $this->get_data($name);
                                        $this->get_input_html($type, $name, $value, $subfield, $is_valid, $this->form_ID);
                                    } else { 
                                        $is_valid = isset($validation_data[$name]['valid']) ? $validation_data[$name]['valid'] : $is_valid; ?>
                                        <div class="form-item <?php echo $name; ?>">

                                        <?php 
                                            if ($this->get_data($name)) {
                                                $value = $this->get_data($name);
                                            }elseif(isset($field['value'])) {
                                                $value = $field['value'];
                                            } else {
                                                $value = "";
                                            }
                                            //preprint($value);
                                            $this->get_input_html($type, $name, $value, $subfield, $is_valid, $this->form_ID); ?>

                                        </div>

                                <?php
                                    }
                                }
                            }

                            echo '</div>';
                        }

                        echo '</div>';                       

                    }
                    $type = isset($field['type']) ? $field['type'] : false;
                    $name = isset($field['name']) ? $field['name'] : false;

                    if ($name && $type) {

                        $is_valid = true;

                        //nejdřív přidáme skrytá pole
                        if ($type == 'hidden') {
                            $value = isset($field['value']) ? $field['value'] : $this->get_data($name);
                            $this->get_input_html($type, $name, $value, $field, $is_valid, $this->form_ID);
                        } else { 
                            $is_valid = isset($validation_data[$name]['valid']) ? $validation_data[$name]['valid'] : $is_valid; ?>

                            <div class="form-item <?php echo $name; ?>">

                                <?php 
                                if (isset($validation_data[$name]['value'])) {
                                    $value = $validation_data[$name]['value'];
                                }else if ($this->get_data($name)) {
                                    $value = $this->get_data($name);
                                }elseif(isset($field['value'])) {
                                    $value = $field['value'];
                                } else {
                                    $value = "";
                                }
                                $this->get_input_html($type, $name, $value, $field, $is_valid, $this->form_ID); ?>

                            </div>
                        <?php
                        }
                    }
                }

                echo '</div>';
            }

            $this->session->removeSession($formID . '_validation');
        }

      

        public function get_input_html($type, $name, $value, $args = [], $is_valid = true, $form)
        {
            $gethtml = new \pluginbrandslug\framework\gethtmlform\d1g1GetHtmlform;
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

            switch ($type) {

                /**
                 * Input types
                 * -----------
                 * button           v rámci některých polí
                 * checkbox         nefunguje ukládání
                 * checkbox_large   nefunguje ukládání
                 * switch           nefunguje ukládání
                 * color            OK
                 * date             OK
                 * datetime-local   OK
                 * email            OK
                 * file
                 * hidden           OK
                 * image            OK upravit upload přes WP upload
                 * month            OK
                 * number           OK
                 * password         OK
                 * radio            OK
                 * radio_large      OK
                 * range            OK
                 * reset
                 * search
                 * select           OK doplnit o js
                 * submit           OK - wordpress
                 * tel              OK
                 * text             OK
                 * textarea         OK
                 * editor           OK
                 * time             OK
                 * url              OK
                 * week             OK
                 * info a warning box    OK
                 * custom html
                 */

                case 'email':
                case 'tel':
                case 'number':
                case 'password':
                case 'text':
                case 'hidden':
                    
                    $gethtml->getcaseform( $type ,$name, $value, $args , $is_valid);

                    break;

                case 'select':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid);
                    break;

                case 'url':
                    $gethtml->getcaseform($type,$name, $value, $args , $is_valid );
                    break;

                case 'image':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );

                    break;

                case 'radio':
                case 'radio_large':
                  $gethtml->getcaseform( $type,$name, $value, $args, $is_valid  );
                   
                    break;

                case 'checkbox':
                case 'checkbox_large':
                   $gethtml->getcaseform( $type,$name, $value, $args , $is_valid,$form);
                    break;

                case 'switch':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid ,$form);
                    break;

                case 'textarea':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                   
                    break;

                case 'range':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                        break;

                case 'editor':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                  
                    break;

                case 'date':
                case 'datetime-local':
                case 'time':
                case 'month':
                case 'week':

                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );

                    break;

                case 'color':

                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                    break;

                case 'info_box':
                case 'warning_box':
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                    break;

                case 'html':
                  
                    $gethtml->getcaseform( $type,$name, $value, $args , $is_valid );
                    break;

                default:
                    # code...
                    break;
            }
        }

        public function save_form()
        { 
            
            $inputs = filter_input_array(INPUT_POST);
            if (!isset($inputs['form_id_d1g1']) || $inputs['form_id_d1g1'] == '') {
                return;
            }
           // preprint($inputs);
            $formID = $inputs['form_id_d1g1'];
            $this->form_ID = $formID;
            //die();
            if (isset($inputs['nonce_' . $formID]) && wp_verify_nonce($inputs['nonce_' . $formID], $formID)) {
                //validace polí
              //  die('test některých polí');
                if (!$this->validate_fields($inputs, $formID)) {
                    $this->session->addSession($formID . '_save', 'fail');
                    wp_safe_redirect($inputs['_wp_http_referer']);
                    exit;
                }
                //honeypot pole
                if ((isset($inputs['d1g1_meta']['name']) && $inputs['d1g1_meta']['name'] !== "") || (isset($inputs['d1g1_meta']['surname']) && $inputs['d1g1_meta']['surname'] !== "")) {
                    exit;
                }
                
                if (isset($this->fields) && isset($this->fields[0])) {
                    //preprint($this->fields);
                   //die(); 
                    // zde můžeme upravovat jak se má soubor zpracovávat
                    if (array_key_exists('save_option',$this->fields[0])){
                        
                        do_action('d1g1_form_save_option_hook', $formID , $inputs , $this->fields );

                        wp_safe_redirect($inputs['_wp_http_referer']);
                    //defaultní zpracování formuláře
                    }else {
                         
                        $metas = $inputs;
                        $validation_data = $this->session->getSession( $this->form_ID.'_validation' );
                      
                        // Doplnění dat z odškrtnutých checkboxů
                        
                        foreach ($validation_data as $input_name => $input_data) {
                                if ( isset($input_data['type']) && (
                                    $input_data['type'] == 'checkbox' || 
                                    $input_data['type'] == 'switch' || 
                                    $input_data['type'] == 'checkbox_large' )
                                    
                                ){
                                    if (empty($input_data['value']) ) {
                                        
                                        $metas[$input_name] = 0;
                                    }
                                }
                        }
                       
                        //vyhodit hodnoty, které se nemají uložit
                        if(isset($metas['_wp_http_referer'])) unset($metas['_wp_http_referer']);
                        if(isset($metas['form_id_d1g1'])) unset($metas['form_id_d1g1']);
                        if(isset($metas['submit'])) unset($metas['submit']);
                        if(isset($metas['nonce_' . $formID])) unset($metas['nonce_' . $formID]);
                         
                        //zde budeme zpracovávat ukládání hodnot
                            if ($metas && !empty($metas)) {
                                
                                foreach ($metas as $meta_key => $meta_value) {
                                
                                    if($meta_key)
                                        $this->save_data($meta_key, $meta_value);
                                    
                                }
                                // remove field validation data
                                $this->session->removeSession($formID . '_validation');
                                // add "all good and saved" notice
                                $this->session->addSession($formID . '_save', 'success');
                                $newUrl = add_query_arg(['submit' => 1], $inputs['_wp_http_referer']);
                                wp_safe_redirect($newUrl);
                                exit;
                                } 
                    }  
                    
                }   
                $this->session->addSession($formID . '_save', 'fail');
                wp_safe_redirect($inputs['_wp_http_referer']);
                exit;
                die('Nastala chyba');
            }
        }
        public function save_data($key, $value) {
            $id = ($this->form_ID ? $this->form_ID : 'default');
            $pref = $this->prefix;
            $name = $pref. $id.'_'. $key;
            update_option($name, $value, false);
        }
        public function get_data($key,$form = '') {
            if($form !== ''){
                $id = $form;
            }else{
                $id = ($this->form_ID ? $this->form_ID : 'default');
            }
            $pref = $this->prefix;
            $name = $pref. $id.'_'. $key;  
            $value = get_option($name, false);
            return $value;
        }

        public function validate_fields($inputs, $formID)
        {
            if (empty($this->fields)) {
              //  preprint($this->fields);
                die('Fields must be set...');
            }
            $fields_all = $this->fields; // všechny pole formuláře
            $ffv = []; // pole určené k validaci
           
            $allvalid = true;

            $validated = [];
            foreach ($fields_all as $sections) {
                //data jsou v sekcích, ty postupně budu kontrolovat
                //preprint($sections);
                foreach ($sections as $key => $section_field) {
                    
                    if (is_numeric($key) ) { // pokud je pole s hodnotami ( mohou obsahovat pole k validaci, ale nemusí)

                        if (is_array($section_field) && array_key_exists('saveAs', $section_field))

                            $ffv[] = $section_field; // pokud je pole určené k uložení, přidám ho do pole pro validaci

                    } else if($key == 'columns') { //pokud se jedná o sloupce
                        if(is_array($section_field)) {
                            foreach ($section_field as $column) {
                                if (is_array($column)){
                                    foreach ($column as $key => $col_field) {
                                        if (is_array($col_field) && array_key_exists('saveAs', $col_field)) {
                                            $ffv[] = $col_field; // pokud je pole určené k uložení, přidám ho do pole pro validaci
                                        }
                                    }
                                }
                            }
                        }
                    } else { 
                        //v tutu chvíli nepodstatné - nejsou tam pole k validaci, třeba se to změní v budoucnu
                    }
                }
            }
            foreach ($ffv as $index => $field) {
                $value = '';
                $valid = true;
                $msg = '';

                $type = isset($field['type']) ? $field['type'] : false;
                $name = isset($field['name']) ? $field['name'] : false;
                $name = $type == 'gallery' ? 'gallery_' . $name : $name;
                $required = isset($field['required']) ? $field['required'] : false;

                switch ($field['saveAs']) {
                    case 'meta':
                        $value = isset($inputs[$name]) ? $inputs[$name] : null;
                        break;
                    /*case 'taxonomy':
                        $value = isset($inputs['d1g1_taxonomy'][$name]) ? $inputs['d1g1_taxonomy'][$name] : null;
                        break;
                    case 'post_title':
                    case 'post_content':
                    case 'post_excerpt':
                        $value = isset($inputs[$field['saveAs']]) ? $inputs[$field['saveAs']] : null;
                        break;*/
                    default:
                        $value = isset($inputs[$name]) ? $inputs[$name] : null;
                }

                if ($required) {
                   $this->validation->d1g1_if_required($value);
                   
                }

                if (isset($field['length'])) {
                   $this->validation->d1g1_length_valid($value);
                }

                //validate emails
                if ($type == 'email') {

                   $this->validation->d1g1_email_valid($value);

                }
                //validate range unit
                if ($type == 'range') {
                  $this->validation->d1g1_range_valid($input,$name);
                
                }

                $validated[$name] = [
                    'value' => $value,
                    'valid' => $valid,
                    'msg' => $msg,
                    'type' => $type
                ];
            }
            $validated['allvalid'] = $allvalid;
            $this->session->addSession($formID . '_validation', $validated);
            return $allvalid;
        }

   
       
        /**
         * Ukládání polí do meta v cpt
         *
         * 
         * @author digihood
         * @return true/false
         */ 
        function save_cpt_meta(){
            global $post;
            if ($post && isset($post->post_type) && !empty($post->post_type)){
                $builder = new \pluginbrandslug\framework\forms_builder\formsBuilderD1G1;
                $all_fields = $builder->get_fields_cpt_form($post->post_type);
                if (!empty($all_fields)) {
                    foreach ($all_fields as $field) {
                        $name = $field['name'];
                        if ($field && isset($name) && isset($post->ID) && isset($_POST[$name])) {
                            update_post_meta($post->ID, $name, $_POST[$name]);
                        }
                    }
                }

            }
        }
    }

    new \pluginbrandslug\framework\forms_core\D1G1_Front_Form;
}
