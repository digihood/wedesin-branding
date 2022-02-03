<?php 
namespace pluginbrandslug\framework\feedback;
/**
 * feedback
 *
 * 
 * @author Wedesin
 */ 
use pluginbrandslug\framework\sessions\sessionClassD1G1;
use pluginbrandslug\framework\monolog\log_function\d1g1_monolog;


if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1_feedback' ) )
{
	class d1g1_feedback
	{

        private $fields;
        private $session;
      
		public function __construct($field_list = [])
		{
            $this->fields = $field_list;
            $this->session = new sessionClassD1G1;
           
        
         add_action( 'd1g1_form_save_option_hook', [$this,'d1g1_feedback_send'],10 , 3);

        }

        public function d1g1_feedback_send($formID , $inputs , $fields){
            if($inputs['plugin_id_d1g1'] === D1G1_BRANDING){
                $this->fields = $fields;
                if($this->fields[0]['save_option'] == 'send_feedback'){
                    
                    $plugin = get_plugin_data(D1G1_BRANDPATH . '/setup.php');
                
                    if(isset($this->fields[0][3]['value']) && $this->fields[0][3]['value']){
                        $replymail = $this->fields[0][3]['value'];
                    }else {
                        $replymail = '';
                    }
                    
                    $result = $this->send_feedback_email($inputs, $formID,$plugin,$replymail);    
                
                    if ($result) {
                        $this->session->addSession($formID . '_submit_res', 'true');
                                                                        
                    } else {
                    
                        $this->session->addSession($formID . '_submit_res', 'false');
                    }
                    exit();
                }
            }
        }
       private function send_feedback_email($inputs, $formID, $plugin , $replymail){
            $mail1 = 'milan@wedesin.cz';
            $mail2 = 'filip@wedesin.cz';
            $settingscss = [];
            $content = $this->feedback_content($inputs,$plugin);
            $footer = __('', D1G1_BRANDING);
            $log = new d1g1_monolog;
            if ($inputs['feedback_subject']) {
                $subject = $inputs['feedback_subject'];
            }else{
                $subject = __('Feedback na plugin  ' . $plugin['Name'] . '', D1G1_BRANDING);
            }
            
          
            $email = new \D1G1SendEmail($settingscss,$replymail);
            //zde zprovoznit emaily
            
            $text = $email->email_content('Feedback', array($content),$footer );
           
            //uložení aktualizace
           
           
           
            if ($inputs && $subject && $inputs['feedback_content']) {
                
                $array = [
                    /*'feedback pred odeslanim mailu  na '.$mail1 .' a ' . $mail2 .''*/
                ];
                $log->d1g1_add_log(__METHOD__,'INFO', $formID . 'success', $array); 
               
                $email->send_client_emails($mail1, $subject ,$text);
                $email->send_client_emails($mail2, $subject ,$text);
                $this->session->addSession($formID . '_save', ' success');
                
            } else {
                $array = [
                    /*'feedback pred odeslanim mailu  na '.$mail1 .' a ' . $mail2 .''*/
                ];
                $log->d1g1_add_log(__METHOD__,'ERROR', $formID . ' fail', $array); 
               
                $this->session->addSession($formID . '_save', 'fail');
            }
          
            
            wp_safe_redirect($inputs['_wp_http_referer']);
            exit;
        }

        public function feedback_content($inputs,$plugin) {
            
            $content = __('Feedback z webu <a href="'.get_home_url().'">'.get_home_url().'</a> na plugin <b>'. $plugin['Name'] . '</b>'  , D1G1_BRANDING).'<br><br>';
            $content .= __('Od uživatele : '. $inputs['username'], 'D1G1BRAND').'<br><br>';
            $content .= __('Uživatelský email  : '. $inputs['usermail'], 'D1G1BRAND').'<br><br>';
            if($inputs['userphone']){
                $content .= __('Telefon uživatele : '. $inputs['userphone'], 'D1G1BRAND').'<br><br>';
            }
            $content .= __('Uživatel se registroval :'. $inputs['dateregister'], 'D1G1BRAND').'<br><br>';
            $content .= __('Role uživatele  : '. $inputs['userroles'], 'D1G1BRAND').'<br><br>';
            $content .= __('Plugin : '. $plugin['Name'], 'D1G1BRAND').'<br><br>';
            $content .= __('Plugin Version  : '. $plugin['Version'], 'D1G1BRAND').'<br><br>';
            if(isset($inputs['licence']) && $inputs['licence']){
                $content .= __('Plugin Licence  : '. $inputs['licence'], 'D1G1BRAND').'<br><br>';
            }
           
            $content .= '<h3>'.__('feedback : ', 'D1G1BRAND').'</h3>';
            $content .= $inputs['feedback_content'];
            return $content;

        }

        public function d1g1_feedback_session(){
            $sessins_list = [
                'feedback_save' => [
                    'fail' => __("Při odesílaní Zpětné vazby došlo k chybě, vyplnili jste obsah ??", D1G1_BRANDING), 
                    'success' => __("Zpětná vazba odeslána", D1G1_BRANDING)
                ],
            ];
            if(isset($_SESSION['feedback_save']) && $_SESSION['feedback_save'] ){
                $this->session->display_notice($sessins_list);
                settings_errors();
                $this->session->removeSession('feedback_save');
                
             }  
        }

    }

 new d1g1_feedback;
}