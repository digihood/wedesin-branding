<?php

/**
 * Vlastní styly pluginu
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( !class_exists('AdminUpdatesWDS') ) {

    class AdminUpdatesWDS {

        /**
         * 
         * Constructor
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @return	void
         */
        public function __construct()
        {
    
            //add description
			add_filter('admin_footer_text', [$this,'wedesin_remove_footer_admin'] );
            //change login url
			add_filter( 'login_headerurl', [$this,'wedesin_homepage_url'] );
        
        }
    
        /**
         * 
         * Constructor
         *
         * @date	21/1/21
         * @since	2.0
         *
         * @return	echo
         */
        public function wedesin_remove_footer_admin () {

			if ( is_eng_wds( ) ) {
				echo '<p>Website by <a href="https://www.wedesin.cz/en/" target="_blank">WeDesIn</a>. If you have any questions, please send an email to <a href="mailto:info@wedesin.cz" target="_blank">info@wedesin.cz</a>.';
			} else {
				echo '<p>Webové stránky vytvořil <a href="https://www.wedesin.cz/" target="_blank">WeDesIn</a>. Pokud máte jakékoliv otázky, napište na <a href="mailto:info@wedesin.cz" target="_blank">info@wedesin.cz</a>.';
			}

		} 

        /**
         * 
         * Přidá odkaz na domácí stránky
         * @since	2.0
         *
         * @return	string
         */
        public function wedesin_homepage_url() {
			return 'https://www.wedesin.cz/';
		}
    
    }
    
    new AdminUpdatesWDS;

}
