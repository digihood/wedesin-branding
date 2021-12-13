<?php 
namespace pluginbrandslug\components\log_content;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}
if (!class_exists('d1g1LogSettings')){
    class d1g1LogSettings{
        public $LogFile;

        //konstruktor
        public function __construct()
        {
            //spuštní
        
            add_action('d1g1_plugin_log_tab_content', [$this, 'add_tab'] );
            add_action('d1g1_plugin_log_header_content', [$this, 'add_header'] );
            //add_action( 'init',  [$this, 'test__log'] );

        }


        /**
         * Zapíše zprávu do logu TEST
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function test__log() {
            if ( isset($_GET['test_log']) && $_GET['test_log'] == 2  ) {
            $this->add_log(     
                'ahoj',
                'testuji si tu uložení',
                'blabla'
            );
    
            die('tu');
            }
        }


        /**
         * Přidá záložku logu pro tento plugin
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function add_header( ) { 
            $plugin_data = get_plugin_data( D1G1_BRANDPATH . 'setup.php' );
            $plugin_name = $plugin_data['Name'];
            
            $default_tab = null;
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
            ?>
            <a href="?page=d1g1-logs&tab=<?= D1G1_BRANDING ?>" class="nav-tab <?= ($tab=== D1G1_BRANDING ? 'nav-tab-active' : '')?>">
                <?php echo $plugin_name; ?>
            </a>
        <?php }

        /**
         * Přidá záložku logu pro tento plugin
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function add_tab( ) {
            $tab = isset($_GET['tab']) ? $_GET['tab'] : '';
            $file = $this->LogFile;
            if ($tab) $file = $tab;
            $this->the_log_excerpt_admin($file);
        }

        /**
         * Výpis logu do admina 
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function the_log_excerpt_admin() { 
      
                if ($_GET['tab'] == D1G1_BRANDING ) { 
            
                    include_once( D1G1_BRANDPATH. 'framework/monolog/views/view-log.php' );
                }
        }
    }
}
new d1g1LogSettings;