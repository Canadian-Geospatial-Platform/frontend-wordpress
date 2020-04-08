var Modal = require("./modal.js");
var selectors = {
    toc: ".helpie-toc div.protected",
    page: ".helpie-enter-password",
    article_list: ".helpie-articles-listing .helpie-element.protected",
    search_list: ".helpie-search-listing .helpie-element.protected",

    boxed_category:
        "#helpie-categories-section-boxed .helpie-category-listing .helpie-element.protected",
    boxed1_category:
        "#helpie-categories-section-boxed1 .helpie-category-listing .helpie-element.protected",
    modern_category:
        "#helpie-categories-section-modern .helpie-category-listing .helpie-element.protected",
    category_inside_link:
        ".helpie-category-listing .helpie-element.protected .article-preview-list li",

    modal: "#helpie-password-modal.small.ui.modal",
    modal_hide: ".pauple_helpie.ui.modal",
    modal_deny: "#helpie-password-modal.modal .actions .deny",
    modal_submit: "#helpie-password-modal .actions .positive",

    input: ".pauple_helpie.ui.modal input[type=password]"
};

var passwordSubmitted = false;

var PasswordProtect = {
    init: function () {
        var thisModule = this;

        setTimeout(function () {
            Modal.init(selectors.modal, selectors.modal_deny);
        }, 300);

        thisModule.eventhandlers();
    },

    eventhandlers: function () {
        var thisModule = this;

        // Single and Category Page Password button Click
        jQuery(selectors.page).click(function () {
            var element = jQuery(this);
            thisModule.post_id = element.data("post-id");
            thisModule.term_id = element.data("term-id");
            thisModule.origin = element.data("origin");

            Modal.show(selectors.modal);
        });

        // Search Page
        jQuery(selectors.search_list).click(function () {
            thisModule.post_id = jQuery(this).data("post-id");
            thisModule.term_id = jQuery(this).data("term-id");
            thisModule.origin = "article";

            Modal.show(selectors.modal);
            console.log("term-id: " + thisModule.term_id);
        });

        // Table of content password protection
        jQuery(selectors.toc).click(function () {
            thisModule.getAttrs(this);
            thisModule.origin = "category";

            Modal.show(selectors.modal);
        });

        // Article Listing
        jQuery(selectors.article_list).click(function () {
            thisModule.post_id = jQuery(this).data("post-id");
            thisModule.term_id = jQuery(this).data("term-id");
            thisModule.origin = "article";

            Modal.show(selectors.modal);
        });

        /* Category Listing elements with term-id-x should be clicked */

        jQuery(selectors.boxed_category).click(function () {
            thisModule.getAttrs(this);
            thisModule.origin = "category";

            Modal.show(selectors.modal);
        });

        jQuery(selectors.boxed1_category).click(function () {
            thisModule.getAttrs(this);
            thisModule.origin = "category";

            Modal.show(selectors.modal);
        });

        jQuery(selectors.modern_category).click(function () {
            thisModule.getAttrs(this);
            thisModule.origin = "category";

            Modal.show(selectors.modal);
        });

        // onClick Event for each article inside in Modern and Boxed1 Category Listing
        jQuery(selectors.category_inside_link).click(function (e) {
            if (jQuery(this).data().article) {
                thisModule.post_id = jQuery(this).data("post-id");
                thisModule.term_id = jQuery(this).data("term-id");
                thisModule.origin = "article";
            } else {
                thisModule.getAttrs(this);
                thisModule.origin = "category";
            }

            Modal.show(selectors.modal);

            e.stopImmediatePropagation();
        });

        // On Password Submit
        jQuery(selectors.modal_submit).click(function () {
            PasswordProtect.submit();
        });
    },

    getAttrs: function (element) {
        var thisView = this;
        var classes = jQuery(element)
            .attr("class")
            .split(" ");

        if (jQuery(element).data("origin")) {
            thisView.origin = jQuery(element).data("origin");
        }

        for (var ii = 0; ii < classes.length; ii++) {
            var className = classes[ii];
            // console.log("className: " + className);
            if (className.match("term-id")) {
                thisView.term_id = className.replace("term-id-", "");
            }
        }

        return thisView;
    },

    submit: function () {
        var thisModule = this;
        if (passwordSubmitted) {
            return;
        }

        passwordSubmitted = true;

        setTimeout(function () {
            passwordSubmitted = false;
        }, 1000);

        var data = this.getValidateProps();
        // console.log("@@@ PROPS @@@");
        console.log(data);

        jQuery.post(my_ajax_object.ajax_url, data, function (response) {
            var ajaxResponse = JSON.parse(response);
            console.log("response: " + ajaxResponse);
            if (ajaxResponse == 0) {
                thisModule.wrongPassword();
            } else {
                if (ajaxResponse.match("http")) {
                    thisModule.correctPasswordAction(ajaxResponse);
                } else {
                    thisModule.wrongPasswordAction();
                }
            }
        });
    },

    getValidateProps: function () {
        var thisModule = this;
        var input = jQuery(selectors.input).val();

        var props = {
            nonce: helpieKBFrontEndNonce,
            post_id: thisModule.post_id,
            term_id: thisModule.term_id,
            origin: thisModule.origin,
            action: "helpie_validate_password",
            input: input
        };

        return props;
    },

    correctPasswordAction: function (ajaxResponse) {
        var input = jQuery(selectors.input);
        var status = jQuery(selectors.modal + " .password-status");

        input.css("border-color", "#75d69c");
        if (status) {
            status.remove();
        }

        input.after(
            "<span class='password-status correct'>Verified. Redirecting you now <img class='redirect-gif' src='" +
            helpieGlobal.plugin_url +
            "includes/asset-files/images/redirecting.gif' /></span>"
        );
        window.location.assign(ajaxResponse);
    },

    wrongPasswordAction: function () {
        var input = jQuery(selectors.input);
        var status = jQuery(selectors.modal + " .password-status");
        input.css("border-color", "#fe6c61");

        if (status) {
            status.remove();
        }

        jQuery(input).after(
            "<span class='password-status wrong'>Wrong Password</span>"
        );
    }
};

module.exports = PasswordProtect;
