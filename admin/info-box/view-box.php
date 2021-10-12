<?php 
/**
 * Zobrazení Rest API dat v adminu
 * 
 * @author Wedesin
 */ 
namespace pluginbrandslug\admin\info_box\view;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if( ! class_exists( 'viewAdminBoxWDS' ) )
{
    
	class viewAdminBoxWDS
	{

		public function __construct()
		{

		}
		/**
		 *  zobrazeni boxu
		 *
		 * @param none
		 * 
		 * @author Wedesin
		 * @return string
		 */
	
        public function wedesin_dashboard_widget_display($type){
			$this->display_box($type);
		}
		/**
		 *  box nastenka 
		 *
		 * @param type (default: plugins)
		 * 
		 * @author Wedesin
		 * @return string
		 */

		private function display_box($type="plugins") { 
			$lang = get_bloginfo('language');
			$rApi = new \pluginbrandslug\admin\info_box\call\getRestApiRequestWDS;
			$data = $rApi->get_data($lang, $type);
            if($data) {
				echo '<div class="card'.($type == 'plugins' ? ' info' : '').'">';

					if ($type == 'pluginsnews'){ 
						echo 	'<h2 style="margin-top:0; line-height: 24px">' .__("Novinky na webu WeDesIn", WDS_BRANDING).'</h2>';
					}
					?>

					<div class="wedesin-widget">
					<?php 
						foreach ($data as $post) {
							if($post){
								
								echo '<h'.($type == 'plugins' ? '2' : '3').' style="'.($type == 'plugins' ? '' : 'font-size:18px') .'">'.$post['title'].'</h'.($type == 'plugins' ? '2>' : '3>');
								echo (!empty($post['content']) ? '<p>'.$post['content'].'</p>' : '');
								echo (!empty($post['thumbnail']) ? '<img src="'.$post['thumbnail'].'" style="float:left; width:100%;height:auto;margin:5px 10px 10px 0;">' : '');
								echo (!empty($post['button']) && !empty($post['button']['url']) && !empty($post['button']['text']) ? '<a href="'.$post['button']['url'].'" target="_blank" class="button button-primary">'.$post['button']['text'].'</a>' : '');
							}
						}
					?>
					</div>
					<?php
				echo '</div>';
			}
		}
	}
}

if( is_admin() )
	new \pluginbrandslug\admin\info_box\view\viewAdminBoxWDS;


