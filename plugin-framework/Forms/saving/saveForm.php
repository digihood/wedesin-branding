<?php
namespace pluginone\framework\Forms\saving;
use pluginone\framework\Forms\Validation\SetValidationRules;
use pluginone\framework\Forms\Validation\Validator;
use pluginone\framework\Globals;
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hlavní třida pro ukladaní dat z formuláře
 * 
 */

if (!class_exists('saveForm')) {
    class saveForm
    {


        private $type_notices = '';
        /**
         * Constructor function that adds an action to save_handler when the admin initializes.
         *
         */
        public function __construct(){
            add_action( 'admin_init', [$this, 'save_handler'] );
        }
        
        /**
         * Tato PHP funkce zpracovává uložení dat formuláře po ověření.
         *
         * @throws None
         * @return void
         */

        public function save_handler(){
            if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == Globals::$FWDIGI_PLUGINID.'-submit'){
                $Rules = new  SetValidationRules($_REQUEST);
                $validator = new Validator($Rules,$_REQUEST);
                if($validator->is_valid()){
                    foreach($Rules->values as $keys => $value){
                        foreach($_REQUEST as $save_name=> $data){
                            if(strpos($save_name,$keys) !== false){
                                $save_type = $Rules->get_save_type($keys);
                                $this->save_by_type($save_type,$save_name,$value);
                            }
                        }

                    }
                
                }
                
            }
        }

        /**
         * Uloží danou hodnotu podle typu.
         *
         * @param string $save_type Typ uložení k provedení. Buď 'meta' nebo 'options'.
         * @param string $save_name Název proměnné, kterou se má uložit.
         * @param mixed $value Hodnota k uložení.
         * @throws Exception Jestliže je poskytnut neplatný typ uložení.
         * @return mixed Výsledek operace uložení, pokud existuje.
         */

        protected function save_by_type($save_type,$save_name,$value){
            switch ($save_type) {
                case 'meta':
                    return $this->meta_save($save_name,$value);
                    break;
                case 'options':
                        $this->options_save($save_name,$value);
                        $this->type_notices = 'success';
                        add_action('admin_notices', [$this, 'build_notices']);
                    
                    break;
              
            }
        }
        /**
         * Uložení data do options
         * 
         * @param string $save_name Název proměnné, kterou se má uložit.
         * @param mixed $value Hodnota k uložení.
         */
        protected function options_save($save_name,$value){
            return update_option($save_name,$value);
        }

        /**
         * Uložení data do meta
         * 
         * @param string $save_name Název proměnné, kterou se má uložit.
         * @param mixed $value Hodnota k uložení.
         */
        protected function meta_save($save_name,$value){
            //soon
        }

        /**
     * Metoda pro vytvoření upozornění s chybami
     */
    public function build_notices(){
            // ob_start();
    ?>

            <div class="notice notice-<?= $this->type_notices; ?> d1g1-notice is-dismissible">
                <?php 
                    switch ($this->type_notices) {
                        case 'error':
                            echo '<p>'. __('Nastavení nebylo uloženo', 'digi-framework'). '</p>';
                            break;
                        
                        case 'success':
                            echo '<p>'. __('Nastavení bylo uloženo', 'digi-framework'). '</p>';
                            break;
                    }
                ?>
                
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">Skrýt toto upozornění.</span></button>
            </div>
    <?php
            // $output = ob_get_contents();
            // ob_end_clean();
            // return $output;
        }
    }
    new saveForm;
}