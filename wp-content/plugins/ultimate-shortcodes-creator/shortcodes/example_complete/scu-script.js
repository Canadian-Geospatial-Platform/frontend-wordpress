
		(function($) {					
			"use strict";	// Throws more exceptions
			var shortcode = document.currentScript.getAttribute('data-name');
			var ajaxurl = scu_common.ajaxurl;
			let url = document.currentScript.src;
			var resources_url = url.substring(0, url.lastIndexOf('/')) + "/resources/assets/";

			//$.ajaxSettings.headers["x-custom"] = 'value';
			//$.ajaxSetup({
			//	headers: { 'Scu-Referer': url.substring(0, url.lastIndexOf('/')) }
			//});
			//delete $.ajaxSettings.headers["Scu-Referer"];


			$(document).ready(function() {
				$(".sc-"+shortcode).each(function() {
					var current = this;
					var content = $(this).children(".scu-content").html();							
					var atts = $(this).data();			
					var ajaxdata = {
						action: 'scu_ajax_handler',
						security: scu_common.ajaxNonce,
						content: content,
						//i18n: i18n,
						atts: atts
					};
				
					
				/***************************************************
				* Begin specific shortcode js
				****************************************************/
							
				/***************************************************************************
 * Shortcode: 	[scu name=example_complete]content[/scu]
 * Desciption: 	Change the font color and add a button 
 ***************************************************************************/

/***************************************************************************
* Available JS variables:
*  current:		(DOM Selector) points to each of the automatically created divs
*  shortcode:	(String) name of the shortcode
*  resourcesUrl:(String) resources files URL
*  content:		(String) shortcode content
*  atts:		(Array)  of shortcode atts  
*  ajaxurl:		(String) the url for admin-ajax.php
*  ajaxdata:	(Object) for data parameters in jQuery ajax. Including:
*						 param security (with an ajaxNonce)
*						 param action (needed for hook in the admin-ajax.php) 
*						 param shortcode (needed to redirect to the shortcode specific cmb-ajax-handler.php)*						 
*						 param content (with the var content value)
*						 param atts (with the var atts value)
****************************************************************************/
$(current).append('<img src="'+resources_url+'/image2.png">');
$(current).append('<button>Click Me</button>');
$(current).on("click", "button", function(event) {
	ajaxdata['myparam'] = 'somevalue';	// You can Add additional parameters in the ajax call to admin-ajax.php
	$.ajax({
		method: "POST",
		headers : {'Scu-Referer' : url.substring(0, url.lastIndexOf('/'))},		// Optional header
		url: ajaxurl,
		dataType: "json",
		data: ajaxdata
	})
	.done(function(response) {				
		$(current).html(response);
	});
});
new TypeIt('#scu-test', {
	strings: ["This is your content: "+content+".", "Press the button below to make an ajax call."],
	speed: 100,	
	loop: true,	
	breakLines: false
}).go();
				/***************************************************
				* End of specific shortcode js
				****************************************************/
				
				});
			});
			
		})(jQuery);

		