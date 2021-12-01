<?php
namespace pluginbrandslug\admin\submenu;
if (!defined('ABSPATH')) {

    exit;
}

if (!class_exists('submenuContentD1G1')) {
    class submenuContentD1G1
    {
        //hook functions
        public function __construct()
        {
        }

        /**
         * Zobrazení testovacího formuláře
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */
        function form_page_contents()
        {

            $builder = new \pluginbrandslug\framework\forms_builder\formsBuilderD1G1();
            //$builder = new formsBuilderD1G1_brand("test_form_mini");

            //$builder->display_form("test_form_mini");
            //$builder->display_form("test_form_mini_2");
            $builder->display_form("test_form_all");
        }

       

        /**
         * Zobrazení ukázkového formuláře
         *
         * @param none
         * 
         * @author digihood
         * @return true/false
         */
        function my_admin_page_contents()
        {   
            
            //Získat aktivní tab z parametru $_GET 
            $default_tab = 'updates_list';
            $builder = new \pluginbrandslug\framework\forms_builder\formsBuilderD1G1();
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
            <div class="wrap d1g1-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php 
                $sessions = new \pluginbrandslug\framework\sessions\sessionClassD1G1;

               

                $sessins_list = [
                    'brand_emails_settings_save' => [
                        'fail' => __("Při ukládání nastavení došlo k chybě. Nastavení nebylo uloženo.<br> Vyplnili jste údaje?", D1G1_BRANDING),
                        'success' =>  __("Nastavení uloženo", D1G1_BRANDING)
                    ], 
                    'update_report_save' => [
                        'fail' => __("Při ukládání reportu došlo k chybě. Report nebyl odeslán.<br> Vyplnili jste údaje?", D1G1_BRANDING), 
                        'success' => __("Report uložen a odeslán", D1G1_BRANDING)
                    ]
                ];
                
            
                if($_SESSION['update_report_save']){
                    $sessions->display_notice($sessins_list);
                    settings_errors();
                    $sessions->removeSession('update_report_save');
                    
                 }elseif($_SESSION['brand_emails_settings_save']){
                    $sessions->display_notice($sessins_list);
                    settings_errors();
                    $sessions->removeSession('brand_emails_settings_save');
                 }
                
                ?>
                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper"> 
                            <a href="?page=<?= D1G1_BRANDING ?>&tab=updates_list" class="nav-tab <?php if ($tab === 'updates_list') : ?>nav-tab-active<?php endif; ?>"> <?php echo d1g1_get_svg(D1G1_BRANDPATH . "assets/icons/info-standard-line.svg"); ?>Přehled aktualizací</a>
                                <a href="?page=<?= D1G1_BRANDING ?>&tab=send_report" class="nav-tab <?php if ($tab === 'send_report') : ?>nav-tab-active<?php endif; ?>"> <?php echo d1g1_get_svg(D1G1_BRANDPATH . "assets/icons/upload-cloud-line.svg"); ?>Odeslat Report</a>
                            <?php
                                $mailingForm = $builder->get_fields_form("brand_emails_settings");
                            if (!empty($mailingForm)){
                                ?>
                                <a href="?page=<?= D1G1_BRANDING ?>&tab=emails" class="nav-tab <?php if ($tab === 'emails') : ?>nav-tab-active<?php endif; ?>"><?php echo d1g1_get_svg(D1G1_BRANDPATH . "assets/icons/link-line.svg"); ?>Nastavení e-mailu</a>
                                <?php 
                            } ?>
                        </nav>
                        <div class="content-box">
                            <?php switch ($tab):
                                    // Default tab
                                default:
                               
                            ?>

                                    <h2>Odeslat hlášení o aktualizaci</h2>
                                    <p>Formulář pro vyplnění hlášení o aktualizaci</p>
                                    
                                    <?php 
                                 $class = new \pluginbrandslug\framework\d1g1_plugins\d1g1plugins;
                                 $test = $class->d1g1_comparison_plugins();  

                                 preprint($test);
                                    if (!empty($mailingForm)){
                                        $builder->display_form("update_report");

                                    
                                    }?>
                                <?php
                                    break;

                                    //Tab 2
                                case 'emails':
                                  //  $ses = new \pluginbrandslug\framework\sessions\sessionClassD1G1;
                                   // echo $ses->chceckallsesion();
                                 
                                  
                                    if (!empty($mailingForm)){
                                        $builder->display_form("brand_emails_settings");
                                    }
                                    break;
                                case 'updates_list':
                                    $this->the_updates_list();
                                    break;

                            endswitch; ?>
                        </div>
                    </div>
                <div class="column sidebar">
                    
                        <?php 
                        $view = new \pluginbrandslug\admin\info_box\view\viewAdminBoxD1G1;
                        $view->d1g1_dashboard_widget_display('pluginsnews');
                        $view->d1g1_dashboard_widget_display('plugins');
                        ?>
                          
                        
                </div>
                </div>
            </div>
       <?php 
    //   session_destroy();

        }
        


        public function the_updates_list() {
            $updates_list = get_option('_d1g1_list', []);
            ?>
            <h2>Seznam dostupných zapsaných aktualizací</h2>
            <table width=100%>
                <thead style="font-weight:700">
                    <tr>
                        <td>Datum</td>
                        <td>Autor</td>
                        <td>Seznam aktualizací</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rev_updates_list = array_reverse($updates_list, true);
                    foreach ($rev_updates_list as $date => $record) {
                        if (isset($record['user']) && $record['update']) {
                            $user = get_userdata($record['user']);
                          //  $zone = new \DateTimeZone('UTC +2');
                            echo '<tr style="border-top: 1px solid black">';
                            echo '<td>'.wp_date('d. m. Y H:i', $date) .'</td>';
                            echo '<td>'.$user->user_login. '('.$user->ID.')</td>';
                            echo '<td>'.$record['update'].'</td>';
                            echo '</tr>';
                            
                        }

                    }
                    ?>
                </tbody>
            </table>
            <?php
            
           // preprint($updates_list);
        }
        
        
    }
    

    new \pluginbrandslug\admin\submenu\submenuContentD1G1;
}