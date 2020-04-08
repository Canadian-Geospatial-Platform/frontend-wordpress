var helpieUtils = require("./../helpie-util.js");
var win = jQuery(window);

var KBTOC = {
    init: function () {
        this.eventHandlers();
    },

    eventHandlers: function () {
        this.smoothScroll();
        this.backToTop();
        this.activeHeading();
        this.accordionModification();
    },

    accordionModification: function () {

        /* 0. Hide Item Content when no content to display. */
        jQuery('.helpie-toc .helpie-accordion .item-content.active').each(function (index) {
            if (jQuery(this).children().length <= 0) {
                jQuery(this).css('display', 'none');
            }
        });

        jQuery('.helpie-toc .helpie-accordion a').click(function (e) {
            var attr = jQuery(this).attr('href');

            /* 0. Don't stop probagation if its a locked category, it needs popup */
            if (jQuery(this).closest('.item-title').hasClass('protected')) {
                return;
            }

            /* 1. Don't activate dropdown, when href attr is set, will go to a page instead */
            if (typeof attr !== typeof undefined && attr !== false && attr != '') {
                e.stopPropagation();
            }

            /* 2. Don't activate dropdown when no children are found */
            if (jQuery(this).closest('.helpie-accordion').find('.item-content').children().length <= 0) {
                e.stopPropagation();
            }




        });
    },
    smoothScroll: function () {
        jQuery("a[href^='#'].item").click(function (event) {
            var link = this.hash;
            var directTo = jQuery(link).offset();

            if (directTo !== undefined) {
                event.preventDefault();

                if (jQuery(this).is(".smooth-scroll.hash")) {
                    jQuery("html, body").animate({
                        scrollTop: directTo.top
                    },
                        800,
                        function () {
                            window.location.hash = link;
                        }
                    );
                } else if (
                    jQuery(this).is(".smooth-scroll") &&
                    jQuery(this).not(".hash")
                ) {
                    jQuery("html, body").animate({
                        scrollTop: directTo.top
                    },
                        800
                    );
                } else if (
                    jQuery(this).not(".smooth-scroll") &&
                    jQuery(this).is(".hash")
                ) {
                    window.location.hash = link;
                } else if (jQuery(this).not(".smooth-scroll.hash")) {
                    jQuery("html, body").animate({
                        scrollTop: directTo.top
                    },
                        1
                    );
                }
            }
        });
    },

    backToTop: function () {
        var link = jQuery(".article-title");
        var directTo = jQuery(link).offset();

        jQuery(".helpieBackToTop").on("click", function () {
            if (jQuery(this).is(".articleTop.smooth-scroll")) {
                jQuery("html, body").animate({
                    scrollTop: directTo.top
                },
                    800
                );
            } else if (jQuery(this).is(".articleTop")) {
                jQuery("html, body").animate({
                    scrollTop: directTo.top
                },
                    1
                );
            }

            if (jQuery(this).is(".pageTop.smooth-scroll")) {
                jQuery("html, body").animate({
                    scrollTop: 0
                },
                    800
                );
            } else if (jQuery(this).is(".pageTop")) {
                jQuery("html, body").animate({
                    scrollTop: 0
                },
                    1
                );
            }
        });
    },

    activeHeading: function () {
        var tocMenu = jQuery(".helpie-toc .ui.middle.aligned.selection.list");
        var tocMenu_a = jQuery("a", tocMenu);
        var id = false;
        var sections = [];

        tocMenu_a.each(function () {
            sections.push(jQuery(jQuery(this).attr("href")));
        });

        win.scroll(function (event) {
            var scrolling = jQuery(this).scrollTop() + jQuery(this).height() / 4;
            var activeHead_id;

            for (var i in sections) {
                var section = jQuery(sections[i]);

                if (section.offset() !== undefined) {
                    if (scrolling >= section.offset().top) {
                        activeHead_id = section.attr("id");
                    }
                }
            }
            if (activeHead_id !== id) {
                id = activeHead_id;
                tocMenu_a.removeClass("active");
                jQuery("a[href='#" + id + "']", tocMenu).addClass("active");
            }
        });
    }
};

module.exports = KBTOC;