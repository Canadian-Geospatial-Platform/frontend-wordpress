var helpieUtils = require("../../../helpie-util.js");
var getArticleData = require("./get-articleData.js");
var publishSubmitted = false;

// Nanobar initialization
var nanobar = require("nanobar");
var simplebar = new nanobar();

var publish = {
    init: function () {
        // console.log("publish");
        this.eventHandler();
    },
    eventHandler: function () {
        var thisModule = this;

        jQuery(".article-publish .publish").click(function () {
            if (publishSubmitted) {
                return;
            }
            publishSubmitted = true;

            thisModule.publishArticle();

            setTimeout(function () {
                publishSubmitted = false;
            }, 10000);
        });
    },

    publishArticle: function () {
        var thisModule = this;
        var livePostProps = getArticleData.getLivePostData();

        var data = {
            action: "helpie_publish",
            nonce: thisModule.nonce,
            "action-type": "publish"
        };

        for (prop in livePostProps) {
            data[prop] = livePostProps[prop];
        }
        simplebar.go(100);

        // console.log(livePostProps);
        jQuery.post(my_ajax_object.ajax_url, data, function (response) {
            var ajaxResponse = JSON.parse(response);
            var post_id = ajaxResponse["post_id"],
                permalink = ajaxResponse["permalink"];
            // console.log(ajaxResponse);
            thisModule.goToEditMode(post_id, livePostProps, permalink);
            toastr.success(helpie_strings.onPublish);
        });
    },

    goToEditMode: function (post_id, livePostProps, permalink) {
        var current_url = window.location.href;
        current_url = helpieUtils.removeParam("link", current_url);
        if (livePostProps["post_state"] == "add-article") {
            current_url = helpieUtils.removeParam("editor_mode", current_url);
            current_url += "post_id=" + post_id;
        }
        if (permalink) {
            current_url += "&link=" + permalink;
        }

        setTimeout(function () {
            window.location.assign(current_url);
        }, 500);
    }
};

module.exports = publish;
