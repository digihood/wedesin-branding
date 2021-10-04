<?php

/**
 * class description
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( !class_exists('ScriptsStylesWDS') ) {

  class ScriptsStylesWDS {

    /**
     * 
     * Constructor
     *
     * @date	21/1/21
     * @since	1.0
     *
     * @return	void
     */
    public function __construct()
    {
      //scripty
      add_action( 'wp_enqueue_scripts', [$this, 'add_scripts']);
  
      //scripty v administraci
      add_action( 'admin_enqueue_scripts', [$this, 'add_admin_scripts'] );
  
    }
  
    /**
     * empty function description
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
  
    public function add_scripts( ) {
  
    }
  
    public function add_admin_scripts( ) {
  
      //Register style
      $admin_style = filemtime(  WDS_BRANDPATH . 'assets/styles/wds-admin.css' );
      wp_enqueue_style( 'star-comments', WDS_BRANDURL . 'assets/styles/wds-admin.css', array( ), $admin_style, 'all' );
    
      wp_enqueue_style( 'fonts-gstatic', 'https://fonts.gstatic.com' );
      wp_enqueue_style( 'font-Lato', 'https://fonts.googleapis.com/css2?family=Lato:ital@0;1&display=swap' );
  
      wp_enqueue_style( 'wp-color-picker' );
  
      //register javascript
      $admin_script = filemtime(  WDS_BRANDPATH . 'assets/scripts/wds-admin.js' );
      wp_enqueue_script( 'star-comments', WDS_BRANDURL . 'assets/scripts/wds-admin.js', array( 'jquery' ), $admin_script, true );
      
      //WP media uploader
      wp_enqueue_media();
  
      //color picker scripts
      $colorpicker_script = filemtime(  WDS_BRANDPATH . 'assets/scripts/wp-color-picker-alpha.min.js' );
      wp_enqueue_script( 'wp-color-picker-alpha', WDS_BRANDURL . 'assets/scripts/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $colorpicker_script, true );
  
      wp_add_inline_script(
        'wp-color-picker-alpha',
        'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
      );
  
      //Selectize.js
      $selectize_script = filemtime(  WDS_BRANDPATH . 'assets/scripts/selectize.js' );
      wp_enqueue_script( 'selectize', WDS_BRANDURL . 'assets/scripts/selectize.js', array( 'jquery' ), $selectize_script, true );
  
      $selectize_style = filemtime(  WDS_BRANDPATH . 'assets/styles/selectize.css' );
      wp_enqueue_style( 'selectize', WDS_BRANDURL . 'assets/styles/selectize.css', array( ), $selectize_style, 'all' );
      
    }
  
  }
  new ScriptsStylesWDS;

}
