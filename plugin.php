<?php
namespace pluginone;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/*
 * Plugin Name: pluginTemplate
 * Plugin URI: 		  
 * Description: desciption
 * Version:           
 * Author:            
 * Author URI:        
 */
define( 'D1G1_PLUGINIDONE', 'pluginone' );
define( 'D1G1_PLUGSLUG_'.D1G1_PLUGINIDONE, 'd1g1_plugins');
define( 'D1G1_PLUGNAME_'.D1G1_PLUGINIDONE, 'Plugin ONE');
define( 'D1G1_PATHS_'.D1G1_PLUGINIDONE, plugin_dir_path( __FILE__ ) );
define( 'D1G1_PATHTOFWASSET_'.D1G1_PLUGINIDONE, plugin_dir_path( __FILE__ ).'plugin-framework/FrameworkAssets/' );
define( 'D1G1_URL_'.D1G1_PLUGINIDONE, plugin_dir_url( __FILE__ ) );

require __DIR__.'/plugin-framework/kint.phar';

include_once __DIR__ . '/includes.php';