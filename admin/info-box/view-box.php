<?php 
/**
 * Zobrazení Rest API dat v adminu
 * 
 * @author digihood
 */ 
namespace pluginbrandslug\admin\info_box\view;

use pluginbrandslug\admin\info_box\call\getRestApiRequestD1G1;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if( ! class_exists( 'viewAdminBoxD1G1' ) )
{
    
	class viewAdminBoxD1G1
	{

		public function __construct()
		{

		}
		/**
		 *  zobrazeni boxu
		 *
		 * @param none
		 * 
		 * @author digihood
		 * @return string
		 */
	
        public function d1g1_dashboard_widget_display($type){
			$this->display_box($type);
		}
		/**
		 *  box nastenka 
		 *
		 * @param type (default: plugins)
		 * 
		 * @author digihood
		 * @return string
		 */

		private function display_box($type="plugins") { 
			$lang = get_bloginfo('language');
			$rApi = new getRestApiRequestD1G1;
			$data = $rApi->get_data($lang, $type);
            if($data) {
				echo '<div class="card'.($type == 'plugins' ? ' info' : '').'">';

					if ($type == 'pluginsnews'){ 
						echo 	'<h2 style="margin-top:0; line-height: 24px">' .__("Novinky na webu Wedesin", D1G1_BRANDING).'</h2>';
					}
					?>

					<div class="d1g1-widget">
						<?php foreach ($data as $post) {
							if($post){
								$this->get_widget($post,$type);
							}
						} ?>
					</div>
					<?php
				echo '</div>';
			}
		}
		/**
		 *  zobrazí obsah postu
		 *
		 * @param post
		 * @param plugin
		 * 
		 * @author digihood
		 * @return string
		 */
		private function get_widget($post, $type){
			if ( !isset($post['title']) || !isset($post['content']) || empty($post['title']) || empty($post['content']) ) return;
			$level = ($type == 'plugins' ? '2' : '3');
			echo '<h'.$level.' '.($type == 'plugins' ? '>' : 'style="font-size:18px">') .' '.$post['title'].'</h'.$level. '>';
			echo $post['content'];

			echo (isset($post['thumbnail']) && !empty($post['thumbnail']) ? '<img src="'.$post['thumbnail'].'" style="width:100%;height:auto;margin:5px 10px 10px 0;">' : '');
			if (!isset($post['button']['url']) || empty($post['button']['url']) || isset($post['button']['text']) || empty($post['button']['text'])) return;
			echo '<a href="'.$post['button']['url'].'" target="_blank" class="button button-primary">'.$post['button']['text'].'</a>';
		}
	}
}

if( is_admin() )
	new viewAdminBoxD1G1;


