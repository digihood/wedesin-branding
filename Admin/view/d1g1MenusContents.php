<?php

namespace digibrand\admin\view;

if (!defined('ABSPATH')) {

    exit;
}
/**
 * d1g1MenusContents
 *  obsah navigace a jednotlivých tabů
 * 
 * @author Digihood
 */
if (!class_exists('d1g1MenusContents')) {
    class d1g1MenusContents {


        function __construct() {
            add_action( 'd1g1_navigations-'.D1G1_BRANDING, [$this,'add_navigations']);
            add_filter( 'd1g1_navigation_content-'.D1G1_BRANDING, [$this,'add_navigation_contents'] );

        }
        /**
         * zobrazní navigační panely
         * 
         * @param $ŧab = get jmeno tabu
         * 
         * @author Digihood
         */
        public static function add_navigations($tab) {
            echo '<a href="?page='.D1G1_BRANDING.'" class="nav-tab '.($tab === null ? 'nav-tab-active' : '' ).'">'. d1g1_get_svg(D1G1_PATHTOFWASSET_digibrand . "icons/home-line.svg").' Default Tab</a>';
            echo '<a href="?page='.D1G1_BRANDING.'&tab=emails" class="nav-tab '.($tab === 'emails' ? 'nav-tab-active' : '' ).'">'. d1g1_get_svg(D1G1_PATHTOFWASSET_digibrand . "icons/link-line.svg").'Emaily</a>';
            echo '<a href="?page='.D1G1_BRANDING.'&tab=update_report" class="nav-tab '.($tab === 'update_report' ? 'nav-tab-active' : '' ).'">'. d1g1_get_svg(D1G1_PATHTOFWASSET_digibrand . "icons/link-line.svg").'Odeslání reportu</a>';
        }
        /**
         * zobrazní navigačním panelum obsah 
         * 
         * @param $contents = array [jmeno tabu => jmeno fieldu]
         * 
         * @author Digihood
         * @return array
         */
        public static function add_navigation_contents($contents){
            $contents['default'] = 'test_repeater';
            /*if(d1g1license::validate_lisense_key()){
                $contents['tools'] = 'test_form_mini_for_test';
            }*/

            $contents['emails'] = 'brand_emails_settings';
            $contents['update_report'] = 'update_report';
            return $contents;

        }

    }
    new d1g1MenusContents;
}
   