var getArticleData = require("./get-articleData.js");

// Nanobar initialization
var nanobar = require("nanobar");
var simplebar = new nanobar();

var remove = {
    init: function () {
        // console.log("remove");
        this.eventsHandler();
    },

    eventsHandler: function () {
        var thisModule = this;

        jQuery(".article-publish .remove").click(function () {
            thisModule.removeRevision();
        });
    },

    /**
     * Remove or Delete article based on capabilites Options.
     */
    removeRevision: function () {
        var thisModule = this;
        var livePostProps = getArticleData.getLivePostData();
        var revision_id = jQuery(".helpie-article-editor").data("revision-id");


        var data = {
            action: "helpie_delete_revision",
            nonce: thisModule.nonce,
            revision_id: revision_id
        };

        simplebar.go(100);

        jQuery
            .post(my_ajax_object.ajax_url, data, function (response) {
                // console.log("response: " + response);
            })
            .done(function () {
                toastr.warning(helpie_strings.onRevisionRemoved);
            });
    },

};

module.exports = remove;
