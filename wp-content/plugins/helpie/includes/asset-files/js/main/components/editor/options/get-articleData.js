var addTermField = require("../../../elements/add-term-field.js");
var dropdown = require("../../dropdown.js");

var articleData = {
    loadPostValues: function () {
        var thisModule = this;
        var post_id = jQuery(".helpie-article-editor").data("post-id");
        var nonce = helpieKBFrontEndNonce;
        var data = {
            action: "helpie_ajax_get_article_info",
            nonce: nonce,
            post_id: post_id
        };

        jQuery.post(my_ajax_object.ajax_url, data, function (response) {
            var ajaxResponse = JSON.parse(response);

            var post_title = ajaxResponse["post_title"];
            var post_content = ajaxResponse["post_content"];
            var category_id = ajaxResponse["category_id"];
            var tags_info = ajaxResponse["tags_info"];

            dropdown.set(".article-categories-field #helpdesk_category", category_id);

            addTermField.renderTerms(tags_info);
        });
    },
    // Gets live Post data from the DOM as it is being edited
    getLivePostData: function () {
        var post_id = jQuery(".helpie-article-editor").data("post-id");
        var post_title = jQuery(
            ".helpie-article-editor .content-area .title"
        ).html();

        if (jQuery(".wp-editor-container").length) {
            // var post_content = tinymce.get('content-tinymce').getContent();

            var activeEditor = tinymce.get("content-tinymce");
            if (
                activeEditor == null ||
                jQuery("#content-tinymce").attr("aria-hidden") == "false"
            ) {
                // Make sure we're not calling setContent on null

                var post_content = jQuery("#content-tinymce").val();
            } else {
                var post_content = activeEditor.getContent();
            }
        } else {
            var post_content = jQuery(
                ".helpie-article-editor .content-area .editor-content"
            ).html();
        }

        // console.log("post_contents: " + post_content);

        var category_id = jQuery("#helpdesk_category-input").val();

        var parent = dropdown.get(".article-categories-field #helpdesk_category", 'item');
        var parent_id = jQuery(parent).attr("data-parent");
        parent_id = parent_id == undefined ? "0" : parent_id;
        // console.log("Parent :: ");
        // console.log(parent_id);

        var post_state = "edit-article";

        if (jQuery(".helpie-article-editor").hasClass("add-article")) {
            post_state = "add-article";
        }

        var tags = addTermField.getCreatedTerms();
        var tag_stringify = tags.join(",");

        var livePostProps = {
            post_id: post_id,
            post_title: post_title,
            post_content: post_content,
            tags: tag_stringify,
            category_id: category_id,
            parent_id: parent_id,
            post_state: post_state
        };

        if (jQuery(".helpie_kb_featured_image").attr("data-attachment")) {
            livePostProps.attachment_id = jQuery(".helpie_kb_featured_image").attr(
                "data-attachment"
            );
        }

        return livePostProps;
    }
};

module.exports = articleData;