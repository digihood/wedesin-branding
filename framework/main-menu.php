<?php 
namespace pluginbrandslug\framework\mainMenu;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

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
            ?>
            <div class="wrap">

                <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
                <section>
                    <div class="plugins-list">
                    <?php
                        $this->d1g1_plugins_menu();
                    ?>
                    </div>
                </section>
            </div>
            <?php
        }

        /**
         * Plugins menu
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 

        function d1g1_plugins_menu() { 
            global $submenu;
            ?>
            <div class="plugins-list">
                <?php
                if (isset($submenu['d1g1-plugins']) && !empty($submenu['d1g1-plugins'])){
                    $submenu_list = $submenu['d1g1-plugins']; ?>
                    <ul class="d1g1-plugins-list">
                        <?php
                        foreach ($submenu_list as $key) {
                           
                           // if ( isset($key[2]) && !empty($key[2]) && isset($key[2]) && !empty($key[3]) ) {
                             //   echo '<li><a href="'.menu_page_url($key[2], false).'">'.$key[3].'</a></li>';
                           // }
                        } 
                        $test = d1g1_get_plugins('all');
                        //preprint($test);
                        $show = $this->d1g1_show_wedesin_plugin($test);
                                  
                      ?>
                    </ul>
                    <?php
                }

                ?>
            </div>
            <?php
        }

        public function d1g1_show_wedesin_plugin($data){
            foreach($data as $value){    
                echo '<div class="plugin-card">';
                echo '<h2 style="line-height: 24px">' .__(''.$value['name'].'', D1G1_BRANDING).'</h2>';
                echo '<h4 '.($value['activated'] == 'true' ? 'style="position:relative; top:-44px; color:green; margin:10px; float:right;"' : 'style="position:relative; top:-44px; color:red; margin:10px; float:right;"').'>'.($value['activated'] == 'true' ? 'Active' : 'Deactive').'</h4>';
                echo '<div class="d1g1-widget">';
                echo '<p>Author : '.$value['author'].'</p>';
                echo '<p>Description : '.$value['description'].'</p>';
                echo '<p>Version : '.$value['version'].'</p>';
                echo '</div>';
                echo '</div>';
               
            }       
        }

    }
	new \pluginbrandslug\framework\mainMenu\mainMenuD1G1;
}
