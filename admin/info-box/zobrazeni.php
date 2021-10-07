<?php 
/**
 * Zobrazení dat v adminu
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'viewAdminBoxWDS' ) )
{
    
	class viewAdminBoxWDS
	{

		public function __construct()
		{
			
			//add widgets do dashboard
			add_action('wp_dashboard_setup', [$this, 'custom_dash_widget_wed'] );

		}

	   /**
     *  přidaní na nastenku ??
     *
     * @param none
     * 
     * @author Wedesin
     * @return string
     */
		
		public function custom_dash_widget_wed(){
           
			add_meta_box('withdraw_to_bank', 'Nástěnka WeDesIn', array($this, 'wedesin_dashboard_widget_display'),'dashboard', 'side','high' );
		}
	   /**
     *  zobrazeni boxu
     *
     * @param none
     * 
     * @author Wedesin
     * @return string
     */
        public function wedesin_dashboard_widget_display(){
			$this->display_box();
		}
	   /**
     *  box nastenka 
     *
     * @param type (default: none)
     * 
     * @author Wedesin
     * @return string
     */
		private function display_box($type="rest_api") { 

			$lang = get_bloginfo('language');
			$rApi = new getRestApiRequestWDS;
			$data = $rApi->get_data($lang, $type);
			echo $data;
			?>
			<h2 style="margin-top:0"><?= __('Novinky na webu WeDesIn', WDS_BRANDING) ?></h2>
			<?php 
			if ($lang == "en-US" || $lang == "cs-CZ" /* || slovenština ještě $lang == "en-US" */ ) {

			} else {

			}
			?>

		<div class="wedesin-widget">
			<br>
			<h3 style="font-size:18px">Převod obrázků online mezi formáty JPG, PNG, BMP, GIF a PDF</h3>
			<p>Potřebujete někdy převést obrázky mezi výše uvedenými formáty? Použijte náš online nástroj.</p>
			<a href="https://www.wedesin.cz/online-nastroje/online-prevod-obrazku-mezi-png-jpg-gif-bmp-a-pdf" target="_blank" class="button button-primary">Přejít na online převodník obrázků</a>
		</div>

		<?php


		}

	}

}

if( is_admin() )
	new viewAdminBoxWDS;


