jQuery(document).ready( function( $ ) {
    $('#upload_image_button').click(function() {
        formfield = $('#oem_showrooms_brand_logo').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = $('img',html).attr('src');
        $('#oem_showrooms_brand_logo').val(imgurl);
        $('#logo-container').html('<img src="' + imgurl + '" width="200" />');
        tb_remove();
    }
    
    $('#removeBrandLogo').click(function() {
		var data = {
			'action': 'showrooms_remove_logo',
			'post_id': $('#post_ID').val()
		};
		
		$.post(ajaxurl, data, function(response) {
			$('#logo-container').html(response);
			$('#removeBrandLogo').remove();
		});
    });
});
