

jQuery(document).ready(function() {
	
	if(jQuery('#iphone_checkbox').attr('checked'))
	{
		jQuery('#jtwp_display_options').show();
	} else {
		jQuery('#jtwp_display_options').hide();
	}
	
	
	jQuery('#iphone_checkbox').live('click', function(){
		if(jQuery(this).attr('checked'))
		{
			jQuery('#jtwp_display_options').show('fadeIn');
		} else {
			jQuery('#jtwp_display_options').hide('fadeIn');
		}
	});
});


