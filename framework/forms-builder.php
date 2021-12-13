<?php 
namespace pluginbrandslug\framework\forms_builder;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
use pluginbrandslug\framework\forms_core\D1G1_Front_Form;
use pluginbrandslug\admin\form_fields\thisPluginField;
if( ! class_exists( 'formsBuilderD1G1' ) )
{
	class formsBuilderD1G1
	{

		private $fields;
		private $d1g1_form;

		public function __construct( )
		{
			

            //prozatím zakomentované (save form zatím nefunkční)
			//add_action( 'wp', [$this, 'save_form'] );
			//add_action( 'admin_init', [$this, 'set_data'] );
			add_action( 'admin_init', [$this, 'save_form'] );
		}
		public function set_data() {
			//$this->d1g1_form = new D1G1_Front_Form($this->fields);
			$this->fields = $this->get_fields_form($this->form_id);
		}

        /**
         * Vyhotovení formuláře
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */
		public function display_form($formID ) {
			$field = $this->get_fields_form($formID);
			$this->d1g1_form = new D1G1_Front_Form($field);
			echo $this->d1g1_form->get_form($formID );
		}
	
		public function save_form() {	
			$inputs = filter_input_array(INPUT_POST);
            if (isset($inputs['form_id_d1g1']) && !empty($inputs['form_id_d1g1']) && !empty($inputs['plugin_id_d1g1']) && $inputs['plugin_id_d1g1'] == D1G1_BRANDING ) {
				$formID = $inputs['form_id_d1g1'];
				$field = $this->get_fields_form($formID);
				if(!empty($field)){
					$this->d1g1_form = new D1G1_Front_Form($field);	
					return $this->d1g1_form->save_form();
				}
				return;

            }
			
			//preprint($this->fields);
			//return $this->d1g1_form->save_form();
		}
		public function get_fields_form($formID){
			$fields= [];
			$tpf = new thisPluginField;
			$fields = $tpf->get_fields_form($formID);
			return $fields;

		}
		public function get_fields_cpt_form($post_type){
			$fields= [];
			$tpf = new thisPluginField;
			$fields = $tpf->get_fields_cpt_form($post_type);
			return $fields;
		}
		
		
	}
	
    new formsBuilderD1G1;

}