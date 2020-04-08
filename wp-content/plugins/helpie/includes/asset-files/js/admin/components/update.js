var xhr;
var msg_strings = {
    save_envato_api_token: {
        before: "Verifying",
        success: " Success!",
        failure: " Failed....!"
    },
    check_for_update: {
        before: "John",
        success: "Doe"
    }
};

var msg_icons = {
    before: "John",
    success: "Doe"
};

function Ajax_Helper(ajax_data) {
    // check if ajax request not proceeded and finish before running another one
    if (
        xhr &&
        (xhr.readyState == 3 || xhr.readyState == 2 || xhr.readyState == 1)
    ) {
        return false;
    }

    // prepare message icon
    var msg_state = msg_strings[ajax_data.func];

    // retrieve callbacks
    var ajax_callbacks = ajax_data.callbacks;
    // delete callbacks to prevent fire function from jQuery.ajax->data
    delete ajax_data.callbacks;

    // start ajax request
    xhr = jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        data: ajax_data,
        beforeSend: function() {
            var msg_before = msg_icons.before + msg_state.before;
            if (ajax_callbacks.before) {
                ajax_callbacks.before(ajax_data, msg_before);
            }
        },
        error: function(response) {
            console.error(response);
            if (ajax_callbacks.error) {
                ajax_callbacks.error(ajax_data, response);
            }
        },
        success: function(response) {
            // if errors occured in php script
            if (!response.success) {
                if (ajax_callbacks.error) {
                    ajax_callbacks.error(ajax_data, response);
                }
                return false;
            } else {
                var msg_success = msg_icons.success + msg_state.success;
                if (ajax_callbacks.success) {
                    ajax_callbacks.success(ajax_data, response, msg_success);
                }
            }
        }
    });
}

jQuery(document).ready(function() {
    // Helpie - Save Envato API TOKEN

    jQuery(document).on("click", "#helpie-save-envato-api-token", function() {
        // console.log('Save Envato API');

        var that = jQuery(this);
        var Spinner = jQuery('.plugin-activation.helpie-segment').find('.spinner');

        Ajax_Helper({
            nonce: helpieUpdateNonce,
            action: "helpie_admin_ajax",
            func: "save_envato_api_token",
            token: jQuery('[name="helpie_envato_api_token"]').val(),
            callbacks: {
                before: function(ajax_data, msg) {
                    Spinner.css("visibility", "visible").show();
                    Spinner.nextAll('strong').html(
                        msg_strings[ajax_data.func].before
                    );
                },
                success: function(ajax_data, response, msg) {
                    console.log('success: ' + response);
                    Spinner.css("visibility", "visible").hide();
                    Spinner.nextAll('strong').html(
                        msg_strings[ajax_data.func].success
                    );
                    location.reload();
                    Spinner.nextAll('strong').css('color' , '#61BC2F');
                },
                error: function(ajax_data, response) {
                    var text = msg_strings[ajax_data.func].failure;
                    var errorMessage = response['message'];
                    console.log('error: '+ text);
                    console.log(errorMessage);
                    Spinner.css('visibility', 'visible').hide();
                    Spinner.nextAll('strong').html(errorMessage);
                    Spinner.nextAll('strong').css('color' , '#E93F33');
                }
            }
        });
    });

    // ==================================================================
    // Helpie - Check plugin update
    // ==================================================================

    jQuery(document).on("click", "#helpie-check-update", function() {
        var that = jQuery(this);

        Ajax_Helper({
            nonce: helpieUpdateNonce,
            action: "helpie_admin_ajax",
            func: "check_for_update",
            callbacks: {
                before: function(ajax_data, msg) {
                    that.find("i").addClass("loading");
                },
                success: function(ajax_data, response, msg) {
                    setTimeout(function() {
                        jQuery(".remote-status").css("visibility", "visible");

                        if (response.message) {
                            jQuery(".remote-status").html(response.message);
                        } else {
                            jQuery(".remote-status").html(
                                jQuery(response.content).html()
                            );
                        }

                        that.find("i").removeClass("loading");
                        that.find("i").removeClass("sync");
                        that.find("i").addClass("check");
                    }, 1500);
                },
                error: function(ajax_data, response) {
                    setTimeout(function() {
                        jQuery(".remote-status").css("visibility", "visible");

                        if (response.message) {
                            jQuery(".remote-status").html(response.message);
                        } else {
                            jQuery(".remote-status").html(
                                jQuery(response.content).html()
                            );
                        }

                        that.find("i").removeClass("loading");
                    }, 1500);
                }
            }
        });
    });

    // ==================================================================
    // Helpie - Update plugin
    // ==================================================================

    jQuery(document).on("click", ".update-now.tg-button-live-update", function(
        e
    ) {
        var that = jQuery(this);
        that.nextAll(".spinner")
            .css("visibility", "visible")
            .show();
        that.nextAll("strong").html(msg_strings.Update_Plugin_Class.before);
        jQuery(".remote-status").html("updating...");
    });
}); // document.ready
