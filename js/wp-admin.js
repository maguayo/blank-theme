jQuery(document).on('ready', startFunction);

function startFunction(){
	if(jQuery('input:radio[name="cf_media_servicios_radio"]:checked').val() == 'sector'){
 		jQuery('#wp-cf_media_servicios_como-wrap, label[for="cf_media_servicios_como"]').hide();
	    jQuery('#wp-cf_media_servicios_aquien-wrap, label[for="cf_media_servicios_aquien"]').hide();
	    jQuery('#wp-cf_media_servicios_texto-wrap, label[for="cf_media_servicios_texto"]').show();
	}else{
		jQuery('#wp-cf_media_servicios_como-wrap, label[for="cf_media_servicios_como"]').show();
	    jQuery('#wp-cf_media_servicios_aquien-wrap, label[for="cf_media_servicios_aquien"]').show();
	    jQuery('#wp-cf_media_servicios_texto-wrap, label[for="cf_media_servicios_texto"]').hide();
	}
	jQuery('input:radio[name="cf_media_servicios_radio"]').on('change', function(){
	    if(jQuery(this).val() == 'sector'){
	       jQuery('#wp-cf_media_servicios_como-wrap, label[for="cf_media_servicios_como"]').hide();
		    jQuery('#wp-cf_media_servicios_aquien-wrap, label[for="cf_media_servicios_aquien"]').hide();
		    jQuery('#wp-cf_media_servicios_texto-wrap, label[for="cf_media_servicios_texto"]').show();
	    }else{
	    	jQuery('#wp-cf_media_servicios_como-wrap, label[for="cf_media_servicios_como"]').show();
		    jQuery('#wp-cf_media_servicios_aquien-wrap, label[for="cf_media_servicios_aquien"]').show();
		    jQuery('#wp-cf_media_servicios_texto-wrap, label[for="cf_media_servicios_texto"]').hide();
	    }
	});
}