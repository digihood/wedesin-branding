const TM_PLUGSEC = 'plugin-template';
jQuery(document).ready(function($){
 
    jQuery('#wp-list-table widefat plugins').ready(function(e) {
      $('tr[data-plugin]').each(function(){
        var dataLayer = $(this).data('plugin');
        if(dataLayer == TM_PLUGSEC+'/setup.php'){
          var url="?get_plugin_info="+TM_PLUGSEC;
          $.get(url).then(function(data){
            $.each(data, function(i, item) {
              if(item.TextDomain == TM_PLUGSEC){
                var html = '<tr class="plugin-update-tr active" id="'+item.TextDomain+'-update" data-slug="'+item.TextDomain+'" data-plugin="'+item.TextDomain+'/setup.php"><td colspan="4" class="plugin-update colspanchange"><div class="update-message notice inline notice-warning notice-alt"><p>Nová verze pro '+item.name+' je dostupná. <a href="#" class="thickbox open-plugin-details-modal" aria-label="">Zobrazit podrobnosti o verzi '+item.new_version+'</a>nebo <a href="#" class="update-link" aria-label="Aktualizovat Šablona pluginů">#</a>.</p></div></td></tr>';
                $('[data-plugin="'+TM_PLUGSEC+'/setup.php"]').toggleClass('update').after(html);
                
              }
            });
          });
        }
      });
    });
  });
  