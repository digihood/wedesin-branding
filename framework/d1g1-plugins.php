<?php 
/**
 * Popis třídy
 *
 * 
 * @author Wedesin
 */ 
namespace brand\framework\d1g1_plugins;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1plugins' ) )
{
	class d1g1plugins
	{

        private $api_url;

		public function __construct()
		{
           // URl pro získaní dat
			$this->api_url = 'https://plugins.digihood.cz/wp-json/wp/v2/'; 
        }



        private function get_url($type) {
	
				if($type == 'pluginsnews') { 
				    return $this->api_url .$type.'?per_page=100';
				}
			
		}

        public function rest_api_post($type){
			try {
			// Přimé napojení Rest API na ziskanou URL 
			    $response = wp_remote_get( $this->get_url($type) );
            } catch (Error $e) {
                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
            }
            	// Ukončí pokud se vyskytne error vrátí prazdno
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				
				return '';
			}

			// Získá Data
			$posts = json_decode( wp_remote_retrieve_body( $response ) );
            
            $array = [];
	        // Pokud je $posts prazdný vrátí prazdný pole
			if ( !empty( $posts ) ) {	
			// Data Pro kazdý Posts 
				foreach ( $posts as $post ) {
					$array[] = array (
						'title'      => ( isset($post->title->rendered) && !empty($post->title->rendered) ? $post->title->rendered : '') , 
						'content'    => ( isset($post->content->rendered) && !empty($post->content->rendered) ? $post->content->rendered : '') ,
					);

				}
			} 
			return $array;	
        }
    }
    // new d1g1plugins;
}