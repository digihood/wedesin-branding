<?php 
/**
 * class description
 *
 * 
 * @author digihood
 */ 
namespace pluginbrandslug\framework\sessions;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'sessionClassD1G1' ) )
{
	class sessionClassD1G1
	{
        private $default_mess_succ;
        private $default_mess_error;

		public function __construct()
		{
            $this->default_mess_succ = __("Nastavení bylo úspěšně aktualizováno", D1G1_BRANDING);
            $this->default_mess_error = __("Nastavení se nepodařilo uložit. Zkuste to, prosím, znovu.", D1G1_BRANDING);
            if(!session_id()) session_start();
        }

        /**
         * Vytvoření session
         *
         * @param $name = jméno session
         * @param $value = hodnota
         * 
         * @author digihood
         * @return true/false
         */ 
        public function addSession( $name, $value="" ) 
        {
            $_SESSION[$name] = $value;
            return true;
        }

        /**
         * Kontrola session
         *
         * @param $name = jméno session
         * @param $value = hodnota
         * 
         * @author digihood
         * @return true/false
         */ 
        public function checkSession( $name, $value="" ) 
        {
            if ( isset( $_SESSION[$name] ) ) 
            {

                if ( $value !== "" ) 
                {

                    if ( $_SESSION[$name] == $value ) 
                    {
                        return true;
                    }                    

                } else {

                    if ( $_SESSION[$name] == 'error' || $_SESSION[$name] == 'success' || $_SESSION[$name] == 'fail') 
                    {

                        return true;

                    } else {
                        
                    }

                }

            }

            return false;

        }

        /**
         * Získat session
         *
         * @param $name = jméno session
         * 
         * @author digihood
         * @return true/false
         */ 
        public function getSession( $name ) 
        {
            
            if ( isset( $_SESSION[$name] ) ) 
            {
                return $_SESSION[$name];
            }

            return false;

        }

        /**
         * Odebrat session
         *
         * @param $name = jméno session
         * 
         * @author digihood
         * @return true/false
         */ 
        public function removeSession( $name ) 
        {
            if ( isset( $_SESSION[$name] ) ) 
            {
                unset($_SESSION[$name]);
                return true;
            }

            return false;
        }

        /**
         * kontrola aktivace sessin
         *
         * @param $name = jméno session
         * 
         * @author digihood
         * @return true/false
         */ 
        public function chceckallsesion() {

            if (isset($_SESSION)){
                
                return $_SESSION;
                }
                echo 'neni sessions';
                
        }

        /**
         * přidat zprávu
         *
         * @param $message = obsah zprávy
         * @param $errormsq = zda je to chybová hláška
         * 
         * @author digihood
         * @return true/false
         */ 
        function showMessage($session, $mess)
        {
            $type = 'success';
            $class = 'notice-success';
            if ( $this->checkSession($session)) {
                if ($this->getSession($session) == 'fail' || $this->getSession($session) == 'error'){
                    $class = 'notice-error';
                    $type = $this->getSession($session);
                }else if ($this->getSession($session) == 'warning') {
                    $class = 'notice-warning';
                    $type = $this->getSession($session);
                }
                $content = $mess[$type];
                if(empty($content)) $content = $this->default_message($type);
                echo '<div class="notice '.$class.' d1g1-notice is-dismissible">'. 
                    '<p>'.$content.'</p>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">'.__('Skrýt toto upozornění.', D1G1_BRANDING).'</span></button>
                </div>';
                // echo '<div id="message" class="updated fade">';

            }
          
        } 
        /**
         * Vrátí základní zprávu, pokud není žádná vyplněná
         *
         * @param $type = Typ zprávy (success, error, fail)
         * 
         * @author digihood
         * @return string
         */ 
        public function default_message($type) {
            if ($type == 'success'){
                return $this->default_mess_succ;
            } else {
                return $this->default_mess_error;
            }
        }
        
        /**
         * zobrazi všechny session
         *
         * @param $form_ids = ID formuláře nebo jména sessions
         * 
         * @author digihood
         * @return true/false
         */ 
        public function display_notice($form_ids) {
            if ($form_ids){
                if (is_array($form_ids)) {
                    foreach ($form_ids as $form_id => $mess) {
                        $this->showMessage($form_id, $mess);
                    }
                }
            }
        }
            
    }
 }