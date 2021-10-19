<?php 

if( ! class_exists( 'logSetupD1G1') )
{
	class logSetupD1G1
	{

		public function __construct()
		{
            add_action( 'init',  [$this, 'new_folder_d1g1_log'] );
            add_action( 'admin_menu',  [$this, 'admin_page_d1g1_log'] );
        }

		/**
         * Přidává stránku s log výpisem do adminu
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function admin_page_d1g1_log() {
            add_submenu_page(
                'd1g1-plugins',                              
                    __( 'Digihood Log', TM_PLUGSEC ),                    
                    __('D1G1 Log', TM_PLUGSEC),               
                    'manage_options',                           
                    'd1g1-logs',                              
                    array( $this, 'my_admin_page_contents' )
            );
        }
        /**
         * Vrátí složku pro logy
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function get_d1g1_log_folder() {
            $upload_dir = wp_upload_dir();
            $return = $upload_dir['basedir'] . '/d1g1-logs';
            return $return;
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
                <nav class="nav-tab-wrapper">
                    <?php 
                    $default_tab = null;
                    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
                    ?>
                    <a href="?page=d1g1-logs" class="nav-tab <?= ($tab===null ? 'nav-tab-active' : '')?>">
                        <?= __('Přehled logů', TM_PLUGSEC) ?>
                    </a>
                    <?php 
                        do_action('d1g1_plugin_log_header_content');
                    ?>
                </nav>
                <div class="tab-content">
                    <?php if($tab===null ){ ?>
                        <div class="wrap">
                            <div class="col-12">
                                <div class="box-info">
                                    <div class="box-header">
                                        <h3 class="box-title"><?php _e( 'Záznamy logu', 'plan' ); ?></h3>
                                    </div>
                                    <div class="box-body">
                                        <?= __('V jednotlivých záložkách naleznete záznamy logů pro Vaše d1g1 pluginy. 
                                        Máte-li problém a potřebujete poradit s chybou, zkopírujte tento log do excelu a ten nám zašlete. Nebo můžete poslat přímo soubor, který naleznete na Vašem ftp ve složce wp-content/uploads/d1g1-log/')?>
                                    </div>
                                </div>                 
                            </div>
                        </div>
                        <div style="clear:both;"></div>  
                    <?php } else { 
                        do_action('d1g1_plugin_log_tab_content');
                    }
                    ?>
                </div>

            </div>
            <?php
        }

        /**
         * Zkontroluje a případně vytvoří složku pro logy
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */ 
        public function new_folder_d1g1_log() {

            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/d1g1-logs';
            if (! is_dir($upload_dir)) {
                mkdir( $upload_dir, 0700 );
            }
        }

    }

    new logSetupD1G1;

}
//přidáme další soubory
include_once( D1G1_BRANDPATH . 'components/log-content.php'); 
//use log\functions;
include_once( D1G1_BRANDPATH . 'framework/log/log-functions.php'); 