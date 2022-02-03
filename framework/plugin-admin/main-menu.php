<?php 
namespace pluginbrandslug\framework\mainMenu;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}
use pluginbrandslug\framework\pluginAdmin\pluginsHomePage\pluginsHomePageD1G1;
if( ! class_exists( 'mainMenuD1G1' ) )
{
    class mainMenuD1G1
	{
		//hook functions
		public function __construct()
		{
            add_action( 'admin_menu',  [$this, 'main_menu_callback'] );
            
        }

        /**
         * Přidává stránku nastavení digihood pluginů do adminu
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function main_menu_callback() {

            if (!isset( $GLOBALS['admin_page_hooks']['d1g1-plugins']) || empty( $GLOBALS['admin_page_hooks']['d1g1-plugins'] ) ) {
                add_menu_page(
                    __( 'WDS Plugins', TM_PLUGSEC ),
                    __( 'WDS Plugins', TM_PLUGSEC ),
                    'manage_options',
                    'd1g1-plugins',
                    array( $this, 'my_admin_page_contents' ),
                    'dashicons-admin-generic',
                    65
                );
        
            }
            
            
        }

        /**
         * Zobrazení hlavní admin stránky v adminu wordpressu
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        function my_admin_page_contents() {

            $homePageClass = new pluginsHomePageD1G1;
            $homePageClass->display_plugin_home();
        }

    }
	new mainMenuD1G1;
}
