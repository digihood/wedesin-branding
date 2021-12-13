<?php
if(!class_exists('Monolog\Logger')){  
    include_once( D1G1_BRANDPATH . 'vendor/autoload.php');
}
//framework
include_once( D1G1_BRANDPATH . 'framework/styles-scripts.php');  
include_once( D1G1_BRANDPATH . 'framework/plugin-admin/main-menu.php');  
include_once( D1G1_BRANDPATH . 'framework/monolog/log-setup.php');  
include_once( D1G1_BRANDPATH . 'framework/log-content.php');
include_once( D1G1_BRANDPATH . 'framework/forms-builder.php'); 
include_once( D1G1_BRANDPATH . 'framework/sessions.php'); 
include_once( D1G1_BRANDPATH . 'framework/cookies.php'); 
include_once( D1G1_BRANDPATH . 'framework/form-validation.php');
include_once( D1G1_BRANDPATH . 'framework/helpers.php'); 
include_once( D1G1_BRANDPATH . 'framework/forms-core.php');  
include_once( D1G1_BRANDPATH . 'framework/get-html-form.php');
include_once( D1G1_BRANDPATH . 'framework/emails.php'); 
include_once( D1G1_BRANDPATH . 'framework/plugin-update-checker/plugin-update-checker.php'); 
include_once( D1G1_BRANDPATH . 'framework/monolog/logs-functions.php');
include_once( D1G1_BRANDPATH . 'framework/plugin-admin/d1g1-plugins-api.php');
include_once( D1G1_BRANDPATH . 'framework/plugin-admin/plugins-menu-page.php');
include_once( D1G1_BRANDPATH . 'framework/feedback/d1g1-feedback.php');
include_once( D1G1_BRANDPATH . 'framework/feedback/d1g1-field-fb.php');
//admin
include_once( D1G1_BRANDPATH . 'admin/sub-menu.php');  
include_once( D1G1_BRANDPATH . 'admin/form_fields.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/main-menu.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/submenu-content.php'); 
include_once( D1G1_BRANDPATH . 'admin/info-box/view-box.php');
include_once( D1G1_BRANDPATH . 'admin/info-box/restapi-call.php');


//components
include_once( D1G1_BRANDPATH . 'components/email-content.php'); 
include_once( D1G1_BRANDPATH . 'components/d1g1-function.php'); 
include_once( D1G1_BRANDPATH . 'components/admin-update.php'); 
include_once( D1G1_BRANDPATH . 'components/styles-scripts.php');
include_once( D1G1_BRANDPATH . 'components/custom-functions.php');

