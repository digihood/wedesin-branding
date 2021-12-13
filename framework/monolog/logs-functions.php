<?php 
/**
 * monolog 
 *
 *  $log = new \pluginbrandslug\framework\monolog\log_function\d1g1_monolog;
 *  $array = ['data' => $arg,'data2' => $arg,'data3' => $arg,];
 *  $log->d1g1_add_log(get_class($this),'INFO','send_update_email', $array); 
 * 
 * @author Wedesin
 */ 
     
namespace pluginbrandslug\framework\monolog\log_function;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\HtmlFormatter;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'd1g1_monolog' ) )
{
	class d1g1_monolog
	{

        //private $variable; 

		public function __construct()
		{
      
        }


         /**
         * log framework , možnost zapisu do více souboru,pod více zpusoby  v commentu možnost do html
         *
         * @param $channel - jmeno channelu odkud pricházi zprava 
         * 
         * @author digihood
         * @return function
         */ 
        public function d1g1_log_louder($channel){
            $logger = new Logger($channel);
            //Create the formatter
            $jsonformatter = new JsonFormatter();
            //$htmlformatter = new HtmlFormatter();
            //Set the formatter
            $directory = $this->d1g1_get_log_folder();
            $handlerjson = new StreamHandler($directory . '/'. D1G1_BRANDING .'.json');
            $handlerjson->setFormatter($jsonformatter); 
            //$handlerhtml = new StreamHandler($directory . '/'. D1G1_BRANDING .'.html');
            //$handlerhtml->setFormatter($htmlformatter);             
            //Set the handler
            $logger->pushHandler($handlerjson);
           // $logger->pushHandler($handlerhtml);
            return $logger;
        }

        /**
         * nastaveni logovaci složky ze setup souboru
         *
         * 
         * @author digihood
         * @return dir
         */ 

        public function d1g1_get_log_folder() {
            $upload_dir = wp_upload_dir();
            $return = $upload_dir['basedir'] . '/'. D1G1_LFILEDIR_BRAND .'';
            return $return;
        }
        
         /**
         * přidaní log zapisu 
         * @param $channel - jmeno channelu odkud pricházi zprava 
         * @param $level - uroven zpravy (DEBUG,INFO,NOTICE,WARNING,CRITICAL,ALERT,EMERGENCY)
         * @param $mess - Zprava,akce,popis udalosti 
         * @param $array - možnost poslat více dat do zapisu  ['data' => $arg,'data2' => $arg,'data3' => $arg,];
         * @author digihood
         * 
         */ 

        public function d1g1_add_log($channel,$level,$mess = '', $array = []){
            $logger = $this->d1g1_log_louder($channel);
       
            switch($level){
                case 'DEBUG':
                    if($mess && $array){
                        $logger->DEBUG($mess, $array);
                    }elseif($mess  ){
                        $logger->DEBUG($mess); 
                    }
                break;
                case 'INFO':
                if($mess && $array){
                        $logger->INFO($mess, $array);
                    }elseif($mess  ){
                        $logger->INFO($mess); 
                    }
                break;
                case 'NOTICE':
                    if($mess && $array){
                        $logger->NOTICE($mess, $array);
                    }elseif($mess  ){
                        $logger->NOTICE($mess); 
                    }
                break;
                case 'WARNING':
                    if($mess && $array){
                        $logger->WARNING($mess, $array);
                    }elseif($mess  ){
                        $logger->WARNING($mess); 
                    }
                break;
                case 'CRITICAL':
                    if($mess && $array){
                        $logger->CRITICAL($mess, $array);
                    }elseif($mess  ){
                        $logger->CRITICAL($mess); 
                    }
                break;
                case 'ALERT':
                    if($mess && $array){
                        $logger->ALERT($mess, $array);
                    }elseif($mess  ){
                        $logger->ALERT($mess); 
                    }
                break;
                case 'EMERGENCY':
                    if($mess && $array){
                        $logger->EMERGENCY($mess, $array);
                    }elseif($mess){
                        $logger->EMERGENCY($mess); 
                    }
                 
                break;

            }

       }
         /**
         * vypis logu 
         * 
         * 
         * @author digihood
         * @return dir
         */ 
        public function d1g1_get_log_file(){
            $directory = $this->d1g1_get_log_folder();
            $file = $directory . '/' . D1G1_BRANDING . '.json';
            if(file_exists($file)){
                $data = file_get_contents($file);
                if($data){
                    $datas = $this->json_split_objects($data);
                    if(!$datas) return; 
                    include_once( 'views/table-header.php' );
                    foreach($datas as $row){
                        if($row){
                            $someArray = json_decode( $row,true );
                            if (isset($someArray['datetime']['date']) && $someArray['datetime']['date']) {
                                $showtime = $someArray['datetime']['date'] . '<br> zone_type:' . $someArray['datetime']['timezone_type'] . '<br> typezone:' . $someArray['datetime']['timezone'] ;
                            }else {
                                $showtime = $this->d1g1_setup_time($someArray['datetime']);
                            }      
                            echo '<tr>';
                            echo '<td>'.$showtime.'</td>';
                            echo '<td>'.$someArray['channel'].'</td>';
                            echo '<td><b>'.$someArray['level_name'].'</b></td>';
                            echo '<td>'.$someArray['message'].'</td>';
                            if(isset($someArray['context']) && $someArray['context']){
                           
                              //  preprint($someArray['context']);
                                foreach($someArray['context'] as $rows=>$context){
                                    if (is_array($context)){
                                        $contextinarray = implode(' || ',$context );
                                    }
                                    if(isset($contextinarray) && $contextinarray) {
                                        echo ($contextinarray ? '<td>'.$rows.'   : <b>'.$contextinarray.'</b><br></td>' : '');
                                    }else {
                                        echo ($context ? '<td>'.$rows.'   : <b>'.$context.'</b><br></td>' : '');
                                    }
                               
                                }
                                
                            }  
                        }
                    }
                }
            }
            include_once( 'views/table-footer.php' );
        }


        /**
         * json_split_objects - Return an array of many JSON objects
         *
         * In some applications (such as PHPUnit, or salt), JSON output is presented as multiple
         * objects, which you cannot simply pass in to json_decode(). This function will split
         * the JSON objects apart and return them as an array of strings, one object per indice.
         *
         * @param string $json  The JSON data to parse
         *
         * @return array
         */
        function json_split_objects($json)
        {
            $q = FALSE;
            $len = strlen($json);
            for($l=$c=$i=0;$i<$len;$i++)
            {   
                $json[$i] == '"' && ($i>0?$json[$i-1]:'') != '\\' && $q = !$q;
                if(!$q && in_array($json[$i], array(" ", "\r", "\n", "\t"))){continue;}
                in_array($json[$i], array('{', '[')) && !$q && $l++;
                in_array($json[$i], array('}', ']')) && !$q && $l--;
                (isset($objects[$c]) && $objects[$c] .= $json[$i]) || $objects[$c] = $json[$i];
                $c += ($l == 0);
            }   
            return $objects;
        }
         /**
         * zpracovani času
         * 
         * @author digihood
         * @return time
         */ 
        function d1g1_setup_time($time){
            $alltime = str_split($time,10);
               $datum = $alltime[0];
               $edittime = str_replace('T', '', $alltime[1] );
               $time = str_replace('.', '', $edittime );
               $showtime = $time .' '. $datum;
               return $showtime;
              

        }
        /**
         * získaní IP uživatele
         * 
         * @author digihood
         * @return ip
         */ 
        function d1g1_get_the_user_ip() {
            if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            }
            return apply_filters( 'wpb_get_ip', $ip );
            }
            

     


    }
     
}