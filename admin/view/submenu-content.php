<?php
namespace pluginbrandslug\admin\submenu;
if (!defined('ABSPATH')) {

    exit;
}

if (!class_exists('submenuContentWDS')) {
    class submenuContentWDS
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
         * @author Wedesin
         * @return true/false
         */
        function form_page_contents()
        {

            $builder = new \pluginbrandslug\framework\forms_builder\formsBuilderWDS();
            //$builder = new formsBuilderWDS_brand("test_form_mini");

            //$builder->display_form("test_form_mini");
            //$builder->display_form("test_form_mini_2");
            $builder->display_form("test_form_all");
        }

        function checkreport(){
           
        }

        /**
         * Zobrazení ukázkového formuláře
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */
        function my_admin_page_contents()
        {   

            //Získat aktivní tab z parametru $_GET 
            $default_tab = null;
            $builder = new \pluginbrandslug\framework\forms_builder\formsBuilderWDS();
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php 
                $sessions = new \pluginbrandslug\framework\sessions\sessionClassWDS;

                //preprint($_SESSION);

                $sessins_list = [
                    'brand_emails_settings_save' => [], 
                    'update_report_save' => [
                        'fail' => __("Při ukládání reportu došlo k chybě. Report nebyl odeslán.<br> Vyplnili jste údaje?", WDS_BRANDING), 
                        'success' => __("Report uložen a odeslán", WDS_BRANDING)
                    ]
                ];
                $sessions->display_notice($sessins_list);
                settings_errors(); 
                ?>
                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper">
                            <a href="?page=wds_brand" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"> <?php echo wds_get_svg(WDS_BRANDURL . "assets/icons/home-line.svg"); ?> Záznam aktualizace</a>
                                <a href="?page=wds_brand&tab=updates_list" class="nav-tab <?php if ($tab === 'updates_list') : ?>nav-tab-active<?php endif; ?>"> <?php echo wds_get_svg(WDS_BRANDURL . "assets/icons/calendar-line.svg"); ?>Přehled aktualizací</a>
                            <?php
                                $mailingForm = $builder->get_fields_form("brand_emails_settings");
                            if (!empty($mailingForm)){
                                ?>
                                <a href="?page=wds_brand&tab=emails" class="nav-tab <?php if ($tab === 'emails') : ?>nav-tab-active<?php endif; ?>"><?php echo wds_get_svg(WDS_BRANDURL . "assets/icons/link-line.svg"); ?>Emaily</a>
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
                                    <?php if (!empty($mailingForm)){
                                        $builder->display_form("update_report");
                                    }?>
                                <?php
                                    break;

                                    //Tab 2
                                case 'emails':
                                  //  $ses = new \pluginbrandslug\framework\sessions\sessionClassWDS;
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
                        $view = new \pluginbrandslug\admin\info_box\view\viewAdminBoxWDS;
                        $view->wedesin_dashboard_widget_display('pluginsnews');
                        $view->wedesin_dashboard_widget_display('plugins');
                        ?>
                          
                        
                </div>
                </div>
            </div>
       <?php 
       session_destroy();

        }
        


        public function the_updates_list() {
            $updates_list = get_option('_wds_list', []);
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
    

    new \pluginbrandslug\admin\submenu\submenuContentWDS;
}