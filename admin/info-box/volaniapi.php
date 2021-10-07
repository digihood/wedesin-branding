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
			$this->api_url = 'https://plugins.digihood.cz/wp-json/wp/v2/';
		}
		   /**
     *  ziskaní url 
     *
     * @param type (CPT)
     * 
     * @author Wedesin
     * @return string
     */ 
		private function get_url($type, $img_id='') {
			if ($type == 'media' && $img_id) {
				return $this->api_url . 'media/' . $img_id;
			} else {
				return $this->api_url . $type . '/?per_page=1';
			}
			
		}

   /**
     * odesladni jazyku  a typu
     *
     * @param lang,type (jazyk, a typ přispěvku)
     * 
     * @author Wedesin
     * @return string
     */ 
		public function get_data($lang, $type) {
			$data = $this->rest_api_post($lang, $type);
			return $data;
		}
	
	
		private function rest_api_post($lang, $type){
			try {
                // Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			    $response = wp_remote_get( $this->get_url($type) );
            } catch (Error $e) {
                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
            }

			// Exit if error.
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				return '';
			}

			//get the body.
			$posts = json_decode( wp_remote_retrieve_body( $response ) );

			$array = [];
			
			if ( !empty( $posts ) ) {
				
				// For each post.
				//preprint($this->get_img());
				//preprint($posts);
		
				foreach ( $posts as $post ) {
					$array[] = array (
						'title'      => ( isset($post->title->rendered) && !empty($post->title->rendered) ? $post->title->rendered : '') , 
						'content'    => ( isset($post->content->rendered) && !empty($post->content->rendered) ? $post->content->rendered : '') ,
						'thumbnail'  => $this->rest_api_img($post->featured_media),
						'button'     => 
							array( 
								'text'   => (isset ($post->acf->green_box_button->title) && !empty($post->acf->green_box_button->title) ? $post->acf->green_box_button->title : ''), 
								'url'    => (isset ($post->acf->green_box_button->url) && !empty($post->acf->green_box_button->url) ? $post->acf->green_box_button->url : '')
							)
					);

				}
			} 
			return $array;
			
		}
		
		private function rest_api_img( $img_id){
				
			$type = 'media';

			try {
				$img_response = wp_remote_get( $this->get_url($type,$img_id) );
			} catch (Error $e) {
				echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
			}
		
			// Exit if error.
			if ( !$img_response || is_wp_error( $img_response ) || !is_array( $img_response ) ) {
				return '';
			}
			
			if (isset($img_response['body']) && !empty($img_response['body']) ) { 
				$api_img = json_decode( $img_response['body'] ); 
				if ($api_img->media_details->sizes->medium->source_url){ 		
					return $api_img->media_details->sizes->medium->source_url;
				} else {
							
					return '';
				}

			}
				
			return '';
				
		}

	}

}



