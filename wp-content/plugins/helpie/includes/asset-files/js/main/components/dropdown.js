var selectors = {
    dropdown: ".ui.dropdown",
    editor: ".article-categories-field #helpdesk_category",
    editor_menu: ".article-categories-field #helpdesk_category .menu",
    editor_items: ".article-categories-field #helpdesk_category .menu .item"
};

var DropDown = {
    init: function () {
        this.eventHandlers();
    },
    eventHandlers: function () {
        var thisModule = this;
        thisModule.onClick();
        thisModule.onSelect();
    },

    onClick: function () {
        jQuery(selectors.dropdown).click(function (e) {
            e.stopPropagation();
            DropDown._toggle(jQuery(this));
        });

        jQuery(document).click(function () {
            if (jQuery(selectors.dropdown + " .menu").hasClass("visible")) {
                DropDown._hide(jQuery(selectors.dropdown));
            }
        });
    },

    onSelect: function () {
        jQuery(selectors.editor_items).click(function () {
            // console.log(this);
            var dropdown = jQuery(selectors.editor);
            var option = jQuery(this);

            // remove previous chosen option
            var previous_category_id = dropdown.find("input").val();
            var previeous_option = dropdown.find(
                ".menu " + "[data-value='" + previous_category_id + "']"
            );
            previeous_option.removeClass("active selected");

            // update chosen option
            var chosen_category_id = option.attr("data-value");
            dropdown.find("input").val(chosen_category_id);
            dropdown
                .find(".text")
                .text(option.text())
                .removeClass("default");
            option.addClass("active selected");
        });
    },

    get: function (item, behaviour) {

        var element = jQuery(item);
        var value = element.find("input").val();

        if (behaviour == 'item') {
            return element.find(".menu " + "[data-value='" + value + "']");
        }

        return value;
    },

    set: function (item, value) {
        var element = jQuery(item);
        var option = element.find(".menu " + "[data-value='" + value + "']");

        var dropdown = jQuery(selectors.editor);

        // remove previous chosen option
        var previous_category_id = dropdown.find("input").val();
        var previeous_option = dropdown.find(
            ".menu " + "[data-value='" + previous_category_id + "']"
        );
        previeous_option.removeClass("active selected");

        // Set Child Item or New Item
        element.find("input").val(value);
        element
            .find(".text")
            .text(option.text())
            .removeClass("default");

        option.addClass("active selected");
    },

    _hide: function (element) {
        element.removeClass("active visible")
            .find(".menu").hide()
            .removeClass("visible");
    },

    _show: function (element) {
        element.addClass("active visible")
            .find(".menu").show()
            .addClass("visible");
    },

    _toggle: function (element) {
        element.toggleClass("active visible")
            .find(".menu").toggle()
            .toggleClass("visible");
    }
};

module.exports = DropDown;
