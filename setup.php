<?php

/**
* Plugin Name: WeDesIn Branding(D1G1)
* Description: WeDesIn branding plugin přináší novinky a nabídku našich služeb a mění vzhled WordPressu do našich barev.
* Version: 2.1.1
* Author: WeDesIn
* Author URI: https://www.wedesin.cz/
* Requires at least: 3.0.
* Tested up to: 5.8.
* Text Domain: wds-branding
* License: GPL2 or higher
*/

/*

Při založení nového pluginu je vždy potřeba:
1. Změnit všechny define názvy - TM_PLUGSEC musí zůstat
2.Přejmenovat defaultní classy
3. namespace
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*******************************
/           DEFINE             *
********************************/

//definice
define( 'TM_PLUGSEC', 'd1g1_plugins' );
define( 'D1G1_BRANDPATH', plugin_dir_path( __FILE__ ) );
define( 'D1G1_BRANDURL', plugin_dir_url( __FILE__ ) );
define( 'D1G1_BRANDING', 'D1G1BRAND' );

/*******************************
/     Plugin requirements      *
********************************/ 
require( D1G1_BRANDPATH . 'framework/plugin-requirements.php');  

class DemandingPlugin extends \pluginbrandslug\requirements\d1g1PluginRequirements {
 
    const PLUGIN_NAME = "digihood WC Video";
 
    public function __construct() {
        $this->add_activation_hooks( __FILE__ );
    }
 
    protected function check_plugin_requirements() {
        global $wp_version;
        $failed = array();
        if ( $wp_version < 4.0 )
            $failed[] = 'WordPress version must be at least 4.0! ';
        if ( version_compare( PHP_VERSION, '7.0.0', '<' ) )
            $failed[] = 'PHP version must be at least 7.0.0! ';
        return $failed;
    }
 
}
$DemandingPlugin = new DemandingPlugin();

/*******************************
/       INCLUDE PARTS          *
********************************/
//framework

include_once( D1G1_BRANDPATH . 'framework/styles-scripts.php');  
include_once( D1G1_BRANDPATH . 'framework/main-menu.php');  
include_once( D1G1_BRANDPATH . 'framework/log/log-setup.php');  
include_once( D1G1_BRANDPATH . 'framework/forms-builder.php'); 
include_once( D1G1_BRANDPATH . 'framework/sessions.php'); 
include_once( D1G1_BRANDPATH . 'framework/cookies.php'); 
include_once( D1G1_BRANDPATH . 'framework/forms-core.php');
include_once( D1G1_BRANDPATH . 'framework/helpers.php'); 
include_once( D1G1_BRANDPATH . 'framework/forms-core.php');  
include_once( D1G1_BRANDPATH . 'framework/emails.php'); 
include_once( D1G1_BRANDPATH . 'framework/plugin-update-checker/plugin-update-checker.php'); 
//add admin page
include_once( D1G1_BRANDPATH . 'admin/sub-menu.php');  
include_once( D1G1_BRANDPATH . 'admin/form_fields.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/main-menu.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/submenu-content.php'); 
include_once( D1G1_BRANDPATH . 'admin/info-box/view-box.php');
include_once( D1G1_BRANDPATH . 'admin/info-box/restapi-call.php');

// Include utility functions

include_once( D1G1_BRANDPATH . 'components/email-content.php'); 
include_once( D1G1_BRANDPATH . 'components/admin-update.php'); 
include_once( D1G1_BRANDPATH . 'components/styles-scripts.php');
include_once( D1G1_BRANDPATH . 'components/custom-functions.php');  


// Nastavení utomatické kontroly auktualizací 
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/WeDesIn/wedesin-branding',
	__FILE__,
	'wedesin-branding'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');
//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication('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');
