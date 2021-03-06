/*
 * Inline Form Validation Engine 2.0 Beta, jQuery plugin
 * Copyright(c) 2010, Cedric Dugas, http://www.position-absolute.com *
 * 2.0 Rewrite by Olivier Refalo, http://www.crionics.com *
 * Extended by Amol Nirmala Waman, http://www.navayan.com *
 * Form validation engine allowing custom regex rules to be added.
 * Licensed under the MIT License
 */
// JavaScript Document
(function ($) {
    var methods = {
        init: function (options) {
            var form = this;
            if (form.data("jqv") === undefined || form.data("jqv") == null) {
                methods._saveOptions(form, options);
                $(".formError").live("hover", function () {
                    $(this).fadeOut(150, function () {
                        $(this).remove()
                    })
                })
            }
        },
        attach: function (userOptions) {
            var form = this;
            var options;
            if (userOptions) {
                options = methods._saveOptions(form, userOptions)
            } else {
                options = form.data("jqv")
            }
            if (!options.binded) {
                if (options.bindMethod == "bind") {
                    form.find("[class*=validate]").not("[type=checkbox]").bind(options.validationEventTrigger, methods._onFieldEvent);
                    form.find("[class*=validate][type=checkbox]").bind("click", methods._onFieldEvent);
                    form.bind("submit", methods._onSubmitEvent)
                } else {
                    if (options.bindMethod == "live") {
                        form.find("[class*=validate]").not("[type=checkbox]").live(options.validationEventTrigger, methods._onFieldEvent);
                        form.find("[class*=validate][type=checkbox]").live("click", methods._onFieldEvent);
                        form.live("submit", methods._onSubmitEvent)
                    }
                }
                options.binded = true
            }
        },
        detach: function () {
            var form = this;
            var options = form.data("jqv");
            if (options.binded) {
                form.find("[class*=validate]").not("[type=checkbox]").unbind(options.validationEventTrigger, methods._onFieldEvent);
                form.find("[class*=validate][type=checkbox]").unbind("click", methods._onFieldEvent);
                form.unbind("submit", methods.onAjaxFormComplete);
                form.find("[class*=validate]").not("[type=checkbox]").die(options.validationEventTrigger, methods._onFieldEvent);
                form.find("[class*=validate][type=checkbox]").die("click", methods._onFieldEvent);
                form.die("submit", methods.onAjaxFormComplete);
                form.removeData("jqv")
            }
        },
        validate: function () {
            return methods._validateFields(this)
        },
        validateField: function (el) {
            var options = $(this).data("jqv");
            return methods._validateField($(el), options)
        },
        validateform: function () {
            return methods._onSubmitEvent(this)
        },
        showPrompt: function (promptText, type, promptPosition, showArrow) {
            var form = this.closest("form");
            var options = form.data("jqv");
            if (!promptPosition) {
                options.promptPosition = promptPosition
            }
            options.showArrow = showArrow === true;
            methods._showPrompt(this, promptText, type, false, options)
        },
        hidePrompt: function () {
            var promptClass = "." + $(this).attr("id").replace(":", "_") + "formError";
            $(promptClass).fadeTo("fast", 0.3, function () {
                $(this).remove()
            })
        },
        hide: function () {
            var formParentalClassName = "parentForm" + $(this).attr("id");
            $("." + formParentalClassName).fadeTo("fast", 0.3, function () {
                $(this).remove()
            })
        },
        hideAll: function () {
            $(".formError").fadeTo("fast", 0.3, function () {
                $(this).remove()
            })
        },
        _onFieldEvent: function () {
            var field = $(this);
            var form = field.closest("form");
            var options = form.data("jqv");
            methods._validateField(field, options)
        },
        _onSubmitEvent: function () {
            var form = $(this);
            var r = methods._validateFields(form, true);
            var options = form.data("jqv");
            if (r && options.ajaxFormValidation) {
                methods._validateFormWithAjax(form, options);
                return false
            }
            if (options.onValidationComplete) {
                options.onValidationComplete(form, r);
                return false
            }
            return r
        },
        _checkAjaxStatus: function (options) {
            var status = true;
            $.each(options.ajaxValidCache, function (key, value) {
                if (value === false) {
                    status = false;
                    return false
                }
            });
            return status
        },
        _validateFields: function (form, skipAjaxFieldValidation) {
            var options = form.data("jqv");
            var errorFound = false;
            form.find("[class*=validate]").not(":hidden").each(function () {
                var field = $(this);
                if (!field.hasClass("ajaxed")) {
                    errorFound |= methods._validateField(field, options, skipAjaxFieldValidation)
                }
            });
            errorFound |= !methods._checkAjaxStatus(options);
            if (errorFound) {
                if (options.scroll) {
                    var destination = Number.MAX_VALUE;
                    var lst = $(".formError:not('.greenPopup')");
                    for (var i = 0; i < lst.length; i++) {
                        var d = $(lst[i]).offset().top;
                        if (d < destination) {
                            destination = d
                        }
                    }
                    if (!options.isOverflown) {
                        $("html:not(:animated),body:not(:animated)").animate({
                            scrollTop: destination
                        }, 1100)
                    } else {
                        var overflowDIV = $(options.overflownDIV);
                        var scrollContainerScroll = overflowDIV.scrollTop();
                        var scrollContainerPos = -parseInt(overflowDIV.offset().top);
                        destination += scrollContainerScroll + scrollContainerPos - 5;
                        var scrollContainer = $(options.overflownDIV + ":not(:animated)");
                        scrollContainer.animate({
                            scrollTop: destination
                        }, 1100)
                    }
                }
                return false
            }
            return true
        },
        _validateFormWithAjax: function (form, options) {
            var data = form.serialize();
            $.ajax({
                type: "GET",
                url: form.attr("action"),
                cache: false,
                dataType: "json",
                data: data,
                form: form,
                methods: methods,
                options: options,
                beforeSend: function () {
                    return options.onBeforeAjaxFormValidation(form, options)
                },
                error: function (data, transport) {
                    methods._ajaxError(data, transport)
                },
                success: function (json) {
                    if (json !== true) {
                        var errorInForm = false;
                        for (var i = 0; i < json.length; i++) {
                            var value = json[i];
                            var errorFieldId = value[0];
                            var errorField = $($("#" + errorFieldId)[0]);
                            if (errorField.length == 1) {
                                var msg = value[2];
                                if (value[1] === true) {
                                    if (msg == "") {
                                        methods._closePrompt(errorField)
                                    } else {
                                        if (options.allrules[msg]) {
                                            var txt = options.allrules[msg].alertTextOk;
                                            if (txt) {
                                                msg = txt
                                            }
                                        }
                                        methods._showPrompt(errorField, msg, "pass", false, options)
                                    }
                                } else {
                                    errorInForm |= true;
                                    if (options.allrules[msg]) {
                                        var txt = options.allrules[msg].alertText;
                                        if (txt) {
                                            msg = txt
                                        }
                                    }
                                    methods._showPrompt(errorField, msg, "", false, options)
                                }
                            }
                        }
                        options.onAjaxFormComplete(!errorInForm, form, json, options)
                    } else {
                        options.onAjaxFormComplete(true, form, "", options)
                    }
                }
            })
        },
        _validateField: function (field, options, skipAjaxFieldValidation) {
            if (!field.attr("id")) {
                $.error("jQueryValidate: an ID attribute is required for this field: " + field.attr("name") + " class:" + field.attr("class"))
            }
            var rulesParsing = field.attr("class");
            var getRules = /validate\[(.*)\]/.exec(rulesParsing);
            if (getRules === null) {
                return false
            }
            var str = getRules[1];
            var rules = str.split(/\[|,|\]/);
            var isAjaxValidator = false;
            var fieldName = field.attr("name");
            var promptText = "";
            var required = false;
            options.isError = false;
            options.showArrow = true;
            optional = false;
            for (var i = 0; i < rules.length; i++) {
                var errorMsg = undefined;
                switch (rules[i]) {
                    case "optional":
                        optional = true;
                        break;
                    case "required":
                        required = true;
                        errorMsg = methods._required(field, rules, i, options);
                        break;
                    case "custom":
                        errorMsg = methods._customRegex(field, rules, i, options);
                        break;
                    case "ajax":
                        if (!skipAjaxFieldValidation) {
                            methods._ajax(field, rules, i, options);
                            isAjaxValidator = true
                        }
                        break;
                    case "minSize":
                        errorMsg = methods._minSize(field, rules, i, options);
                        break;
                    case "maxSize":
                        errorMsg = methods._maxSize(field, rules, i, options);
                        break;
                    case "min":
                        errorMsg = methods._min(field, rules, i, options);
                        break;
                    case "max":
                        errorMsg = methods._max(field, rules, i, options);
                        break;
                    case "past":
                        errorMsg = methods._past(field, rules, i, options);
                        break;
                    case "future":
                        errorMsg = methods._future(field, rules, i, options);
                        break;
                    case "maxCheckbox":
                        errorMsg = methods._maxCheckbox(field, rules, i, options);
                        field = $($("input[name='" + fieldName + "']"));
                        break;
                    case "minCheckbox":
                        errorMsg = methods._minCheckbox(field, rules, i, options);
                        field = $($("input[name='" + fieldName + "']"));
                        break;
                    case "maxListOptions":
                        errorMsg = methods._maxListOptions(field, rules, i, options);
                        field = $($("select[name='" + fieldName + "']"));
                        break;
                    case "minListOptions":
                        errorMsg = methods._minListOptions(field, rules, i, options);
                        field = $($("select[name='" + fieldName + "']"));
                        break;
                    case "equals":
                        errorMsg = methods._equals(field, rules, i, options);
                        break;
                    case "checkDuplicate":
                        errorMsg = methods._checkDuplicate(field, rules, i, options);
                        break;
                    case "funcCall":
                        errorMsg = methods._funcCall(field, rules, i, options);
                        break;
                    default:
                }
                if (errorMsg !== undefined) {
                    promptText += errorMsg + "<br/>";
                    options.isError = true
                }
            }
            if (!required && !optional) {
                if (field.val() == "") {
                    options.isError = false
                }
            }
            var fieldType = field.attr("type");
            if ((fieldType == "radio" || fieldType == "checkbox") && $("input[name='" + fieldName + "']").size() > 1) {
                field = $($("input[name='" + fieldName + "'][type!=hidden]:first"));
                options.showArrow = false
            }
            if (!isAjaxValidator) {
                if (options.isError) {
                    methods._showPrompt(field, promptText, "", false, options)
                } else {
                    methods._closePrompt(field)
                }
            }
            return options.isError
        },
        _required: function (field, rules, i, options) {
            switch (field.attr("type")) {
                case "text":
                case "password":
                case "textarea":
                    if (!field.val()) {
                        return options.allrules[rules[i]].alertText
                    }
                    break;
                case "radio":
                case "checkbox":
                    var name = field.attr("name");
                    if ($("input[name='" + name + "']:checked").size() === 0) {
                        if ($("input[name='" + name + "']").size() === 1) {
                            return options.allrules[rules[i]].alertTextCheckboxe
                        } else {
                            return options.allrules[rules[i]].alertTextCheckboxMultiple
                        }
                    }
                    break;
                case "select-one":
                    if (!field.val()) {
                        return options.allrules[rules[i]].alertText
                    }
                    break;
                case "select-multiple":
                    if (!field.find("option:selected").val()) {
                        return options.allrules[rules[i]].alertText
                    }
                    break
            }
        },
        _customRegex: function (field, rules, i, options) {
            var customRule = rules[i + 1];
            var pattern = new RegExp(options.allrules[customRule].regex);
            if (!pattern.test(field.attr("value"))) {
                return options.allrules[customRule].alertText
            }
        },
        _funcCall: function (field, rules, i, options) {
            var functionName = rules[i + 1];
            var fn = window[functionName];
            if (typeof (fn) === "function") {
                return fn(field, rules, i, options)
            }
        },
        _equals: function (field, rules, i, options) {
            var equalsField = rules[i + 1];
            if (field.attr("value") != $("#" + equalsField).attr("value")) {
                return options.allrules.equals.alertText
            }
        },
        _maxSize: function (field, rules, i, options) {
            var max = rules[i + 1];
            var len = field.attr("value").length;
            if (len > max) {
                var rule = options.allrules.maxSize;
                return rule.alertText + max + rule.alertText2
            }
        },
        _minSize: function (field, rules, i, options) {
            var min = rules[i + 1];
            var len = field.attr("value").length;
            if (len < min) {
                var rule = options.allrules.minSize;
                return rule.alertText + min + rule.alertText2
            }
        },
        _min: function (field, rules, i, options) {
            var min = parseFloat(rules[i + 1]);
            var len = parseFloat(field.attr("value"));
            if (len < min) {
                var rule = options.allrules.min;
                if (rule.alertText2) {
                    return rule.alertText + min + rule.alertText2
                }
                return rule.alertText + min
            }
        },
        _max: function (field, rules, i, options) {
            var max = parseFloat(rules[i + 1]);
            var len = parseFloat(field.attr("value"));
            if (len > max) {
                var rule = options.allrules.max;
                if (rule.alertText2) {
                    return rule.alertText + max + rule.alertText2
                }
                return rule.alertText + max
            }
        },
        _past: function (field, rules, i, options) {
            var p = rules[i + 1];
            var pdate = (p.toLowerCase() == "now") ? new Date() : methods._parseDate(p);
            var vdate = methods._parseDate(field.attr("value"));
            if (vdate > pdate) {
                var rule = options.allrules.past;
                if (rule.alertText2) {
                    return rule.alertText + methods._dateToString(pdate) + rule.alertText2
                }
                return rule.alertText + methods._dateToString(pdate)
            }
        },
        _future: function (field, rules, i, options) {
            var p = rules[i + 1];
            var pdate = (p.toLowerCase() == "now") ? new Date() : methods._parseDate(p);
            var vdate = methods._parseDate(field.attr("value"));
            if (vdate < pdate) {
                var rule = options.allrules.future;
                if (rule.alertText2) {
                    return rule.alertText + methods._dateToString(pdate) + rule.alertText2
                }
                return rule.alertText + methods._dateToString(pdate)
            }
        },
        _maxCheckbox: function (field, rules, i, options) {
            var nbCheck = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = $("input[name='" + groupname + "']:checked").size();
            if (groupSize > nbCheck) {
                options.showArrow = false;
                return options.allrules.maxCheckbox.alertText
            }
        },
        _minCheckbox: function (field, rules, i, options) {
            var nbCheck = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = $("input[name='" + groupname + "']:checked").size();
            if (groupSize < nbCheck) {
                options.showArrow = false;
                return options.allrules.minCheckbox.alertText + " " + nbCheck + " " + options.allrules.minCheckbox.alertText2
            }
        },
        _maxListOptions: function (field, rules, i, options) {
            var listItems = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = $("select[name='" + groupname + "'] option:selected").size();
            if (groupSize > listItems) {
                var rule = options.allrules.maxListOptions;
                return rule.alertText + listItems + rule.alertText2
            }
        },
        _minListOptions: function (field, rules, i, options) {
            var listItems = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = $("select[name='" + groupname + "'] option:selected").size();
			var groupvalue = $("select[name='" + groupname + "'] option:selected").text();
			
            //if (groupSize < listItems) {
			if($.trim(groupvalue) ==""){
                var rule = options.allrules.minListOptions;
                return rule.alertText + listItems + rule.alertText2
            }
        },
        _checkDuplicate: function (field, rules, i, options) {
            var equalsField = rules[i + 1];
            if (field.attr("value") == $("#" + equalsField).attr("value")) {
                return options.allrules.checkDuplicate.alertText
            }
        },
        _ajax: function (field, rules, i, options) {
            var errorSelector = rules[i + 1];
            var rule = options.allrules[errorSelector];
            var extraData = rule.extraData;
            if (!extraData) {
                extraData = ""
            }
            if (!options.isError) {
                $.ajax({
                    type: "GET",
                    url: rule.url,
                    cache: false,
                    dataType: "json",
                    data: "fieldId=" + field.attr("id") + "&fieldValue=" + field.attr("value") + "&extraData=" + extraData,
                    field: field,
                    rule: rule,
                    methods: methods,
                    options: options,
                    beforeSend: function () {
                        var loadingText = rule.alertTextLoad;
                        if (loadingText) {
                            methods._showPrompt(field, loadingText, "load", true, options)
                        }
                    },
                    error: function (data, transport) {
                        methods._ajaxError(data, transport)
                    },
                    success: function (json) {
                        var errorFieldId = json[0];
                        var errorField = $($("#" + errorFieldId)[0]);
                        if (errorField.length == 1) {
                            var status = json[1];
                            if (status === false) {
                                options.ajaxValidCache[errorFieldId] = false;
                                options.isError = true;
                                var promptText = rule.alertText;
                                methods._showPrompt(errorField, promptText, "", true, options)
                            } else {
                                if (options.ajaxValidCache[errorFieldId] !== undefined) {
                                    options.ajaxValidCache[errorFieldId] = true
                                }
                                var alertTextOk = rule.alertTextOk;
                                if (alertTextOk) {
                                    methods._showPrompt(errorField, alertTextOk, "pass", true, options)
                                } else {
                                    methods._closePrompt(errorField)
                                }
                            }
                        }
                    }
                })
            }
        },
        _ajaxError: function (data, transport) {
            if (data.status === 0 && transport === null) {
                alert("The page is not served from a server! ajax call failed")
            } else {
                if (console) {
                    console.log("Ajax error: " + data.status + " " + transport)
                }
            }
        },
        _dateToString: function (date) {
            return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate()
        },
        _parseDate: function (d) {
            var dateParts = d.split("-");
            if (dateParts !== d) {
                dateParts = d.split("/")
            }
            return new Date(dateParts[0], (dateParts[1] - 1), dateParts[2])
        },
        _showPrompt: function (field, promptText, type, ajaxed, options) {
            var prompt = methods._getPrompt(field);
            if (prompt) {
                methods._updatePrompt(field, prompt, promptText, type, ajaxed, options)
            } else {
                methods._buildPrompt(field, promptText, type, ajaxed, options)
            }
        },
        _buildPrompt: function (field, promptText, type, ajaxed, options) {
            var prompt = $("<div>");
            prompt.addClass(field.attr("id").replace(":", "_") + "formError");
            prompt.addClass("parentForm" + field.parents("form").attr("id").replace(":", "_"));
            prompt.addClass("formError");
            switch (type) {
                case "pass":
                    prompt.addClass("greenPopup");
                    break;
                case "load":
                    prompt.addClass("blackPopup")
            }
            if (ajaxed) {
                prompt.addClass("ajaxed")
            }
            var promptContent = $("<div>").addClass("formErrorContent btn2 sml").html(promptText).appendTo(prompt);
            if (options.showArrow) {
                var arrow = $("<div>").addClass("formErrorArrow");
                switch (options.promptPosition) {
                    case "bottomLeft":
                    case "bottomRight":
                        prompt.find(".formErrorContent").before(arrow);
                        arrow.addClass("formErrorArrowBottom").html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');
                        break;
                    case "topLeft":
                    case "topRight":
                        arrow.html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');
                        prompt.append(arrow);
                        break
                }
            }
            if (options.isOverflown) {
                field.before(prompt)
            } else {
                $("body").append(prompt)
            }
            var pos = methods._calculatePosition(field, prompt, options);
            prompt.css({
                top: pos.callerTopPosition,
                left: pos.callerleftPosition,
                marginTop: pos.marginTopSize
            });
            return prompt.animate({})
        },
        _updatePrompt: function (field, prompt, promptText, type, ajaxed, options) {
            if (prompt) {
                if (type == "pass") {
                    prompt.addClass("greenPopup")
                } else {
                    prompt.removeClass("greenPopup")
                }
                if (type == "load") {
                    prompt.addClass("blackPopup")
                } else {
                    prompt.removeClass("blackPopup")
                }
                if (ajaxed) {
                    prompt.addClass("ajaxed")
                } else {
                    prompt.removeClass("ajaxed")
                }
                prompt.find(".formErrorContent").html(promptText);
                var pos = methods._calculatePosition(field, prompt, options);
                prompt.animate({
                    top: pos.callerTopPosition,
                    marginTop: pos.marginTopSize
                })
            }
        },
        _closePrompt: function (field) {
            var prompt = methods._getPrompt(field);
            if (prompt) {
                prompt.fadeTo("fast", 0, function () {
                    prompt.remove()
                })
            }
        },
        closePrompt: function (field) {
            return methods._closePrompt(field)
        },
        _getPrompt: function (field) {
            var className = "." + field.attr("id").replace(":", "_") + "formError";
            var match = $(className)[0];
            if (match) {
                return $(match)
            }
        },
        _calculatePosition: function (field, promptElmt, options) {
            var promptTopPosition, promptleftPosition, marginTopSize;
            var fieldWidth = field.width();
            var promptHeight = promptElmt.height();
            var overflow = options.isOverflown;
            if (overflow) {
                promptTopPosition = promptleftPosition = 0;
                marginTopSize = -promptHeight
            } else {
                var offset = field.offset();
                promptTopPosition = offset.top;
                promptleftPosition = offset.left;
                marginTopSize = 0
            }
            switch (options.promptPosition) {
                default:
                case "topRight":
                    if (overflow) {
                        promptleftPosition += fieldWidth - 27
                    } else {
                        promptleftPosition += fieldWidth - 27;
                        promptTopPosition += -promptHeight
                    }
                    break;
                case "topLeft":
                    promptTopPosition += -promptHeight - 10;
                    break;
                case "centerRight":
                    promptleftPosition += fieldWidth + 13;
                    break;
                case "bottomLeft":
                    promptTopPosition = promptTopPosition + field.height() + 15;
                    break;
                case "bottomRight":
                    promptleftPosition += fieldWidth - 30;
                    promptTopPosition += field.height() + 5
            }
            return {
                callerTopPosition: promptTopPosition + "px",
                callerleftPosition: promptleftPosition + "px",
                marginTopSize: marginTopSize + "px"
            }
        },
        _saveOptions: function (form, options) {
            if ($.validationEngineLanguage) {
                var allRules = $.validationEngineLanguage.allRules
            } else {
                $.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page")
            }
            var userOptions = $.extend({
                validationEventTrigger: "blur",
                scroll: true,
                promptPosition: "topRight",
                bindMethod: "bind",
                ajaxFormValidation: false,
                onAjaxFormComplete: $.noop,
                onBeforeAjaxFormValidation: $.noop,
                onValidationComplete: false,
                isOverflown: false,
                overflownDIV: "",
                allrules: allRules,
                binded: false,
                showArrow: true,
                isError: false,
                ajaxValidCache: {}
            }, options);
            form.data("jqv", userOptions);
            return userOptions
        }
    };
    $.fn.validationEngine = function (method) {
        var form = $(this);
        if (!form[0]) {
            return false
        }
        if (typeof (method) === "string" && method.charAt(0) != "_" && methods[method]) {
            methods.init.apply(form);
            return methods[method].apply(form, Array.prototype.slice.call(arguments, 1))
        } else {
            if (typeof method === "object" || !method) {
                methods.init.apply(form, arguments);
                return methods.attach.apply(form)
            } else {
                $.error("Method " + method + " does not exist in jQuery.validationEngine")
            }
        }
    }
})(jQuery);