var tinymce = require("tinymce");

console.log("tinymce.init: " + !!tinymce.init);

var tinymceService = {
    init: function (selector, type) {
        var thisModule = this;

        if (type == "inlineFull") {
            thisModule.inlineFull(selector);
        } else {
            thisModule.inlineBasic(selector);
        }
    },

    // domain : comes from scripts-handler
    inlineFull: function (selector) {
        console.log("domain: " + domain);
        var thisModule = this;
        var tinymcePluginsPath =
            helpie_strings.pluginURL + "vendor-custom/tinymce/plugins/";

        tinymce.init({
            selector: ".helpie-article-editor .content-area .editor-content.tinymce",
            theme: "inlite",
            plugins: "image media link paste contextmenu textpattern autolink codesample",
            external_plugins: {
                table: tinymcePluginsPath + "table/plugin.js",
                contextmenu: tinymcePluginsPath + "contextmenu/plugin.min.js",
                textpattern: tinymcePluginsPath + "textpattern/plugin.min.js",
                autolink: tinymcePluginsPath + "autolink/plugin.min.js",
                codesample: tinymcePluginsPath + "codesample/plugin.min.js"
            },
            codesample_languages: [{
                    text: "HTML/XML",
                    value: "markup"
                },
                {
                    text: "JavaScript",
                    value: "javascript"
                },
                {
                    text: "CSS",
                    value: "css"
                },
                {
                    text: "PHP",
                    value: "php"
                },
                {
                    text: "Ruby",
                    value: "ruby"
                },
                {
                    text: "Python",
                    value: "python"
                },
                {
                    text: "Java",
                    value: "java"
                },
                {
                    text: "C",
                    value: "c"
                },
                {
                    text: "C#",
                    value: "csharp"
                },
                {
                    text: "C++",
                    value: "cpp"
                },
                {
                    text: "JSON",
                    value: "json"
                },
                {
                    text: "SQL",
                    value: "sql"
                },
                {
                    text: "bash",
                    value: "bash"
                },
                {
                    text: "markdown",
                    value: "markdown"
                }
            ],
            insert_toolbar: "quickimage media codesample",
            selection_toolbar: "bold italic | quicklink h2 h3 h4 h5 h6 blockquote codesample",
            inline: true,
            paste_data_images: true,
            convert_urls: false,
            images_upload_url: helpie_strings.pluginURL +
                "features/postAcceptor.php?path=" +
                helpie_strings.dirURL +
                "",
            automatic_uploads: true,
            media_live_embeds: true,
            init_instance_callback: function (editor) {
                var content = tinymce.get("content-tinymce").getContent();
                if (content == "") {
                    jQuery(
                        ".helpie-article-editor .content-area .editor-content"
                    ).html("");
                }
            }
        });
    },

    inlineBasic: function () {
        tinymce.init({
            selector: ".helpie-article-editor .content-area .title.tinymce",
            theme: "inlite",
            inline: true,
            convert_urls: false,
            selection_toolbar: "",
            init_instance_callback: function (editor) {
                var content = tinymce.get("title-tinymce").getContent();
                if (content == "") {
                    jQuery(".helpie-article-editor .content-area .title").html(
                        ""
                    );
                }
            }
        });
    }
};

module.exports = tinymceService;