var active = "visible active";
var Modal = {
    init: function (selector, closeSelector) {
        var thisModule = this;
        var element = jQuery(selector);

        // Move Modal to Bottom
        element.parent().appendTo('body');

        thisModule.close(element);

        jQuery(closeSelector).click(function () {
            thisModule.close(element);
        });
    },

    show: function (selector) {
        var element = jQuery(selector);

        element.parent().attr('style', 'display: flex !important').addClass(active);
        element.addClass(active).show();
        element.find("input").first().focus();
    },

    close: function (element) {
        element.parent().css("display", "none").removeClass(active);
        element.removeClass(active).hide();
        element.find("input").first().blur();
    }
};

module.exports = Modal;
