var dropdown = require("../../dropdown.js");
var category = {
	init: function () {
		// console.log("category");
		this.eventHandler();
	},
	eventHandler: function () {
		var thisModule = this;
		jQuery(".add-category input").bind("enterKey", function (e) {
			thisModule.addCategory(this);
		});

		jQuery(".add-category input").keyup(function (e) {
			if (e.keyCode == 13) {
				jQuery(this)
					.trigger("enterKey")
					.val("");
			}
		});

		// Load Indendation for Categories based on Levels data-level attributes
		this.loadCategoriesIndendation();

		// Add new category Label
		this.addNewCategoryLabel();
	},

	addCategory: function () {
		// var singleParent = jQuery("#helpdesk_category").dropdownX("get value");
		var singleParent = dropdown.get(".article-categories-field #helpdesk_category", "value");
		singleParent = singleParent ? singleParent : 0;
		var new_category = jQuery(".add-category input").val();
		//get menu
		var $menu = jQuery("#helpdesk_category").find(".menu");
		//append new option to menu.
		// The 'new' data-value is used to tell php handler to create new category
		$menu.append(
			'<div class="item" data-parent = "' +
			singleParent +
			'"data-value="' +
			new_category +
			'" >' +
			new_category +
			"</div>"
		);
		//reinitialize drop down
		// jQuery(".ui.dropdown#helpdesk_category").dropdownX();
		// dropdown.init();

		//optional, set new value as selected option		
		dropdown.set(".article-categories-field #helpdesk_category", new_category);
	},
	loadCategoriesIndendation: function () {
		var items = jQuery("#helpdesk_category.dropdown")
			.find(".editor-dropdown")
			.children(".item");
		items = jQuery(items);

		if (0 < items.length) {
			items.each(function () {
				cat = jQuery(this);
				var level = cat.attr("data-level"),
					hypen = "-",
					categoryName = cat.text();
				hypen = hypen.repeat(level);
				cat.html(hypen + "&nbsp;" + categoryName);
			});
		}
	},

	addNewCategoryLabel: function () {
		// Add New Category Label
		jQuery(".add-category-label").click(function () {
			jQuery(this)
				.find("i")
				.toggleClass("minus plus");
			jQuery(".add-category").toggle();
			jQuery(".add-field-note").toggle();

			var item = jQuery("#helpdesk_category.dropdown")
				.find(".editor-dropdown")
				.children(".item");
			item = jQuery(item);
			if (0 < item.length) {
				item.each(function () {
					cat = jQuery(this);
					var parentLabel = cat.attr("data-value");
					if (parentLabel == -1) {
						cat.toggle();
					}
				});
			}
		});
	}
};

module.exports = category;
