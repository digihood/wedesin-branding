<?php

/**
 * Třída SetValidationRules
 *
 * Tato třída se používá k nastavení pravidel validace formulářových polí.
 */
namespace pluginone\framework\Forms\Validation;

use pluginone\admin\fields\d1g1PluginField;
use pluginone\framework\globals;

class SetValidationRules
{

    public $form_id = '';   // ID formuláře
    public $names = [];     // Názvy polí
    public $rules = [];     // Pravidla validace
    public $values = [];    // Hodnoty polí
    public $types = [];     // Typy polí
    public $save_type = [];  // Typ uložení hodnot jednotlivých poly

    /**
     * Konstruktor třídy SetValidationRules
     *
     * @param mixed $Request  Objekt reprezentující požadavek
     */
    public function __construct($Request)
    {
        if (isset($Request['form_id'])) {
            $this->form_id = $Request['form_id'];
        }
        $this->set_rules($Request);
    }

    /**
     * Metoda pro nastavení pravidel validace
     *
     * @param mixed $Request  Objekt reprezentující požadavek
     */
    public function set_rules($Request)
    {
        foreach ($Request as $keys => $value) {
            $key = explode('_', $keys);
           
            if ($key[0] == globals::$FWDIGI_PLUGINID) {
               
                $this->rules[end($key)] = $this->get_section_field($key[1], $key[2]);
                $this->values[end($key)] = $value;
            }
        }
       
    }

    /**
     * Metoda pro získání pravidel validace pro dané pole
     *
     * @param string $section  Název sekce
     * @param string $order    Pořadí pole
     *
     * @return mixed           Pravidla validace pole
     */
    public function get_section_field($section, $order)
    {
        $form = d1g1PluginField::get_fields_form($this->form_id);

        $this->names[$form['sections'][$section]['fields'][$order]['name']] = $form['sections'][$section]['fields'][$order]['label'];
        $this->save_type[$form['sections'][$section]['fields'][$order]['name']] = $form['sections'][$section]['fields'][$order]['saveAs'];
        if (isset($form['sections'][$section]['fields'][$order]['rules']) && $form['sections'][$section]['fields'][$order]['rules']) {
            $this->types[$form['sections'][$section]['fields'][$order]['name']] = $form['sections'][$section]['fields'][$order]['type'];
           
        
            return ['rule_string' => $form['sections'][$section]['fields'][$order]['rules'],'rule' => explode('|', $form['sections'][$section]['fields'][$order]['rules'])];
        } else {
            return null;
        }
    }

    public function get_type_field($name){
        return $this->types[$name];
    }

    public function get_save_type($name){
      
        return $this->save_type[$name];
    }
}


