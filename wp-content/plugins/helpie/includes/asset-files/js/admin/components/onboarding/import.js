var isEmptyDemoData = true;
var selectors = {
    checkAll: ".checkbox.check_all_checkbox",
    checkParent: ".list .master.checkbox",
    checkChild: ".list .child.checkbox",

    deleteBtn: ".delete-demo-button",

};
var Import = {
    init: function () {
        this.eventHandlers();
    },
    eventHandlers: function () {
        this.isOnboardPage();
        this.deleteDemo();
        this.masterCheckBox();
        this.childCheckBox();
    },

    isOnboardPage: function () {
        var url = new URL(window.location.href);

        if (url.searchParams.get("page") == "onboarding" || "helpie-kb-settings") {
            if (isEmptyDemoData) {
                this.setDemoData();
            }
            isEmptyDemoData = false;
        }
    },

    setDemoData: function () {
        var data = {
            action: "helpie_onboarding"
        };

        jQuery.get(my_ajax_object.ajax_url, data, function (response) {
            window.helpieDemosData = JSON.parse(response);
        });
    },

    // Backend Settings Imported Demo's Events
    deleteDemo: function () {
        jQuery(selectors.deleteBtn).on("click", function (e) {
            e.preventDefault();
            console.log("Button Click Event !");
            var btn = jQuery(this);
            btn.children().addClass("loading");
            btn.addClass('disabled');

            Import.submitDemoDeleteEntries();
        });

		/*
		On success :
			1. remove loading icon
			2. "check circle outline" in icon
			3. toggle "red" class name with "green" button class
		*/
    },

    getDemoEntries: function () {
        var checkAll = jQuery(selectors.checkAll);
        var entries = {
            checked_all: 1
        };

        if (!checkAll.hasClass('checked')) {
            entries.checked_all = 0;
            var list = jQuery(selectors.checkParent);
            list.each(function () {
                var childCheckbox = jQuery(this).closest('.checkbox').siblings('.list').find('.checkbox');

                var type = jQuery(this);
                var typeName = type.find("[type=checkbox]").attr("name");
                entries[typeName] = {};

                // is master checkbox is checked for types
                if (type.checkbox('is checked')) {
                    childCheckbox.find("[type=checkbox]").each(function (i) {
                        entries[typeName][i] = jQuery(this).attr("name");
                    });
                } else {
                    childCheckbox.each(function (i) {
                        if (jQuery(this).checkbox("is checked")) {
                            entries[typeName][i] = jQuery(this).find("[type=checkbox]").attr("name");
                        }
                    });
                }
            });
        }
        return entries;
    },

    submitDemoDeleteEntries: function () {
        var demoValues = Import.getDemoEntries();

        var data = {
            action: "helpie_delete_demo_entries",
            entries: demoValues,
        };

        console.log(data);

        jQuery.post(my_ajax_object.ajax_url, data, function (response, status) {
            if (status === "success") {

                var result = JSON.parse(response);
                var message = (result.notice) ? result.notice : result.error;
                jQuery(".basic.delete-demo-button").after("<div class='import-demo-response'>" + message + "</div>");
                jQuery(selectors.deleteBtn).children().removeClass("loading");

                setInterval(function () {
                    window.location.reload();
                }, 6000);
            }
            if (status === "error") {
                alert("something went wrong !!");
                setInterval(function () {
                    window.location.reload();
                }, 6000);
            }
        });
    },

    masterCheckBox: function () {
        jQuery(selectors.checkParent)
            .checkbox({
                // check all children
                onChecked: function () {
                    var $childCheckbox = jQuery(this).closest('.checkbox').siblings('.list').find('.checkbox');
                    $childCheckbox.checkbox('check');
                },
                // uncheck all children
                onUnchecked: function () {
                    var $childCheckbox = jQuery(this).closest('.checkbox').siblings('.list').find('.checkbox');
                    $childCheckbox.checkbox('uncheck');
                }
            });

        jQuery(selectors.checkAll)
            .checkbox({
                // check all children
                onChecked: function () {
                    var list = jQuery(selectors.checkParent);
                    list.each(function () {
                        var $childCheckbox = jQuery(this).closest('.checkbox').siblings('.list').find('.checkbox');
                        $childCheckbox.checkbox('check');
                        // Disable All CheckBox
                        jQuery(this).checkbox('disable');
                        $childCheckbox.checkbox('disable');
                    });

                },
                // uncheck all children
                onUnchecked: function () {
                    var list = jQuery(selectors.checkParent);
                    list.each(function () {
                        var $childCheckbox = jQuery(list).closest('.checkbox').siblings('.list').find('.checkbox');
                        $childCheckbox.checkbox('uncheck');

                        // Enable All CheckBox
                        jQuery(this).checkbox('enable');
                        $childCheckbox.checkbox('enable');
                    });

                }
            });
    },

    childCheckBox: function () {
        jQuery(selectors.checkChild)
            .checkbox({
                // Fire on load to set parent value
                fireOnInit: true,
                // Change parent state on each child checkbox change
                onChange: function () {
                    var
                        $listGroup = jQuery(this).closest('.list'),
                        $parentCheckbox = $listGroup.closest('.item').children('.checkbox'),
                        $checkbox = $listGroup.find('.checkbox'),
                        allChecked = true,
                        allUnchecked = true;
                    // check to see if all other siblings are checked or unchecked
                    $checkbox.each(function () {
                        if (jQuery(this).checkbox('is checked')) {
                            allUnchecked = false;
                        }
                        else {
                            allChecked = false;
                        }
                    });
                    // set parent checkbox state, but dont trigger its onChange callback
                    if (allChecked) {
                        $parentCheckbox.checkbox('set checked');
                    }
                    else if (allUnchecked) {
                        $parentCheckbox.checkbox('set unchecked');
                    }
                    else {
                        $parentCheckbox.checkbox('set indeterminate');
                    }
                }
            });
    }
};

module.exports = Import;
