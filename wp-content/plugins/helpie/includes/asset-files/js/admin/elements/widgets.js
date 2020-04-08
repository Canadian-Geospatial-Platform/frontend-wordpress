var helpieWidgets = {
	updateField: function(element) {
		var inputHidden = jQuery(element)
			.closest(".helpie-field-row")
			.find("input[type=hidden]");

		var parent_dropdown = jQuery(element).closest(".dropdown");
		var labels = parent_dropdown.find("a.label");
		var new_array = [];
		labels.each(function(index) {
			new_array.push(jQuery(this).attr("data-value"));
		});
		var imploded = new_array.join(",");
		inputHidden.val(imploded);
	},

	getInputValue: function(element, $default) {
		var input_value = jQuery(element)
			.closest(".helpie-field-row")
			.find("input[type=hidden]")
			.val();
		if (input_value) {
			var input_value_array = input_value.split(",");
		} else {
			var input_value_array = $default;
		}

		return input_value_array;
	},

	initMultiDropDown: function(element, input_value_array) {
		var thisModule = this;

		jQuery(element)
			.dropdownX("set selected", input_value_array)
			.dropdownX({
				onChange: function() {
					setTimeout(function() {
						thisModule.updateField(element);
					}, 500);
				}
			});
	},

	eventHandler: function() {
		var thisModule = this;

		jQuery(".helpie-field.multi_dropdown").each(function() {
			var input_value_array = thisModule.getInputValue(this, "all");
			thisModule.initMultiDropDown(this, input_value_array);
		});
	},

	init: function() {
		this.eventHandler();
	}
};

module.exports = helpieWidgets;

/* Document Ready for widget add and update */

jQuery(document).ready(function() {
	jQuery(document).on("widget-added", function(event, widget) {
		// console.log("Widget Added");
		helpieWidgets.init();
	});

	jQuery(document).on("widget-updated", function(event, widget) {
		// console.log("Widget Updated");
		helpieWidgets.init();
	});
});
