<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
  
/**
 * Print result with pre tag
 *
 * @param $lang string
 * 
 * @author digihood
 * @return echo string
 */ 

if ( !function_exists('preprint') ) {

    function preprint( $print ) {

        echo '<pre>';

        echo print_r( $print );

        echo '</pre>';

    }

}

/**
 * Vrátí správnou délku stringu
 *
 * @param $value string
 * 
 * @author digihood
 * @return int
 */ 
if ( !function_exists('valid_leght_string') ) {

    function valid_leght_string($value) {
        $strip = (strip_tags($value));
        $strip = trim($strip);
        $conversion_table = Array(
            'ä'=>'a',
            'Ä'=>'A',
            'á'=>'a',
            'Á'=>'A',
            'à'=>'a',
            'À'=>'A',
            'ã'=>'a',
            'Ã'=>'A',
            'â'=>'a',
            'Â'=>'A',
            'č'=>'c',
            'Č'=>'C',
            'ć'=>'c',
            'Ć'=>'C',
            'ď'=>'d',
            'Ď'=>'D',
            'ě'=>'e',
            'Ě'=>'E',
            'é'=>'e',
            'É'=>'E',
            'ë'=>'e',
            'Ë'=>'E',
            'è'=>'e',
            'È'=>'E',
            'ê'=>'e',
            'Ê'=>'E',
            'í'=>'i',
            'Í'=>'I',
            'ï'=>'i',
            'Ï'=>'I',
            'ì'=>'i',
            'Ì'=>'I',
            'î'=>'i',
            'Î'=>'I',
            'ľ'=>'l',
            'Ľ'=>'L',
            'ĺ'=>'l',
            'Ĺ'=>'L',
            'ń'=>'n',
            'Ń'=>'N',
            'ň'=>'n',
            'Ň'=>'N',
            'ñ'=>'n',
            'Ñ'=>'N',
            'ó'=>'o',
            'Ó'=>'O',
            'ö'=>'o',
            'Ö'=>'O',
            'ô'=>'o',
            'Ô'=>'O',
            'ò'=>'o',
            'Ò'=>'O',
            'õ'=>'o',
            'Õ'=>'O',
            'ő'=>'o',
            'Ő'=>'O',
            'ř'=>'r',
            'Ř'=>'R',
            'ŕ'=>'r',
            'Ŕ'=>'R',
            'š'=>'s',
            'Š'=>'S',
            'ś'=>'s',
            'Ś'=>'S',
            'ť'=>'t',
            'Ť'=>'T',
            'ú'=>'u',
            'Ú'=>'U',
            'ů'=>'u',
            'Ů'=>'U',
            'ü'=>'u',
            'Ü'=>'U',
            'ù'=>'u',
            'Ù'=>'U',
            'ũ'=>'u',
            'Ũ'=>'U',
            'û'=>'u',
            'Û'=>'U',
            'ý'=>'y',
            'Ý'=>'Y',
            'ž'=>'z',
            'Ž'=>'Z',
            'ź'=>'z',
            'Ź'=>'Z'
        );
        $return = strtr($strip, $conversion_table);
        $return = str_replace( array("\r", "\n"), '', $return );
        $num = strlen($return);

        return $num;
    }

}

/**
 * get wedesin plugins
 *
 * @param $lang string
 * 
 * @author digihood
 * @return echo string
 */ 

if ( !function_exists('d1g1_get_plugins') ) {

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
                                'activated' => false
                            ];
                        }
                    }
                }
            return $data;
            break;
        endswitch;

    }






}