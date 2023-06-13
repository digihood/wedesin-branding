<?php 
namespace pluginone\framework\pluginAdmin\Menu;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1SubMenu' ) )

{
    /**
     * Hlavní menu pluginu
     * 
     */
    class d1g1SubMenu

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
            add_action( 'admin_menu',  [$this, 'submenus_callback'] );
        }

        /**
         * Přidává stránku nastavení digihood pluginů do adminu
         *
         * @param none
         * 
         * @author digihood
         */ 
        public function submenus_callback() {
            $submenus = [
                [
                    'd1g1-plugins',                              
                    __( D1G1_PLUGNAME_pluginone, D1G1_PLUGNAME_pluginone ),                    
                    __(D1G1_PLUGNAME_pluginone, D1G1_PLUGNAME_pluginone),               
                    'manage_options',                           
                    D1G1_PLUGINIDONE,                              
                    [d1d1SubMenuContent::class, 'my_admin_page_contents']
                           
                ]
            ];
            if ( !empty( $submenus ) ) {
                foreach ( $submenus as $submenu ) {
                    add_submenu_page(
                        $submenu[0],
                        $submenu[1],
                        $submenu[2],
                        $submenu[3],
                        $submenu[4],
                        $submenu[5]
                    );
                }
            }             
            
        }

    }

	new d1g1SubMenu;

}

