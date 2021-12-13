<?php 
namespace pluginbrandslug\framework\feedback;
/**
 * field pro feedback
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1_field_fb' ) )
{
	class d1g1_field_fb
	{

        //private $variable; 

		public function __construct()
		{
           add_action( 'd1g1_submit_button_form', [$this,'button_feedback'], 10, 1 );
        }

        public function field_feedback(){
            $userdata = get_userdata(get_current_user_id());
            $username = $userdata->user_login;
            $useremail = $userdata->user_email;
            $dateregister = $userdata->user_registered;
            $userroles = $userdata->roles[0];
            $userphone = get_user_meta(get_current_user_id(),'billing_phone',true);
        
            

            $fields=[
                [
                    'headline' => 'Zpetná vazba ',
                    'description' => 'Váš názor je pro nás důležitý. Chtěli bychom vás poprosit o zpětnou reakci.',
                    'save_option' => 'send_feedback',
                    
                    [
                        'type' => 'text',
                        'name' => 'feedback_subject',
                        'saveAs' => 'meta',
                        'required' => false,
                        'label' => 'Předmět',
                    ],
                    [
                        'type' => 'editor',
                        'name' => 'feedback_content',
                        'saveAs' => 'meta',
                        'required' => true,
                        'label' => 'Obsah',
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'username',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => $username
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'usermail',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => $useremail
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'dateregister',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => $dateregister
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'userroles',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => $userroles
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'userphone',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => $userphone
                    ],
                    [
                        'type' => 'hidden',
                        'name' => 'licence',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => 'In construct'
                    ],
                ]
            ];
            return $fields;
        }

        public function button_feedback($formID){
          
                $button_text = 'Odeslat zpětnou vazbu';
              return  submit_button($button_text) ;
            
        }
    }
    // new d1g1_field_fb;
}