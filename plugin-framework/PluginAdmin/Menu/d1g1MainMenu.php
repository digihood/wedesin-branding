<?php 
namespace pluginone\framework\PluginAdmin\Menu;
use pluginone\framework\globals;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if( ! class_exists( 'd1g1MainMenu' ) )
{

    /**
     * Hlavní menu pluginu
     * 
     * @author digihood
     */

    class d1g1MainMenu
	{

        /**
         * Konstruktor
         *
         * @param none
         * @return none
         * 
         */
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
         * @return bool
         */ 
        public function main_menu_callback() {
            if (!isset( $GLOBALS['admin_page_hooks']['d1g1-plugins']) || empty( $GLOBALS['admin_page_hooks']['d1g1-plugins'] ) ) {
                add_menu_page(
                    __( 'Digi Plugins', globals::$FWDIGI_PLUGINID ),
                    __( 'Digi Plugins', globals::$FWDIGI_PLUGINID ),
                    'manage_options',
                    'd1g1-plugins',
                    array( $this, 'my_admin_page_contents' ),
                    'dashicons-admin-generic',
                    65
                );
        
            }
            
            
        }

        /**
         * obsah hlavní admin stránky v adminu wordpressu
         *
         * @param none
         * 
         * @author digihood
         */ 
        static function my_admin_page_contents() {


        }

    }
	new d1g1MainMenu;
}
