<?php 
//use components\log2\d1g1LogSettings;

?>
<style>
.box-button {
    position:absolute;
    right:30px;
    top:163px;
    margin:10px;
}




</style>
<div class="wrap">
    <div class="col-12">
        <div class="box-info">
            <div class="box-header">
                <h3 class="box-title"><?php _e( 'Záznamy logu', 'plan' ); ?></h3>
                <div class="box-button"><a href="<?php echo '/wp-content/uploads/'. D1G1_LFILEDIR_BRAND .'/'. D1G1_BRANDING .'.json'; ?>" class="button button-primary" download>Stahnout LOG</a></div>
            </div>
            <div class="box-body">
                <?php 
                
                /*$idoklad_log = iDoklad_Log::get_instance();
                echo $idoklad_log->render_table();*/
                $settings = new \pluginbrandslug\framework\monolog\log_function\d1g1_monolog;
               // preprint($viewfile);
                echo $settings->d1g1_get_log_file();
              
                ?>
            </div>
        </div>                 
    </div>
</div>
<div style="clear:both;"></div>  