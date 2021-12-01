<?php 
/**
 * Popis třídy
 *
 * 
 * @author Wedesin
 */ 
namespace pluginbrandslug\framework\d1g1_plugins;
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

        /**
         * vytvoři url pro ziskani api 
         *
         * @param $type  - pluginlist
         * @author digihood
         * @return strnatcmp
         */

        public function get_url($type) {
	
				if($type == 'pluginslist') { 
				    return $this->api_url . $type . '?per_page=100';
				}
			
		}
         /**
         * získaní dat z api
         *
         * @param $type  - pluginlist typ přispevku 
         * @author digihood
         * @return array
         */
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
            
            //$array = [];
	        // Pokud je $posts prazdný vrátí prazdný pole
			if ( !empty( $posts ) ) {	
			// Data Pro kazdý Posts 
				foreach ( $posts as $post ) {
					$array[] = [
						'title'      => ( isset($post->title->rendered) && !empty($post->title->rendered) ? $post->title->rendered : '') , 
						'content'    => ( isset($post->content->rendered) && !empty($post->content->rendered) ? $post->content->rendered : '') ,
						'small_content' => ( isset($post->excerpt->rendered) && !empty($post->excerpt->rendered) ? $post->excerpt->rendered : '') ,
						'TextDomain'    => ( isset($post->acf->plugin_slug) && !empty($post->acf->plugin_slug) ? $post->acf->plugin_slug : '') ,
					];
					
				}
				return $array;
			} 
				
        }
		/**
		 * get wedesin plugins
		 *
		 * @param $what string
		 * 
		 * @author digihood
		 * @return echo string
		 */ 


		function d1g1_get_plugins($what = '') {
			$plugins = get_plugins();
            
		   switch($what):
			default:
		   case 'all':
				foreach($plugins as $plugin){
					if($plugin['AuthorName'] == 'WeDesIn'){
						$active = is_plugin_active( ''.$plugin['TextDomain'].'/setup.php' );
						$data[] = [
							'name' => $plugin['Name'],
							'version' => $plugin['Version'],
							'description' => $plugin['Description'],
							'author' => $plugin['Author'],
							'TextDomain' => $plugin['TextDomain'],
							'Author_URI' => $plugin['AuthorURI'],
							'activated' => ($active == true ?  'true' : 'false')
						];
					} 
				}
				return $data;   
				break;
			case 'active':
				foreach($plugins as $plugin){
					if($plugin['AuthorName'] == 'WeDesIn'){
						$inactive = is_plugin_active( ''.$plugin['TextDomain'].'/setup.php' );
						if($inactive == true){
							$data[] = [
								'name' => $plugin['Name'],
								'version' => $plugin['Version'],
								'description' => $plugin['Description'],
								'author' => $plugin['Author'],
								'TextDomain' => $plugin['TextDomain'],
								'activated' => true
							];
						}
					}
				}
				return $data;
				break;
			case 'inactive':
				
					foreach($plugins as $plugin){
						if($plugin['AuthorName'] == 'WeDesIn'){
							$inactive = is_plugin_inactive( ''.$plugin['TextDomain'].'/setup.php' );
							if($inactive == true){
								$data[] = [
									'name' => $plugin['Name'],
									'version' => $plugin['Version'],
									'description' => $plugin['Description'],
									'author' => $plugin['Author'],
									'TextDomain' => $plugin['TextDomain'],
									'activated' => false
								];
							}
						}
					}
				return $data;
				break;
			endswitch;
	
		}
		 /**
         * připravena funkce na porovnani dat z api 
         *
         * @param 
         * @author digihood
         * @return 
         */
		public function d1g1_comparison_plugins(){
			$class = new \pluginbrandslug\framework\d1g1_plugins\d1g1plugins;
			$data = $class->d1g1_get_plugins();
			$api = $class->rest_api_post('pluginslist');
			$array = [];
		
			//return $data;
			
		}
    }
    // new d1g1plugins;
}