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
            <div class="wrap">

                <h2><?php echo __('Další naše pluginy', D1G1_BRANDING); ?></h2>
                <section>
                    <div class="plugins-list">
                    <?php
                       // $this->d1g1_plugins_menu();
                    ?>
                    </div>     
                </section>
            </div>
            <?php
        }

        /**
         * Plugins menu
         * // nefunguje zobrazeni odkazu na nastaveni 
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
                         $class = new \pluginbrandslug\framework\d1g1_plugins\d1g1plugins;
                         $data = $class->d1g1_get_plugins();
 
                        $count = count($data);
                        foreach ($submenu_list as $key) {
                           
                            if ( isset($key[2]) && !empty($key[2]) && isset($key[2]) && !empty($key[3]) ) {
                                $array[] = [
                                    '1' => $key[2],
                                    '2' => $key[3],
                                ];
                              // echo '<li><a href="'.menu_page_url($key[2], false).'">'.$key[3].'</a></li>';
                            }
                        
                               
                        } 
                       // preprint($data);
                       
                       
                       
                        $show = $this->d1g1_show_wedesin_plugin($data);
                                  
                      ?>
                    </ul>
                    <?php
                }

                ?>
            </div>
            <?php
        } 
        
         /**
         * seradí array podle abcedy (activni/neactivní)
         *
         * @param $a prvni array
         * @param $b druhy array
         * @author digihood
         * @return strnatcmp
         */ 
        
        function compare_activated($a, $b){
          return strnatcmp($b['activated'], $a['activated']);
        }
    
        /**
         * zobrazi pluginy v boxech 
         *
         * @param $data -- array s daty nainstalovanych pluginu
         * // nefunguje zobrazeni odkazu na nastaveni 
         * @author digihood
         * @return echo
         */ 
        public function d1g1_show_wedesin_plugin($data){
           
           $url = get_site_url();
          // preprint($test);
            usort($data, [$this,'compare_activated']);
            foreach($data as $value){
                
                echo '<div class="plugin-card">';
                if($value['activated'] == 'false'){
                    echo '<form method="post">';
                    echo '<p class="h4" style="margin-right:10px; float:right; line-height: 24px"><button type="submit" class="button button-primary plugin-button" name="plugin_name" value="'.$value['TextDomain'].'">' .__('Aktivovat',D1G1_BRANDING).'</button></p>';
                    echo '</form>';
                }
                echo '<p class="h2" style="display:inline-block; line-height: 24px"><b>' .__(''.$value['name'].'', D1G1_BRANDING).'</b></h2>';
                if($value['activated'] == 'true'){
                    echo '<p class="h4 " style="display:inline-block; color:green; margin-right:10px; float:right; line-height: 24px"><a class="button button-primary" href="'.$url.'/wp-admin/admin.php?page='.D1G1_BRANDING.'">' .__('Nastavení', D1G1_BRANDING).'</a></h4>';   
                }
                echo '<div class="d1g1-widget">';
                echo '<p><b>Author</b> : <a href="'.$value['Author_URI'].'">'.$value['author'].'</a></p>';
                echo '<p><b>Description</b> : '.$value['description'].'</p>';
                echo '<p><b>Version</b> : '.$value['version'].'</p>';
                echo '</div>';
                echo '</div>';
               
            }  
            
            if(array_key_exists('plugin_name', $_POST)) {
                activate_plugin( ''.$_POST['plugin_name'].'/setup.php' );
            }
        }

    }
	new \pluginbrandslug\framework\mainMenu\mainMenuD1G1;
}
