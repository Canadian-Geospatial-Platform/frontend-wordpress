
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
* Available JS variables:
*  current:		(DOM Selector) points to each of the automatically created divs
*  shortcode:	(String) name of the shortcode
*  resourcesUrl:(String) resources files URL
*  content:		(String) shortcode content
*  atts:		(Array)  of shortcode atts  
*  ajaxurl:		(String) the url for admin-ajax.php
*  ajaxdata:	(Object) for data parameters in jQuery ajax. Including:
*						 param security (with the ajaxNonce)
*						 param action (needed for hook in the admin-ajax.php) 
*						 param shortcode (needed to redirect to the shortcode specific cmb-ajax-handler.php)*						 
*						 param content (with the var content value)
*						 param atts (with the var atts value)
****************************************************************************/
$(current).append('<button>Click Me</button>');
$(current).on("click", "button", function(event) {
	alert('JS Code working successfully');
});
				/***************************************************
				* End of specific shortcode js
				****************************************************/
				
				});
			});
			
		})(jQuery);

		