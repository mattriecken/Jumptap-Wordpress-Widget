

jQuery(document).ready(function() {
	
	if(jQuery('#iphone_checkbox').attr('checked'))
	{
		jQuery('#jtwp_display_iphone_options').show();
	} else {
		jQuery('#jtwp_display_iphone_options').hide();
	}
	if(jQuery('#android_checkbox').attr('checked'))
	{
		jQuery('#jtwp_display_android_options').show();
	} else {
		jQuery('#jtwp_display_android_options').hide();
	}
	
	
	jQuery('#iphone_checkbox').live('click', function(){
		if(jQuery(this).attr('checked'))
		{
			jQuery('#jtwp_display_iphone_options').show('fadeIn');
		} else {
			jQuery('#jtwp_display_iphone_options').hide('fadeIn');
		}
	});
	
	jQuery('#android_checkbox').live('click', function(){
		if(jQuery(this).attr('checked'))
		{
			jQuery('#jtwp_display_android_options').show('fadeIn');
		} else {
			jQuery('#jtwp_display_android_options').hide('fadeIn');
		}
	});
	
});


