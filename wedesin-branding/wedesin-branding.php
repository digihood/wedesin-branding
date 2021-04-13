<?php

/*

	Plugin Name: WeDesIn Branding
	Plugin URI: https://www.wedesin.cz/
	Description: WeDesIn branding plugin přináší novinky a nabídku našich služeb a mění vzhled WordPressu do našich barev.
	Version: 1.42
	Author: WeDesIn
	Author URI: https://www.wedesin.cz/
	License: WeDesIn
	Text Domain: wedesin-branding
*/

if ( !class_exists( 'WeDesInBrading' ) ) { 

	//include updater
	//https://github.com/YahnisElsts/plugin-update-checker
	require 'functions/plugin-update-checker/plugin-update-checker.php';

	$UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'http://wedesin.cz/plugins/wedesin-branding/updater.json',
		__FILE__, 
		'wedesin-branding'

	);

	class WeDesInBrading {

		/*
		 * Constructor
		 */

		public function __construct() {

			//add scripts
			add_action( 'wp_footer', [$this, 'admin_bar_branding']);
			add_action( 'admin_enqueue_scripts', [$this, '_wedesin_admin_scripts'] );

			//add description
			add_filter('admin_footer_text', [$this,'wedesin_remove_footer_admin'] );

			//add login style
			add_action( 'login_enqueue_scripts', [$this,'wedesin_login_stylesheet'] );

			//change login url
			add_filter( 'login_headerurl', [$this,'wedesin_homepage_url'] );

			//add widgets do dashboard
			add_action('wp_dashboard_setup', [$this, 'custom_dash_widget_wed'] );

			//remove colour admin setting
			remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

		}

		//change the look of the sites admin
		public function _wedesin_admin_scripts()

		{

			///if ( is_user_logged_in() && is_admin_bar_showing() ) {

			$time = filemtime( plugin_dir_path( __FILE__ ) . 'css/wedesin-admin.css');
			wp_enqueue_style( 'wedesin-admin-style', plugin_dir_url( __FILE__ ) .'css/wedesin-admin.css', null, $time, 'all' );


		}

		//return english 
		function is_eng( ) {

			$lang = get_bloginfo('language');
			if ( $lang == "en-GB" || $lang == "en-US" || $lang == "en-AU" || $lang == "en-CA" || $lang == "en-NZ" || $lang == "en-ZA" ) {
				return true;
			} else {
				return false;
			}
		}

		//add wedesin title at the bottom

		public function wedesin_remove_footer_admin () {

			if ( $this->is_eng( ) ) {
				echo '<p>Website by <a href="http://www.wedesin.cz/" target="_blank">WeDesIn</a>. If you have any questions, please send an email to <a href="mailto:info@wedesin.cz" target="_blank">info@wedesin.cz</a>.';
			} else {
				echo '<p>Webové stránky vytvořil <a href="http://www.wedesin.cz/" target="_blank">WeDesIn</a>. Pokud máte jakékoliv otázky, napište na <a href="mailto:info@wedesin.cz" target="_blank">info@wedesin.cz</a>.';
			}

		} 

		public function wedesin_homepage_url() {
			return 'https://www.wedesin.cz/';
		}

		/**
		 * Add front end branding
		 *
		 * @param none
		 * 
		 * @author Wedesin
		 * @return echo/false
		 */ 
		public function admin_bar_branding( ) { ?>
			<style>
			#wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
				content: ' ' !important;
				background: url( <?php echo plugins_url(); ?>/wedesin-branding/img/wedesin-logo-icon.png) no-repeat !important;
				width: 22px !important;
				height: 22px !important;
				display: block;
				background-size: 95% !important;
				background-position: center;
			}
			#wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a, #wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar .quicklinks .menupop.hover ul li div[tabindex]:focus, #wpadminbar .quicklinks .menupop.hover ul li div[tabindex]:hover, #wpadminbar li #adminbarsearch.adminbar-focused:before, #wpadminbar li .ab-item:focus .ab-icon:before, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover,
			#wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label, #wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label,
			#wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item, #wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus,
			#collapse-button:focus,
			#collapse-button:hover,
			#adminmenu li.opensub>a.menu-top {
				color: #8AB336 !important;
			}
			</style>
			<?php 
		}

		//add login stylesheet
		public function wedesin_login_stylesheet() { 

			if ( $this->is_eng( ) ) {
				$img_url =  plugin_dir_url( __FILE__ ) . '/img/wedesin-logo-en.png';
			} else {
				$img_url =  plugin_dir_url( __FILE__ ) . '/img/wedesin-logo-cz.png';
			}

			?>

		<style type="text/css">

			body.login h1 a {
			background: transparent url( <?php echo $img_url; ?>) no-repeat !important;
			background-size: 100% 100% !important;
			width: 300px !important;
			height: 80px !important;
			}

			body.wp-core-ui .button-primary {
				background:  #A5C83C;
				border-color: #A5C83C #8AB336 #8AB336;
				-webkit-box-shadow: 0 1px 0 #8AB336;
				box-shadow: 0 1px 0 #8AB336;
				color: #fff;
				text-decoration: none;
				text-shadow: 0 -1px 1px #8AB336, 1px 0 1px #8AB336, 0 1px 1px #8AB336, -1px 0 1px #8AB336;
				transition: 0.3 linear all;
				-webkit-transition: 0.3 linear all;
				-moz-transition: 0.3 linear all;
			}

			body.wp-core-ui .button-primary:active,
			body.wp-core-ui .button-primary:focus,
			body.wp-core-ui .button-primary:hover {
				background: #8AB336;
				border-color: #8AB336;
				color: #fff;
				box-shadow: inset 0 2px 0 #8AB336;

			}

			input[type=text]:focus, 
			input[type=search]:focus, 
			input[type=radio]:focus, 
			input[type=tel]:focus, 
			input[type=time]:focus, 
			input[type=url]:focus, 
			input[type=week]:focus, 
			input[type=password]:focus, 
			input[type=checkbox]:focus, 
			input[type=color]:focus, 
			input[type=date]:focus, 
			input[type=datetime]:focus, 
			input[type=datetime-local]:focus, 
			input[type=email]:focus, 
			input[type=month]:focus, 
			input[type=number]:focus, 
			select:focus, textarea:focus {
				border-color: #A5C83C !important;
				-webkit-box-shadow: 0 0 2px rgba(165,200,60,.8) !important;
				box-shadow: 0 0 2px rgba(165,200,60,.8) !important;
			}

			body.login .message {
				border-left: 4px solid #8AB336;
			}


			body input[type=checkbox]:checked:before {
				content: "\f147";
				margin: -3px 0 0 -4px;
				color: #A5C83C;
			}

			.login #backtoblog a:hover, 
			.login #nav a:hover, 
			.login h1 a:hover {
				color: #8AB336 !important;
			}



			a:focus {
				-webkit-box-shadow: 0 0 0 1px #8AB336, 0 0 2px 1px rgba(30,140,190,.8) !important;
				box-shadow: 0 0 0 1px #8AB336, 0 0 2px 1px rgba(30,140,190,.8) !important;

			}

 

			body.wp-core-ui .button-secondary .dashicons-hidden:before,
			body.wp-core-ui .button-secondary .dashicons-visibility:before {

				color: #A5C83C !important

			}

			body.login .button.wp-hide-pw:focus {
				border-color: #8AB336;
    			box-shadow: 0 0 0 1px #8AB336;
			}

			body a,
			body a:hover,
			body a:focus {
				color: #A5C83C
			}


			body.wp-core-ui .admin-email__actions-primary .button.button-large:not(#correct-admin-email) {
				color: #8AB336;
				border-color: #8AB336;
			}

			.wp-core-ui input[type=checkbox]:checked:before {
    			margin: 7px 0 0 -4px;
    			color: #8AB336;
				content: '\2714';
			}

		</style>

		<?php } 

		public function custom_dash_widget_wed(){
			add_meta_box('withdraw_to_bank', 'Nástěnka WeDesIn', array($this, 'wedesin_dashboard_widget_display'),'dashboard', 'side','high' );
		}


		public function wedesin_dashboard_widget_display(){

			$lang = get_bloginfo('language');

			if ($lang == "en-GB" || $lang == "en-US" || $lang == "en-AU" || $lang == "en-CA" || $lang == "en-NZ" || $lang == "en-ZA" ) {

				echo '<div><h3>Welcome to your admin section</h3>
				<p>Quick navigation:</p>
				<ul>
				<li><a href="'.site_url().'/wp-admin/edit.php?post_type=page">Change pages</a></li>
				<li><a href="'.site_url().'/wp-admin/edit.php?post_type=post">Change posts</a></li>
				<li><a href="'.site_url().'/wp-admin/upload.php">Edit media</a></li>
				<li><a href="'.site_url().'/wp-admin/nav-menus.php">Change navigation menu</a></li>
				</ul></div>'; 

			} else { ?>

				<div class="wedesin-widget">
					<?php if ( $this->pull_wedesin_post( 'offers' ) ) { ?>
						<h2 style="margin-top:0">Nabídka WeDesIn</h2>
						<?php print_r( $this->pull_wedesin_post( 'offers' ) );?>
					<?php } ?>
					<h2 style="margin-top:0">Novinky na webu WeDesIn</h2>
					<?php print_r( $this->pull_wedesin_post( 'posts' ) );?>
					<br>
					<h3 style="font-size:18px">Převod obrázků online mezi formáty JPG, PNG, BMP, GIF a PDF</h3>
					<p>Potřebujete někdy převést obrázky mezi výše uvedenými formáty? Použijte náš online nástroj.</p>
					<a href="https://www.wedesin.cz/online-nastroje/online-prevod-obrazku-mezi-png-jpg-gif-bmp-a-pdf" target="_blank" class="button button-primary">Přejít na online převodník obrázků</a>
				</div>

			<?php }	

		}

		private function pull_wedesin_post( $post_type ) {

			// Initialize variable.
			$allposts = '';

			// Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			$response = wp_remote_get( 'https://www.wedesin.cz/wp-json/wp/v2/'.$post_type.'/?per_page=1' );

			// Exit if error.
			if ( is_wp_error( $response ) ) {
				return;
			}

			//get the body.
			$posts = json_decode( wp_remote_retrieve_body( $response ) );

			//exit if nothing is returned.
			if ( empty( $posts ) ) {
				return;
			}

			//check for error
			if ( is_wp_error( $posts ) ) {
				return;
			}

			// If there are posts.
			if ( !empty( $posts ) ) {
				// For each post.
				foreach ( $posts as $post ) {

					$img_id = $post->featured_media;					

					// Format the date.
					$fordate = date( 'j. n. Y', strtotime( $post->modified ) );
					// Show a linked title and post date.
					$allposts .= '<div ><h4 style="font-size:16px"><a href="' . esc_url( $post->link ) . '" target=\"_blank\">' . esc_html( $post->title->rendered ) . '</a></h4>

					<div><span style="font-style: italic">' . esc_html( $fordate ) . ', WeDesIn</span></div><div>';

					if ( !empty( $img_id ) ) {

						$img_response = wp_remote_get( 'https://www.wedesin.cz/wp-json/wp/v2/media/'.$img_id );

						if ( !empty( $img_response['body'] ) ) {
							$allposts .= '<img src="'.json_decode( $img_response['body'])->media_details->sizes->thumbnail->source_url.'" style="
							float:left; width:100px;height:auto;margin:5px 10px 10px 0;">';
						}

					}

					$allposts .=  $post->excerpt->rendered . '</div><div class="wedclear"><a href="'.$post->link. '" target="_blank" class="button button-primary">Zobrazit příspěvek</a></div></div>';

				}				

				return $allposts;

			}

			return false;

		}

	}

	/**
	 * What The File main function
	 */
	function WeDesIn_load_branding() {
		new WeDesInBrading();
	}

	add_action( 'plugins_loaded', 'WeDesIn_load_branding' );

}