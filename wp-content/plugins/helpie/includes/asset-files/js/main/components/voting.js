var KBVoting = {
    init: function() {
        // jQuery('.voting-icon i').popup();
        this.eventHandlers();
    },

    eventHandlers: function() {
        var thisModule = this;
        console.log("eventHandlers");
        if (0 < jQuery(".pauple-helpie-module.article-voting").length) {
            jQuery(".pauple-helpie-module.article-voting .voting-icon").click(
                KBVoting.debounce(function() {
                    thisModule.onVotingIconClick(this);
                }, 500)
            );
        }
    },
    debounce: function(fn, delay) {
        var timer = null;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                fn.apply(context, args);
            }, delay);
        };
    },

    onVotingIconClick: function(element) {
        console.log("onVotingIconClick");
        var previous_value = "";
        var previous_element = "";
        if (
            jQuery(".pauple-helpie-module.article-voting .voting-icon.selected")
                .length
        ) {
            previous_value = jQuery(
                ".pauple-helpie-module.article-voting .voting-icon.selected"
            ).attr("data-vote");
            previous_element = jQuery(
                ".pauple-helpie-module.article-voting .voting-icon.selected"
            );
        }

        var value = jQuery(element).attr("data-vote");
        var postID = jQuery(element)
            .closest(".icon-tray")
            .attr("data-post-id");
        var userID = jQuery(element)
            .closest(".icon-tray")
            .attr("data-user-id");

        jQuery(".pauple-helpie-module.article-voting .voting-icon").removeClass(
            "selected"
        );
        jQuery(element).addClass("selected");

        var articleVoteDebounced = KBVoting.debounce(
            KBVoting.articleVote,
            1500
        );
        articleVoteDebounced(value, postID, userID);

        if (value != previous_value) {
            if (previous_element) {
                var previous_count = parseInt(
                    previous_element.find("count").text()
                );
                var new_count = previous_count - 1;
                previous_element.find("count").text(new_count);
            }

            // var new_count = previous_count - 1;

            var new_pc = parseInt(
                jQuery(element)
                    .find("count")
                    .text()
            );
            var new_nc = new_pc + 1;
            jQuery(element)
                .find("count")
                .text(new_nc);
        }
    },

    articleVote: function(value, postID, userID) {
        var nonce = helpieKBFrontEndNonce;

        var data = {
            action: "article_voting_callback",
            nonce: nonce,
            voteValue: value, // We pass php values differently!
            postID: postID,
            userID: userID
            // 'postID': get_the_ID(),
        };

        jQuery.post(my_ajax_object.ajax_url, data, function(response) {
            var ajaxResponse = JSON.parse(response);
            console.log(
                "from server : " + JSON.stringify(ajaxResponse, null, 5)
            );

            var result = {
                suggestions: ajaxResponse
            };
        });
    }
};

module.exports = KBVoting;
