<?php 
//use components\log2\wedesinLogSettings;
?>

<div class="wrap">
    <div class="col-12">
        <div class="box-info">
            <div class="box-header">
                <h3 class="box-title"><?php _e( 'Záznamy logu', 'plan' ); ?></h3>
            </div>
            <div class="box-body">
                <?php 
                
                /*$idoklad_log = iDoklad_Log::get_instance();
                echo $idoklad_log->render_table();*/
                $settings = new \pluginbrandslug\framework\log_functions\wedesinLog;
                echo $settings->get_print_log($viewfile);
              
                ?>
            </div>
        </div>                 
    </div>
</div>
<div style="clear:both;"></div>  
