<?php
namespace pluginbrandslug;
/**
* Plugin Name: WeDesIn Branding
* Description: WeDesIn branding plugin přináší novinky a nabídku našich služeb a mění vzhled WordPressu do našich barev.
* Version: 2.4.0
* Framework version: 2.1
* Author: WeDesIn
* Author URI: https://www.wedesin.cz/
* Requires at least: 3.0.
* Tested up to: 5.8.
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
define( 'D1G1_LFILEDIR_BRAND','d1g1-wedesin-logs');
// Nastavení automatické kontroly auktualizací 
// D1G1_GITHUBURL example : https://github.com/WeDesIn/wedesin-branding
// D1G1_GITHUBREP example : wedesin-branding
define( 'D1G1_GITHUBURL_BRAND', 'hhttps://github.com/WeDesIn/wedesin-branding');
define( 'D1G1_GITHUBREP_BRAND', 'wedesin-branding');

/*******************************
/     Plugin requirements      *
********************************/ 
require( D1G1_BRANDPATH . 'framework/plugin-requirements.php');  

class DemandingPlugin extends \pluginbrandslug\requirements\d1g1PluginRequirements {
 
    const PLUGIN_NAME = "WeDesIn Branding";
 
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
/       INCLUDE PART           *
********************************/


include_once( D1G1_BRANDPATH . 'includes.php'); 



if(D1G1_GITHUBURL_BRAND && D1G1_GITHUBREP_BRAND){
    $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
        D1G1_GITHUBURL_BRAND,
        __FILE__,
        D1G1_GITHUBREP_BRAND
    );
    //Set the branch that contains the stable release.
    $myUpdateChecker->setBranch('master');
    //Optional: If you're using a private repository, specify the access token like this:
    $myUpdateChecker->setAuthentication('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');
}