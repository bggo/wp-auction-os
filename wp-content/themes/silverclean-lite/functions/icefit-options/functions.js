/**
 *
 * Silverclean WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013 Mathieu Sarrasin - Iceable Media
 *
 * Admin Settings Panel JS
 *
 */
var silverclean_admin_panel;
(function(jQuery){silverclean_admin_panel={
	init:function(){
		//admin panel
		var icf_title;
		jQuery('#icefit-admin-panel').removeClass('no-js');
		jQuery('#no-js-warning').hide();
		jQuery('#icefit-admin-panel .icefit-admin-panel-menu-link:first').addClass('visible');
		jQuery('#icefit-admin-panel .icefit-admin-panel-content-box:first').addClass('visible');
		jQuery('.icefit-admin-panel-menu-link').click(function(event) {
			event.preventDefault();
		});
		jQuery('.icefit-admin-panel-menu-link').click(function() {
			icf_title = jQuery(this).attr("id").replace('icefit-admin-panel-menu-', '');
			jQuery('.icefit-admin-panel-menu-link').removeClass('visible');
			jQuery('#icefit-admin-panel-menu-' + icf_title).addClass('visible');
			jQuery('.icefit-admin-panel-content-box').removeClass('visible');
			jQuery('.icefit-admin-panel-content-box').hide();
			jQuery('#icefit-admin-panel-content-' + icf_title).fadeIn("fast");
			jQuery('.icefit-admin-panel-content-box').removeClass('visible');
		});
		//submit
		jQuery('#icefitform').submit(function(){
			function newValues() {
				var serializedValues = jQuery("#icefitform").serialize();
				return serializedValues;
			}
			var serializedReturn = newValues();
			var data = {
				action: 'silverclean_settings_ajax_post_action',
				data: serializedReturn,
				silverclean_settings_nonce: jQuery('#silverclean_settings_nonce').val()
			};
			jQuery.post(ajaxurl, data);
			jQuery('#ajax-result').html('Settings saved.').fadeIn("normal").delay('1000').fadeOut("normal");
			return false; 
		});
		
		//reset
		jQuery('#icefit-reset-button').click(function() {
			var answer = confirm("Are you sure you want to reset ALL settings for this theme to default values ?");
			if (answer) {
				var data = { action: 'silverclean_settings_reset_ajax_post_action' };
				jQuery.post(ajaxurl, data);
				setTimeout("location.reload(true);",300);
			}
		});
			
	}
};

jQuery(document).ready(function(){
	silverclean_admin_panel.init()	
})})(jQuery);