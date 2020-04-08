var revision = {
    init: function() {
        // console.log("Revision");
        this.eventsHandler();
    },

    eventsHandler: function() {
        var thisModule = this;
        jQuery(".revisions .menu .item").click(function() {
            thisModule.setCurrentRevision(this);
        });
    },

    setCurrentRevision: function(element) {
        var thisModule = this;

        jQuery(".revisions .menu .item").removeClass("active");
        jQuery(element).addClass("active");

        var post_id = jQuery(element).data("post-id");
        var revision_id = jQuery(element).data("revision-id");
        var previous_revision_id = jQuery(element).data("previous-revision-id");

        // Set revision-id in editor
        jQuery(".helpie-article-editor").data("revision-id", revision_id);

        thisModule.getRevision(post_id, revision_id, previous_revision_id);
    },

    getRevision: function(post_id, revision_id, previous_revision_id) {
        var thisModule = this;
        var nonce = helpieKBFrontEndNonce;

        var data = {
            action: "helpie_get_revision",
            nonce: nonce,
            post_id: post_id,
            revision_id: revision_id,
            previous_revision_id: previous_revision_id
        };

        jQuery.post(my_ajax_object.ajax_url, data, function(response) {
            var ajaxResponse = JSON.parse(response);
            console.log("getRevision: ... ");
            jQuery(".helpie-article-editor .content-area .title").html(
                ajaxResponse["title"]
            );

            // For inline
            jQuery(".helpie-article-editor .content-area .editor-content").html(
                ajaxResponse["content"]
            );

            // For wpeditor
            tinymce.get("content-tinymce").setContent(ajaxResponse["content"]);

            var previous_html = "";

            if (ajaxResponse["diff_array"]) {
                if (ajaxResponse["diff_array"][0]) {
                    previous_html += ajaxResponse["diff_array"][0]["diff"];
                }
                if (ajaxResponse["diff_array"][1]) {
                    previous_html += ajaxResponse["diff_array"][1]["diff"];
                }
            }

            jQuery(
                ".helpie-article-editor .revision-diff-area .table-area"
            ).html(previous_html);
        });
    }
};

module.exports = revision;
