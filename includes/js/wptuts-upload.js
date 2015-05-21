jQuery(document).ready(function($){
	
	var formfield;

	$('#delete_logo_button').on('click', function(e){
		e.preventDefault();
		$('#logo_url').val('');
		$('#upload_logo_preview img').remove();
	});

	$('#delete_favicon_button').on('click', function(e){
		e.preventDefault();
		$('#favicon_url').val('');
		$('#upload_favicon_preview img').remove();
	});

	$('#upload_logo_button').click(function() {
		formfield = 1;
		tb_show('Upload a logo', 'media-upload.php?referer=wptuts-settings&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});

	$('#upload_favicon_button').click(function() {
		formfield = 2;
		tb_show('Upload a favicon', 'media-upload.php?referer=wptuts-settings&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});

	//store old send to editor function
	window.original_send_to_editor = window.send_to_editor;
	
	window.send_to_editor = function(html) {
		if (formfield == 1) {
			var image_url = $('img',html).attr('src');
			$('#logo_url').val(image_url);
			tb_remove();
			$('#upload_logo_preview img').attr('src',image_url);
		}else{
			if(formfield == 2){
				var image_url = $('img',html).attr('src');
				$('#favicon_url').val(image_url);
				tb_remove();
				$('#upload_favicon_preview img').attr('src',image_url);
			}else{
				window.original_send_to_editor(html);
			}
		}
	}
	
});