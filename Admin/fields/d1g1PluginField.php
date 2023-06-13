<?php 
namespace digibrand\admin\fields;
use digibrand\framework\Globals;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  
if( ! class_exists( 'd1g1PluginField' ) )
{
    class d1g1PluginField
    {
        public static function get_fields_form($formID){
			
            $fields= [];
			if($formID == 'brand_emails_settings'){
				$fields = [
					'headline' => 'Nastavení emailů',
					'description' => 'Pro správné používání emailů je potřeba přizpůsobit jejich vzhled a nastavení.',
					'enctype' => '',
					'sections' => [
						'section1' => [
							'headline' => 'Nastavení vzhledu emailu',
							'fields' => [  
									[
										'type' => 'color',
										'name' => 'footer_bg_color',
										'label' => 'Barva pozadí zápatí',
										'help_text' => 'Vyberte si barvu, kterou bude mít zápatí emailů',
										'value' => '#0a0a0a', // rgba(30,30,30,0.64)
										'saveAs' => 'options',
										'options' => [
											'width' => 'full',
										],
									],
									[
										'type' => 'color',
										'name' => 'footer_color',
										'label' => 'Barva textu zápatí',
										'help_text' => 'Vyberte si barvu, kterou bude mít text  v zápatí emailů',
										'value' => '#ff00dd', // rgba(30,30,30,0.64)
										'saveAs' => 'options',
										'options' => [
											'width' => 'half',
										],
									],
									[
										'type' => 'color',
										'name' => 'Links_color',
										'label' => 'Barva textu odkazů',
										'help_text' => 'Vyberte si barvu, kterou bude mít odkaz  v zápatí emailů',
										'value' => '#2199e8', 
										'saveAs' => 'options',
										'options' => [
											'width' => 'half',
										],
									],
									[
										'type' => 'image',
										'name' => 'header_logo',
										'label' => 'Logo do hlavičky emailu',
										'description' => 'Chcete-li vložit do emailu své logo, zde ho nahrajte',
										'help_text' => 'Chcete-li vložit do emailu své logo, zde ho nahrajte. Nahrávejte ve formátu jpg, nebo png o šířce alespoň 200px',
										'value' => '',
										'floating_label' => true,
										'saveAs' => 'options',
										'options' => [
											'width' => 'half',
										],
									],
									[
										'type' => 'text',
										'name' => 'reply_to_email',
										'label' => 'Email pro odpověď',
										'help_text' => 'Vyplňte email, na který má přijít odpověď',
										'saveAs' => 'options',
										'options' => [
											'width' => 'full',
										],
									]    

								]
							],
							'section2' => [
								'headline' => "Nastaveni emailu o aktualizacích", 
								'fields' => [
									[
										'type' => 'textarea',
										'name' => 'mail_text_license_d1g1',
										'label' => 'Text emailu',
										'description' => 'Text emailu',
										'help_text' => 'Pomocný text pro editor',
										'floating_label' => true,
										'saveAs' => 'options',
									],
									[
										'type' => 'text',
										'name' => 'license_email_subject',
										'saveAs' => 'options',
										'label' => 'Předmět emailu',
										'help_text' => 'Vyplňte předmět, který má být uvedem v emailu s odeslanou licencí',
									],
									[
										'type' => 'text',
										'name' => 'send_to_email',
										'saveAs' => 'options',
										'label' => 'Email odeslat na',
										'help_text' => 'Vyplňte email, na který má být odesláno hlášení o aktualizaci',
									]
								]
					
							],
						]
					];
			
			}elseif($formID == 'update_report'){
				
				add_filter('d1g1_button_form-'.Globals::$FWDIGI_PLUGINID.'_'.$formID,function ($text) { $text = 'Odeslat hlášení'; return $text;} );
				$plugins = [];
				$plugins_list = get_plugins();
				foreach ($plugins_list as $plugin => $value) {
					if ($plugin && isset($value['Name']))
						$plugins[$plugin] = $value['Name'];
				}
				
				$fields = [
					'headline' => 'Aktualizace',
					'description' => '',
					'enctype' => '',
					'sections' => [
						'section1' => [
							'headline' => 'Jádro WP',
							'description' => 'Co z WP bylo aktualizováno?',
							'fields' => [
								[
									'type' => 'checkbox',
									'name' => 'up_wp',
									'label' => 'Aktualizace Wordpressu',
									'saveAs' => 'options',
								],
								[
									'type' => 'checkbox',
									'name' => 'up_theme',
									'label' => 'Aktualizace Šablony',
									'saveAs' => 'options',
								],
								[
									'type' => 'checkbox',
									'name' => 'up_settings',
									'label' => 'Aktualizace Nastavení důležitých fcí (zabezpečení, zálohy a pod.)',
									'saveAs' => 'options',
								]  
							]
						],
						'section2' => [
							'headline' => 'Pluginy',
							'description' => 'Jaké pluginy byly aktualizovány',

							'fields' => [
								[
									'type' => 'checkbox',
									'name' => 'up_plugins',
									'label' => 'Aktualizace Nastavení důležitých fcí (zabezpečení, zálohy a pod.)',
									'saveAs' => 'options',
									'options' => [
										'checkboxs' => $plugins
									],
								],
							]
							],
							'section3' => [
								'headline' => 'Připojit ke zprávě poznámku',
								'fields' => [
									[
										'type' => 'editor',
										'name' => 'up_content',
										'label' => 'Poznámka',
										'description' => 'Text emailu navíc',
										'floating_label' => true,
										'saveAs' => 'options',
									],
								]
							]
					]
				];
			}elseif ($formID == 'test') {
				$fields = [
					'headline' => 'Nadpis formuláře',
					'description' => 'Popisek formuláře',
					'enctype' => '',
					'sections' => 
						[
						'section111' => [
							'headline' => 'test-444',
							'description' => 'test-444',
							'fields' => [  
								[
									'type' => 'text',
									'name' => 'title',
									'label' => 'Jméno',
									'saveAs' => 'options',
									'rules' => 'required', //same:adresa-url
									'options' => [
										'width' => 'half',
										'show_attr' => true,
										'step' => 1,
										'unit' => '',

									]
								],
								[
									'type' => 'url',
									'name' => 'adresa-url',
									'label' => 'adresa url',
									'saveAs' => 'options',
									'rules' => 'required|url',
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'email',
									'name' => 'email1',
									'label' => 'E-mail',
									'floating_label' => true,
									'saveAs' => 'options',
									//'rules' => 'required|email',
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'tel',
									'name' => 'telephone',
									'label' => 'Telefon',
									'floating_label' => true,
									'saveAs' => 'options',
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'number',
									'name' => 'cislo',
									'label' => 'Nějaké číslo',
									'floating_label' => true,
									'saveAs' => 'options',
									//'rules' => 'required|number|max:20|min:10',
									'options' => [
										'width' => 'full',
									]
								],
								[
									'type' => 'password',
									'name' => 'heslo',
									'label' => 'Vaše heslo',
									'floating_label' => true,
									'saveAs' => 'options',
									'options' => [
										'width' => 'half',
									]
								],
							]
						],
						'section9' => [
							'headline' => 'test-7',
							'description' => 'test-77',
							'fields' => [
								[
									'type' => 'color',
									'name' => 'barva',
									'label' => 'Primární barva',
									'description' => 'Eu nisi sed viverra id aliquam enim, odio nunc.',
									'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
									'value' => '#ff00dd', // rgba(30,30,30,0.64)
									'saveAs' => 'meta',
									'required' => true,
								],
							],
						]
					]
				];
			} else if ($formID == 'test_rep') {
				$fields = [
					'headline' => 'Nadpis formuláře',
					'description' => 'Popisek formuláře',
					'enctype' => '',
					'sections' => [
						'section-repeater' => [
							'headline' => 'Přidání repeateru',
							'description' => 'Otestování sekcí s repeaterem a jeho zobrazením',
							'fields' => [  
								[
									'type' => 'text',
									'name' => 'name',
									'label' => 'Jméno',
									'floating_label' => true,
									'saveAs' => 'meta',
									'required' => true,
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'text',
									'name' => 'surname',
									'label' => 'Příjmení',
									'floating_label' => true,
									'saveAs' => 'meta',
									'required' => true,
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'repeater',
									'name' => 'firts_repeater',
									'label' => 'Zadejte více seznamů se jmény',
									'floating_label' => true,
									'saveAs' => 'meta',
									'options' => [
										
									],
									'fields' => [  
										[
											'type' => 'text',
											'name' => 'name',
											'label' => 'Jméno',
											'saveAs' => 'meta',
											'required' => true,
										],
										[
											'type' => 'email',
											'name' => 'email',
											'label' => 'E-mail',
											'floating_label' => true,
											'saveAs' => 'meta',
											'required' => true,
										],
										[
											'type' => 'tel',
											'name' => 'phone',
											'label' => 'Telefon',
											'floating_label' => true,
											'saveAs' => 'meta',
										],
									]
								],
							]
						]
					]
				];
			} else if ($formID == 'emails_settings') {
				$fields=[
					[
						'headline' => 'Nastavení emailů',
						'description' => 'Pro správné používání emailů je potřeba přizpůsobit jejich vzhled a nastavení.',
						[
							'type' => 'switch',
							'name' => 'switch',
							'label' => 'Aktivace emailů',
							'description' => 'Zaškrtnutí tlačítka aktivuje odesílání emailů',
							'saveAs' => 'meta',
						],
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
									'required' => true,
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
									'required' => true,
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
                        'headline' => 'Nastavení textace jednotlivých emailů',     
						[
                            'type' => 'editor',
                            'name' => 'mail_text_license_d1g1s',
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
                        ]
					]
				];
			}
			return $fields;
        
        }
        public static function get_fields_cpt_form($post_type){
            $fields= [];
            if ($post_type == 'feedback') {
                $fields=[
                   
                ];
            }
            return $fields;
        }
    }
}

					// [
					// 	'headline' => 'Nadis formuláře',
					// 	'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 	'fields' => [	
					// 		[
					// 			'type' => 'text',
					// 			'name' => 'info_box1',
					// 			'headline' => 'Info box 1',
					// 			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 			'required' => false,
					// 		],
	
					// 		[
					// 			'type' => 'switch',
					// 			'name' => 'switch1',
					// 			'label' => 'Checkbox as switch',
					// 			'saveAs' => 'meta',
					// 			'required' => false,
					// 		],
					// 		[
					// 			'type' => 'textarea',
					// 			'name' => 'dlouhytext',
					// 			'label' => 'Dlouhý text',
					// 			'description' => null,
					// 			'floating_label' => true,
					// 			'saveAs' => 'meta',
					// 			'required' => false,
					// 		],
					// 		[
					// 			'type' => 'editor',
					// 			'name' => 'editor',
					// 			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 			'help_text' => 'Pomocný text pro editor',
					// 		],
					// 	]
					// ],
					// [
					// 	[
					// 		'type' => 'switch',
					// 		'name' => 'switch1',
					// 		'label' => 'Checkbox as switch',
					// 		'saveAs' => 'meta',
					// 	],
					// 	'columns' => [
					// 		[
				
					// 			[
					// 				'type' => 'text',
					// 				'name' => 'title',
					// 				'label' => 'Jméno',
					// 				'saveAs' => 'meta',
					// 				'required' => true,
					// 			],
					// 			[
					// 				'type' => 'email',
					// 				'name' => 'email1',
					// 				'label' => 'E-mail',
					// 				'floating_label' => true,
					// 				'saveAs' => 'meta',
					// 				'required' => true,
					// 			],
					// 			[
					// 				'type' => 'tel',
					// 				'name' => 'telephone',
					// 				'label' => 'Telefon',
					// 				'floating_label' => true,
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'number',
					// 				'name' => 'cislo',
					// 				'label' => 'Nějaké číslo',
					// 				'floating_label' => true,
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'password',
					// 				'name' => 'heslo',
					// 				'label' => 'Vaše heslo',
					// 				'floating_label' => true,
					// 				'saveAs' => 'meta',
					// 			],
					// 		],
					// 		[
					// 			[
					// 				'type' => 'select',
					// 				'name' => 'select1',
					// 				'label' => 'Jednoduchý výběr',
					// 				'floating_label' => true,
					// 				'options' => [
					// 					'' => 'None',
					// 					'prvni' => 'První',
					// 					'druhy' => 'Druhý',
					// 					'treti' => 'Třetí',
					// 					'ctvrty' => 'Čtvrtý',
					// 					'paty' => 'Pátý',
					// 					'sesty' => 'Šestý',
					// 					'sedmi' => 'Sedmí',
					// 				],
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'select',
					// 				'name' => 'multiselect',
					// 				'label' => 'Multi výběr',
					// 				'multiple' => true,
					// 				'floating_label' => true,
					// 				'options' => [
					// 					'' => 'None',
					// 					'prvni' => 'První',
					// 					'druhy' => 'Druhý',
					// 					'treti' => 'Třetí',
					// 					'ctvrty' => 'Čtvrtý',
					// 					'paty' => 'Pátý',
					// 					'sesty' => 'Šestý',
					// 					'sedmi' => 'Sedmí',
					// 				],
					// 				'selectize' => [ //nutno zprovoznit (issue #3)
					// 					//'sortField' => '"text"', // hodnota včetně uvozovek
					// 					'maxItems' => 3,
					// 				],
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'textarea',
					// 				'name' => 'dlouhytext',
					// 				'label' => 'Dlouhý text',
					// 				'floating_label' => true,
					// 				'saveAs' => 'meta',
					// 			],
					// 		],
					// 	],
					// 	[
					// 		'type' => 'editor',
					// 		'name' => 'editor',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Pomocný text pro editor',
					// 	],
					// 	[
					// 		'type' => 'info_box',
					// 		'name' => 'info_box',
					// 		'headline' => 'Info box',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 	],
					// ],
					// [
					// 	[
					// 		'type' => 'text',
					// 		'name' => 'title',
					// 		'label' => 'Jméno',
					// 		'placeholder' => 'Vaše jméno',
					// 		'help_text' => 'Definovaný placeholder jiný než label',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'text',
					// 		'name' => 'title',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'label' => 'Jméno',
					// 		'help_text' => 'Placeholder není definovaný (placeholder = label)',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'warning_box',
					// 		'name' => 'warning_box',
					// 		'headline' => 'Warning box',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 	],
				
					// ],
					// [
					// 	[
					// 		'type' => 'checkbox_large',
					// 		'name' => 'checkbox_large1',
					// 		'label' => 'Checkbox large',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'saveAs' => 'meta',
					// 	],
					// 	[
					// 		'type' => 'checkbox',
					// 		'name' => 'checkbox1',
					// 		'label' => 'Checkbox Lorem ipsum dolor sit amet',
					// 		'saveAs' => 'meta',
					// 	],
					// 	[
					// 		'type' => 'checkbox',
					// 		'name' => 'checkbox2',
					// 		'label' => 'Checkbox Lorem ipsum dolor sit amet',
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// ],
					// [
					// 	[
					// 		'type' => 'radio_large',
					// 		'name' => 'radio_large1',
					// 		'description' => 'Radio large - Radio tlačíta zobrazená jako jednotlivé bloky s h3 nadpisem',
					// 		'saveAs' => 'meta',
					// 		'options' => [
					// 			'check1' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'], // label, help text
					// 			'check2' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
					// 			'check3' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
					// 			'check4' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
				
					// 		],
							
					// 	],
					// 	[
					// 		'type' => 'radio',
					// 		'name' => 'radio1',
					// 		'description' => 'Radio 1 - Běžná radio tlačítka',
					// 		'help_text' => 'Jednoduchý radio option s popisem a pomocným textem',
					// 		'options' => [
					// 			'prvni' => 'První',
					// 			'druhy' => 'Druhý',
					// 			'treti' => 'Třetí',
					// 			'ctvrty' => 'Čtvrtý',
					// 			'paty' => 'Pátý',
					// 			'sesty' => 'Šestý',
					// 			'sedmi' => 'Sedmí',
					// 		],
					// 		'value' => 'treti',
					// 		'saveAs' => 'meta',
					// 	],
					// 	[
					// 		'type' => 'radio',
					// 		'name' => 'radio2',
					// 		'description' => 'Radio 2 - I běžná radio tlačítka mohou být doplněny o pomocný text',
					// 		'saveAs' => 'meta',
					// 		'options' => [
					// 			'check1' => ['Checkbox large 1','Lorem ipsum dolor sit amet'], // label, help text
					// 			'check2' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
					// 			'check3' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
					// 			'check4' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
				
					// 		],
							
					// 	],
					// ],
					// [
					// 	'columns' => [
					// 		[
					// 			[
					// 				'type' => 'switch',
					// 				'name' => 'switch',
					// 				'label' => 'Checkbox as switch',
					// 				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'range',
					// 				'name' => 'range1',
					// 				'label' => 'Výběr hodnoty se skoky po 10',
					// 				'help_text' => 'Defaultně nastavena hodnota 40',
					// 				'max' => 100,
					// 				'min' => 0,
					// 				'step' => 10,
					// 				'value' => 40,
					// 				'saveAs' => 'meta',
					// 				'required' => true,
					// 			],
								
					// 		],
					// 		[
					// 			[
					// 				'type' => 'range',
					// 				'name' => 'range2',
					// 				'label' => 'Výběr hodnoty s danou jednotkou',
					// 				'description' => 'V tomto výběru je daná jednotkou a zobrazuje se minimální a maximální hodnota',
					// 				'help_text' => 'Defaultně nastavena hodnota 1250 px',
					// 				'max' => 2400,
					// 				'min' => 0,
					// 				'value' => 1250,
					// 				'unit' => 'px',
					// 				'show_attr' => true,
					// 				'saveAs' => 'meta',
					// 			],
					// 			[
					// 				'type' => 'range',
					// 				'name' => 'range3',
					// 				'label' => 'Výběr hodnoty s výběrem jednotky',
					// 				'help_text' => 'Defaultně nastavena hodnota 1250 px',
					// 				'max' => 2400,
					// 				'min' => 0,
					// 				'value' => 1250,
					// 				'unit' => [
					// 					'px' => 'px',
					// 					'%' => '%',
					// 					'rem' => 'rem',
					// 					'em' => 'em',
					// 					'vh' => 'vh',
					// 					'vw' => 'vw',
					// 				],
					// 				'saveAs' => 'meta',
					// 			],
					// 		],
					// 	]
						
					// ],
					// [
					// 	[
					// 		'type' => 'url',
					// 		'name' => 'odkaz',
					// 		'label' => 'Url',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'image',
					// 		'name' => 'obrazek',
					// 		'label' => 'Obrázek',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'value' => 'https://via.placeholder.com/300x200',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// ],
					// [
					// 	[
					// 		'type' => 'image',
					// 		'name' => 'obrazek2',
					// 		'label' => 'Obrázek',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'value' => 'https://via.placeholder.com/300x200',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'date',
					// 		'name' => 'datum',
					// 		'label' => 'Datum',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'time',
					// 		'name' => 'cas',
					// 		'label' => 'Čas',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
					// 	[
					// 		'type' => 'month',
					// 		'name' => 'mesic',
					// 		'label' => 'Měsíc',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 	],
					// 	[
					// 		'type' => 'week',
					// 		'name' => 'tyden',
					// 		'label' => 'Týden',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 	],
					// 	[
					// 		'type' => 'datetime-local',
					// 		'name' => 'datumcas',
					// 		'label' => 'Datum a Čas',
					// 		'floating_label' => true,
					// 		'saveAs' => 'meta',
					// 	],
					// ],
					// [
					// 	[
					// 		'type' => 'color',
					// 		'name' => 'barva',
					// 		'label' => 'Primární barva',
					// 		'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
					// 		'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
					// 		'value' => '#ff00dd', // rgba(30,30,30,0.64)
					// 		'saveAs' => 'meta',
					// 		'required' => true,
					// 	],
						
					// ],
					// [
					// 	[
					// 		'type' => 'html',
					// 		'name' => 'tabulka',
					// 		'content' => '<table>
					// 						<tr>
					// 							<th>Company</th>
					// 							<th>Contact</th>
					// 							<th>Country</th>
					// 						</tr>
					// 						<tr>
					// 							<td>Alfreds Futterkiste</td>
					// 							<td>Maria Anders</td>
					// 							<td>Germany</td>
					// 						</tr>
					// 						<tr>
					// 							<td>Centro comercial Moctezuma</td>
					// 							<td>Francisco Chang</td>
					// 							<td>Mexico</td>
					// 						</tr>
					// 						<tr>
					// 							<td>Ernst Handel</td>
					// 							<td>Roland Mendel</td>
					// 							<td>Austria</td>
					// 						</tr>
					// 						<tr>
					// 							<td>Island Trading</td>
					// 							<td>Helen Bennett</td>
					// 							<td>UK</td>
					// 						</tr>
					// 						<tr>
					// 							<td>Laughing Bacchus Winecellars</td>
					// 							<td>Yoshi Tannamuri</td>
					// 							<td>Canada</td>
					// 						</tr>
					// 						<tr>
					// 							<td>Magazzini Alimentari Riuniti</td>
					// 							<td>Giovanni Rovelli</td>
					// 							<td>Italy</td>
					// 						</tr>
					// 					</table>',
					// 	],
						
					// ],


