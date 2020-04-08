var addTermField = {
    //Default field selector. This can be overwritten by init parameter
    fieldSector: ".article-terms-field",

    modalAddTags: function() {
        var thisModule = this;

        var inputElement = jQuery(this.fieldSector + " input");

        inputElement.bind("enterKey", function(e) {
            console.log("modalAddTags");
            //do stuff here
            var new_tag = jQuery(this).val();
            thisModule.appendTag(new_tag);
            jQuery(this).val("");
        });

        inputElement.keyup(function(e) {
            if (e.keyCode == 13) {
                jQuery(this).trigger("enterKey");
                thisModule.modalDeleteTags();
            }
        });
    },

    renderTerms: function(tags_info) {
        if (tags_info) {
            for (var ii = 0; ii < tags_info.length; ii++) {
                var tag_name = tags_info[ii]["name"];
                this.appendTag(tag_name);
            }
        }
        this.deleteEventHandler();
    },

    deleteEventHandler: function() {
        jQuery(
            this.fieldSector + " .terms-container span.single-term-cont"
        ).click(function() {
            console.log("span clicked");
            jQuery(this).remove();
        });
    },

    getCreatedTerms: function() {
        var tags = [];

        jQuery(
            this.fieldSector + " .terms-container span.single-term-cont"
        ).each(function(index) {
            var single_tag = jQuery(this)
                .children(".label")
                .text();
            console.log(index + ": " + single_tag);
            tags.push(single_tag);
        });

        return tags;
    },

    appendTag: function(new_tag) {
        var existing_tags = this.getCreatedTags();

        var is_new_tag = true;
        for (var ii = 0; ii < existing_tags.length; ii++) {
            if (existing_tags[ii] == new_tag) {
                is_new_tag = false;
            }
        }

        if (is_new_tag == true) {
            var html =
                "<span class='single-term-cont'><span class='label'>" +
                new_tag +
                "</span><span>  </span></span>";
            jQuery(".article-terms-field .terms-container").append(html);
        }
    },

    removeAllTags: function() {
        jQuery(this.fieldSector + " .terms-container").html("");
    },

    modalDeleteTags: function() {
        jQuery(
            this.fieldSector + " .terms-container span.single-term-cont"
        ).click(function() {
            jQuery(this).remove();
        });
    },

    getCreatedTags: function() {
        var tags = [];

        jQuery(
            this.fieldSector + " .terms-container span.single-term-cont"
        ).each(function(index) {
            var single_tag = jQuery(this)
                .children(".label")
                .text();
            tags.push(single_tag);
        });

        return tags;
    },

    appendTag: function(new_tag) {
        var existing_tags = this.getCreatedTags();

        var is_new_tag = true;
        for (var ii = 0; ii < existing_tags.length; ii++) {
            if (existing_tags[ii] == new_tag) {
                is_new_tag = false;
            }
        }

        if (is_new_tag == true) {
            var html = "<span class='single-term-cont'>";
            html += "<span class='label'>" + new_tag + "</span>";
            html += "<span>  </span>";
            html += "</span>";
            jQuery(".article-terms-field .terms-container").append(html);
        }
    }
};

module.exports = addTermField;
