var tinymceService = require("./tinymce-service.js");
var addTermField = require("../../elements/add-term-field.js");

// setting the defualt values for toastr notification
toastr.options.closeButton = true;
toastr.options.showMethod = "fadeIn";
toastr.options.hideMethod = "fadeOut";
toastr.options.closeMethod = "fadeOut";

// Load Front-editor Options
var categoryOption = require("./options/category.js"),
    revisionOption = require("./options/revision.js"),
    getArticleData = require("./options/get-articleData.js"),
    publishOption = require("./options/publish.js"),
    removeOption = require("./options/remove.js");

var Editor = {
    nonce: helpieKBFrontEndNonce,

    init: function () {
        var thisModule = this,
            // Initialise tinymce
            titleSelector =
                ".helpie-article-editor .content-area .title.tinymce",
            contentSelector =
                ".helpie-article-editor .content-area .editor-content.tinymce";

        tinymceService.init(titleSelector, "inlineBasic");
        tinymceService.init(contentSelector, "inlineFull");

        // Initialise addTermField
        addTermField.modalAddTags();

        // Initialise semantic components for the controls section
        // jQuery(".ui.accordion").accordion();

        // Initialise eventshandler
        thisModule.eventsHandler();

        // initializating Options
        categoryOption.init();
        revisionOption.init();
        publishOption.init();
        removeOption.init();

        // Load Values when not in add-article mode
        if (!jQuery(".helpie-article-editor").hasClass("add-article")) {
            getArticleData.loadPostValues();
        }
    },

    eventsHandler: function () {
        var thisModule = this;

        jQuery(".article-publish .show-diff").click(function () {
            thisModule.setDiffMode();
        });

        jQuery(".article-publish .edit-article").click(function () {
            thisModule.setEditMode();
        });

        thisModule.mobileEvents();
        jQuery(window).resize(function () {
            // console.log("second time");
            if (window.innerWidth <= 1024) {
                jQuery(
                    ".helpie-edit-page-container .controls-section .sticky"
                ).hide();
            } else {
                jQuery(
                    ".helpie-edit-page-container .controls-section .sticky"
                ).show();
            }
        });

        this.viewArticleNotice();
        this.setFeaturedImage();
    },

    /* Various Event Handlers */

    mobileEvents: function () {
        jQuery(document).mouseup(function (e) {
            var container = jQuery(
                ".helpie-edit-page-container .controls-section"
            );
            var sticky = jQuery(
                ".helpie-edit-page-container .controls-section .sticky"
            );

            if (window.innerWidth <= 1024) {
                // if the target of the click isn't the container nor a descendant of the container
                if (
                    !container.is(e.target) &&
                    container.has(e.target).length === 0
                ) {
                    sticky.hide();
                }
            }
        });

        jQuery(".helpie-edit-page-container .mobile-controls").click(
            function () {
                jQuery(
                    ".helpie-edit-page-container .controls-section .sticky"
                ).toggle();
            }
        );
    },

    setDiffMode: function () {
        jQuery(".helpie-article-editor").addClass("diff-mode");

        jQuery(".article-publish.buttons .edit-article").show();
        jQuery(".article-publish.buttons .show-diff").hide();
        jQuery(".article-publish.buttons .save-post").hide();
    },

    setEditMode: function () {
        jQuery(".helpie-article-editor").removeClass("diff-mode");

        jQuery(".article-publish.buttons .edit-article").hide();
        jQuery(".article-publish.buttons .show-diff").show();
        jQuery(".article-publish.buttons .save-post").show();
    },

    viewArticleNotice: function () {
        var permalink = this.getQueryParams(document.location.search);
        if (permalink["link"]) {
            var viewInfo =
                "<a href='" +
                permalink["link"] +
                "' target='_blank'>" +
                helpie_strings.onVisit +
                "</a>";
            setTimeout(function () {
                toastr.info(viewInfo);
            }, 2000);
        }
    },

    getQueryParams: function (qs) {
        qs = qs.split("+").join(" ");
        var params = {},
            tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;
        while ((tokens = re.exec(qs))) {
            params[decodeURIComponent(tokens[1])] = decodeURIComponent(
                tokens[2]
            );
        }
        return params;
    },

    setFeaturedImage: function () {
        var custom_uploader;

        jQuery("#helpie_kb_featured_upload_image_button").click(function (e) {
            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: helpie_strings.chooseFeaturedImage,
                button: {
                    text: helpie_strings.setFeaturedImage
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on("select", function () {
                attachment = custom_uploader
                    .state()
                    .get("selection")
                    .first()
                    .toJSON();
                jQuery("#helpie_kb_featured_upload_image").val(attachment.url);

                var data = {
                    action: "helpie_publish_img",
                    nonce: helpieKBFrontEndNonce
                };
                location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (
                    s,
                    k,
                    v
                ) {
                    data[k] = v;
                });
                data.attachment_id = attachment.id;

                jQuery.post(my_ajax_object.ajax_url, data, function (response) {
                    var ajaxResponse = JSON.parse(response);
                    var featuredImg = jQuery(".helpie_kb_featured_image");
                    if (ajaxResponse.src) {
                        featuredImg.attr("src", ajaxResponse.src);
                    }
                    if (ajaxResponse.attachment_id) {
                        featuredImg.attr(
                            "data-attachment",
                            ajaxResponse.attachment_id
                        );
                        featuredImg.attr("src", attachment.url);
                    }
                });
            });

            //Open the uploader dialog
            custom_uploader.open();
        });
    }
};

module.exports = Editor;
