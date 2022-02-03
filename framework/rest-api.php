<?php 
/**
 * Popis třídy
 *
 * 
 * @author Wedesin
 */ 
namespace pluginbrandslug\framework\rest_api;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1_rest_api' ) )
{
	class d1g1_rest_api
	{

        private $api_url;
        private $type;
        private $type_id;
        private $per_page;

		public function __construct($api_url,$type,$type_id,$per_page = '')
		{
             $this->api_url = $api_url;
             $this->type = $type;
             $this->type_id = $type_id;
             $this->per_page = $per_page;
        }

        private function setup_url(){
            $page_per = ($this->per_page ? $this->per_page : '100');
            if($this->type == 'media'){
                $url = $this->api_url . '/wp-json/wp/v2/' . $this->type . '/' . $this->type_id;
            }else{
                $url = $this->api_url . '/wp-json/wp/v2/' . $this->type . '/?' . $this->type . '_type='. $this->type_id .'&per_page= '. $page_per .'';
            }
        return $url;
        }


		private function rest_api_post(){
			try {
			// Přimé napojení Rest API na ziskanou URL 
			    $response = wp_remote_get( $this->setup_url() );
            } catch (Error $e) {
                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
            }

			// Ukončí pokud se vyskytne error vrátí prazdno
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				
				return '';
			}

			// Získá Data
			$posts = json_decode( wp_remote_retrieve_body( $response ) );

			
	        //misto pro hook
            $array = [];
            $array = do_action( 'd1g1_rest_api', $posts );
            
			return $array;
		}
        public function get_data() {
			$data = $this->rest_api_post();
			return $data;
		}










    }
     //new d1g1_rest_api;
}