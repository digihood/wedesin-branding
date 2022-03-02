<?php 
namespace pluginbrandslug\admin\submenu;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'subMenuD1G1' ) )

{
    class subMenuD1G1

	{
		//hook functions

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
         * @return true/false
         */ 
        public function submenus_callback() {

            /*https://developer.wordpress.org/reference/functions/add_submenu_page/
            1) slub nadřazené položky menu
            2) titulek stránky
            3) menu stránky
            4) pravomoce
            5) menu slug
            6) callback na přidání obsahu
            */

            $subcontent = new \pluginbrandslug\admin\submenu\submenuContentD1G1;

            $submenus = [
                [
                    'd1g1-plugins',                              
                    __( 'Branding', TM_PLUGSEC ),                    
                    __('Branding', TM_PLUGSEC),               
                    'manage_options',                           
                    D1G1_BRANDING,                              
                    [$subcontent, 'my_admin_page_contents'],          
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
                        $submenu[5],
                    );
                }
            }             
            
        }

    }

	new \pluginbrandslug\admin\submenu\subMenuD1G1;

}

