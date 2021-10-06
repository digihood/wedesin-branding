<?php 
/**
 * Stažení dat z webu
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'getRestApiRequestWDS' ) )
{
    
	class getRestApiRequestWDS
	{
		private $api_url;

		public function __construct()
		{
			$this->api_url = 'https://www.wedesin.cz/wp-json/wp/v2/';
		}
		private function get_url($type) {

			return $this->api_url . $type . '/?per_page=1';
		}


		public function get_data($lang, $type) {
			$data = $this->rest_api_post($lang, $type);
			preprint($data);
		}
		private function rest_api_post($lang, $type){

			try {
                // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			    $response = wp_remote_get( $this->get_url($type) );
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
			return $posts;

		}

		private function pull_wedesin_post( $post_type ) {

			// Initialize variable.
			$allposts = '';

            try {

                // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			    $response = wp_remote_get( 'https://www.wedesin.cz/wp-json/wp/v2/'.$post_type.'/?per_page=1' );
    
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
		private function get_api_title(){

		}
		private function get_api_content(){
			
		}
		private function get_api_thumbnail(){
			
		}
		private function get_api_button(){
			
		}


	}

}



