"use strict";function _typeof(e){return(_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var ShortcodesUltimateMakerEditor={};ShortcodesUltimateMakerEditor.App=function(e){var t={};return t.el={editor:e("#shortcodes-ultimate-maker-editor"),publishBtn:e('input#publish[name="publish"]'),updateBtn:e('input#publish[name="save"]')},t.l10n=ShortcodesUltimateMakerEditorData.l10n.Editor,t.init=function(){t.changePublishLabels(),ShortcodesUltimateMakerEditor.TagName.init(),ShortcodesUltimateMakerEditor.Icon.init(),ShortcodesUltimateMakerEditor.Attributes.init(),ShortcodesUltimateMakerEditor.Code.init(),ShortcodesUltimateMakerEditor.CustomCss.init()},t.removePostboxClass=function(){t.el.editor.removeClass("postbox")},t.changePublishLabels=function(){t.el.publishBtn.val(t.l10n.createShortcode),t.el.updateBtn.val(t.l10n.updateShortcode)},{init:t.init}}(jQuery),jQuery(document).ready(ShortcodesUltimateMakerEditor.App.init),ShortcodesUltimateMakerEditor.TagName=function(e){var i={};return i.el={tagName:e("#sum-tag-name"),title:e("#sum-title")},i.init=function(){i.bindEvents()},i.bindEvents=function(){i.el.tagName.on("keyup",i.validateTagName),i.el.title.on("blur",i.generateTagName)},i.generateTagName=function(){var e,t=i.el.title.val();""===i.el.tagName.val()&&(e=t.toLowerCase().replace(/ /g,"_").replace(/[^a-z0-9_]/g,""),i.el.tagName.val(e),i.el.tagName.trigger("keyup"))},i.validateTagName=function(e){var t=i.el.tagName.val(),a=""===t;/^([a-z0-9_]*)$/.test(t)?i.el.tagName.parent("td").removeClass("sum-validation-failed"):i.el.tagName.parent("td").addClass("sum-validation-failed"),a?i.el.tagName.parent("td").addClass("sum-validation-required"):i.el.tagName.parent("td").removeClass("sum-validation-required")},{init:i.init}}(jQuery),ShortcodesUltimateMakerEditor.Icon=function(e){var a={};return a.el={body:e("body"),field:e("#sum-icon"),value:e("#sum-icon-value"),picker:null,dropdown:null,mediaLink:null,mediaFrame:null},a.tpl={general:e("#sum-icon-tpl").html(),fa:e("#sum-icon-fa-tpl").html(),img:e("#sum-icon-img-tpl").html()},a.l10n=ShortcodesUltimateMakerEditorData.l10n.Icon,a.icons=ShortcodesUltimateMakerEditorData.icons,a.init=function(){e(a.tpl.general).appendTo(a.el.field),a.el.picker=a.el.field.children(".sum-icon-picker").attr("data-label-closed",a.l10n.selectIcon).attr("data-label-open",a.l10n.close),a.el.dropdown=a.el.field.children(".sum-icon-dropdown").append(a.getDropdownContent()),a.el.mediaLink=a.el.field.find(".sum-icon-media-link a").html(a.l10n.useCustomImage+"&hellip;"),a.el.mediaFrame=wp.media({library:{type:"image"},title:a.l10n.selectCustomImage,button:{text:a.l10n.useSelectedImage},multiple:!1}),a.updatePreview(),a.bindEvents()},a.bindEvents=function(){a.el.picker.on("click",a.toggleDropdown),a.el.dropdown.on("click","i",a.setFAIcon),a.el.mediaLink.on("click",a.openMediaLibrary),a.el.mediaFrame.on("select",a.setImgIcon),a.el.body.on("click",a.clickOutsideDropdown)},a.updatePreview=function(){var e=a.el.value.val(),t="";t=-1<e.indexOf("/")?a.tpl.img.replace("%ICON%",e):a.tpl.fa.replace(/%ICON%/g,e),a.el.picker.html(t)},a.setFAIcon=function(){a.el.value.val(e(this).attr("title")),a.toggleDropdown(),a.updatePreview()},a.setImgIcon=function(){var e=a.el.mediaFrame.state().get("selection").first().toJSON();a.el.value.val(e.url),a.updatePreview()},a.openMediaLibrary=function(e){e.preventDefault(),a.toggleDropdown(),a.el.mediaFrame.open()},a.getDropdownContent=function(){for(var e="",t=a.icons.length-1;0<=t;t--)e+=a.tpl.fa.replace(/%ICON%/g,a.icons[t]);return e},a.toggleDropdown=function(){a.el.field.toggleClass("open")},a.clickOutsideDropdown=function(e){!a.el.field.is(e.target)&&a.el.field.hasClass("open")&&0===a.el.field.has(e.target).length&&a.el.field.removeClass("open")},{init:a.init}}(jQuery),ShortcodesUltimateMakerEditor.Attributes=function(n){var r={};return r.el={field:n("#sum-attributes"),value:n("#sum-attributes-value"),head:null,items:null,add:null},r.tpl={general:n("#sum-attributes-tpl").html(),item:n("#sum-attributes-item-tpl").html(),option:n("#sum-attributes-option-tpl").html(),types:""},r.l10n=ShortcodesUltimateMakerEditorData.l10n.Attributes,r.index=0,r.defaults=ShortcodesUltimateMakerEditorData.attributes.defaults,r.types=ShortcodesUltimateMakerEditorData.attributes.types,r.init=function(){r.tpl.general=r.parseTemplate(r.tpl.general,r.l10n.general),n(r.tpl.general).appendTo(r.el.field),r.el.items=r.el.field.children(".sum-attributes-items");for(var e=r.getValue(),t=0;t<e.length;t++)r.addAttribute(e[t]);r.el.items.sortable({tolerance:"pointer",handle:".sum-attributes-item-head",containment:"parent",placeholder:"sum-attributes-item-placeholder",start:function(){r.closeAll()},stop:function(){r.updateValue()}}),r.el.add=r.el.field.children(".sum-attributes-add"),r.el.add.children("a").text(r.l10n.add),r.bindEvents()},r.bindEvents=function(){r.el.add.on("click","a",r.addNewAttribute),r.el.field.on("click",".sum-attributes-item-head-label > a, .sum-attributes-item-head-toggle, .sum-attributes-item-toggle",r.toggleAttribute),r.el.field.on("click",".sum-attributes-item-close",r.toggleAttribute),r.el.field.on("click",".sum-attributes-item-head-delete",r.deleteAttribute),r.el.field.on("click",".sum-attributes-item-restore > a",r.restoreAttribute),r.el.field.on("change",".sum-attributes-item-label",r.changeLabel),r.el.field.on("change",".sum-attributes-item-name",r.changeName),r.el.field.on("change",".sum-attributes-item-type",r.changeType),r.el.field.on("change",".sum-attributes-item-default",r.changeDefault),r.el.field.on("keyup",".sum-attributes-item-name",r.validateName),r.el.items.on("change","td input, td select, td textarea",r.updateValue)},r.addNewAttribute=function(){var e=r.index+1;r.addAttribute(n.extend({},r.defaults,{name:r.l10n.item.newName.replace("%s",e),slug:"attribute_"+e,options:"option1|%s 1\noption2|%s 2".replace(/%s/g,r.l10n.general.option),open:!0})),r.updateValue()},r.addAttribute=function(e){e=n.extend({},r.defaults,e);var t=n.extend({},{index:r.index},r.l10n.item),a=n(r.parseTemplate(r.tpl.item,t));a.find(".sum-attributes-item-head-label > a").text(e.name||e.slug),a.find(".sum-attributes-item-head-type").text(r.types[e.type]),a.find(".sum-attributes-item-head-default").text(e.default),a.find(".sum-attributes-item-label").val(e.name),a.find(".sum-attributes-item-default").val(e.default),a.find(".sum-attributes-item-name").val(e.slug),a.find(".sum-attributes-item-desc").val(e.desc),a.find(".sum-attributes-item-options").val(e.options),a.find(".sum-attributes-item-min").val(e.min),a.find(".sum-attributes-item-max").val(e.max),a.find(".sum-attributes-item-step").val(e.step),a.find(".sum-attributes-item-type").append(r.getTypes()).val(e.type),a.attr("data-type",e.type),a.appendTo(r.el.items),r.index++,void 0!==_typeof(e.open)&&e.open&&(r.closeAll(),a.addClass("open"),a.find("input:text:first").focus())},r.closeAll=function(){r.el.items.children("div").removeClass("open")},r.getValue=function(){return JSON.parse(r.el.value.val())},r.getTypes=function(){if(""!==r.tpl.types)return r.tpl.types;return n.each(r.types,function(e,t){r.tpl.types+=r.tpl.option.replace("%value%",e).replace("%label%",t)}),r.tpl.types},r.updateValue=function(){var e=r.el.items.children("div"),l=[];e.each(function(e){var t=n(this),a=t.find("input, textarea, select"),i={};t.hasClass("deleted")||(a.each(function(){var e=n(this),t=e.data("name"),a=e.val();i[t]=a}),l.push(i))}),r.el.value.val(JSON.stringify(l)),n(document).trigger("sum/attributes/updated")},r.parseTemplate=function(e,a){return e.replace(/%(\w+)%/g,function(e,t){return void 0!==a[t]?a[t]:""})},r.toggleAttribute=function(e){e.preventDefault();var t=n(this).parents(".sum-attributes-item");t.hasClass("open")?r.closeAll():(r.closeAll(),t.addClass("open"))},r.deleteAttribute=function(e){e.preventDefault();var t=n(this).parents(".sum-attributes-item");t.removeClass("open"),t.addClass("deleted"),r.updateValue()},r.restoreAttribute=function(e){n(this).parents(".sum-attributes-item").removeClass("deleted"),r.updateValue()},r.changeLabel=function(){var e=n(this).parents(".sum-attributes-item"),t=e.find(".sum-attributes-item-head-label > a"),a=e.find(".sum-attributes-item-label").val(),i=e.find(".sum-attributes-item-name").val();""!==a?t.text(a):t.text(i)},r.changeName=function(){var e=n(this).parents(".sum-attributes-item"),t=e.find(".sum-attributes-item-head-label > a"),a=e.find(".sum-attributes-item-label").val(),i=e.find(".sum-attributes-item-name").val();""===a&&t.text(i)},r.changeType=function(e){var t=n(this).parents(".sum-attributes-item"),a=t.find(".sum-attributes-item-head-type"),i=n(this).val();a.text(r.types[i]),t.attr("data-type",i)},r.changeDefault=function(){var e=n(this).parents(".sum-attributes-item").find(".sum-attributes-item-head-default"),t=n(this).val();e.text(t)},r.validateName=function(){var e=n(this),t=e.val(),a=""===t;/^([a-z0-9_]*)$/.test(t)?e.parent("td").removeClass("sum-validation-failed"):e.parent("td").addClass("sum-validation-failed"),a?e.parent("td").addClass("sum-validation-required"):e.parent("td").removeClass("sum-validation-required")},{init:r.init}}(jQuery),ShortcodesUltimateMakerEditor.Code=function(i){var l={};return l.el={value:i("#sum-code-value"),mode:i("#sum-type"),variablesContainer:i("#sum-code-variables"),variables:i("#sum-code-variables-list"),attributes:i("#sum-attributes")},l.tpl={variable:{tag:i("#sum-code-variable-tpl").html(),html:"{{%s}}",php_echo:"$%s",php_return:"$%s"}},l.editor=null,l.isEditorEnabled="undefined"!=typeof wp&&void 0!==wp.codeEditor,l.l10n=ShortcodesUltimateMakerEditorData.l10n.Code,l.init=function(){l.initEditor(),l.updateEditorMode(),l.updateVariables(),l.bindEvents()},l.initEditor=function(){if(l.isEditorEnabled){var e=wp.codeEditor.defaultSettings?_.clone(wp.codeEditor.defaultSettings):{};e.codemirror=_.extend({},e.codemirror,{viewportMargin:1/0,mode:"php",autoCloseBrackets:!0,matchBrackets:!0,autoCloseTags:!0,matchTags:{bothTags:!0}}),l.editor=wp.codeEditor.initialize(l.el.value,e).codemirror}},l.bindEvents=function(){l.el.mode.on("change",l.updateEditorMode),l.el.mode.on("change",l.updateVariables),i(document).on("sum/attributes/updated",l.updateVariables),l.el.variables.on("click","a",l.insertVariable)},l.updateEditorMode=function(){if(l.isEditorEnabled){var e=l.el.mode.val();"html"===e&&l.editor.setOption("mode","htmlmixed"),"php_echo"!==e&&"php_return"!==e||l.editor.setOption("mode","text/x-php")}},l.updateVariables=function(){var e=l.el.attributes.find(".sum-attributes-item");l.el.variables.children("li").remove(),l.addVariable("content"),e.each(function(){var e=i(this);if(!e.hasClass("deleted")){var t=e.find('input:text[data-name="slug"]').val();""!==t&&l.addVariable(t)}})},l.addVariable=function(e){var t=l.el.mode.val(),a=i(l.tpl.variable.tag);a.children("a").text(l.tpl.variable[t].replace("%s",e)),l.el.variables.append(a)},l.insertVariable=function(e){if(e.preventDefault(),l.isEditorEnabled){var t=i(this).text(),a=l.editor.getCursor("from");l.editor.replaceSelection(t),l.editor.focus(),a=_.extend({},a,{ch:a.ch+t.length}),l.editor.setCursor(a)}},{init:l.init}}(jQuery),ShortcodesUltimateMakerEditor.CustomCss=function(e){var t={};return t.el={value:e("#sum-custom-css-value")},t.editor=null,t.isEditorEnabled="undefined"!=typeof wp&&void 0!==wp.codeEditor,t.init=function(){if(t.isEditorEnabled){var e=wp.codeEditor.defaultSettings?_.clone(wp.codeEditor.defaultSettings):{};e.codemirror=_.extend({},e.codemirror,{viewportMargin:1/0,mode:"css"}),wp.codeEditor.initialize(t.el.value,e)}},{init:t.init}}(jQuery);