PasswordProtect = require("./components/password-protect.js");
DropDown = require("./components/dropdown.js");
KBSidebar = require("./components/sidebar.js");
KBVoting = require("./components/voting.js");

Accordion = require("./elements/accordion.js");
KBSearch = require("./components/search.js");
Single = require("./components/single.js");

/*
Semantic UI: dropdown method name changed to dropdownX from
Helpie: v1.9.2,
Semantic UI: v2.4.2
*/

var KB = {
    init: function () {
        KBVoting.init();
        KBSearch.init();
        KBSidebar.init();
        Accordion.init();
        PasswordProtect.init();
        DropDown.init();
        Single.init();

        this.eventHandlers();
    },

    eventHandlers: function () {
        thisModule = this;

        jQuery(".helpie-main-content-area ul.main-nav li a").click(function () {
            jQuery(".helpie-main-content-area ul.main-nav li").removeClass("active");
            jQuery(this)
                .closest("li")
                .addClass("active");
            jQuery(".helpie-main-content-area .content-section").hide();
            jQuery(jQuery(this).data("target")).show();
        });

        jQuery(".category-sidebar ul li a").click(function () {
            jQuery(".category-sidebar ul li").removeClass("active");
            jQuery(this)
                .closest("li")
                .addClass("active");
            jQuery(".category-main-content .category-section").hide();
            jQuery(jQuery(this).data("target")).show();
        });
    }
};

module.exports = KB;
