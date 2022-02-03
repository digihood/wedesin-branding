<?php 
/**
 * Popis třídy
 *
 * 
 * @author Wedesin
 */ 

use pluginbrandslug\framework\monolog\log_function\d1g1_monolog;
use pluginbrandslug\framework\d1g1_plugins\d1g1plugins;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'overview_logD1G1' ) )
{
	class overview_logD1G1
	{

        private $plugins; 

		public function __construct()
		{
       $this->plugins = new d1g1plugins;
       

    }


    public function get_plugin_json(){
      $jsonsplit = new d1g1_monolog;
      $activeplugins = $this->plugins->d1g1_get_plugins(1);
      $upload_dir = wp_upload_dir();
      $pluginlogs = [];
      foreach($activeplugins as $activeplugin){
        $file = $upload_dir['basedir']. '/d1g1-' . $activeplugin['TextDomain'] . '-logs/' .$activeplugin['TextDomain']. '.json';
        if(file_exists($file) && filesize($file)){
          $json = file_get_contents($file);
          $lines = count(file($file));
          
          if($lines !== 1){
            $array = $jsonsplit->json_split_objects($json);
            $count = count($array) - 1;
            for($i = 0; $i <= $count; $i++){
              
              $key = array_keys($array);
              $jsondata = json_decode($array[$i]);
             
              if(!isset($pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name]))$pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name] = 0;
                $pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name]++;
            }
          }else{
            $jsonsplit->json_split_objects($json);
            $jsondata = json_decode($json);
           
            if(!isset($pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name]))$pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name] = 0;
              $pluginlogs[$activeplugin['TextDomain']][$jsondata->level_name]++;   
            }
          }

         
        } 
       
          
        return $pluginlogs;  
      } 
    


    public function overview_plugins_log(){
      $data = $this->get_plugin_json();
      
      $activeplugins = $this->plugins->d1g1_get_plugins(1);
      $upload_dir = wp_upload_dir();
      $D1G1_error_counts = get_option('D1G1_error_counts');
      
      foreach($activeplugins as $activeplugin){
        $file = $upload_dir['baseurl']. '/d1g1-' . $activeplugin['TextDomain'] . '-logs/' .$activeplugin['TextDomain']. '.json';
      
        if(isset($data[$activeplugin['TextDomain']]) && $data[$activeplugin['TextDomain']])$plugin_data = $data[$activeplugin['TextDomain']];
        echo '<div class="plugin-card">';
        echo '<p class="h4" "><a href="'. $file .'" class="button button-primary" download>Stahnout LOG</a></p>';
        echo '<p class="h2"><b>'. $activeplugin['name'] .'</b></h2>';
        echo '<div class="d1g1-widget">';
        if(isset($data[$activeplugin['TextDomain']]) && $data[$activeplugin['TextDomain']]){
          foreach ($plugin_data as $key => $value) {
            if(isset($key) && $key && isset($value) && $value ){
           
                echo '<p><b>'.$key.'</b> : ' .
                ($key == 'INFO' ? (isset($D1G1_error_counts[$activeplugin['TextDomain']][$key]) && $D1G1_error_counts[$activeplugin['TextDomain']][$key] !== $plugin_data[$key] ? '<font color="orange">'.$value.'</font>' : $value)  : (isset($D1G1_error_counts[$activeplugin['TextDomain']][$key]) && $D1G1_error_counts[$activeplugin['TextDomain']][$key] !== $plugin_data[$key] ? '<font color="red">'.$value.'</font>' : $value) )
                . '</p>';
              
            }
          }
        }else {
          echo '<p><b>žádný log</b></p>';
        }
        echo '</div>';
        echo '</div>';
      }
     
    }

    public function count_all_logs_output(){
      $data = $this->get_plugin_json();
      $activeplugins = $this->plugins->d1g1_get_plugins(1);
      $debug = 0;
        $info = 0;
        $notice = 0;
        $warning = 0;
        $error = 0;
        $critical = 0;
        $alert = 0;
        $emergency = 0;
      foreach ($activeplugins as $activeplugin) {
        if(isset($data[$activeplugin['TextDomain']]['DEBUG']) && $data[$activeplugin['TextDomain']]['DEBUG']){
          $debug += ($data[$activeplugin['TextDomain']]['DEBUG']);
        }
        if(isset($data[$activeplugin['TextDomain']]['INFO']) && $data[$activeplugin['TextDomain']]['INFO']){
          $info += $data[$activeplugin['TextDomain']]['INFO'];
        }
        if(isset($data[$activeplugin['TextDomain']]['NOTICE']) && $data[$activeplugin['TextDomain']]['NOTICE']){  
          $notice += $data[$activeplugin['TextDomain']]['NOTICE'];
        }
        if(isset($data[$activeplugin['TextDomain']]['WARNING']) && $data[$activeplugin['TextDomain']]['WARNING']){  
          $warning += $data[$activeplugin['TextDomain']]['WARNING'];
        } 
        if(isset($data[$activeplugin['TextDomain']]['ERROR']) && $data[$activeplugin['TextDomain']]['ERROR']){  
          $error += $data[$activeplugin['TextDomain']]['ERROR'];
        }
        if(isset($data[$activeplugin['TextDomain']]['CRITICAL']) && $data[$activeplugin['TextDomain']]['CRITICAL']){ 
          $critical += $data[$activeplugin['TextDomain']]['CRITICAL'];
        }
        if(isset($data[$activeplugin['TextDomain']]['ALERT']) && $data[$activeplugin['TextDomain']]['ALERT']){  
          $alert += $data[$activeplugin['TextDomain']]['ALERT'];
        }
        if(isset($data[$activeplugin['TextDomain']]['EMERGENCY']) && $data[$activeplugin['TextDomain']]['EMERGENCY']){  
          $emergency += $data[$activeplugin['TextDomain']]['EMERGENCY'];
        }    
      }
     
      $count_logs = [
        'debug'  => $debug,
        'info' => $info,
        'notice' => $notice,
        'warning' => $warning,
        'error' => $error,
        'critical' => $critical,
        'alert' => $alert,
        'emergency' => $emergency,
      ];
     
      return $count_logs;
    }


    
        
  }
   
}