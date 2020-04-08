// Nanobar initialization
var nanobar = require("nanobar");
var Modal = require("./modal.js");
var simplebar = new nanobar();

var Single = {
    init: function () {
        this.eventHandlers();
    },

    eventHandlers: function () {
        var thisModule = this;
        /**
         * Delete or Trash the Article in Single Page
         */
        jQuery(".remove-article").click(function () {
            var option = jQuery(this),
                article_id = option.data("revision-id"),
                state = option.data("remove-option");

            thisModule.deleteRevision(article_id, state);
        });

        // show remove article popup
        Modal.init("#helpie-remove-info-modal", "#helpie-remove-info-modal .cancel.button");
        jQuery(".article-remove-option").click(function () {
            Modal.show("#helpie-remove-info-modal");
        });
    },

    deleteRevision: function (article_id, state) {
        var thisModule = this;
        // console.log("article_id: " + article_id);
        // console.log("state: " + state);

        var data = {
            action: "delete_single_article",
            nonce: thisModule.nonce,
            article_id: article_id,
            option: state
        };

        simplebar.go(100);

        jQuery.post(my_ajax_object.ajax_url, data, function (response) {
            var ajaxResponse = JSON.parse(response);
            if (state == "trash") {
                toastr.error(helpie_strings.onTrashed);
            } else {
                toastr.error(helpie_strings.onDeleted);
            }
            setTimeout(function () {
                window.location.href = ajaxResponse["forward_to"];
            }, 600);
        });
    }
};

module.exports = Single;
