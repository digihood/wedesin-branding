<?php 
namespace pluginbrandslug\framework\form_validation;
/**
 * validace formulařu
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'D1G1validform' ) )
{
	class D1G1validform
	{

        //private $variable; 

		public function __construct()
		{
            //set variable
            //$this->variable = '';
            add_action('wp_ajax_d1g1_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_d1g1_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1);

            add_action('wp_ajax_d1g1_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_d1g1_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1);

            add_action('wp_ajax_d1g1_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_d1g1_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1);

        }

         /**
         * validace range pole
         *
         * @param $inputs
         *        $name
         * 
         * @author digihood
         * 
         */ 

        public function d1g1_range_valid($inputs, $name){
            $unit = (isset($inputs[$name.'_unit']) ? $inputs[$name.'_unit'] : '');
            if (!empty($unit)) {
                if (!filter_var($unit, FILTER_VALIDATE_EMAIL)) {
                    $validated[$name.'_unit'] = [
                        'value' => $inputs[$name.'_unit'],
                        'valid' => true,
                        'msg' => "",
                    ];
                }
            }
        }

        /**
         * validace email pole
         *
         * @param $value
         *        
         * 
         * @author digihood
         * 
         */ 

        public function d1g1_email_valid($value){
            if (!empty($value)) {

                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $valid = false;
                    $msg = 'Pole není email';
                    $allvalid = false;
                }
            }
        }

        /**
         * validace delky pole
         *
         * @param $value
         *        
         * 
         * @author digihood
         * 
         */ 

        public function d1g1_lenght_valid($value){
            $num = $this->valid_leght_string($value);

            if ($num > $field['length']) {
                $valid = false;
                $msg = 'Příliš mnoho znaků (' . $num . ')';
                $allvalid = false;
            }
        }

        /**
         * validace povinosti pole
         *
         * @param $value
         *        
         * 
         * @author digihood
         * 
         */ 

        public function d1g1_if_required($value){
            if (is_array($value)) {
                if (empty($value)) {
                    $valid = false;
                    $msg = 'Povinné pole';
                    $allvalid = false;
                }
            } else {
                if ($value == '' || !$value) {
                    $valid = false;
                    $msg = 'Povinné pole';

                    $allvalid = false;
                }
            }
        }


          /**
         * validace textu pole
         *
         * @param $value
         *        
         * 
         * @author digihood
         * 
         */ 

        public function valid_leght_string($value) {
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

         /**
         * droped callback file
         *
         * @param 
         *        
         * 
         * @author digihood
         * @return echo
         */ 

        public function handle_dropped_files_callback()
        {
            status_header(200);

            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
            $num_files = count($_FILES['file']['tmp_name']);

            $newupload = 0;

            if (!empty($_FILES)) {
                $files = $_FILES;

                foreach ($files as $file) {

                    /* UPLOAD DO MÉDIÍ WORDPRESSU
                    $newfile = array (
                        'name' => $file['name'],
                        'type' => $file['type'],
                        'tmp_name' => $file['tmp_name'],
                        'error' => $file['error'],
                        'size' => $file['size']
                    );

                    $_FILES = array('upload'=>$newfile);
                    */

                    $upload_folder_path = WP_CONTENT_DIR . '/order-files';

                    if (!file_exists($upload_folder_path)) {
                        mkdir($upload_folder_path);
                    }

                    //preprint( $file );
                    $temp = $_FILES['photo']['tmp_name'];
                    $data = $file['name'];
                    $extten = "." . substr($data, strrpos($data, '.') + 1);
                    $file_name = substr($data, 0, strrpos($data, '.'));
                    $finalpath = $upload_folder_path . '/' . $file_name .  $extten;

                    //oprava opakovaných souborů
                    if (file_exists($finalpath)) {

                        for ($i = 1; $i < 999; $i++) {

                            $finalpath = $upload_folder_path . '/' . $file_name . "-" . $i .  $extten;

                            if (!file_exists($finalpath)) break;
                        }
                    }

                    //UPLOAD DO MÉDIÍ WORDPRESSU $newupload = media_handle_upload( $file, 0 );*/                        
                    if (move_uploaded_file($temp, $finalpath)) {
                        $newupload = $finalpath;
                    } else {
                        $newupload = 0;
                    }
                }
            }

            echo $newupload;
            die();
        }

         /**
         * deleted file callback
         *
         * @param u
         * 
         * @author digihood
         * @return die/echo
         */ 

        public function handle_deleted_files_callback()
        {
            if (isset($_REQUEST['media_id'])) {
                $post_id = $_REQUEST['media_id'];

                //$status = wp_delete_attachment($post_id, true);
                $status = !unlink($post_id);

                if ($status)
                    echo json_encode(array('status' => 'OK'));
                else
                    echo json_encode(array('status' => 'FAILED'));
            }

            die();
        }

         /**
         * get files callback
         *
         * @param 
         * 
         * @author digihood
         * @return echo/die
         */ 

        public function get_files_callback()
        {
            $images = [];
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR;
            if (isset($_REQUEST['images'])) {
                $image_ids = $_REQUEST['images'];
                if ($image_ids) {
                    foreach (explode(',', $image_ids) as $image_id) {
                        $meta = wp_get_attachment_metadata($image_id);
                        if ($meta) {
                            $images[] = [
                                'ID' => $image_id,
                                'name' => get_the_title($image_id),
                                'size' => filesize($upload_path . $meta['file']),
                                'url' => wp_get_attachment_url($image_id),
                            ];
                        }
                    }
                }
                echo json_encode($images);
            } else {
                echo json_encode(false);
            }

            die();
        }

        public function d1g1_notice_form($notice){

            if($notice == 'error'){
                ?>
                <div class="notice notice-error d1g1-notice is-dismissible">
                <?= '<p>'.__('Nastavení se nepodařilo uložit. Formulář obsahuje chyby. Zkontrolujte správnost vyplnění následujících položek.', TM_PLUGSEC). '</p>'?>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?=''. __('Skrýt toto upozornění.', TM_PLUGSEC). ''?></span></button>
                </div>
            <?php 
            }elseif ($notice == 'success'){
                ?>
                <div class="notice notice-success d1g1-notice is-dismissible">
               <?= '<p>'. __('Nastavení bylo uloženo.', TM_PLUGSEC) . '</p>' ?>
               <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?=''. __('Skrýt toto upozornění.', TM_PLUGSEC). ''?></span></button>
               </div>
           <?php
            }
         
        }


    }
     new D1G1validform;
}