<?php 
namespace pluginbrandslug\admin\form_fields;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  
if( ! class_exists( 'PluginField' ) )
{
    class thisPluginField
    {
        public function __construct()
        {
  
        }
        public function get_fields_form($formID){
            $fields= [];
			if ($formID == 'brand_emails_settings') {
				$fields=[
					[
						'headline' => 'Nastavení emailů',
						'description' => 'Pro správné používání emailů je potřeba přizpůsobit jejich vzhled a nastavení.',
					],
					[           
                        'headline' => 'Nastavení vzhledu emailu',     
						'columns' => [   
							[
								[
									'type' => 'color',
									'name' => 'footer_bg_color',
									'label' => 'Barva pozadí zápatí',
									'help_text' => 'Vyberte si barvu, kterou bude mít zápatí emailů',
									'value' => '#0a0a0a', // rgba(30,30,30,0.64)
									'saveAs' => 'meta',
								]
							],
							[
								[
									'type' => 'color',
									'name' => 'footer_color',
									'label' => 'Barva textu zápatí',
									'help_text' => 'Vyberte si barvu, kterou bude mít text  v zápatí emailů',
									'value' => '#ff00dd', // rgba(30,30,30,0.64)
									'saveAs' => 'meta',
								]
							],
							[
								[
									'type' => 'color',
									'name' => 'Links_color',
									'label' => 'Barva textu odkazů',
									'help_text' => 'Vyberte si barvu, kterou bude mít odkaz  v zápatí emailů',
									'value' => '#2199e8', 
									'saveAs' => 'meta',
								]
							]
						],
                        [
                            'type' => 'image',
                            'name' => 'header_logo',
                            'label' => 'Logo do hlavičky emailu',
                            'description' => 'Chcete-li vložit do emailu své logo, zde ho nahrajte',
                            'help_text' => 'Chcete-li vložit do emailu své logo, zde ho nahrajte. Nahrávejte ve formátu jpg, nebo png o šířce alespoň 200px',
                            'value' => '',
                            'floating_label' => true,
                            'saveAs' => 'meta'
                        ],     
						[
                            'type' => 'text',
                            'name' => 'reply_to_email',
                            'saveAs' => 'meta',
                            'label' => 'Email pro odpověď',
                            'help_text' => 'Vyplňte email, na který má přijít odpověď',
                        ]
                    ],
					[           
                        'headline' => 'Nastavení emailu o Aktualizacích',     
						[
                            'type' => 'editor',
                            'name' => 'mail_text_license_d1g1',
                            'label' => 'Text emailu',
                            'description' => 'Text emailu',
                            'help_text' => 'Pomocný text pro editor',
                            'floating_label' => true,
                            'saveAs' => 'meta',
                        ],
						[
                            'type' => 'text',
                            'name' => 'license_email_subject',
                            'saveAs' => 'meta',
                            'label' => 'Předmět emailu',
                            'help_text' => 'Vyplňte předmět, který má být uvedem v emailu s odeslanou licencí',
                        ],
						[
                            'type' => 'text',
                            'name' => 'send_to_email',
                            'saveAs' => 'meta',
                            'label' => 'Email odeslat na',
                            'help_text' => 'Vyplňte email, na který má být odesláno hlášení o aktualizaci',
                        ]
					]
				];
			} else if ($formID == 'update_report') {
				$plugins = [];
				$plugins_list = get_plugins();
				foreach ($plugins_list as $plugin => $value) {
					if ($plugin && isset($value['Name']))
						$plugins[$plugin] = $value['Name'];
				}
				$fields=[
					[
						'headline' => 'Jádro WP',
						'description' => 'Co z WP bylo aktualizováno?',
						'save_option' => 'send_mail',
						'button_text' => 'send_report',
						[
							'type' => 'checkbox',
							'name' => 'up_wp',
							'label' => 'Aktualizace Wordpressu',
							'saveAs' => 'meta',
						],
						[
							'type' => 'checkbox',
							'name' => 'up_theme',
							'label' => 'Aktualizace Šablony',
							'saveAs' => 'meta',
						],
						[
							'type' => 'checkbox',
							'name' => 'up_settings',
							'label' => 'Aktualizace Nastavení důležitých fcí (zabezpečení, zálohy a pod.)',
							'saveAs' => 'meta',
						]
					],
					[
						'headline' => 'Pluginy',
						'description' => 'Jaké pluginy byly aktualizovány',
						[
							'type' => 'checkbox',
							'name' => 'up_plugins',
							'label' => 'Aktualizace Nastavení důležitých fcí (zabezpečení, zálohy a pod.)',
							'saveAs' => 'meta',
							'options' => $plugins
						],
					],
					[
						'headline' => 'Připojit ke zprávě poznámku',
						[
                            'type' => 'editor',
                            'name' => 'up_content',
                            'label' => 'Poznámka',
                            'description' => 'Text emailu navíc',
                            'floating_label' => true,
                            'saveAs' => 'meta',
                        ],
					]
					];

			}
			
			return $fields;
        
        }
        public function get_fields_cpt_form($post_type){
            $fields= [];
            if ($post_type == 'license') {
                $fields=[
                    [
                        'type' => 'text',
                        'name' => 'license_author_email_d1g1',
                        'saveAs' => 'meta',
                        'label' => 'Email zákazníka',
                    ],
                    [
                        'type' => 'text',
                        'name' => 'transaction_ID_d1g1',
                        'saveAs' => 'meta',
                        'label' => 'ID Transakce',
                    ],
                    [
                        'type' => 'text',
                        'name' => 'license_ID_d1g1',
                        'saveAs' => 'meta',
                        'label' => 'Číslo licence',
                    ]
                ];
            }
            return $fields;
        }
    }
}


?>