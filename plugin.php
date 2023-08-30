<?php
namespace digibrand;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/*
 * Plugin Name: Digihood Branding
 * Plugin URI: digihood.cz   
 * Description: Nová verze Digihood branding pluginu 4.0, Děkujeme, že děláte weby s námi.
 * Version: 4.0.0          
 * Author: Digihood    
 * Author URI: digihood.cz   
 */

// Global PFW constants
define( 'D1G1_BRANDING', 'digibrand' );
define( 'D1G1_PLUGSLUG_'.D1G1_BRANDING, 'd1g1_plugins');
define( 'D1G1_PLUGNAME_'.D1G1_BRANDING, 'Digihood Branding');
define( 'D1G1_PATHS_'.D1G1_BRANDING, plugin_dir_path( __FILE__ ) );
define( 'D1G1_PATHTOFWASSET_'.D1G1_BRANDING, plugin_dir_path( __FILE__ ).'plugin-framework/FrameworkAssets/' );
define( 'D1G1_URL_'.D1G1_BRANDING, plugin_dir_url( __FILE__ ) );
define('D1G1_SITE_BOX_LANG_SHOW',['cs','sk']);


require __DIR__.'/plugin-framework/kint.phar';

include_once __DIR__ . '/includes.php';
