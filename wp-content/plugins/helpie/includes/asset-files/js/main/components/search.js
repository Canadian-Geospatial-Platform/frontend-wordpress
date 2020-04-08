// search.js is depend on vendor package of jquery.autocomplete.js
require("./../../../vendors/autocomplete/jquery.autocomplete");

var KBSearch = {
    init: function() {
        this.eventHandlers();
    },

    eventHandlers: function() {
        this.initSearchAutocomplete();
    },

    initSearchAutocomplete: function() {
        if (0 < jQuery("#autocomplete").length) {
            // Call only if autocomplete element is present

            jQuery("#autocomplete").autocompleteX({
                appendTo: ".helpie-autocomplete-suggestions-container",
                lookup: function(query, done) {
                    var nonce = helpieKBFrontEndNonce;
                    query = jQuery.trim(query);

                    var data = {
                        action: "helpie_search_autosuggest",
                        nonce: nonce,
                        story: "kb",
                        query_value: query // We pass php values differently!
                    };
                    if (0 < query.length) {
                        jQuery.post(my_ajax_object.ajax_url, data, function(
                            response
                        ) {
                            var ajaxResponse = JSON.parse(response);

                            for (var ii = 0; ii < ajaxResponse.length; ii++) {
                                // get the text in a string:
                                ajaxResponse[ii]["title"] = jQuery("<div>")
                                    .html(ajaxResponse[ii]["title"])
                                    .text();
                                ajaxResponse[ii]["value"] = jQuery("<div>")
                                    .html(ajaxResponse[ii]["value"])
                                    .text();
                            }

                            var result = {
                                suggestions: ajaxResponse
                            };

                            done(result);
                        });
                    }
                },

                // overrides autocomplete defaults
                showNoSuggestionNotice: true,
                noSuggestionNotice:
                    helpie_strings.noMatches || "Did not match any articles !",
                deferRequestBy: 400,

                formatResult: function(suggestion, currentValue) {
                    var value = suggestion.title;
                    value = KBSearch.suggestionHighlighter(value, currentValue);

                    var content = suggestion.content;
                    content = KBSearch.suggestionHighlighter(
                        content,
                        currentValue
                    );
                    if (content.length == 0) {
                        content = "";
                    } else {
                        var html =
                            '<div class="description"><p style="margin: 0px !important;">';
                        html += content;
                        html += "</p></div>";
                        content = html;
                    }

                    var searchedIn = helpie_strings.in || "in";
                    var category = suggestion.category;

                    var html =
                        '<div class="ui middle aligned mini image">' +
                        suggestion.image +
                        "</div>";
                    html += '<div class="middle aligned item-content">';
                    html += '<a class="header">';
                    html += '<span class="item-title">' + value + "</span>";
                    html += '<span class="item-in">' + searchedIn + "</span>";
                    html +=
                        '<span class="item-cat_name">' + category + "</span>";
                    html += "</a>";
                    html += content;
                    html += "</div>";

                    suggestion = html;

                    return suggestion;
                },

                onSelect: function(suggestion) {
                    window.location.href = suggestion.link;
                }
            });
        }
    },

    suggestionHighlighter: function(suggestionValue, currentValue) {
        if (!currentValue) {
            return suggestionValue;
        }
        var pattern =
            "(" + currentValue.replace(/[|\\{}()[\]^$+*?.]/g, "\\$&") + ")";
        return suggestionValue
            .replace(new RegExp(pattern, "gi"), "<strong>$1</strong>")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/&lt;(\/?strong)&gt;/g, "<$1>");
    }
};

module.exports = KBSearch;
