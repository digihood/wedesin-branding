<?php 
/**
 * Stažení dat z webu
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'WedesinRestApiWDS' ) )
{

	class WedesinRestApiWDS
	{

		public function __construct()
		{
			
			//add widgets do dashboard
			add_action('wp_dashboard_setup', [$this, 'custom_dash_widget_wed'] );

		}

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
					<h2 style="margin-top:0">Novinky na webu WeDesIn</h2>
					<?php print_r( $this->pull_wedesin_post( 'rest_api' ) );
                    /*?>
					<br>
					<h3 style="font-size:18px">Převod obrázků online mezi formáty JPG, PNG, BMP, GIF a PDF</h3>
					<p>Potřebujete někdy převést obrázky mezi výše uvedenými formáty? Použijte náš online nástroj.</p>
					<a href="https://www.wedesin.cz/online-nastroje/online-prevod-obrazku-mezi-png-jpg-gif-bmp-a-pdf" target="_blank" class="button button-primary">Přejít na online převodník obrázků</a>
                    <?php */?>
                </div>

			<?php }	

		}

		public function pull_wedesin_post( $post_type ) {

			// Initialize variable.
			$allposts = '';

            try {

                // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			    $response = wp_remote_get( 'https://www.wedesin.cz/wp-json/wp/v2/'.$post_type.'/?per_page=2' );
				//$response = wp_remote_get( 'https://plugins.digihood.cz/wp-json/wp/v2/plugins/?per_page=1' );
    
            } catch (Error $e) {

                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';

                $log = new pluginbrandslug\log\wedesinLogSettings;
                $log->add_log('WeDesIn stažení příspěvků', 'Nepodařilo se stáhnout poslední příspěvky, došlo k chybě' . $e->getMessage());

            }
			//preprint($response);
			// Exit if error.
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				return;
			}

			//get the body.
			$posts = json_decode( wp_remote_retrieve_body( $response ) );
		
			//check for error
			if ( empty( $posts ) || is_wp_error( $posts ) ) {
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


		public function pull_geenbox_post( $post_type ) {

			// Initialize variable.
			$allposts = '';

            try {

                // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			  //  $response = wp_remote_get( 'https://www.wedesin.cz/wp-json/wp/v2/'.$post_type.'/?per_page=2' );
				$response = wp_remote_get( 'https://plugins.digihood.cz/wp-json/wp/v2/plugins/?per_page=1' );
    
            } catch (Error $e) {

                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';

                $log = new pluginbrandslug\log\wedesinLogSettings;
                $log->add_log('WeDesIn stažení příspěvků', 'Nepodařilo se stáhnout poslední příspěvky, došlo k chybě' . $e->getMessage());

            }

			// Exit if error.
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				return;
			}

			//get the body.
			$posts = json_decode( wp_remote_retrieve_body( $response ) );
		preprint($posts);
			//check for error
			if ( empty( $posts ) || is_wp_error( $posts ) ) {
				return;
			}

			// If there are posts.
			if ( !empty( $posts ) ) {
				// For each post.
				foreach ( $posts as $post ) {

					$img_id = $post->featured_media;					
				
					// Show a linked title and post date.
					$allposts .= '<div class="card info"><h2><a href="' . esc_url( $post->link ) . '" target=\"_blank\">' . esc_html( $post->title->rendered ) . '</a></h2><div>
				    <p>'.$post->acf->green_box_content.'</p>
					';
					
			//	echo $post->title->rendered ;
					$allposts .=  $post->excerpt->rendered . '</div><div class="wedclear"><a href="'.$post->url.'" target="'.$post->target.'" class="button button-primary">'.$post->title.'</a></div></div>';

				}				
			
				return $allposts;

			}

			return false;

		}

	}

}

if( is_admin() )
	new WedesinRestApiWDS;


