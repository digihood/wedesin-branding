<?php

/**
* Plugin Name: WeDesIn Branding
* Description: WeDesIn branding plugin přináší novinky a nabídku našich služeb a mění vzhled WordPressu do našich barev.
* Version: 2.1.2
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
define( 'TM_PLUGSEC', 'wds_plugins' );
define( 'WDS_BRANDPATH', plugin_dir_path( __FILE__ ) );
define( 'WDS_BRANDURL', plugin_dir_url( __FILE__ ) );
define( 'WDS_BRANDING', 'WDSBRAND' );

/*******************************
/       INCLUDE PARTS          *
********************************/
//framework

include_once( WDS_BRANDPATH . 'framework/styles-scripts.php');  
include_once( WDS_BRANDPATH . 'framework/main-menu.php');  
include_once( WDS_BRANDPATH . 'framework/log/log-setup.php');  
include_once( WDS_BRANDPATH . 'framework/forms-builder.php'); 
include_once( WDS_BRANDPATH . 'framework/sessions.php'); 
include_once( WDS_BRANDPATH . 'framework/cookies.php'); 
include_once( WDS_BRANDPATH . 'framework/forms-core.php');
include_once( WDS_BRANDPATH . 'framework/helpers.php'); 
include_once( WDS_BRANDPATH . 'framework/forms-core.php');  
include_once( WDS_BRANDPATH . 'framework/emails.php'); 
include_once( WDS_BRANDPATH . 'framework/plugin-update-checker/plugin-update-checker.php'); 
//add admin page
include_once( WDS_BRANDPATH . 'admin/sub-menu.php');  
include_once( WDS_BRANDPATH . 'admin/form_fields.php'); 
include_once( WDS_BRANDPATH . 'admin/view/main-menu.php'); 
include_once( WDS_BRANDPATH . 'admin/view/submenu-content.php'); 

// Include utility functions

include_once( WDS_BRANDPATH . 'components/email-content.php'); 
include_once( WDS_BRANDPATH . 'components/admin-update.php'); 
include_once( WDS_BRANDPATH . 'components/styles-scripts.php');
include_once( WDS_BRANDPATH . 'components/custom-functions.php');  
include_once( WDS_BRANDPATH . 'components/custom-box.php');
include_once( WDS_BRANDPATH . 'components/custom-new-box.php');

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
