<?php
/*******************************
/          Framework           *
********************************/
/*******************************
/          Framework           *
********************************/

include_once( D1G1_BRANDPATH . 'framework/styles-scripts.php');  
include_once( D1G1_BRANDPATH . 'framework/main-menu.php');  
include_once( D1G1_BRANDPATH . 'framework/monolog/log-setup.php');  
include_once( D1G1_BRANDPATH . 'components/log-content.php');
include_once( D1G1_BRANDPATH . 'framework/forms-builder.php'); 
include_once( D1G1_BRANDPATH . 'framework/sessions.php'); 
include_once( D1G1_BRANDPATH . 'framework/cookies.php'); 
include_once( D1G1_BRANDPATH . 'framework/form-validation.php');
 
include_once( D1G1_BRANDPATH . 'components/d1g1-function.php'); 



include_once( D1G1_BRANDPATH . 'framework/helpers.php'); 
include_once( D1G1_BRANDPATH . 'framework/forms-core.php');  
include_once( D1G1_BRANDPATH . 'framework/get-html-form.php');
include_once( D1G1_BRANDPATH . 'framework/emails.php'); 
include_once( D1G1_BRANDPATH . 'framework/plugin-update-checker/plugin-update-checker.php'); 
/*******************************
/          Add admin Page      *
********************************/
include_once( D1G1_BRANDPATH . 'admin/sub-menu.php');  
include_once( D1G1_BRANDPATH . 'admin/form_fields.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/main-menu.php'); 
include_once( D1G1_BRANDPATH . 'admin/view/submenu-content.php'); 
include_once( D1G1_BRANDPATH . 'admin/info-box/view-box.php');
include_once( D1G1_BRANDPATH . 'admin/info-box/restapi-call.php');


/*******************************
/  Include utility functions   *
********************************/
include_once( D1G1_BRANDPATH . 'components/email-content.php'); 
include_once( D1G1_BRANDPATH . 'components/admin-update.php'); 
include_once( D1G1_BRANDPATH . 'components/styles-scripts.php');
include_once( D1G1_BRANDPATH . 'components/custom-functions.php');


/*******************************
/         Logs MONOLOG         *
********************************/

include_once( D1G1_BRANDPATH . 'framework/monolog/logs-functions.php');
if(!class_exists('Monolog\Logger')){  
    include_once( D1G1_BRANDPATH . 'vendor/autoload.php');
}
?>