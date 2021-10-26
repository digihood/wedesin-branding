<?php 
namespace pluginbrandslug\components\formfunction;




/**
 * Popis třídy
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

   



if( ! class_exists( 'D1G1FormFunction' ) )
{
	class D1G1FormFunction 
	{
       private $fields;
       private $session;
      
		public function __construct($field_list = [])
		{
            $this->fields = $field_list;
            
         //   add_action( 'd1g1_test', [$this,''] );
        
         add_action( 'd1g1_form_save_option_hook', [$this,'d1g1_mail_send'],10,3);

        
        }

         /**
         * Odeslat email s aktualizací
         *
         * @author digihood
         * @return true/false
         */ 

 
            // add_action('digi_test','d1g1_testfefe');

            public function d1g1_mail_send( $formID , $inputs , $fields) {
                
                $this->fields = $fields;
                if($this->fields[0]['save_option'] == 'send_mail'){
                   // preprint($this->fields[0]['save_option']);
                    //die();
                    $this->session = new \pluginbrandslug\framework\sessions\sessionClassD1G1;       
                    $result = $this->send_update_email($inputs, $formID);              
                    if ($result) {
                        $this->session->addSession($formID . '_submit_res', 'true');                                                          
                    } else {
                        $this->session->addSession($formID . '_submit_res', 'false');
                    }

                    //$newUrl = add_query_arg(['submit' => 1], $inputs['_wp_http_referer']);  
                   // wp_safe_redirect($inputs['_wp_http_referer']);
                    exit();
                }
                
             }
         

        function send_update_email($inputs, $formID){
            $mail = get_option('_d1g1_D1G1BRAND_brand_emails_settings_send_to_email',false);
            if (empty($mail)) {
                $mail = get_option( 'admin_email' );
            }
            $content = $this->update_email_content($inputs);
            $footer = __('Děkujeme, že využíváte naše služby. V případě problémů s aktualizací se na nás neprodleně obraťte na emailu <a href="mailto:jan@wedesin.cz">jan@wedesin.cz</a>', D1G1_BRANDING);
            $subject = get_option('_d1g1_D1G1BRAND_brand_emails_settings_license_email_subject','');
            if (empty($subject)) $subject = __('Aktualizovali jsme váš web', D1G1_BRANDING);
            $email = new \pluginbrandslug\framework\emails\d1g1SendEmailBrand;
            //zde zprovoznit emaily
            $text = $email->email_content('Aktualizace webu', array($content),$footer );
            //uložení aktualizace
            $this->session = new \pluginbrandslug\framework\sessions\sessionClassD1G1;
            $this->save_update_data($inputs);
            if ($this->save_update_data($inputs)) {
                $email->send_client_emails($mail, $subject ,$text);
                $this->session->addSession($formID . '_save', 'success');
            } else {
                $this->session->addSession($formID . '_save', 'fail');
            }
            wp_safe_redirect($inputs['_wp_http_referer']);
            exit;
        }

        public function save_update_data($inputs){
            $update_list = get_option('_d1g1_list', []);
            $new = $this->update_list($inputs);
            if($new) {
                $update_list[strtotime('now')] = array(
                    'user'=> get_current_user_id(),
                    'update'=> $new
                );
                update_option('_d1g1_list',$update_list);
                return true;
            } else{
                return false;
            }



        }
        
        public function update_list($inputs) {
            global $wp_version;
            $content = '';
            if(isset($inputs['up_wp']) && !empty($inputs['up_wp'])) {
                if ($wp_version){
                    $content .= __('Wordpress aktualizován na verzi', 'D1G1BRAND').' '. $wp_version.'<br>';
                }else {
                    $content .= __('Wordpress aktualizován na nejnovější verzi', 'D1G1BRAND').'<br>';
                } 
            }
            if(isset($inputs['up_theme']) && !empty($inputs['up_theme'])) {
                $content .= __('Šablona byla aktualizován na nejnovější verzi', 'D1G1BRAND').'<br>';
            }
            if(isset($inputs['up_settings']) && !empty($inputs['up_settings'])) {
                $content .= __('Na webu jsme aktualizovali nastavení webu (zabezpečení, zálohy, php, nastavení eshopu)', 'D1G1BRAND').'<br>';
            }
            if(isset($inputs['up_plugins']) && !empty($inputs['up_plugins'])) {
                $content .= '<p><b>'. __('Aktualizované pluginy', 'D1G1BRAND').':</b></p>';
                $plugins_list = get_plugins();
                foreach ($inputs['up_plugins'] as $key => $value) {
                    if(array_key_exists($value, $plugins_list )){
                        if (isset($plugins_list[$value])){
                            $name = (isset($plugins_list[$value]['Name'])? $plugins_list[$value]['Name'] : '');
                            $version = (isset($plugins_list[$value]['Version'])? $plugins_list[$value]['Version'] : '');
                            if ($name && $version) {
                                $content .= $name . ' '. __('Aktualizováno na verzi', 'D1G1BRAND'). ' '. $version. '<br>';
                            }
                        }
                    }
                }
            }
            if(isset($inputs['up_content']) && !empty($inputs['up_content'])) {
                $content .= '<p><b>'.__('Poznámka k aktualizaci', 'D1G1BRAND').'</b></p>';
                $content .= '<div>'.$inputs['up_content'].'</div>';
            }
            return $content;

        }
        public function url_without_http() {
            $http = substr(get_home_url(), 0, 5);
                if ($http == 'https'){
                    return str_replace('https://','',''.get_home_url().'');
                }else {
                    return str_replace('http://','',''.get_home_url().'');
                }

        }

        public function update_email_content($inputs) {
            $text = get_option('_d1g1_D1G1BRAND_brand_emails_settings_mail_text_license_d1g1',false);
            $content = __('Dobrý den', 'D1G1BRAND').',<br><br>';
            $content .= __('právě jsme aktualizovali Váš web', 'D1G1BRAND').' <a href="'.get_home_url().'">'.$this->url_without_http().'</a>.<br><br>';
            if ($text) $content .= $text;
            $content .= '<h3>'.__('Přehled aktualizací:', 'D1G1BRAND').'</h3>';
            $content .= $this->update_list($inputs);
            return $content;

        }
      

       
    }
    new \pluginbrandslug\components\formfunction\D1G1FormFunction;
}