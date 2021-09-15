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

            $builder = new formsBuilderWDS_brand();
            //$builder = new formsBuilderWDS_brand("test_form_mini");

            //$builder->display_form("test_form_mini");
            //$builder->display_form("test_form_mini_2");
            $builder->display_form("test_form_all");
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
            $builder = new \formsBuilderWDS_brand();
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php settings_errors(); ?>
                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper">
                            <a href="?page=wds_brand" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"> <?php echo file_get_contents(WDS_BRANDURL . "assets/icons/home-line.svg"); ?> Záznam aktualizace</a>
                            <?php
                                $mailingForm = $builder->get_fields_form("brand_emails_settings");
                            if (!empty($mailingForm)){
                                ?>
                                <a href="?page=wds_brand&tab=emails" class="nav-tab <?php if ($tab === 'emails') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(WDS_URLSEC . "assets/icons/link-line.svg"); ?>Emaily</a>
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
                                    if (!empty($mailingForm)){
                                        $builder->display_form("brand_emails_settings");
                                    }
                                    break;

                            endswitch; ?>
                        </div>
                    </div>
                    <div class="column sidebar">
                        <div class="card">
                            <p><img src="<?php echo WDS_BRANDURL ?>assets/img/Logo-Wedesin-CZ.png" alt=""></p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                            <p><a href="#" class="button">tlačítko</a></p>
                        </div>
                        <div class="card info">
                            <h3><?php echo file_get_contents(WDS_BRANDURL . "assets/icons/info-standard-line.svg"); ?>Info blok</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }

    new submenuContentWDS;
}