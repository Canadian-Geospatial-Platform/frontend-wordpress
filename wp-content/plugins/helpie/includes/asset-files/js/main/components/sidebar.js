var helpieUtils = require("./../helpie-util.js");
var KBTOC = require("./toc.js");

require("./../../../vendors/sticky/jquery.sticky-sidebar.min.js");

// Caching the KBSidbar Varibles;
var win = jQuery(window);

var sidebarArea = jQuery(".pauple-helpie-single-sidebar");
var sidebar = jQuery(".helpie-sidebar-fixer");
var mobileSidebarButton = jQuery(".mobile-toc-button");
var mobileIcon = jQuery(mobileSidebarButton).children("i");

// KBSidebar
var KBSidebar = {
    init: function() {
        KBTOC.init(); // Initiating TOC Module

        if (0 < sidebarArea.length) {
            this.eventhandlers();

            // Only for tablet and mobile
            if (win.width() <= 1024) {
                this.mobileMenuEventHandler();
            }
        }
    },

    eventhandlers: function() {
        var thisModule = this;

        // Show Fixed Sidebar Only for Desktop
        if (1024 < win.width()) {
            if (
                thisModule.isTOCPresent() &&
                sidebarArea.hasClass("fixed-sidebar")
            ) {
                this.stickySidebarOnScroll();
            }
        }
    },

    stickySidebarOnScroll: function() {
        this.setFixerWidth();
        this.setFixerHeight();
        var sidebars = jQuery(".pauple-helpie-single-sidebar");
        sidebars.each(function(i) {
            new StickySidebar(this, {
                containerSelector: ".helpie-primary-view",
                innerWrapperSelector: ".helpie-sidebar-fixer",
                topSpacing: 20,
                bottomSpacing: 20
            });
        });
    },

    mobileMenuOnClickOutside: function() {
        sidebarArea.hide();
        mobileSidebarButton.removeClass("open");
        mobileIcon.removeClass("close link");
        mobileIcon.addClass("bars");
    },

    mobileMenuOnClick: function(clicked) {
        // console.log('Being clicked :',jQuery(clicked));
        var mobileIcon = jQuery(clicked).children("i");
        // console.log("mobileMenuOnClick: " + sidebarArea.is(":visible"));
        if (sidebarArea.is(":visible")) {
            jQuery(clicked)
                .next(sidebarArea)
                .slideUp();
            jQuery(clicked).removeClass("open");
            mobileIcon.removeClass("close link");
            mobileIcon.addClass("bars");
        } else {
            jQuery(clicked)
                .next(sidebarArea)
                .slideDown();
            jQuery(clicked).addClass("open");
            mobileIcon.removeClass("bars");
            mobileIcon.addClass("close link");
        }
    },

    mobileMenuEventHandler: function() {
        var thisModule = this;

        jQuery(document).on("click touchstart", function(e) {
            var container = sidebarArea;
            var container2 = mobileSidebarButton;

            // if the target of the click isn't the container nor a descendant of the container
            var not_container1 =
                !container.is(e.target) && container.has(e.target).length === 0;
            var not_container2 =
                !container2.is(e.target) &&
                container2.has(e.target).length === 0;

            if (not_container1 && not_container2) {
                thisModule.mobileMenuOnClickOutside();
            }
        });

        mobileSidebarButton.click(
            helpieUtils.debounce(function(e) {
                // console.log("clicked mobile-toc-button");
                thisModule.mobileMenuOnClick(this);
                e.stopPropagation();
            }, 300)
        );
    },

    isTOCPresent: function() {
        return 0 < sidebar.length ? true : false;
    },

    setFixerWidth: function() {
        var fixerWidth = sidebarArea.width();
        sidebar.css("width", fixerWidth);
    },

    setFixerHeight: function() {
        var fixerHeight = win.height() - 200;
        sidebar.css("height", fixerHeight);
    }
};

module.exports = KBSidebar;