/*
$fields = [
					'headline' => 'Nadpis formuláře',
					'description' => 'Popisek formuláře',
					'enctype' => '',
					'sections' => 
						[
						'section111' => [
							'headline' => 'test-444',
							'description' => 'test-444',
							'fields' => [  
								[
									'type' => 'text',
									'name' => 'title',
									'label' => 'Jméno',
									'saveAs' => 'meta',
									'required' => true,
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'email',
									'name' => 'email1',
									'label' => 'E-mail',
									'floating_label' => true,
									'saveAs' => 'meta',
									'required' => true,
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'tel',
									'name' => 'telephone',
									'label' => 'Telefon',
									'floating_label' => true,
									'saveAs' => 'meta',
									'options' => [
										'width' => 'half',
									]
								],
								[
									'type' => 'number',
									'name' => 'cislo',
									'label' => 'Nějaké číslo',
									'floating_label' => true,
									'saveAs' => 'meta',
									'options' => [
										'width' => 'full',
									]
								],
								[
									'type' => 'password',
									'name' => 'heslo',
									'label' => 'Vaše heslo',
									'floating_label' => true,
									'saveAs' => 'meta',
									'options' => [
										'width' => 'half',
									]
								],
							]
						],
						'section10' => [
							'headline' => 'test-8',
							'description' => 'test-88',
							'fields' => [
								[
									'type' => 'html',
									'name' => 'tabulka',
									'custom_html' => '
										<table>
											<tr>
												<th>Company</th>
												<th>Contact</th>
												<th>Country</th>
											</tr>
											<tr>
												<td>Alfreds Futterkiste</td>
												<td>Maria Anders</td>
												<td>Germany</td>
											</tr>
											<tr>
												<td>Centro comercial Moctezuma</td>
												<td>Francisco Chang</td>
												<td>Mexico</td>
											</tr>
											<tr>
												<td>Ernst Handel</td>
												<td>Roland Mendel</td>
												<td>Austria</td>
											</tr>
											<tr>
												<td>Island Trading</td>
												<td>Helen Bennett</td>
												<td>UK</td>
											</tr>
											<tr>
												<td>Laughing Bacchus Winecellars</td>
												<td>Yoshi Tannamuri</td>
												<td>Canada</td>
											</tr>
											<tr>
												<td>Magazzini Alimentari Riuniti</td>
												<td>Giovanni Rovelli</td>
												<td>Italy</td>
											</tr>
										</table>
									',
								],
							],
						],
						'section9' => [
							'headline' => 'test-7',
							'description' => 'test-77',
							'fields' => [
								[
									'type' => 'color',
									'name' => 'barva',
									'label' => 'Primární barva',
									'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
									'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
									'value' => '#ff00dd', // rgba(30,30,30,0.64)
									'saveAs' => 'meta',
									'required' => true,
								],
							],
						],
						'section8' => [
							'headline' => 'test-6',
							'description' => 'test-66',
							'fields' => [
									[
										'type' => 'image',
										'name' => 'obrazek2',
										'label' => 'Obrázek',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
										'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
										//'value' => 'https://via.placeholder.com/300x200',
										'floating_label' => true,
										'saveAs' => 'meta',
										'required' => true,
									],
									[
										'type' => 'date',
										'name' => 'datum',
										'label' => 'Datum',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
										'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
										'floating_label' => true,
										'saveAs' => 'meta',
										'required' => true,
									],
									[
										'type' => 'time',
										'name' => 'cas',
										'label' => 'Čas',
										'floating_label' => true,
										'saveAs' => 'meta',
										'required' => true,
									],
									[
										'type' => 'month',
										'name' => 'mesic',
										'label' => 'Měsíc',
										'floating_label' => true,
										'saveAs' => 'meta',
									],
									[
										'type' => 'week',
										'name' => 'tyden',
										'label' => 'Týden',
										'floating_label' => true,
										'saveAs' => 'meta',
									],
									[
										'type' => 'datetime-local',
										'name' => 'datumcas',
										'label' => 'Datum a Čas',
										'floating_label' => true,
										'saveAs' => 'meta',
									],
								],
							],
							'section7' => [
								'headline' => 'test-5',
								'description' => 'test-55',
								'fields' => [
									[
										'type' => 'url',
										'name' => 'odkaz',
										'label' => 'Url',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
										'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
										'floating_label' => true,
										'saveAs' => 'meta',
										'required' => true,
									],
									[
										'type' => 'image',
										'name' => 'obrazek',
										'label' => 'Obrázek',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
										'help_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
										//'value' => 'https://via.placeholder.com/300x200',
										'floating_label' => true,
										'saveAs' => 'meta',
										'required' => true,
									],
								]
							],
							'section6' => [
								'headline' => 'test-4',
								'description' => 'test-44',
								'fields' => [
									[
										[
											'type' => 'switch',
											'name' => 'switch',
											'label' => 'Checkbox as switch',
											'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
											'saveAs' => 'meta',
											'options' => [
												'width' => 'half',
											]
										],
										[
											'type' => 'range',
											'name' => 'range1',
											'label' => 'Výběr hodnoty se skoky po 10',
											'help_text' => 'Defaultně nastavena hodnota 40',
											'args' => [
												'max' => 100,
												'min' => 0,
												'step' => 10,
												'value' => 40,
												],
											'saveAs' => 'meta',
											'required' => true,
										],
										
									],
									[
										[
											'type' => 'range',
											'name' => 'range2',
											'label' => 'Výběr hodnoty s danou jednotkou',
											'description' => 'V tomto výběru je daná jednotkou a zobrazuje se minimální a maximální hodnota',
											'help_text' => 'Defaultně nastavena hodnota 1250 px',
											'args' => [	
												'max' => 2400,
												'min' => 0,
												'value' => 1250,
												'unit' => 'px',
												],
											'show_attr' => true,
											'saveAs' => 'meta',
										],
										[
											'type' => 'range',
											'name' => 'range3',
											'label' => 'Výběr hodnoty s výběrem jednotky',
											'help_text' => 'Defaultně nastavena hodnota 1250 px',
											'args' => [
												'max' => 2400,
												'min' => 0,
												'value' => 1250,
												'unit' => [
													'px' => 'px',
													'%' => '%',
													'rem' => 'rem',
													'em' => 'em',
													'vh' => 'vh',
													'vw' => 'vw',
													],
												],
											'saveAs' => 'meta',
										],
									],
								]
							],
							'section5' => [
								'headline' => 'test-3',
								'description' => 'test-33',
								'fields' => [
									[
										'type' => 'radio',
										'name' => 'radio1',
										'description' => 'Radio 1 - Běžná radio tlačítka',
										'help_text' => 'Jednoduchý radio option s popisem a pomocným textem',
										'args' => [
											'options' => [
												'prvni' => 'První',
												'druhy' => 'Druhý',
												'treti' => 'Třetí',
												'ctvrty' => 'Čtvrtý',
												'paty' => 'Pátý',
												'sesty' => 'Šestý',
												'sedmi' => 'Sedmí',
											],
										],
										'value' => 'treti',
										'saveAs' => 'meta',
									],
									[
										'type' => 'radio',
										'name' => 'radio2',
										'description' => 'Radio 2 - I běžná radio tlačítka mohou být doplněny o pomocný text',
										'saveAs' => 'meta',
										'args' => [
											'options' => 
											[
												'check1' => ['Checkbox large 1','Lorem ipsum dolor sit amet'], // label, help text
												'check2' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
												'check3' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
												'check4' => ['Checkbox large 1','Lorem ipsum dolor sit amet'],
											],
										],
									],
									[
										'type' => 'info_box',
										'name' => 'info_box',
										'headline' => 'Info box',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
									],
									[
										'type' => 'warning_box',
										'name' => 'warning_box',
										'headline' => 'warning box box',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
									],
								],
							],
							'section4' => [
								'headline' => 'test-2',
								'description' => 'test-22',
								'fields' => [
									[
										'type' => 'radio_large',
										'name' => 'radio_large1',
										'description' => 'Radio large - Radio tlačíta zobrazená jako jednotlivé bloky s h3 nadpisem',
										'saveAs' => 'meta',
										'args' => [
											'options' => [
												'check1' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'], // label, help text
												'check2' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
												'check3' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
												'check4' => ['Checkbox large 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
											],
										],	
									],
								],
							],
							'section3' => [
								'headline' => 'test-1',
								'description' => 'test-11',
								'fields' => [
									[
										'type' => 'checkbox_large',
										'name' => 'checkbox_large1',
										'label' => 'Checkbox large',
										'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
										'saveAs' => 'meta',
									],
									[
										'type' => 'checkbox',
										'name' => 'checkbox1',
										'label' => 'Checkbox Lorem ipsum dolor sit amet',
										'description' => null,
										'saveAs' => 'meta',
									],
									[
										'type' => 'checkbox',
										'name' => 'checkbox2',
										'label' => 'Checkbox Lorem ipsum dolor sit amet',
										'saveAs' => 'meta',
										'required' => true,
									],
								]

							],
							'section1' => [
								'headline' => 'test',
								'description' => 'test',
								'colums' => [  
									[
										[
											'type' => 'text',
											'name' => 'title',
											'label' => 'Jméno',
											'saveAs' => 'meta',
											'required' => true,
										],
										[
											'type' => 'email',
											'name' => 'email1',
											'label' => 'E-mail',
											'floating_label' => true,
											'saveAs' => 'meta',
											'required' => true,
										],
										[
											'type' => 'tel',
											'name' => 'telephone',
											'label' => 'Telefon',
											'floating_label' => true,
											'saveAs' => 'meta',
										],
										[
											'type' => 'number',
											'name' => 'cislo',
											'label' => 'Nějaké číslo',
											'floating_label' => true,
											'saveAs' => 'meta',
										],
										[
											'type' => 'password',
											'name' => 'heslo',
											'label' => 'Vaše heslo',
											'floating_label' => true,
											'saveAs' => 'meta',
										],
									],
									[
										[
											'type' => 'select',
											'name' => 'select1',
											'label' => 'Jednoduchý výběr',
											'floating_label' => true,
											'args' => [
												'options' => [
													'' => 'None',
													'prvni' => 'První',
													'druhy' => 'Druhý',
													'treti' => 'Třetí',
													'ctvrty' => 'Čtvrtý',
													'paty' => 'Pátý',
													'sesty' => 'Šestý',
													'sedmi' => 'Sedmí',
												],
											],
											'saveAs' => 'meta',
										],
										[
											'type' => 'select',
											'name' => 'multiselect',
											'label' => 'Multi výběr',
											'multiple' => true,
											'floating_label' => true,
											'args' => [
												'options' => [
													'' => 'None',
													'prvni' => 'První',
													'druhy' => 'Druhý',
													'treti' => 'Třetí',
													'ctvrty' => 'Čtvrtý',
													'paty' => 'Pátý',
													'sesty' => 'Šestý',
													'sedmi' => 'Sedmí',
												],
												'selectize' => [ //nutno zprovoznit (issue #3)
													//'sortField' => '"text"', // hodnota včetně uvozovek
													'maxItems' => 3,
												],
											],
											'saveAs' => 'meta',
										],
										[
											'type' => 'textarea',
											'name' => 'dlouhytext',
											'label' => 'Dlouhý text',
											'floating_label' => true,
											'saveAs' => 'meta',
										],
									],
								]
						],
						'section2' =>	[
							'headline' => 'Nastavení Indentity pro XMLs',
							'description' => 'Fakturační udaje',
							'fields' =>[ 
								[
									'type' => 'text',
									'label' => 'Company',
									'name' => 'company',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'City',
									'name' => 'city',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Street',
									'name' => 'street',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Street Number',
									'name' => 'street_number',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Zip',
									'name' => 'zip',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Ico',
									'name' => 'ico',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Dic',
									'name' => 'dic',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Mobil Phone',
									'name' => 'mobilPhone',
									'saveAs' => 'meta',
									'required' => false,
								],
								[
									'type' => 'text',
									'label' => 'Email',
									'name' => 'email',
									'saveAs' => 'meta',
									'required' => false,
								],	
							]
						]
					]
				];
*/