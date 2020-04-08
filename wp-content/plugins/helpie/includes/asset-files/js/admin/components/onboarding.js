var Import = require("./onboarding/import.js");

var selectors = {
    // Collections
    steps: ".helpie-element.onboarding .steps",
    sections: ".helpie-element.onboarding .sections",
    prevBtn: ".helpie-element.onboarding .previous.button",
    nextBtn: ".helpie-element.onboarding .next.button",
    pageForm: ".helpie-element.onboarding .page_setup.form",
    demoForm: ".helpie-element.onboarding .demo_setup.form",
    finishPage: ".helpie-element.onboarding .finish_page",
    dimmer: ".helpie-element.onboarding .dimmer",

    // Items
    pageSelect: ".helpie-element.onboarding .form [name='page_type'].dropdown",
    demoSelect: ".helpie-element.onboarding .form .radio.checkbox",
    demoCategory: ".helpie-element.onboarding .form .categories.selection.multiple.dropdown"
};

var Onboarding = {
    init: function () {
        Import.init();
        this.eventhandlers();
    },

    eventhandlers: function () {
        var thisModule = this;

        // Screen 1.Page Setup
        jQuery(selectors.pageSelect).dropdownX({
            onChange: function (value, text) {
                thisModule.onPageTypeSelect(value, text);
                setTimeout(function () {
                    jQuery(selectors.pageForm).form("validate form");
                }, 1);
            }
        });

        // Screen 2.Demo Setup
        jQuery(selectors.demoCategory).dropdownX();
        jQuery(selectors.demoSelect).checkbox({
            onChecked: function () {
                var checked = jQuery(this).attr("value");
                thisModule.setCategoryValues(checked);
            }
        });

        thisModule.onNavButtonClicks();
        thisModule.formValidation(selectors.pageForm);
        thisModule.formValidation(selectors.demoForm);
    },

    onPageTypeSelect: function (type, text) {
        var formFields = jQuery(".helpie-element.onboarding .form").children();

        var props = {
            nameField: jQuery(formFields[1]),
            slugField: jQuery(formFields[2]),
            label: "Name of your " + text,
            type: type,
            text: text
        };

        this.updateNameandSlugFields(props);
    },

    updateNameandSlugFields: function (props) {
        props.nameField.find("label").text(props.label);
        this.updateField(props.nameField, "page_name", props.text);
        this.updateField(props.slugField, "page_slug", props.type);
    },

    updateField: function (field, attrName, value) {

        var placeholder = value;
        if (attrName == 'page_slug') {
            value = (value == 'knowledge_base') ? 'kb' : value;
            value = (value == 'documentation') ? 'docs' : value;
        }

        field
            .find("[name='" + attrName + "']")
            .attr("placeholder", placeholder)
            .attr("value", value);
    },

    setCategoryValues: function (checked) {
        var categories = window.helpieDemosData[checked].categories;
        var values = [
            {
                name: "All",
                value: "all",
                selected: true
            }
        ];

        for (var i = 0; i < categories.length; i++) {
            values[i + 1] = {
                name: categories[i].name,
                value: categories[i].slug
            };
        }

        jQuery(selectors.demoCategory).dropdownX({
            values: values,
            placeholder: 'Select a Catgory'
        });
    },

    onNavButtonClicks: function () {
        var thisModule = this;

        jQuery(selectors.nextBtn).on("click", function (e) {
            e.preventDefault();
            jQuery(selectors.pageForm).form("validate form");
            jQuery(selectors.demoForm).form("validate form");
            var isDemoPassValidation = jQuery(selectors.pageForm).form("is valid");
            var isPagePassValidation = jQuery(selectors.demoForm).form("is valid");

            if (isDemoPassValidation && isPagePassValidation) {
                thisModule.setNavsWrap("next");
            }

            console.log("Next Button click");
        });

        jQuery(selectors.prevBtn).on("click", function (e) {
            e.preventDefault();
            thisModule.setNavsWrap("prev");
            console.log("previous Button click");
        });

        thisModule.setNavClickEvent();
    },

    formValidation: function (formElement) {
        jQuery(formElement).form({
            fields: {
                page_type: "empty",
                page_name: "empty",
                page_slug: "empty",
                categories: "empty",
                demo: "checked"
            }
        });
    },

    submitOnboard: function () {
        var pageValues = jQuery(selectors.pageForm).form("get values");
        var demoValues = jQuery(selectors.demoForm).form("get values");

        var data = {
            action: "helpie_onboarding_submit",
            page: pageValues,
            demo: demoValues,
            items: window.helpieDemosData[demoValues.demo]
        };
        console.log(data);

        var dimmer = jQuery(selectors.dimmer);
        dimmer.addClass("active");
        jQuery.post(my_ajax_object.ajax_url, data, function (response, status) {
            if (status === "success") {
                dimmer.removeClass("active");
                var result = JSON.parse(response);
                console.log(result);
                Onboarding.resultHtml(result);
            }
            if (status === "error") {
                dimmer.removeClass("active");
                alert("something wrong happened");
            }
        });
    },

    resultHtml: function (result) {
        var page = jQuery(selectors.finishPage);
        var pageValues = jQuery(selectors.pageForm).form("get values");

        var html = '<p>';
        for (var index = 0; index < result.error.notice.length; index++) {
            var item = result.error.notice[index];
            html += item.message + '</br>';
        }
        html += '</p>';
        page.html(html);

        var linkHtml = '';

        linkHtml += "<a class='ui labeled icon small button mainpage-link' href='http://" + window.location.hostname + "/" + pageValues.page_slug + "/'>";
        linkHtml += "Visit Main Page";
        linkHtml += "<i class='external alternate icon'></i>";
        linkHtml += "</a>";

        page.after(linkHtml);

        // return html;
    },

    setNavsWrap: function (to) {
        this.setActive("step", to);
        this.setActive("section", to);
        this.setNavClickEvent();
    },

    setActive: function (item, to) {
        var activeClass = "active " + item;
        var navSelector = item == "section" ? selectors.sections : selectors.steps;
        var navItem = jQuery(navSelector)
            .find(".active." + item)
            .attr("class", item);

        if (to == "next") {
            navItem.next().attr("class", activeClass);
        } else if (to == "prev") {
            navItem.prev().attr("class", activeClass);
        }
    },

    setNavClickEvent: function () {
        var thisModule = this;
        var prev = jQuery(selectors.prevBtn);
        var next = jQuery(selectors.nextBtn);
        var steps = jQuery(selectors.steps);

        var isPrevDisabled = prev.hasClass("disabled");
        // var isNextDisabled = next.hasClass("disabled");
        var isLastActive = thisModule.hasActive(steps, "last");
        var isFirstActive = thisModule.hasActive(steps, "first");

        if (isFirstActive) {
            prev.addClass("disabled");
            next.text("Next");
        } else if (isLastActive) {
            next.addClass("disabled");
            prev.parent().hide();
            steps
                .children()
                .last()
                .addClass("completed");
            // alert("Are you sure do you want to import demo ? ");
            // Onboard form Submission
            thisModule.submitOnboard();
        } else {
            if (isPrevDisabled) {
                prev.removeClass("disabled");
                next.text("Finish");
            }
            // if (isNextDisabled) {
            //     next.removeClass("disabled");
            // }
        }
    },

    hasActive: function (steps, nth) {
        var isActive;

        if (nth == "first") {
            isActive = steps
                .children()
                .first()
                .hasClass("active");
        } else if (nth == "last") {
            isActive = steps
                .children()
                .last()
                .hasClass("active");
        }

        return isActive;
    }
};

module.exports = Onboarding;
