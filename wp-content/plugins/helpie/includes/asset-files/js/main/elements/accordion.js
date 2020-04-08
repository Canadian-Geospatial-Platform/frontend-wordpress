
// Accordion
var Accordion = {

    init: function () {

        jQuery(".helpie-accordion .item-title").click(function() {

            var title = jQuery(this);
            var content= jQuery(title).next(".item-content");
            var icon = jQuery(title).children("i");

            if(content.hasClass("active")){
                icon.addClass('right');
                icon.removeClass('down');
                content.slideUp('fast');
                content.removeClass('active');
            } else {
                icon.addClass('down');
                icon.removeClass('right');
                content.slideDown('fast');
                content.addClass('active');
            }
        });
    }
};

module.exports = Accordion;
