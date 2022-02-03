<?php 
/**
 * vytvoření UTM odkazů 
 * @param $content - v jake casti webu se odkaz nachazí
 * @param $target - nepovinný , cílova url defaut je digihood
 * 
 * @author Wedesin
 */ 
namespace pluginbrandslug\framework\utm;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'utm_d1g1' ) )
{
	class utm_d1g1
	{

        private $campaign;
        private $content;
        private $source; 
        private $medium; 
        private $target; 
		public function __construct( $content , $target = '')
		{   
            $this->campaign = D1G1_BRANDING;
            $this->content = $content;
            $this->source = get_home_url();
            $this->medium = 'referral';
            $this->target = ( $target ? $target : 'http://digihood.cz');
           
        }

        public function base_url(){
           
            $url = $this->target . '/?utm_source=' . $this->source . '&utm_medium=' . $this->medium . '&utm_campaign=' . $this->campaign . '&utm_content=' . $this->content;

            return $url;
        }

  
    }
    
}