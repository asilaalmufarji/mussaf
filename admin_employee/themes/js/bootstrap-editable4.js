/*! X-editable - v1.5.3
* In-place editing with Twitter Bootstrap, jQuery UI or pure jQuery
* http://github.com/vitalets/x-editable
* Copyright (c) 2018 Vitaliy Potapov; Licensed MIT */(function ($) {
    "use strict"; var EditableForm = function (div, options) { this.options = $.extend({}, $.fn.editableform.defaults, options); this.$div = $(div); if (!this.options.scope) { this.options.scope = this; } }; EditableForm.prototype = {
        constructor: EditableForm, initInput: function () { this.input = this.options.input; this.value = this.input.str2value(this.options.value); this.input.prerender(); }, initTemplate: function () { this.$form = $($.fn.editableform.template); }, initButtons: function () { var $btn = this.$form.find('.editable-buttons'); $btn.append($.fn.editableform.buttons); if (this.options.showbuttons === 'bottom') { $btn.addClass('editable-buttons-bottom'); } }, render: function () {
            this.$loading = $($.fn.editableform.loading); this.$div.empty().append(this.$loading); this.initTemplate(); if (this.options.showbuttons) { this.initButtons(); } else { this.$form.find('.editable-buttons').remove(); }
            this.showLoading(); this.isSaving = false; this.$div.triggerHandler('rendering'); this.initInput(); this.$form.find('div.editable-input').prepend(this.input.$tpl); this.$div.append(this.$form); $.when(this.input.render()).then($.proxy(function () {
                if (!this.options.showbuttons) { this.input.autosubmit(); }
                this.$form.find('.editable-cancel').click($.proxy(this.cancel, this)); if (this.input.error) { this.error(this.input.error); this.$form.find('.editable-submit').attr('disabled', true); this.input.$input.attr('disabled', true); this.$form.submit(function (e) { e.preventDefault(); }); } else { this.error(false); this.input.$input.removeAttr('disabled'); this.$form.find('.editable-submit').removeAttr('disabled'); var value = (this.value === null || this.value === undefined || this.value === '') ? this.options.defaultValue : this.value; this.input.value2input(value); this.$form.submit($.proxy(this.submit, this)); }
                this.$div.triggerHandler('rendered'); this.showForm(); if (this.input.postrender) { this.input.postrender(); }
            }, this));
        }, cancel: function () { this.$div.triggerHandler('cancel'); }, showLoading: function () {
            var w, h; if (this.$form) {
                w = this.$form.outerWidth(); h = this.$form.outerHeight(); if (w) { this.$loading.width(w); }
                if (h) { this.$loading.height(h); }
                this.$form.hide();
            } else { w = this.$loading.parent().width(); if (w) { this.$loading.width(w); } }
            this.$loading.show();
        }, showForm: function (activate) {
            this.$loading.hide(); this.$form.show(); if (activate !== false) { this.input.activate(); }
            this.$div.triggerHandler('show');
        }, error: function (msg) {
            var $group = this.$form.find('.control-group'), $block = this.$form.find('.editable-error-block'), lines; if (msg === false) { $group.removeClass($.fn.editableform.errorGroupClass); $block.removeClass($.fn.editableform.errorBlockClass).empty().hide(); } else {
                if (msg) {
                    lines = ('' + msg).split('\n'); for (var i = 0; i < lines.length; i++) { lines[i] = $('<div>').text(lines[i]).html(); }
                    msg = lines.join('<br>');
                }
                $group.addClass($.fn.editableform.errorGroupClass); $block.addClass($.fn.editableform.errorBlockClass).html(msg).show();
            }
        }, submit: function (e) {
            e.stopPropagation(); e.preventDefault(); var newValue = this.input.input2value(); var error = this.validate(newValue); if ($.type(error) === 'object' && error.newValue !== undefined) { newValue = error.newValue; this.input.value2input(newValue); if (typeof error.msg === 'string') { this.error(error.msg); this.showForm(); return; } } else if (error) { this.error(error); this.showForm(); return; }
            if (!this.options.savenochange && this.input.value2str(newValue) === this.input.value2str(this.value)) { this.$div.triggerHandler('nochange'); return; }
            var submitValue = this.input.value2submit(newValue); this.isSaving = true; $.when(this.save(submitValue)).done($.proxy(function (response) {
                this.isSaving = false; var res = typeof this.options.success === 'function' ? this.options.success.call(this.options.scope, response, newValue) : null; if (res === false) { this.error(false); this.showForm(false); return; }
                if (typeof res === 'string') { this.error(res); this.showForm(); return; }
                if (res && typeof res === 'object' && res.hasOwnProperty('newValue')) { newValue = res.newValue; }
                this.error(false); this.value = newValue; this.$div.triggerHandler('save', { newValue: newValue, submitValue: submitValue, response: response });
            }, this)).fail($.proxy(function (xhr) {
                this.isSaving = false; var msg; if (typeof this.options.error === 'function') { msg = this.options.error.call(this.options.scope, xhr, newValue); } else { msg = typeof xhr === 'string' ? xhr : xhr.responseText || xhr.statusText || 'Unknown error!'; }
                this.error(msg); this.showForm();
            }, this));
        }, save: function (submitValue) {
            this.options.pk = $.fn.editableutils.tryParseJson(this.options.pk, true); var pk = (typeof this.options.pk === 'function') ? this.options.pk.call(this.options.scope) : this.options.pk, send = !!(typeof this.options.url === 'function' || (this.options.url && ((this.options.send === 'always') || (this.options.send === 'auto' && pk !== null && pk !== undefined)))), params; if (send) {
                this.showLoading(); params = { name: this.options.name || '', value: submitValue, pk: pk }; if (typeof this.options.params === 'function') { params = this.options.params.call(this.options.scope, params); } else { this.options.params = $.fn.editableutils.tryParseJson(this.options.params, true); $.extend(params, this.options.params); }
                if (typeof this.options.url === 'function') { return this.options.url.call(this.options.scope, params); } else { return $.ajax($.extend({ url: this.options.url, data: params, type: 'POST' }, this.options.ajaxOptions)); }
            }
        }, validate: function (value) {
            if (value === undefined) { value = this.value; }
            if (typeof this.options.validate === 'function') { return this.options.validate.call(this.options.scope, value); }
        }, option: function (key, value) {
            if (key in this.options) { this.options[key] = value; }
            if (key === 'value') { this.setValue(value); }
        }, setValue: function (value, convertStr) {
            if (convertStr) { this.value = this.input.str2value(value); } else { this.value = value; }
            if (this.$form && this.$form.is(':visible')) { this.input.value2input(this.value); }
        }
    }; $.fn.editableform = function (option) {
        var args = arguments; return this.each(function () {
            var $this = $(this), data = $this.data('editableform'), options = typeof option === 'object' && option; if (!data) { $this.data('editableform', (data = new EditableForm(this, options))); }
            if (typeof option === 'string') { data[option].apply(data, Array.prototype.slice.call(args, 1)); }
        });
    }; $.fn.editableform.Constructor = EditableForm; $.fn.editableform.defaults = { type: 'text', url: null, params: null, name: null, pk: null, value: null, defaultValue: null, send: 'auto', validate: null, success: null, error: null, ajaxOptions: null, showbuttons: true, scope: null, savenochange: false }; $.fn.editableform.template = '<form class="form-inline editableform">' +
        '<div class="control-group">' +
        '<div><div class="editable-input"></div><div class="editable-buttons"></div></div>' +
        '<div class="editable-error-block"></div>' +
        '</div>' +
        '</form>'; $.fn.editableform.template = '<form class="form-inline editableform">' +
            '<div class="input-group editable-input">' +
            '<span class="input-group-append editable-buttons">' +
            '</span>' +
            '</div>' +
            '</form>'; $.fn.editableform.loading = '<div class="editableform-loading"></div>'; $.fn.editableform.buttons = '<button type="submit" class="editable-submit">ok</button>' +
                '<button type="button" class="editable-cancel">cancel</button>'; $.fn.editableform.errorGroupClass = null; $.fn.editableform.errorBlockClass = 'editable-error'; $.fn.editableform.engine = 'jquery';
}(window.jQuery)); (function ($) {
    "use strict"; $.fn.editableutils = {
        inherit: function (Child, Parent) { var F = function () { }; F.prototype = Parent.prototype; Child.prototype = new F(); Child.prototype.constructor = Child; Child.superclass = Parent.prototype; }, setCursorPosition: function (elem, pos) { if (elem.setSelectionRange) { try { elem.setSelectionRange(pos, pos); } catch (e) { } } else if (elem.createTextRange) { var range = elem.createTextRange(); range.collapse(true); range.moveEnd('character', pos); range.moveStart('character', pos); range.select(); } }, tryParseJson: function (s, safe) {
            if (typeof s === 'string' && s.length && s.match(/^[\{\[].*[\}\]]$/)) { if (safe) { try { s = (new Function('return ' + s))(); } catch (e) { } finally { return s; } } else { s = (new Function('return ' + s))(); } }
            return s;
        }, sliceObj: function (obj, keys, caseSensitive) {
            var key, keyLower, newObj = {}; if (!$.isArray(keys) || !keys.length) { return newObj; }
            for (var i = 0; i < keys.length; i++) {
                key = keys[i]; if (obj.hasOwnProperty(key)) { newObj[key] = obj[key]; }
                if (caseSensitive === true) { continue; }
                keyLower = key.toLowerCase(); if (obj.hasOwnProperty(keyLower)) { newObj[key] = obj[keyLower]; }
            }
            return newObj;
        }, getConfigData: function ($element) { var data = {}; $.each($element[0].dataset, function (k, v) { if (typeof v !== 'object' || (v && typeof v === 'object' && (v.constructor === Object || v.constructor === Array))) { data[k] = v; } }); return data; }, objectKeys: function (o) {
            if (Object.keys) { return Object.keys(o); } else {
                if (o !== Object(o)) { throw new TypeError('Object.keys called on a non-object'); }
                var k = [], p; for (p in o) { if (Object.prototype.hasOwnProperty.call(o, p)) { k.push(p); } }
                return k;
            }
        }, escape: function (str) { return $('<div>').text(str).html(); }, itemsByValue: function (value, sourceData, valueProp) {
            if (!sourceData || value === null) { return []; }
            if (typeof (valueProp) !== "function") { var idKey = valueProp || 'value'; valueProp = function (e) { return e[idKey]; }; }
            var isValArray = $.isArray(value), result = [], that = this; $.each(sourceData, function (i, o) { if (o.children) { result = result.concat(that.itemsByValue(value, o.children, valueProp)); } else { if (isValArray) { if ($.grep(value, function (v) { return v == (o && typeof o === 'object' ? valueProp(o) : o); }).length) { result.push(o); } } else { var itemValue = (o && (typeof o === 'object')) ? valueProp(o) : o; if (value == itemValue) { result.push(o); } } } }); return result;
        }, createInput: function (options) {
            var TypeConstructor, typeOptions, input, type = options.type; if (type === 'date') {
                if (options.mode === 'inline') { if ($.fn.editabletypes.datefield) { type = 'datefield'; } else if ($.fn.editabletypes.dateuifield) { type = 'dateuifield'; } } else { if ($.fn.editabletypes.date) { type = 'date'; } else if ($.fn.editabletypes.dateui) { type = 'dateui'; } }
                if (type === 'date' && !$.fn.editabletypes.date) { type = 'combodate'; }
            }
            if (type === 'datetime' && options.mode === 'inline') { type = 'datetimefield'; }
            if (type === 'wysihtml5' && !$.fn.editabletypes[type]) { type = 'textarea'; }
            if (typeof $.fn.editabletypes[type] === 'function') { TypeConstructor = $.fn.editabletypes[type]; typeOptions = this.sliceObj(options, this.objectKeys(TypeConstructor.defaults)); input = new TypeConstructor(typeOptions); return input; } else { $.error('Unknown type: ' + type); return false; }
        }, supportsTransitions: function () {
            var b = document.body || document.documentElement, s = b.style, p = 'transition', v = ['Moz', 'Webkit', 'Khtml', 'O', 'ms']; if (typeof s[p] === 'string') { return true; }
            p = p.charAt(0).toUpperCase() + p.substr(1); for (var i = 0; i < v.length; i++) { if (typeof s[v[i] + p] === 'string') { return true; } }
            return false;
        }
    };
}(window.jQuery)); (function ($) {
    "use strict"; var Popup = function (element, options) { this.init(element, options); }; var Inline = function (element, options) { this.init(element, options); }; Popup.prototype = {
        containerName: null, containerDataName: null, innerCss: null, containerClass: 'editable-container editable-popup', defaults: {}, init: function (element, options) {
            this.$element = $(element); this.options = $.extend({}, $.fn.editableContainer.defaults, options); this.splitOptions(); this.formOptions.scope = this.$element[0]; this.initContainer(); this.delayedHide = false; this.$element.on('destroyed', $.proxy(function () { this.destroy(); }, this)); if (!$(document).data('editable-handlers-attached')) {
                $(document).on('keyup.editable', function (e) { if (e.which === 27) { $('.editable-open').editableContainer('hide', 'cancel'); } }); $(document).on('click.editable', function (e) {
                    var $target = $(e.target), i, exclude_classes = ['.editable-container', '.ui-datepicker-header', '.datepicker', '.modal-backdrop', '.bootstrap-wysihtml5-insert-image-modal', '.bootstrap-wysihtml5-insert-link-modal']; if ($('.select2-drop-mask').is(':visible')) { return; }
                    if (!$.contains(document.documentElement, e.target)) { return; }
                    if ($target.is(document)) { return; }
                    for (i = 0; i < exclude_classes.length; i++) { if ($target.is(exclude_classes[i]) || $target.parents(exclude_classes[i]).length) { return; } }
                    Popup.prototype.closeOthers(e.target);
                }); $(document).data('editable-handlers-attached', true);
            }
        }, splitOptions: function () {
            this.containerOptions = {}; this.formOptions = {}; if (!$.fn[this.containerName]) { throw new Error(this.containerName + ' not found. Have you included corresponding js file?'); }
            for (var k in this.options) { if (k in this.defaults) { this.containerOptions[k] = this.options[k]; } else { this.formOptions[k] = this.options[k]; } }
        }, tip: function () { return this.container() ? this.container().$tip : null; }, container: function () {
            var container; if (this.containerDataName) { if (container = this.$element.data(this.containerDataName)) { return container; } }
            container = this.$element.data(this.containerName); return container;
        }, call: function () { this.$element[this.containerName].apply(this.$element, arguments); }, initContainer: function () { this.call(this.containerOptions); }, renderForm: function () { this.$form.editableform(this.formOptions).on({ save: $.proxy(this.save, this), nochange: $.proxy(function () { this.hide('nochange'); }, this), cancel: $.proxy(function () { this.hide('cancel'); }, this), show: $.proxy(function () { if (this.delayedHide) { this.hide(this.delayedHide.reason); this.delayedHide = false; } else { this.setPosition(); } }, this), rendering: $.proxy(this.setPosition, this), resize: $.proxy(this.setPosition, this), rendered: $.proxy(function () { this.$element.triggerHandler('shown', $(this.options.scope).data('editable')); }, this) }).editableform('render'); }, show: function (closeAll) {
            this.$element.addClass('editable-open'); if (closeAll !== false) { this.closeOthers(this.$element[0]); }
            this.innerShow(); this.tip().addClass(this.containerClass); if (this.$form) { }
            this.$form = $('<div>'); if (this.tip().is(this.innerCss)) { this.tip().append(this.$form); } else { this.tip().find(this.innerCss).append(this.$form); }
            this.renderForm();
        }, hide: function (reason) {
            if (!this.tip() || !this.tip().is(':visible') || !this.$element.hasClass('editable-open')) { return; }
            if (this.$form.data('editableform').isSaving) { this.delayedHide = { reason: reason }; return; } else { this.delayedHide = false; }
            this.$element.removeClass('editable-open'); this.innerHide(); this.$element.triggerHandler('hidden', reason || 'manual');
        }, innerShow: function () { }, innerHide: function () { }, toggle: function (closeAll) { if (this.container() && this.tip() && this.tip().is(':visible')) { this.hide(); } else { this.show(closeAll); } }, setPosition: function () { }, save: function (e, params) { this.$element.triggerHandler('save', params); this.hide('save'); }, option: function (key, value) { this.options[key] = value; if (key in this.containerOptions) { this.containerOptions[key] = value; this.setContainerOption(key, value); } else { this.formOptions[key] = value; if (this.$form) { this.$form.editableform('option', key, value); } } }, setContainerOption: function (key, value) { this.call('option', key, value); }, destroy: function () { this.hide(); this.innerDestroy(); this.$element.off('destroyed'); this.$element.removeData('editableContainer'); }, innerDestroy: function () { }, closeOthers: function (element) {
            $('.editable-open').each(function (i, el) {
                if (el === element || $(el).find(element).length) { return; }
                var $el = $(el), ec = $el.data('editableContainer'); if (!ec) { return; }
                if (ec.options.onblur === 'cancel') { $el.data('editableContainer').hide('onblur'); } else if (ec.options.onblur === 'submit') { $el.data('editableContainer').tip().find('form').submit(); }
            });
        }, activate: function () { if (this.tip && this.tip().is(':visible') && this.$form) { this.$form.data('editableform').input.activate(); } }
    }; $.fn.editableContainer = function (option) {
        var args = arguments; return this.each(function () {
            var $this = $(this), dataKey = 'editableContainer', data = $this.data(dataKey), options = typeof option === 'object' && option, Constructor = (options.mode === 'inline') ? Inline : Popup; if (!data) { $this.data(dataKey, (data = new Constructor(this, options))); }
            if (typeof option === 'string') { data[option].apply(data, Array.prototype.slice.call(args, 1)); }
        });
    }; $.fn.editableContainer.Popup = Popup; $.fn.editableContainer.Inline = Inline; $.fn.editableContainer.defaults = { value: null, placement: 'top', autohide: true, onblur: 'cancel', anim: false, mode: 'popup' }; jQuery.event.special.destroyed = { remove: function (o) { if (o.handler) { o.handler(); } } };
}(window.jQuery)); (function ($) { "use strict"; $.extend($.fn.editableContainer.Inline.prototype, $.fn.editableContainer.Popup.prototype, { containerName: 'editableform', innerCss: '.editable-inline', containerClass: 'editable-container editable-inline', initContainer: function () { this.$tip = $('<span></span>'); if (!this.options.anim) { this.options.anim = 0; } }, splitOptions: function () { this.containerOptions = {}; this.formOptions = this.options; }, tip: function () { return this.$tip; }, innerShow: function () { this.$element.hide(); this.tip().insertAfter(this.$element).show(); }, innerHide: function () { this.$tip.hide(this.options.anim, $.proxy(function () { this.$element.show(); this.innerDestroy(); }, this)); }, innerDestroy: function () { if (this.tip()) { this.tip().empty().remove(); } } }); }(window.jQuery)); (function ($) {
    "use strict"; var Editable = function (element, options) {
        this.$element = $(element); this.options = $.extend({}, $.fn.editable.defaults, options, $.fn.editableutils.getConfigData(this.$element)); if (this.options.selector) { this.initLive(); } else { this.init(); }
        if (this.options.highlight && !$.fn.editableutils.supportsTransitions()) { this.options.highlight = false; }
    }; Editable.prototype = {
        constructor: Editable, init: function () {
            var isValueByText = false, doAutotext, finalize; this.options.name = this.options.name || this.$element.attr('id'); this.options.scope = this.$element[0]; this.input = $.fn.editableutils.createInput(this.options); if (!this.input) { return; }
            if (this.options.value === undefined || this.options.value === null) { this.value = this.input.html2value($.trim(this.$element.html())); isValueByText = true; } else { this.options.value = $.fn.editableutils.tryParseJson(this.options.value, true); if (typeof this.options.value === 'string') { this.value = this.input.str2value(this.options.value); } else { this.value = this.options.value; } }
            this.$element.addClass('editable'); if (this.input.type === 'textarea') { this.$element.addClass('editable-pre-wrapped'); }
            if (this.options.toggle !== 'manual') {
                this.$element.addClass('editable-click'); this.$element.on(this.options.toggle + '.editable', $.proxy(function (e) {
                    if (!this.options.disabled) { e.preventDefault(); }
                    if (this.options.toggle === 'mouseenter') { this.show(); } else { var closeAll = (this.options.toggle !== 'click'); this.toggle(closeAll); }
                }, this));
            } else { this.$element.attr('tabindex', -1); }
            if (typeof this.options.display === 'function') { this.options.autotext = 'always'; }
            switch (this.options.autotext) { case 'always': doAutotext = true; break; case 'auto': doAutotext = !$.trim(this.$element.text()).length && this.value !== null && this.value !== undefined && !isValueByText; break; default: doAutotext = false; }
            $.when(doAutotext ? this.render() : true).then($.proxy(function () {
                if (this.options.disabled) { this.disable(); } else { this.enable(); }
                this.$element.triggerHandler('init', this);
            }, this));
        }, initLive: function () {
            var selector = this.options.selector; this.options.selector = false; this.options.autotext = 'never'; this.$element.on(this.options.toggle + '.editable', selector, $.proxy(function (e) {
                var $target = $(e.target).closest(selector); if (!$target.data('editable')) {
                    if ($target.hasClass(this.options.emptyclass)) { $target.empty(); }
                    $target.editable(this.options).trigger(e);
                }
            }, this));
        }, render: function (response) {
            if (this.options.display === false) { return; }
            if (this.input.value2htmlFinal) { return this.input.value2html(this.value, this.$element[0], this.options.display, response); } else if (typeof this.options.display === 'function') { return this.options.display.call(this.$element[0], this.value, response); } else { return this.input.value2html(this.value, this.$element[0]); }
        }, enable: function () { this.options.disabled = false; this.$element.removeClass('editable-disabled'); this.handleEmpty(this.isEmpty); if (this.options.toggle !== 'manual') { if (this.$element.attr('tabindex') === '-1') { this.$element.removeAttr('tabindex'); } } }, disable: function () { this.options.disabled = true; this.hide(); this.$element.addClass('editable-disabled'); this.handleEmpty(this.isEmpty); this.$element.attr('tabindex', -1); }, toggleDisabled: function () { if (this.options.disabled) { this.enable(); } else { this.disable(); } }, option: function (key, value) {
            if (key && typeof key === 'object') { $.each(key, $.proxy(function (k, v) { this.option($.trim(k), v); }, this)); return; }
            this.options[key] = value; if (key === 'disabled') { return value ? this.disable() : this.enable(); }
            if (key === 'value') { this.setValue(value); }
            if (this.container) { this.container.option(key, value); }
            if (this.input.option) { this.input.option(key, value); }
        }, handleEmpty: function (isEmpty) {
            if (this.options.display === false) { return; }
            if (isEmpty !== undefined) { this.isEmpty = isEmpty; } else { if (typeof (this.input.isEmpty) === 'function') { this.isEmpty = this.input.isEmpty(this.$element); } else { this.isEmpty = $.trim(this.$element.html()) === ''; } }
            if (!this.options.disabled) { if (this.isEmpty) { this.$element.html(this.options.emptytext); if (this.options.emptyclass) { this.$element.addClass(this.options.emptyclass); } } else if (this.options.emptyclass) { this.$element.removeClass(this.options.emptyclass); } } else { if (this.isEmpty) { this.$element.empty(); if (this.options.emptyclass) { this.$element.removeClass(this.options.emptyclass); } } }
        }, show: function (closeAll) {
            if (this.options.disabled) { return; }
            if (!this.container) { var containerOptions = $.extend({}, this.options, { value: this.value, input: this.input }); this.$element.editableContainer(containerOptions); this.$element.on("save.internal", $.proxy(this.save, this)); this.container = this.$element.data('editableContainer'); } else if (this.container.tip().is(':visible')) { return; }
            this.container.show(closeAll);
        }, hide: function () { if (this.container) { this.container.hide(); } }, toggle: function (closeAll) { if (this.container && this.container.tip().is(':visible')) { this.hide(); } else { this.show(closeAll); } }, save: function (e, params) {
            if (this.options.unsavedclass) { var sent = false; sent = sent || typeof this.options.url === 'function'; sent = sent || this.options.display === false; sent = sent || params.response !== undefined; sent = sent || (this.options.savenochange && this.input.value2str(this.value) !== this.input.value2str(params.newValue)); if (sent) { this.$element.removeClass(this.options.unsavedclass); } else { this.$element.addClass(this.options.unsavedclass); } }
            if (this.options.highlight) {
                var $e = this.$element, bgColor = $e.css('background-color'); $e.css('background-color', this.options.highlight); setTimeout(function () {
                    if (bgColor === 'transparent') { bgColor = ''; }
                    $e.css('background-color', bgColor); $e.addClass('editable-bg-transition'); $e.addClass('bg-transparent'); setTimeout(function () { $e.removeClass('editable-bg-transition'); $e.removeClass('bg-transparent'); }, 1700);
                }, 10);
            }
            this.setValue(params.newValue, false, params.response);
        }, validate: function () { if (typeof this.options.validate === 'function') { return this.options.validate.call(this, this.value); } }, setValue: function (value, convertStr, response) {
            if (convertStr) { this.value = this.input.str2value(value); } else { this.value = value; }
            if (this.container) { this.container.option('value', this.value); }
            $.when(this.render(response)).then($.proxy(function () { this.handleEmpty(); }, this));
        }, activate: function () { if (this.container) { this.container.activate(); } }, destroy: function () {
            this.disable(); if (this.container) { this.container.destroy(); }
            this.input.destroy(); if (this.options.toggle !== 'manual') { this.$element.removeClass('editable-click'); this.$element.off(this.options.toggle + '.editable'); }
            this.$element.off("save.internal"); this.$element.removeClass('editable editable-open editable-disabled'); this.$element.removeData('editable');
        }
    }; $.fn.editable = function (option) {
        var result = {}, args = arguments, datakey = 'editable'; switch (option) {
            case 'validate': this.each(function () { var $this = $(this), data = $this.data(datakey), error; if (data && (error = data.validate())) { result[data.options.name] = error; } }); return result; case 'getValue': if (arguments.length === 2 && arguments[1] === true) { result = this.eq(0).data(datakey).value; } else { this.each(function () { var $this = $(this), data = $this.data(datakey); if (data && data.value !== undefined && data.value !== null) { result[data.options.name] = data.input.value2submit(data.value); } }); }
                return result; case 'submit': var config = arguments[1] || {}, $elems = this, errors = this.editable('validate'); if ($.isEmptyObject(errors)) {
                    var ajaxOptions = {}; if ($elems.length === 1) {
                        var editable = $elems.data('editable'); var params = { name: editable.options.name || '', value: editable.input.value2submit(editable.value), pk: (typeof editable.options.pk === 'function') ? editable.options.pk.call(editable.options.scope) : editable.options.pk }; if (typeof editable.options.params === 'function') { params = editable.options.params.call(editable.options.scope, params); } else { editable.options.params = $.fn.editableutils.tryParseJson(editable.options.params, true); $.extend(params, editable.options.params); }
                        ajaxOptions = { url: editable.options.url, data: params, type: 'POST' }; config.success = config.success || editable.options.success; config.error = config.error || editable.options.error;
                    } else { var values = this.editable('getValue'); ajaxOptions = { url: config.url, data: values, type: 'POST' }; }
                    ajaxOptions.success = typeof config.success === 'function' ? function (response) { config.success.call($elems, response, config); } : $.noop; ajaxOptions.error = typeof config.error === 'function' ? function () { config.error.apply($elems, arguments); } : $.noop; if (config.ajaxOptions) { $.extend(ajaxOptions, config.ajaxOptions); }
                    if (config.data) { $.extend(ajaxOptions.data, config.data); }
                    $.ajax(ajaxOptions);
                } else { if (typeof config.error === 'function') { config.error.call($elems, errors); } }
                return this;
        }
        return this.each(function () {
            var $this = $(this), data = $this.data(datakey), options = typeof option === 'object' && option; if (options && options.selector) { data = new Editable(this, options); return; }
            if (!data) { $this.data(datakey, (data = new Editable(this, options))); }
            if (typeof option === 'string') { data[option].apply(data, Array.prototype.slice.call(args, 1)); }
        });
    }; $.fn.editable.defaults = { type: 'text', disabled: false, toggle: 'click', emptytext: 'Empty', autotext: 'auto', value: null, display: null, emptyclass: 'editable-empty', unsavedclass: 'editable-unsaved', selector: null, highlight: '#FFFF80' };
}(window.jQuery)); (function ($) { "use strict"; $.fn.editabletypes = {}; var AbstractInput = function () { }; AbstractInput.prototype = { init: function (type, options, defaults) { this.type = type; this.options = $.extend({}, defaults, options); }, prerender: function () { this.$tpl = $(this.options.tpl); this.$input = this.$tpl; this.$clear = null; this.error = null; }, render: function () { }, value2html: function (value, element) { $(element)[this.options.escape ? 'text' : 'html']($.trim(value)); }, html2value: function (html) { return $('<div>').html(html).text(); }, value2str: function (value) { return String(value); }, str2value: function (str) { return str; }, value2submit: function (value) { return value; }, value2input: function (value) { this.$input.val(value); }, input2value: function () { return this.$input.val(); }, activate: function () { if (this.$input.is(':visible')) { this.$input.focus(); } }, clear: function () { this.$input.val(null); }, escape: function (str) { return $('<div>').text(str).html(); }, autosubmit: function () { }, destroy: function () { }, setClass: function () { if (this.options.inputclass) { this.$input.addClass(this.options.inputclass); } }, setAttr: function (attr) { if (this.options[attr] !== undefined && this.options[attr] !== null) { this.$input.attr(attr, this.options[attr]); } }, option: function (key, value) { this.options[key] = value; } }; AbstractInput.defaults = { tpl: '', inputclass: null, escape: true, scope: null, showbuttons: true }; $.extend($.fn.editabletypes, { abstractinput: AbstractInput }); }(window.jQuery)); (function ($) {
    "use strict"; var List = function (options) { }; $.fn.editableutils.inherit(List, $.fn.editabletypes.abstractinput); $.extend(List.prototype, {
        render: function () { var deferred = $.Deferred(); this.error = null; this.onSourceReady(function () { this.renderList(); deferred.resolve(); }, function () { this.error = this.options.sourceError; deferred.resolve(); }); return deferred.promise(); }, html2value: function (html) { return null; }, value2html: function (value, element, display, response) {
            var deferred = $.Deferred(), success = function () {
                if (typeof display === 'function') { display.call(element, value, this.sourceData, response); } else { this.value2htmlFinal(value, element); }
                deferred.resolve();
            }; if (value === null) { success.call(this); } else { this.onSourceReady(success, function () { deferred.resolve(); }); }
            return deferred.promise();
        }, onSourceReady: function (success, error) {
            var source; if ($.isFunction(this.options.source)) { source = this.options.source.call(this.options.scope); this.sourceData = null; } else { source = this.options.source; }
            if (this.options.sourceCache && $.isArray(this.sourceData)) { success.call(this); return; }
            try { source = $.fn.editableutils.tryParseJson(source, false); } catch (e) { error.call(this); return; }
            if (typeof source === 'string') {
                if (this.options.sourceCache) {
                    var cacheID = source, cache; if (!$(document).data(cacheID)) { $(document).data(cacheID, {}); }
                    cache = $(document).data(cacheID); if (cache.loading === false && cache.sourceData) { this.sourceData = cache.sourceData; this.doPrepend(); success.call(this); return; } else if (cache.loading === true) { cache.callbacks.push($.proxy(function () { this.sourceData = cache.sourceData; this.doPrepend(); success.call(this); }, this)); cache.err_callbacks.push($.proxy(error, this)); return; } else { cache.loading = true; cache.callbacks = []; cache.err_callbacks = []; }
                }
                var ajaxOptions = $.extend({
                    url: source, type: 'get', cache: false, dataType: 'json', success: $.proxy(function (data) {
                        if (cache) { cache.loading = false; }
                        this.sourceData = this.makeArray(data); if ($.isArray(this.sourceData)) {
                            if (cache) { cache.sourceData = this.sourceData; $.each(cache.callbacks, function () { this.call(); }); }
                            this.doPrepend(); success.call(this);
                        } else { error.call(this); if (cache) { $.each(cache.err_callbacks, function () { this.call(); }); } }
                    }, this), error: $.proxy(function () { error.call(this); if (cache) { cache.loading = false; $.each(cache.err_callbacks, function () { this.call(); }); } }, this)
                }, this.options.sourceOptions); $.ajax(ajaxOptions);
            } else { this.sourceData = this.makeArray(source); if ($.isArray(this.sourceData)) { this.doPrepend(); success.call(this); } else { error.call(this); } }
        }, doPrepend: function () {
            if (this.options.prepend === null || this.options.prepend === undefined) { return; }
            if (!$.isArray(this.prependData)) {
                if ($.isFunction(this.options.prepend)) { this.options.prepend = this.options.prepend.call(this.options.scope); }
                this.options.prepend = $.fn.editableutils.tryParseJson(this.options.prepend, true); if (typeof this.options.prepend === 'string') { this.options.prepend = { '': this.options.prepend }; }
                this.prependData = this.makeArray(this.options.prepend);
            }
            if ($.isArray(this.prependData) && $.isArray(this.sourceData)) { this.sourceData = this.prependData.concat(this.sourceData); }
        }, renderList: function () { }, value2htmlFinal: function (value, element) { }, makeArray: function (data) {
            var count, obj, result = [], item, iterateItem; if (!data || typeof data === 'string') { return null; }
            if ($.isArray(data)) {
                iterateItem = function (k, v) { obj = { value: k, text: v }; if (count++ >= 2) { return false; } }; for (var i = 0; i < data.length; i++) {
                    item = data[i]; if (typeof item === 'object') {
                        count = 0; $.each(item, iterateItem); if (count === 1) { result.push(obj); } else if (count > 1) {
                            if (item.children) { item.children = this.makeArray(item.children); }
                            result.push(item);
                        }
                    } else { result.push({ value: item, text: item }); }
                }
            } else { $.each(data, function (k, v) { result.push({ value: k, text: v }); }); }
            return result;
        }, option: function (key, value) {
            this.options[key] = value; if (key === 'source') { this.sourceData = null; }
            if (key === 'prepend') { this.prependData = null; }
        }
    }); List.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { source: null, prepend: false, sourceError: 'Error when loading list', sourceCache: true, sourceOptions: null }); $.fn.editabletypes.list = List;
}(window.jQuery)); (function ($) {
    "use strict"; var Text = function (options) { this.init('text', options, Text.defaults); }; $.fn.editableutils.inherit(Text, $.fn.editabletypes.abstractinput); $.extend(Text.prototype, {
        render: function () { this.renderClear(); this.setClass(); this.setAttr('placeholder'); }, activate: function () {
            if (this.$input.is(':visible')) {
                var inp = this.$input; setTimeout(function () { inp.focus(); }, 100); if (this.$input.is('input,textarea') && !this.$input.is('[type="checkbox"],[type="range"]')) { $.fn.editableutils.setCursorPosition(this.$input.get(0), this.$input.val().length); }
                if (this.toggleClear) { this.toggleClear(); }
            }
        }, renderClear: function () {
            if (this.options.clear) {
                this.$clear = $('<span class="editable-clear-x"></span>'); this.$input.after(this.$clear).css('padding-right', 24).keyup($.proxy(function (e) {
                    if (~$.inArray(e.keyCode, [40, 38, 9, 13, 27])) { return; }
                    clearTimeout(this.t); var that = this; this.t = setTimeout(function () { that.toggleClear(e); }, 100);
                }, this)).parent().css('position', 'relative'); this.$clear.click($.proxy(this.clear, this));
            }
        }, postrender: function () { }, toggleClear: function (e) {
            if (!this.$clear) { return; }
            var len = this.$input.val().length, visible = this.$clear.is(':visible'); if (len && !visible) { this.$clear.show(); }
            if (!len && visible) { this.$clear.hide(); }
        }, clear: function () { this.$clear.hide(); this.$input.val('').focus(); }
    }); Text.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<input type="text">', placeholder: null, clear: true }); $.fn.editabletypes.text = Text;
}(window.jQuery)); (function ($) { "use strict"; var Textarea = function (options) { this.init('textarea', options, Textarea.defaults); }; $.fn.editableutils.inherit(Textarea, $.fn.editabletypes.abstractinput); $.extend(Textarea.prototype, { render: function () { this.setClass(); this.setAttr('placeholder'); this.setAttr('rows'); this.$input.keydown(function (e) { if (e.ctrlKey && e.which === 13) { $(this).closest('form').submit(); } }); }, activate: function () { $.fn.editabletypes.text.prototype.activate.call(this); } }); Textarea.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<textarea></textarea>', inputclass: 'input-large', placeholder: null, rows: 7 }); $.fn.editabletypes.textarea = Textarea; }(window.jQuery)); (function ($) {
    "use strict"; var Select = function (options) { this.init('select', options, Select.defaults); }; $.fn.editableutils.inherit(Select, $.fn.editabletypes.list); $.extend(Select.prototype, {
        renderList: function () {
            this.$input.empty(); var escape = this.options.escape; var fillItems = function ($el, data) {
                var attr; if ($.isArray(data)) {
                    for (var i = 0; i < data.length; i++) {
                        attr = {}; if (data[i].children) { attr.label = data[i].text; $el.append(fillItems($('<optgroup>', attr), data[i].children)); } else {
                            attr.value = data[i].value; if (data[i].disabled) { attr.disabled = true; }
                            var $option = $('<option>', attr); $option[escape ? 'text' : 'html'](data[i].text); $el.append($option);
                        }
                    }
                }
                return $el;
            }; fillItems(this.$input, this.sourceData); this.setClass(); this.$input.on('keydown.editable', function (e) { if (e.which === 13) { $(this).closest('form').submit(); } });
        }, value2htmlFinal: function (value, element) {
            var text = '', items = $.fn.editableutils.itemsByValue(value, this.sourceData); if (items.length) { text = items[0].text; }
            $.fn.editabletypes.abstractinput.prototype.value2html.call(this, text, element);
        }, autosubmit: function () { this.$input.off('keydown.editable').on('change.editable', function () { $(this).closest('form').submit(); }); }
    }); Select.defaults = $.extend({}, $.fn.editabletypes.list.defaults, { tpl: '<select></select>' }); $.fn.editabletypes.select = Select;
}(window.jQuery)); (function ($) {
    "use strict"; var Checklist = function (options) { this.init('checklist', options, Checklist.defaults); }; $.fn.editableutils.inherit(Checklist, $.fn.editabletypes.list); $.extend(Checklist.prototype, {
        renderList: function () {
            var $label, $div; this.$tpl.empty(); if (!$.isArray(this.sourceData)) { return; }
            for (var i = 0; i < this.sourceData.length; i++) { $label = $('<label>').append($('<input>', { type: 'checkbox', value: this.sourceData[i].value })); var $option = $('<span>'); $option[this.options.escape ? 'text' : 'html'](' ' + this.sourceData[i].text); $label.append($option); $('<div>').append($label).appendTo(this.$tpl); }
            this.$input = this.$tpl.find('input[type="checkbox"]'); this.setClass();
        }, value2str: function (value) { return $.isArray(value) ? value.sort().join($.trim(this.options.separator)) : ''; }, str2value: function (str) {
            var reg, value = null; if (typeof str === 'string' && str.length) { reg = new RegExp('\\s*' + $.trim(this.options.separator) + '\\s*'); value = str.split(reg); } else if ($.isArray(str)) { value = str; } else { value = [str]; }
            return value;
        }, value2input: function (value) { this.$input.prop('checked', false); if ($.isArray(value) && value.length) { this.$input.each(function (i, el) { var $el = $(el); $.each(value, function (j, val) { if ($el.val() == val) { $el.prop('checked', true); } }); }); } }, input2value: function () { var checked = []; this.$input.filter(':checked').each(function (i, el) { checked.push($(el).val()); }); return checked; }, value2htmlFinal: function (value, element) { var html = [], checked = $.fn.editableutils.itemsByValue(value, this.sourceData), escape = this.options.escape; if (checked.length) { $.each(checked, function (i, v) { var text = escape ? $.fn.editableutils.escape(v.text) : v.text; html.push(text); }); $(element).html(html.join('<br>')); } else { $(element).empty(); } }, activate: function () { this.$input.first().focus(); }, autosubmit: function () { this.$input.on('keydown', function (e) { if (e.which === 13) { $(this).closest('form').submit(); } }); }
    }); Checklist.defaults = $.extend({}, $.fn.editabletypes.list.defaults, { tpl: '<div class="editable-checklist"></div>', inputclass: null, separator: ',' }); $.fn.editabletypes.checklist = Checklist;
}(window.jQuery)); (function ($) { "use strict"; var Password = function (options) { this.init('password', options, Password.defaults); }; $.fn.editableutils.inherit(Password, $.fn.editabletypes.text); $.extend(Password.prototype, { value2html: function (value, element) { if (value) { $(element).text('[hidden]'); } else { $(element).empty(); } }, html2value: function (html) { return null; } }); Password.defaults = $.extend({}, $.fn.editabletypes.text.defaults, { tpl: '<input type="password">' }); $.fn.editabletypes.password = Password; }(window.jQuery)); (function ($) { "use strict"; var Email = function (options) { this.init('email', options, Email.defaults); }; $.fn.editableutils.inherit(Email, $.fn.editabletypes.text); Email.defaults = $.extend({}, $.fn.editabletypes.text.defaults, { tpl: '<input type="email">' }); $.fn.editabletypes.email = Email; }(window.jQuery)); (function ($) { "use strict"; var Url = function (options) { this.init('url', options, Url.defaults); }; $.fn.editableutils.inherit(Url, $.fn.editabletypes.text); Url.defaults = $.extend({}, $.fn.editabletypes.text.defaults, { tpl: '<input type="url">' }); $.fn.editabletypes.url = Url; }(window.jQuery)); (function ($) { "use strict"; var Tel = function (options) { this.init('tel', options, Tel.defaults); }; $.fn.editableutils.inherit(Tel, $.fn.editabletypes.text); Tel.defaults = $.extend({}, $.fn.editabletypes.text.defaults, { tpl: '<input type="tel">' }); $.fn.editabletypes.tel = Tel; }(window.jQuery)); (function ($) { "use strict"; var NumberInput = function (options) { this.init('number', options, NumberInput.defaults); }; $.fn.editableutils.inherit(NumberInput, $.fn.editabletypes.text); $.extend(NumberInput.prototype, { render: function () { NumberInput.superclass.render.call(this); this.setAttr('min'); this.setAttr('max'); this.setAttr('step'); }, postrender: function () { if (this.$clear) { this.$clear.css({ right: 24 }); } } }); NumberInput.defaults = $.extend({}, $.fn.editabletypes.text.defaults, { tpl: '<input type="number">', inputclass: 'input-mini', min: null, max: null, step: null }); $.fn.editabletypes.number = NumberInput; }(window.jQuery)); (function ($) { "use strict"; var Range = function (options) { this.init('range', options, Range.defaults); }; $.fn.editableutils.inherit(Range, $.fn.editabletypes.number); $.extend(Range.prototype, { render: function () { this.$input = this.$tpl.filter('input'); this.setClass(); this.setAttr('min'); this.setAttr('max'); this.setAttr('step'); this.$input.on('input', function () { $(this).siblings('output').text($(this).val()); }); }, activate: function () { this.$input.focus(); } }); Range.defaults = $.extend({}, $.fn.editabletypes.number.defaults, { tpl: '<input type="range"><output style="width: 30px; display: inline-block"></output>', inputclass: 'input-medium' }); $.fn.editabletypes.range = Range; }(window.jQuery)); (function ($) { "use strict"; var Time = function (options) { this.init('time', options, Time.defaults); }; $.fn.editableutils.inherit(Time, $.fn.editabletypes.abstractinput); $.extend(Time.prototype, { render: function () { this.setClass(); } }); Time.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<input type="time">' }); $.fn.editabletypes.time = Time; }(window.jQuery)); (function ($) {
    "use strict"; var Constructor = function (options) {
        this.init('select2', options, Constructor.defaults); options.select2 = options.select2 || {}; this.sourceData = null; if (options.placeholder) { options.select2.placeholder = options.placeholder; }
        if (!options.select2.tags && options.source) {
            var source = options.source; if ($.isFunction(options.source)) { source = options.source.call(options.scope); }
            if (typeof source === 'string') {
                options.select2.ajax = options.select2.ajax || {}; if (!options.select2.ajax.data) { options.select2.ajax.data = function (term) { return { query: term }; }; }
                if (!options.select2.ajax.results) { options.select2.ajax.results = function (data) { return { results: data }; }; }
                options.select2.ajax.url = source;
            } else { this.sourceData = this.convertSource(source); options.select2.data = this.sourceData; }
        }
        this.options.select2 = $.extend({}, Constructor.defaults.select2, options.select2); this.isMultiple = this.options.select2.tags || this.options.select2.multiple; this.isRemote = ('ajax' in this.options.select2); this.idFunc = this.options.select2.id; if (typeof (this.idFunc) !== "function") { var idKey = this.idFunc || 'id'; this.idFunc = function (e) { return e[idKey]; }; }
        this.formatSelection = this.options.select2.formatSelection; if (typeof (this.formatSelection) !== "function") { this.formatSelection = function (e) { return e.text; }; }
    }; $.fn.editableutils.inherit(Constructor, $.fn.editabletypes.abstractinput); $.extend(Constructor.prototype, {
        render: function () {
            this.setClass(); if (this.isRemote) { this.$input.on('select2-loaded', $.proxy(function (e) { this.sourceData = e.items.results; }, this)); }
            if (this.isMultiple) { this.$input.on('change', function () { $(this).closest('form').parent().triggerHandler('resize'); }); }
        }, value2html: function (value, element) {
            var text = '', data, that = this; if (this.options.select2.tags) { data = value; } else if (this.sourceData) { data = $.fn.editableutils.itemsByValue(value, this.sourceData, this.idFunc); } else { }
            if ($.isArray(data)) { text = []; $.each(data, function (k, v) { text.push(v && typeof v === 'object' ? that.formatSelection(v) : v); }); } else if (data) { text = that.formatSelection(data); }
            text = $.isArray(text) ? text.join(this.options.viewseparator) : text; Constructor.superclass.value2html.call(this, text, element);
        }, html2value: function (html) { return this.options.select2.tags ? this.str2value(html, this.options.viewseparator) : null; }, value2input: function (value) {
            if ($.isArray(value)) { value = value.join(this.getSeparator()); }
            if (!this.$input.data('select2')) { this.$input.val(value); this.$input.select2(this.options.select2); } else { this.$input.val(value).trigger('change', true); }
            if (this.isRemote && !this.isMultiple && !this.options.select2.initSelection) { var customId = this.options.select2.id, customText = this.options.select2.formatSelection; if (!customId && !customText) { var $el = $(this.options.scope); if (!$el.data('editable').isEmpty) { var data = { id: value, text: $el.text() }; this.$input.select2('data', data); } } }
        }, input2value: function () { return this.$input.select2('val'); }, str2value: function (str, separator) {
            if (typeof str !== 'string' || !this.isMultiple) { return str; }
            separator = separator || this.getSeparator(); var val, i, l; if (str === null || str.length < 1) { return null; }
            val = str.split(separator); for (i = 0, l = val.length; i < l; i = i + 1) { val[i] = $.trim(val[i]); }
            return val;
        }, autosubmit: function () { this.$input.on('change', function (e, isInitial) { if (!isInitial) { $(this).closest('form').submit(); } }); }, getSeparator: function () { return this.options.select2.separator || $.fn.select2.defaults.separator; }, convertSource: function (source) {
            if ($.isArray(source) && source.length && source[0].value !== undefined) { for (var i = 0; i < source.length; i++) { if (source[i].value !== undefined) { source[i].id = source[i].value; delete source[i].value; } } }
            return source;
        }, activate: function () { this.$input.select2('open'); }, destroy: function () { if (this.$input) { if (this.$input.data('select2')) { this.$input.select2('destroy'); } } }
    }); Constructor.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<input type="hidden">', select2: null, placeholder: null, source: null, viewseparator: ', ' }); $.fn.editabletypes.select2 = Constructor;
}(window.jQuery)); (function ($) {
    var Combodate = function (element, options) {
        this.$element = $(element); if (!this.$element.is('input')) { $.error('Combodate should be applied to INPUT element'); return; }
        this.options = $.extend({}, $.fn.combodate.defaults, options, this.$element.data()); this.init();
    }; Combodate.prototype = {
        constructor: Combodate, init: function () { this.map = { day: ['D', 'date'], month: ['M', 'month'], year: ['Y', 'year'], hour: ['[Hh]', 'hours'], minute: ['m', 'minutes'], second: ['s', 'seconds'], ampm: ['[Aa]', ''] }; this.$widget = $('<span class="combodate"></span>').html(this.getTemplate()); this.initCombos(); this.datetime = null; this.$widget.on('change', 'select', $.proxy(function (e) { this.$element.val(this.getValue()).change(); if (this.options.smartDays) { if ($(e.target).is('.month') || $(e.target).is('.year')) { this.fillCombo('day'); } } }, this)); this.$widget.find('select').css('width', 'auto'); this.$element.hide().after(this.$widget); this.setValue(this.$element.val() || this.options.value); }, getTemplate: function () {
            var tpl = this.options.template; var inputDisabled = this.$element.prop('disabled'); var customClass = this.options.customClass; $.each(this.map, function (k, v) { v = v[0]; var r = new RegExp(v + '+'), token = v.length > 1 ? v.substring(1, 2) : v; tpl = tpl.replace(r, '{' + token + '}'); }); tpl = tpl.replace(/ /g, '&nbsp;'); $.each(this.map, function (k, v) {
                v = v[0]; var token = v.length > 1 ? v.substring(1, 2) : v; tpl = tpl.replace('{' + token + '}', '<select class="' + k + ' ' + customClass + '"' +
                    (inputDisabled ? ' disabled="disabled"' : '') + '></select>');
            }); return tpl;
        }, initCombos: function () { for (var k in this.map) { var $c = this.$widget.find('.' + k); this['$' + k] = $c.length ? $c : null; this.fillCombo(k); } }, fillCombo: function (k) {
            var $combo = this['$' + k]; if (!$combo) { return; }
            var f = 'fill' + k.charAt(0).toUpperCase() + k.slice(1); var items = this[f](); var value = $combo.val(); $combo.empty(); for (var i = 0; i < items.length; i++) { $combo.append('<option value="' + items[i][0] + '">' + items[i][1] + '</option>'); }
            $combo.val(value);
        }, fillCommon: function (key) {
            var values = [], relTime; if (this.options.firstItem === 'name') {
                if (moment.localeData) { relTime = moment.localeData()._relativeTime; } else { relTime = moment.relativeTime || moment.langData()._relativeTime; }
                var header = typeof relTime[key] === 'function' ? relTime[key](1, true, key, false) : relTime[key]; header = header.split(' ').reverse()[0]; values.push(['', header]);
            } else if (this.options.firstItem === 'empty') { values.push(['', '']); }
            return values;
        }, fillDay: function () {
            var items = this.fillCommon('d'), name, i, twoDigit = this.options.template.indexOf('DD') !== -1, daysCount = 31; if (this.options.smartDays && this.$month && this.$year) { var month = parseInt(this.$month.val(), 10); var year = parseInt(this.$year.val(), 10); if (!isNaN(month) && !isNaN(year)) { daysCount = moment([year, month]).daysInMonth(); } }
            for (i = 1; i <= daysCount; i++) { name = twoDigit ? this.leadZero(i) : i; items.push([i, name]); }
            return items;
        }, fillMonth: function () {
            var items = this.fillCommon('M'), name, i, longNamesNum = this.options.template.indexOf('MMMMMM') !== -1, shortNamesNum = this.options.template.indexOf('MMMMM') !== -1, longNames = this.options.template.indexOf('MMMM') !== -1, shortNames = this.options.template.indexOf('MMM') !== -1, twoDigit = this.options.template.indexOf('MM') !== -1; for (i = 0; i <= 11; i++) {
                if (longNamesNum) { name = moment().date(1).month(i).format('MM - MMMM'); } else if (shortNamesNum) { name = moment().date(1).month(i).format('MM - MMM'); } else if (longNames) { name = moment().date(1).month(i).format('MMMM'); } else if (shortNames) { name = moment().date(1).month(i).format('MMM'); } else if (twoDigit) { name = this.leadZero(i + 1); } else { name = i + 1; }
                items.push([i, name]);
            }
            return items;
        }, fillYear: function () {
            var items = [], name, i, longNames = this.options.template.indexOf('YYYY') !== -1; for (i = this.options.maxYear; i >= this.options.minYear; i--) { name = longNames ? i : (i + '').substring(2); items[this.options.yearDescending ? 'push' : 'unshift']([i, name]); }
            items = this.fillCommon('y').concat(items); return items;
        }, fillHour: function () {
            var items = this.fillCommon('h'), name, i, h12 = this.options.template.indexOf('h') !== -1, h24 = this.options.template.indexOf('H') !== -1, twoDigit = this.options.template.toLowerCase().indexOf('hh') !== -1, min = h12 ? 1 : 0, max = h12 ? 12 : 23; for (i = min; i <= max; i++) { name = twoDigit ? this.leadZero(i) : i; items.push([i, name]); }
            return items;
        }, fillMinute: function () {
            var items = this.fillCommon('m'), name, i, twoDigit = this.options.template.indexOf('mm') !== -1; for (i = 0; i <= 59; i += this.options.minuteStep) { name = twoDigit ? this.leadZero(i) : i; items.push([i, name]); }
            return items;
        }, fillSecond: function () {
            var items = this.fillCommon('s'), name, i, twoDigit = this.options.template.indexOf('ss') !== -1; for (i = 0; i <= 59; i += this.options.secondStep) { name = twoDigit ? this.leadZero(i) : i; items.push([i, name]); }
            return items;
        }, fillAmpm: function () { var ampmL = this.options.template.indexOf('a') !== -1, ampmU = this.options.template.indexOf('A') !== -1, items = [['am', ampmL ? 'am' : 'AM'], ['pm', ampmL ? 'pm' : 'PM']]; return items; }, getValue: function (format) {
            var dt, values = {}, that = this, notSelected = false; $.each(this.map, function (k, v) {
                if (k === 'ampm') { return; }
                if (that['$' + k]) { values[k] = parseInt(that['$' + k].val(), 10); } else {
                    var defaultValue; if (that.datetime) { defaultValue = that.datetime[v[1]](); } else { defaultValue = k === 'day' ? 1 : 0; }
                    values[k] = defaultValue;
                }
                if (isNaN(values[k])) { notSelected = true; return false; }
            }); if (notSelected) { return ''; }
            if (this.$ampm) { if (values.hour === 12) { values.hour = this.$ampm.val() === 'am' ? 0 : 12; } else { values.hour = this.$ampm.val() === 'am' ? values.hour : values.hour + 12; } }
            dt = moment([values.year, values.month, values.day, values.hour, values.minute, values.second]); this.highlight(dt); format = format === undefined ? this.options.format : format; if (format === null) { return dt.isValid() ? dt : null; } else { return dt.isValid() ? dt.format(format) : ''; }
        }, setValue: function (value) {
            if (!value) { return; }
            var dt = typeof value === 'string' ? moment(value, this.options.format, true) : moment(value), that = this, values = {}; function getNearest($select, value) { var delta = {}; $select.children('option').each(function (i, opt) { var optValue = $(opt).attr('value'), distance; if (optValue === '') return; distance = Math.abs(optValue - value); if (typeof delta.distance === 'undefined' || distance < delta.distance) { delta = { value: optValue, distance: distance }; } }); return delta.value; }
            if (dt.isValid()) {
                $.each(this.map, function (k, v) {
                    if (k === 'ampm') { return; }
                    values[k] = dt[v[1]]();
                }); if (this.$ampm) { if (values.hour >= 12) { values.ampm = 'pm'; if (values.hour > 12) { values.hour -= 12; } } else { values.ampm = 'am'; if (values.hour === 0) { values.hour = 12; } } }
                $.each(values, function (k, v) {
                    if (that['$' + k]) {
                        if (k === 'minute' && that.options.minuteStep > 1 && that.options.roundTime) { v = getNearest(that['$' + k], v); }
                        if (k === 'second' && that.options.secondStep > 1 && that.options.roundTime) { v = getNearest(that['$' + k], v); }
                        that['$' + k].val(v);
                    }
                }); if (this.options.smartDays) { this.fillCombo('day'); }
                this.$element.val(dt.format(this.options.format)).change(); this.datetime = dt;
            } else { this.datetime = null; }
        }, highlight: function (dt) {
            if (!dt.isValid()) {
                if (this.options.errorClass) { this.$widget.addClass(this.options.errorClass); } else {
                    if (!this.borderColor) { this.borderColor = this.$widget.find('select').css('border-color'); }
                    this.$widget.find('select').css('border-color', 'red');
                }
            } else { if (this.options.errorClass) { this.$widget.removeClass(this.options.errorClass); } else { this.$widget.find('select').css('border-color', this.borderColor); } }
        }, leadZero: function (v) { return v <= 9 ? '0' + v : v; }, destroy: function () { this.$widget.remove(); this.$element.removeData('combodate').show(); }
    }; $.fn.combodate = function (option) {
        var d, args = Array.apply(null, arguments); args.shift(); if (option === 'getValue' && this.length && (d = this.eq(0).data('combodate'))) { return d.getValue.apply(d, args); }
        return this.each(function () {
            var $this = $(this), data = $this.data('combodate'), options = typeof option == 'object' && option; if (!data) { $this.data('combodate', (data = new Combodate(this, options))); }
            if (typeof option == 'string' && typeof data[option] == 'function') { data[option].apply(data, args); }
        });
    }; $.fn.combodate.defaults = { format: 'DD-MM-YYYY HH:mm', template: 'D / MMM / YYYY   H : mm', value: null, minYear: 1970, maxYear: new Date().getFullYear(), yearDescending: true, minuteStep: 5, secondStep: 1, firstItem: 'empty', errorClass: null, customClass: '', roundTime: true, smartDays: false };
}(window.jQuery)); (function ($) {
    "use strict"; var Constructor = function (options) {
        this.init('combodate', options, Constructor.defaults); if (!this.options.viewformat) { this.options.viewformat = this.options.format; }
        options.combodate = $.fn.editableutils.tryParseJson(options.combodate, true); this.options.combodate = $.extend({}, Constructor.defaults.combodate, options.combodate, { format: this.options.format, template: this.options.template });
    }; $.fn.editableutils.inherit(Constructor, $.fn.editabletypes.abstractinput); $.extend(Constructor.prototype, {
        render: function () {
            this.$input.combodate(this.options.combodate); if ($.fn.editableform.engine === 'bs3') { this.$input.siblings().find('select').addClass('form-control'); }
            if (this.options.inputclass) { this.$input.siblings().find('select').addClass(this.options.inputclass); }
        }, value2html: function (value, element) { var text = value ? value.format(this.options.viewformat) : ''; Constructor.superclass.value2html.call(this, text, element); }, html2value: function (html) { return html ? moment(html, this.options.viewformat) : null; }, value2str: function (value) { return value ? value.format(this.options.format) : ''; }, str2value: function (str) { return str ? moment(str, this.options.format) : null; }, value2submit: function (value) { return this.value2str(value); }, value2input: function (value) { this.$input.combodate('setValue', value); }, input2value: function () { return this.$input.combodate('getValue', null); }, activate: function () { this.$input.siblings('.combodate').find('select').eq(0).focus(); }, autosubmit: function () { }
    }); Constructor.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<input type="text">', inputclass: null, format: 'YYYY-MM-DD', viewformat: null, template: 'D / MMM / YYYY', combodate: null }); $.fn.editabletypes.combodate = Constructor;
}(window.jQuery)); (function ($) {
    "use strict"; var pInitInput = $.fn.editableform.Constructor.prototype.initInput; $.extend($.fn.editableform.Constructor.prototype, {
        initTemplate: function () { this.$form = $($.fn.editableform.template); this.$form.find('.control-group').addClass('form-group'); this.$form.find('.editable-error-block').addClass('help-block'); }, initInput: function () {
            pInitInput.apply(this); var emptyInputClass = this.input.options.inputclass === null || this.input.options.inputclass === false; var defaultClass = 'form-control-sm border-right-0'; var stdtypes = 'text,select,textarea,password,email,url,tel,number,range,time,typeaheadjs'.split(','); if (~$.inArray(this.input.type, stdtypes)) { this.input.$input.addClass('form-control'); if (emptyInputClass) { this.input.options.inputclass = defaultClass; this.input.$input.addClass(defaultClass); } }
            var $btn = this.$form.find('.editable-buttons'); var classes = emptyInputClass ? [defaultClass] : this.input.options.inputclass.split(' '); for (var i = 0; i < classes.length; i++) { if (classes[i].toLowerCase() === 'input-lg') { $btn.find('button').removeClass('btn-sm').addClass('btn-lg'); } }
        }
    }); $.fn.editableform.buttons = '<button type="submit" class="btn btn-success btn-sm editable-submit">' +
        '<i class="fa fa-check" aria-hidden="true"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-danger btn-sm editable-cancel">' +
        '<i class="fa fa-times" aria-hidden="true"></i>' +
        '</button>'; $.fn.editableform.errorGroupClass = 'has-error'; $.fn.editableform.errorBlockClass = null; $.fn.editableform.engine = 'bs4';
}(window.jQuery)); (function ($) {
    "use strict"; $.extend($.fn.editableContainer.Popup.prototype, {
        containerName: 'popover', containerDataName: 'bs.popover', innerCss: '.popover-body', defaults: $.fn.popover.Constructor.DEFAULTS, initContainer: function () {
            $.extend(this.containerOptions, { trigger: 'manual', selector: false, content: ' ', template: '<div class="popover border-primary"><div class="arrow"></div><h3 class="popover-header bg-primary"></h3><div class="popover-body "></div></div>' }); var t; if (this.$element.data('template')) { t = this.$element.data('template'); this.$element.removeData('template'); }
            this.call(this.containerOptions); if (t) { this.$element.data('template', t); }
        }, innerShow: function () { this.call('show'); }, innerHide: function () { this.call('hide'); }, innerDestroy: function () { this.call('dispose'); }, setContainerOption: function (key, value) { this.container().options[key] = value; }, setPosition: function () { (function () { }).call(this.container()); }, tip: function () { return this.container() ? $(this.container().tip) : null; }
    });
}(window.jQuery)); (function ($) {
    function UTCDate() { return new Date(Date.UTC.apply(Date, arguments)); }
    function UTCToday() { var today = new Date(); return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate()); }
    var Datepicker = function (element, options) {
        var that = this; this._process_options(options); this.element = $(element); this.isInline = false; this.isInput = this.element.is('input'); this.component = this.element.is('.date') ? this.element.find('.add-on, .btn') : false; this.hasInput = this.component && this.element.find('input').length; if (this.component && this.component.length === 0)
            this.component = false; this.picker = $(DPGlobal.template); this._buildEvents(); this._attachEvents(); if (this.isInline) { this.picker.addClass('datepicker-inline').appendTo(this.element); } else { this.picker.addClass('datepicker-dropdown dropdown-menu'); }
        if (this.o.rtl) { this.picker.addClass('datepicker-rtl'); this.picker.find('.prev i, .next i').toggleClass('icon-arrow-left icon-arrow-right'); }
        this.viewMode = this.o.startView; if (this.o.calendarWeeks)
            this.picker.find('tfoot th.today').attr('colspan', function (i, val) { return parseInt(val) + 1; }); this._allow_update = false; this.setStartDate(this.o.startDate); this.setEndDate(this.o.endDate); this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled); this.fillDow(); this.fillMonths(); this._allow_update = true; this.update(); this.showMode(); if (this.isInline) { this.show(); }
    }; Datepicker.prototype = {
        constructor: Datepicker, _process_options: function (opts) {
            this._o = $.extend({}, this._o, opts); var o = this.o = $.extend({}, this._o); var lang = o.language; if (!dates[lang]) {
                lang = lang.split('-')[0]; if (!dates[lang])
                    lang = defaults.language;
            }
            o.language = lang; switch (o.startView) { case 2: case 'decade': o.startView = 2; break; case 1: case 'year': o.startView = 1; break; default: o.startView = 0; }
            switch (o.minViewMode) { case 1: case 'months': o.minViewMode = 1; break; case 2: case 'years': o.minViewMode = 2; break; default: o.minViewMode = 0; }
            o.startView = Math.max(o.startView, o.minViewMode); o.weekStart %= 7; o.weekEnd = ((o.weekStart + 6) % 7); var format = DPGlobal.parseFormat(o.format)
            if (o.startDate !== -Infinity) { o.startDate = DPGlobal.parseDate(o.startDate, format, o.language); }
            if (o.endDate !== Infinity) { o.endDate = DPGlobal.parseDate(o.endDate, format, o.language); }
            o.daysOfWeekDisabled = o.daysOfWeekDisabled || []; if (!$.isArray(o.daysOfWeekDisabled))
                o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/); o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function (d) { return parseInt(d, 10); });
        }, _events: [], _secondaryEvents: [], _applyEvents: function (evs) { for (var i = 0, el, ev; i < evs.length; i++) { el = evs[i][0]; ev = evs[i][1]; el.on(ev); } }, _unapplyEvents: function (evs) { for (var i = 0, el, ev; i < evs.length; i++) { el = evs[i][0]; ev = evs[i][1]; el.off(ev); } }, _buildEvents: function () {
            if (this.isInput) { this._events = [[this.element, { focus: $.proxy(this.show, this), keyup: $.proxy(this.update, this), keydown: $.proxy(this.keydown, this) }]]; }
            else if (this.component && this.hasInput) { this._events = [[this.element.find('input'), { focus: $.proxy(this.show, this), keyup: $.proxy(this.update, this), keydown: $.proxy(this.keydown, this) }], [this.component, { click: $.proxy(this.show, this) }]]; }
            else if (this.element.is('div')) { this.isInline = true; }
            else { this._events = [[this.element, { click: $.proxy(this.show, this) }]]; }
            this._secondaryEvents = [[this.picker, { click: $.proxy(this.click, this) }], [$(window), { resize: $.proxy(this.place, this) }], [$(document), { mousedown: $.proxy(function (e) { if (!(this.element.is(e.target) || this.element.find(e.target).size() || this.picker.is(e.target) || this.picker.find(e.target).size())) { this.hide(); } }, this) }]];
        }, _attachEvents: function () { this._detachEvents(); this._applyEvents(this._events); }, _detachEvents: function () { this._unapplyEvents(this._events); }, _attachSecondaryEvents: function () { this._detachSecondaryEvents(); this._applyEvents(this._secondaryEvents); }, _detachSecondaryEvents: function () { this._unapplyEvents(this._secondaryEvents); }, _trigger: function (event, altdate) { var date = altdate || this.date, local_date = new Date(date.getTime() + (date.getTimezoneOffset() * 60000)); this.element.trigger({ type: event, date: local_date, format: $.proxy(function (altformat) { var format = altformat || this.o.format; return DPGlobal.formatDate(date, format, this.o.language); }, this) }); }, show: function (e) {
            if (!this.isInline)
                this.picker.appendTo('body'); this.picker.show(); this.height = this.component ? this.component.outerHeight() : this.element.outerHeight(); this.place(); this._attachSecondaryEvents(); if (e) { e.preventDefault(); }
            this._trigger('show');
        }, hide: function (e) {
            if (this.isInline) return; if (!this.picker.is(':visible')) return; this.picker.hide().detach(); this._detachSecondaryEvents(); this.viewMode = this.o.startView; this.showMode(); if (this.o.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find('input').val()))
                this.setValue(); this._trigger('hide');
        }, remove: function () { this.hide(); this._detachEvents(); this._detachSecondaryEvents(); this.picker.remove(); delete this.element.data().datepicker; if (!this.isInput) { delete this.element.data().date; } }, getDate: function () { var d = this.getUTCDate(); return new Date(d.getTime() + (d.getTimezoneOffset() * 60000)); }, getUTCDate: function () { return this.date; }, setDate: function (d) { this.setUTCDate(new Date(d.getTime() - (d.getTimezoneOffset() * 60000))); }, setUTCDate: function (d) { this.date = d; this.setValue(); }, setValue: function () { var formatted = this.getFormattedDate(); if (!this.isInput) { if (this.component) { this.element.find('input').val(formatted); } } else { this.element.val(formatted); } }, getFormattedDate: function (format) {
            if (format === undefined)
                format = this.o.format; return DPGlobal.formatDate(this.date, format, this.o.language);
        }, setStartDate: function (startDate) { this._process_options({ startDate: startDate }); this.update(); this.updateNavArrows(); }, setEndDate: function (endDate) { this._process_options({ endDate: endDate }); this.update(); this.updateNavArrows(); }, setDaysOfWeekDisabled: function (daysOfWeekDisabled) { this._process_options({ daysOfWeekDisabled: daysOfWeekDisabled }); this.update(); this.updateNavArrows(); }, place: function () { if (this.isInline) return; var zIndex = parseInt(this.element.parents().filter(function () { return $(this).css('z-index') != 'auto'; }).first().css('z-index')) + 10; var offset = this.component ? this.component.parent().offset() : this.element.offset(); var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(true); this.picker.css({ top: offset.top + height, left: offset.left, zIndex: zIndex }); }, _allow_update: true, update: function () {
            if (!this._allow_update) return; var date, fromArgs = false; if (arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) { date = arguments[0]; fromArgs = true; } else { date = this.isInput ? this.element.val() : this.element.data('date') || this.element.find('input').val(); delete this.element.data().date; }
            this.date = DPGlobal.parseDate(date, this.o.format, this.o.language); if (fromArgs) this.setValue(); if (this.date < this.o.startDate) { this.viewDate = new Date(this.o.startDate); } else if (this.date > this.o.endDate) { this.viewDate = new Date(this.o.endDate); } else { this.viewDate = new Date(this.date); }
            this.fill();
        }, fillDow: function () {
            var dowCnt = this.o.weekStart, html = '<tr>'; if (this.o.calendarWeeks) { var cell = '<th class="cw">&nbsp;</th>'; html += cell; this.picker.find('.datepicker-days thead tr:first-child').prepend(cell); }
            while (dowCnt < this.o.weekStart + 7) { html += '<th class="dow">' + dates[this.o.language].daysMin[(dowCnt++) % 7] + '</th>'; }
            html += '</tr>'; this.picker.find('.datepicker-days thead').append(html);
        }, fillMonths: function () {
            var html = '', i = 0; while (i < 12) { html += '<span class="month">' + dates[this.o.language].monthsShort[i++] + '</span>'; }
            this.picker.find('.datepicker-months td').html(html);
        }, setRange: function (range) {
            if (!range || !range.length)
                delete this.range; else
                this.range = $.map(range, function (d) { return d.valueOf(); }); this.fill();
        }, getClassNames: function (date) {
            var cls = [], year = this.viewDate.getUTCFullYear(), month = this.viewDate.getUTCMonth(), currentDate = this.date.valueOf(), today = new Date(); if (date.getUTCFullYear() < year || (date.getUTCFullYear() == year && date.getUTCMonth() < month)) { cls.push('old'); } else if (date.getUTCFullYear() > year || (date.getUTCFullYear() == year && date.getUTCMonth() > month)) { cls.push('new'); }
            if (this.o.todayHighlight && date.getUTCFullYear() == today.getFullYear() && date.getUTCMonth() == today.getMonth() && date.getUTCDate() == today.getDate()) { cls.push('today'); }
            if (currentDate && date.valueOf() == currentDate) { cls.push('active'); }
            if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate || $.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1) { cls.push('disabled'); }
            if (this.range) {
                if (date > this.range[0] && date < this.range[this.range.length - 1]) { cls.push('range'); }
                if ($.inArray(date.valueOf(), this.range) != -1) { cls.push('selected'); }
            }
            return cls;
        }, fill: function () {
            var d = new Date(this.viewDate), year = d.getUTCFullYear(), month = d.getUTCMonth(), startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity, startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity, endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity, endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity, currentDate = this.date && this.date.valueOf(), tooltip; this.picker.find('.datepicker-days thead th.datepicker-switch').text(dates[this.o.language].months[month] + ' ' + year); this.picker.find('tfoot th.today').text(dates[this.o.language].today).toggle(this.o.todayBtn !== false); this.picker.find('tfoot th.clear').text(dates[this.o.language].clear).toggle(this.o.clearBtn !== false); this.updateNavArrows(); this.fillMonths(); var prevMonth = UTCDate(year, month - 1, 28, 0, 0, 0, 0), day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth()); prevMonth.setUTCDate(day); prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7) % 7); var nextMonth = new Date(prevMonth); nextMonth.setUTCDate(nextMonth.getUTCDate() + 42); nextMonth = nextMonth.valueOf(); var html = []; var clsName; while (prevMonth.valueOf() < nextMonth) {
                if (prevMonth.getUTCDay() == this.o.weekStart) {
                    html.push('<tr>'); if (this.o.calendarWeeks) {
                        var
                        ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5), th = new Date(+ws + (7 + 4 - ws.getUTCDay()) % 7 * 864e5), yth = new Date(+(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay()) % 7 * 864e5), calWeek = (th - yth) / 864e5 / 7 + 1; html.push('<td class="cw">' + calWeek + '</td>');
                    }
                }
                clsName = this.getClassNames(prevMonth); clsName.push('day'); var before = this.o.beforeShowDay(prevMonth); if (before === undefined)
                    before = {}; else if (typeof (before) === 'boolean')
                    before = { enabled: before }; else if (typeof (before) === 'string')
                    before = { classes: before }; if (before.enabled === false)
                    clsName.push('disabled'); if (before.classes)
                    clsName = clsName.concat(before.classes.split(/\s+/)); if (before.tooltip)
                    tooltip = before.tooltip; clsName = $.unique(clsName); html.push('<td class="' + clsName.join(' ') + '"' + (tooltip ? ' title="' + tooltip + '"' : '') + '>' + prevMonth.getUTCDate() + '</td>'); if (prevMonth.getUTCDay() == this.o.weekEnd) { html.push('</tr>'); }
                prevMonth.setUTCDate(prevMonth.getUTCDate() + 1);
            }
            this.picker.find('.datepicker-days tbody').empty().append(html.join('')); var currentYear = this.date && this.date.getUTCFullYear(); var months = this.picker.find('.datepicker-months').find('th:eq(1)').text(year).end().find('span').removeClass('active'); if (currentYear && currentYear == year) { months.eq(this.date.getUTCMonth()).addClass('active'); }
            if (year < startYear || year > endYear) { months.addClass('disabled'); }
            if (year == startYear) { months.slice(0, startMonth).addClass('disabled'); }
            if (year == endYear) { months.slice(endMonth + 1).addClass('disabled'); }
            html = ''; year = parseInt(year / 10, 10) * 10; var yearCont = this.picker.find('.datepicker-years').find('th:eq(1)').text(year + '-' + (year + 9)).end().find('td'); year -= 1; for (var i = -1; i < 11; i++) { html += '<span class="year' + (i == -1 ? ' old' : i == 10 ? ' new' : '') + (currentYear == year ? ' active' : '') + (year < startYear || year > endYear ? ' disabled' : '') + '">' + year + '</span>'; year += 1; }
            yearCont.html(html);
        }, updateNavArrows: function () {
            if (!this._allow_update) return; var d = new Date(this.viewDate), year = d.getUTCFullYear(), month = d.getUTCMonth(); switch (this.viewMode) {
                case 0: if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()) { this.picker.find('.prev').css({ visibility: 'hidden' }); } else { this.picker.find('.prev').css({ visibility: 'visible' }); }
                    if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()) { this.picker.find('.next').css({ visibility: 'hidden' }); } else { this.picker.find('.next').css({ visibility: 'visible' }); }
                    break; case 1: case 2: if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()) { this.picker.find('.prev').css({ visibility: 'hidden' }); } else { this.picker.find('.prev').css({ visibility: 'visible' }); }
                    if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()) { this.picker.find('.next').css({ visibility: 'hidden' }); } else { this.picker.find('.next').css({ visibility: 'visible' }); }
                    break;
            }
        }, click: function (e) {
            e.preventDefault(); var target = $(e.target).closest('span, td, th'); if (target.length == 1) {
                switch (target[0].nodeName.toLowerCase()) {
                    case 'th': switch (target[0].className) {
                        case 'datepicker-switch': this.showMode(1); break; case 'prev': case 'next': var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1); switch (this.viewMode) { case 0: this.viewDate = this.moveMonth(this.viewDate, dir); break; case 1: case 2: this.viewDate = this.moveYear(this.viewDate, dir); break; }
                            this.fill(); break; case 'today': var date = new Date(); date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0); this.showMode(-2); var which = this.o.todayBtn == 'linked' ? null : 'view'; this._setDate(date, which); break; case 'clear': var element; if (this.isInput)
                                element = this.element; else if (this.component)
                                element = this.element.find('input'); if (element)
                                element.val("").change(); this._trigger('changeDate'); this.update(); if (this.o.autoclose)
                                this.hide(); break;
                    }
                        break; case 'span': if (!target.is('.disabled')) {
                            this.viewDate.setUTCDate(1); if (target.is('.month')) { var day = 1; var month = target.parent().find('span').index(target); var year = this.viewDate.getUTCFullYear(); this.viewDate.setUTCMonth(month); this._trigger('changeMonth', this.viewDate); if (this.o.minViewMode === 1) { this._setDate(UTCDate(year, month, day, 0, 0, 0, 0)); } } else { var year = parseInt(target.text(), 10) || 0; var day = 1; var month = 0; this.viewDate.setUTCFullYear(year); this._trigger('changeYear', this.viewDate); if (this.o.minViewMode === 2) { this._setDate(UTCDate(year, month, day, 0, 0, 0, 0)); } }
                            this.showMode(-1); this.fill();
                        }
                        break; case 'td': if (target.is('.day') && !target.is('.disabled')) {
                            var day = parseInt(target.text(), 10) || 1; var year = this.viewDate.getUTCFullYear(), month = this.viewDate.getUTCMonth(); if (target.is('.old')) { if (month === 0) { month = 11; year -= 1; } else { month -= 1; } } else if (target.is('.new')) { if (month == 11) { month = 0; year += 1; } else { month += 1; } }
                            this._setDate(UTCDate(year, month, day, 0, 0, 0, 0));
                        }
                        break;
                }
            }
        }, _setDate: function (date, which) {
            if (!which || which == 'date')
                this.date = new Date(date); if (!which || which == 'view')
                this.viewDate = new Date(date); this.fill(); this.setValue(); this._trigger('changeDate'); var element; if (this.isInput) { element = this.element; } else if (this.component) { element = this.element.find('input'); }
            if (element) { element.change(); if (this.o.autoclose && (!which || which == 'date')) { this.hide(); } }
        }, moveMonth: function (date, dir) {
            if (!dir) return date; var new_date = new Date(date.valueOf()), day = new_date.getUTCDate(), month = new_date.getUTCMonth(), mag = Math.abs(dir), new_month, test; dir = dir > 0 ? 1 : -1; if (mag == 1) {
                test = dir == -1 ? function () { return new_date.getUTCMonth() == month; } : function () { return new_date.getUTCMonth() != new_month; }; new_month = month + dir; new_date.setUTCMonth(new_month); if (new_month < 0 || new_month > 11)
                    new_month = (new_month + 12) % 12;
            } else {
                for (var i = 0; i < mag; i++)
                    new_date = this.moveMonth(new_date, dir); new_month = new_date.getUTCMonth(); new_date.setUTCDate(day); test = function () { return new_month != new_date.getUTCMonth(); };
            }
            while (test()) { new_date.setUTCDate(--day); new_date.setUTCMonth(new_month); }
            return new_date;
        }, moveYear: function (date, dir) { return this.moveMonth(date, dir * 12); }, dateWithinRange: function (date) { return date >= this.o.startDate && date <= this.o.endDate; }, keydown: function (e) {
            if (this.picker.is(':not(:visible)')) {
                if (e.keyCode == 27)
                    this.show(); return;
            }
            var dateChanged = false, dir, day, month, newDate, newViewDate; switch (e.keyCode) {
                case 27: this.hide(); e.preventDefault(); break; case 37: case 39: if (!this.o.keyboardNavigation) break; dir = e.keyCode == 37 ? -1 : 1; if (e.ctrlKey) { newDate = this.moveYear(this.date, dir); newViewDate = this.moveYear(this.viewDate, dir); } else if (e.shiftKey) { newDate = this.moveMonth(this.date, dir); newViewDate = this.moveMonth(this.viewDate, dir); } else { newDate = new Date(this.date); newDate.setUTCDate(this.date.getUTCDate() + dir); newViewDate = new Date(this.viewDate); newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir); }
                    if (this.dateWithinRange(newDate)) { this.date = newDate; this.viewDate = newViewDate; this.setValue(); this.update(); e.preventDefault(); dateChanged = true; }
                    break; case 38: case 40: if (!this.o.keyboardNavigation) break; dir = e.keyCode == 38 ? -1 : 1; if (e.ctrlKey) { newDate = this.moveYear(this.date, dir); newViewDate = this.moveYear(this.viewDate, dir); } else if (e.shiftKey) { newDate = this.moveMonth(this.date, dir); newViewDate = this.moveMonth(this.viewDate, dir); } else { newDate = new Date(this.date); newDate.setUTCDate(this.date.getUTCDate() + dir * 7); newViewDate = new Date(this.viewDate); newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir * 7); }
                    if (this.dateWithinRange(newDate)) { this.date = newDate; this.viewDate = newViewDate; this.setValue(); this.update(); e.preventDefault(); dateChanged = true; }
                    break; case 13: this.hide(); e.preventDefault(); break; case 9: this.hide(); break;
            }
            if (dateChanged) {
                this._trigger('changeDate'); var element; if (this.isInput) { element = this.element; } else if (this.component) { element = this.element.find('input'); }
                if (element) { element.change(); }
            }
        }, showMode: function (dir) {
            if (dir) { this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir)); }
            this.picker.find('>div').hide().filter('.datepicker-' + DPGlobal.modes[this.viewMode].clsName).css('display', 'block'); this.updateNavArrows();
        }
    }; var DateRangePicker = function (element, options) { this.element = $(element); this.inputs = $.map(options.inputs, function (i) { return i.jquery ? i[0] : i; }); delete options.inputs; $(this.inputs).datepicker(options).bind('changeDate', $.proxy(this.dateUpdated, this)); this.pickers = $.map(this.inputs, function (i) { return $(i).data('datepicker'); }); this.updateDates(); }; DateRangePicker.prototype = {
        updateDates: function () { this.dates = $.map(this.pickers, function (i) { return i.date; }); this.updateRanges(); }, updateRanges: function () { var range = $.map(this.dates, function (d) { return d.valueOf(); }); $.each(this.pickers, function (i, p) { p.setRange(range); }); }, dateUpdated: function (e) {
            var dp = $(e.target).data('datepicker'), new_date = dp.getUTCDate(), i = $.inArray(e.target, this.inputs), l = this.inputs.length; if (i == -1) return; if (new_date < this.dates[i]) { while (i >= 0 && new_date < this.dates[i]) { this.pickers[i--].setUTCDate(new_date); } }
            else if (new_date > this.dates[i]) { while (i < l && new_date > this.dates[i]) { this.pickers[i++].setUTCDate(new_date); } }
            this.updateDates();
        }, remove: function () { $.map(this.pickers, function (p) { p.remove(); }); delete this.element.data().datepicker; }
    }; function opts_from_el(el, prefix) {
        var data = $(el).data(), out = {}, inkey, replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])'), prefix = new RegExp('^' + prefix.toLowerCase()); for (var key in data)
            if (prefix.test(key)) { inkey = key.replace(replace, function (_, a) { return a.toLowerCase(); }); out[inkey] = data[key]; }
        return out;
    }
    function opts_from_locale(lang) {
        var out = {}; if (!dates[lang]) {
            lang = lang.split('-')[0]
            if (!dates[lang])
                return;
        }
        var d = dates[lang]; $.each(locale_opts, function (i, k) {
            if (k in d)
                out[k] = d[k];
        }); return out;
    }
    var old = $.fn.datepicker; var datepicker = $.fn.datepicker = function (option) {
        var args = Array.apply(null, arguments); args.shift(); var internal_return, this_return; this.each(function () {
            var $this = $(this), data = $this.data('datepicker'), options = typeof option == 'object' && option; if (!data) {
                var elopts = opts_from_el(this, 'date'), xopts = $.extend({}, defaults, elopts, options), locopts = opts_from_locale(xopts.language), opts = $.extend({}, defaults, locopts, elopts, options); if ($this.is('.input-daterange') || opts.inputs) { var ropts = { inputs: opts.inputs || $this.find('input').toArray() }; $this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts)))); }
                else { $this.data('datepicker', (data = new Datepicker(this, opts))); }
            }
            if (typeof option == 'string' && typeof data[option] == 'function') {
                internal_return = data[option].apply(data, args); if (internal_return !== undefined)
                    return false;
            }
        }); if (internal_return !== undefined)
            return internal_return; else
            return this;
    }; var defaults = $.fn.datepicker.defaults = { autoclose: false, beforeShowDay: $.noop, calendarWeeks: false, clearBtn: false, daysOfWeekDisabled: [], endDate: Infinity, forceParse: true, format: 'mm/dd/yyyy', keyboardNavigation: true, language: 'en', minViewMode: 0, rtl: false, startDate: -Infinity, startView: 0, todayBtn: false, todayHighlight: false, weekStart: 0 }; var locale_opts = $.fn.datepicker.locale_opts = ['format', 'rtl', 'weekStart']; $.fn.datepicker.Constructor = Datepicker; var dates = $.fn.datepicker.dates = { en: { days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"], daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"], months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], today: "Today", clear: "Clear" } }; var DPGlobal = {
        modes: [{ clsName: 'days', navFnc: 'Month', navStep: 1 }, { clsName: 'months', navFnc: 'FullYear', navStep: 1 }, { clsName: 'years', navFnc: 'FullYear', navStep: 10 }], isLeapYear: function (year) { return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); }, getDaysInMonth: function (year, month) { return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month]; }, validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g, nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g, parseFormat: function (format) {
            var separators = format.replace(this.validParts, '\0').split('\0'), parts = format.match(this.validParts); if (!separators || !separators.length || !parts || parts.length === 0) { throw new Error("Invalid date format."); }
            return { separators: separators, parts: parts };
        }, parseDate: function (date, format, language) {
            if (date instanceof Date) return date; if (typeof format === 'string')
                format = DPGlobal.parseFormat(format); if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)) {
                    var part_re = /([\-+]\d+)([dmwy])/, parts = date.match(/([\-+]\d+)([dmwy])/g), part, dir; date = new Date(); for (var i = 0; i < parts.length; i++) { part = part_re.exec(parts[i]); dir = parseInt(part[1]); switch (part[2]) { case 'd': date.setUTCDate(date.getUTCDate() + dir); break; case 'm': date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir); break; case 'w': date.setUTCDate(date.getUTCDate() + dir * 7); break; case 'y': date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir); break; } }
                    return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
                }
            var parts = date && date.match(this.nonpunctuation) || [], date = new Date(), parsed = {}, setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'], setters_map = {
                yyyy: function (d, v) { return d.setUTCFullYear(v); }, yy: function (d, v) { return d.setUTCFullYear(2000 + v); }, m: function (d, v) {
                    v -= 1; while (v < 0) v += 12; v %= 12; d.setUTCMonth(v); while (d.getUTCMonth() != v)
                        d.setUTCDate(d.getUTCDate() - 1); return d;
                }, d: function (d, v) { return d.setUTCDate(v); }
            }, val, filtered, part; setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m']; setters_map['dd'] = setters_map['d']; date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0); var fparts = format.parts.slice(); if (parts.length != fparts.length) { fparts = $(fparts).filter(function (i, p) { return $.inArray(p, setters_order) !== -1; }).toArray(); }
            if (parts.length == fparts.length) {
                for (var i = 0, cnt = fparts.length; i < cnt; i++) {
                    val = parseInt(parts[i], 10); part = fparts[i]; if (isNaN(val)) { switch (part) { case 'MM': filtered = $(dates[language].months).filter(function () { var m = this.slice(0, parts[i].length), p = parts[i].slice(0, m.length); return m == p; }); val = $.inArray(filtered[0], dates[language].months) + 1; break; case 'M': filtered = $(dates[language].monthsShort).filter(function () { var m = this.slice(0, parts[i].length), p = parts[i].slice(0, m.length); return m == p; }); val = $.inArray(filtered[0], dates[language].monthsShort) + 1; break; } }
                    parsed[part] = val;
                }
                for (var i = 0, s; i < setters_order.length; i++) {
                    s = setters_order[i]; if (s in parsed && !isNaN(parsed[s]))
                        setters_map[s](date, parsed[s]);
                }
            }
            return date;
        }, formatDate: function (date, format, language) {
            if (typeof format === 'string')
                format = DPGlobal.parseFormat(format); var val = { d: date.getUTCDate(), D: dates[language].daysShort[date.getUTCDay()], DD: dates[language].days[date.getUTCDay()], m: date.getUTCMonth() + 1, M: dates[language].monthsShort[date.getUTCMonth()], MM: dates[language].months[date.getUTCMonth()], yy: date.getUTCFullYear().toString().substring(2), yyyy: date.getUTCFullYear() }; val.dd = (val.d < 10 ? '0' : '') + val.d; val.mm = (val.m < 10 ? '0' : '') + val.m; var date = [], seps = $.extend([], format.separators); for (var i = 0, cnt = format.parts.length; i <= cnt; i++) {
                    if (seps.length)
                        date.push(seps.shift()); date.push(val[format.parts[i]]);
                }
            return date.join('');
        }, headTemplate: '<thead>' +
            '<tr>' +
            '<th class="prev"><i class="icon-arrow-left"/></th>' +
            '<th colspan="5" class="datepicker-switch"></th>' +
            '<th class="next"><i class="icon-arrow-right"/></th>' +
            '</tr>' +
            '</thead>', contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>', footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
    }; DPGlobal.template = '<div class="datepicker">' +
        '<div class="datepicker-days">' +
        '<table class=" table-condensed">' +
        DPGlobal.headTemplate +
        '<tbody></tbody>' +
        DPGlobal.footTemplate +
        '</table>' +
        '</div>' +
        '<div class="datepicker-months">' +
        '<table class="table-condensed">' +
        DPGlobal.headTemplate +
        DPGlobal.contTemplate +
        DPGlobal.footTemplate +
        '</table>' +
        '</div>' +
        '<div class="datepicker-years">' +
        '<table class="table-condensed">' +
        DPGlobal.headTemplate +
        DPGlobal.contTemplate +
        DPGlobal.footTemplate +
        '</table>' +
        '</div>' +
        '</div>'; $.fn.datepicker.DPGlobal = DPGlobal; $.fn.datepicker.noConflict = function () { $.fn.datepicker = old; return this; }; $(document).on('focus.datepicker.data-api click.datepicker.data-api', '[data-provide="datepicker"]', function (e) { var $this = $(this); if ($this.data('datepicker')) return; e.preventDefault(); datepicker.call($this, 'show'); }); $(function () { datepicker.call($('[data-provide="datepicker-inline"]')); });
}(window.jQuery)); (function ($) {
    "use strict"; $.fn.bdatepicker = $.fn.datepicker.noConflict(); if (!$.fn.datepicker) { $.fn.datepicker = $.fn.bdatepicker; }
    var Date = function (options) { this.init('date', options, Date.defaults); this.initPicker(options, Date.defaults); }; $.fn.editableutils.inherit(Date, $.fn.editabletypes.abstractinput); $.extend(Date.prototype, {
        initPicker: function (options, defaults) {
            if (!this.options.viewformat) { this.options.viewformat = this.options.format; }
            options.datepicker = $.fn.editableutils.tryParseJson(options.datepicker, true); this.options.datepicker = $.extend({}, defaults.datepicker, options.datepicker, { format: this.options.viewformat }); this.options.datepicker.language = this.options.datepicker.language || 'en'; this.dpg = $.fn.bdatepicker.DPGlobal; this.parsedFormat = this.dpg.parseFormat(this.options.format); this.parsedViewFormat = this.dpg.parseFormat(this.options.viewformat);
        }, render: function () { this.$input.bdatepicker(this.options.datepicker); if (this.options.clear) { this.$clear = $('<a href="#"></a>').html(this.options.clear).click($.proxy(function (e) { e.preventDefault(); e.stopPropagation(); this.clear(); }, this)); this.$tpl.parent().append($('<div class="editable-clear">').append(this.$clear)); } }, value2html: function (value, element) { var text = value ? this.dpg.formatDate(value, this.parsedViewFormat, this.options.datepicker.language) : ''; Date.superclass.value2html.call(this, text, element); }, html2value: function (html) { return this.parseDate(html, this.parsedViewFormat); }, value2str: function (value) { return value ? this.dpg.formatDate(value, this.parsedFormat, this.options.datepicker.language) : ''; }, str2value: function (str) { return this.parseDate(str, this.parsedFormat); }, value2submit: function (value) { return this.value2str(value); }, value2input: function (value) { this.$input.bdatepicker('update', value); }, input2value: function () { return this.$input.data('datepicker').date; }, activate: function () { }, clear: function () { this.$input.data('datepicker').date = null; this.$input.find('.active').removeClass('active'); if (!this.options.showbuttons) { this.$input.closest('form').submit(); } }, autosubmit: function () {
            this.$input.on('mouseup', '.day', function (e) {
                if ($(e.currentTarget).is('.old') || $(e.currentTarget).is('.new')) { return; }
                var $form = $(this).closest('form'); setTimeout(function () { $form.submit(); }, 200);
            });
        }, parseDate: function (str, format) {
            var date = null, formattedBack; if (str) { date = this.dpg.parseDate(str, format, this.options.datepicker.language); if (typeof str === 'string') { formattedBack = this.dpg.formatDate(date, format, this.options.datepicker.language); if (str !== formattedBack) { date = null; } } }
            return date;
        }
    }); Date.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<div class="editable-date well"></div>', inputclass: null, format: 'yyyy-mm-dd', viewformat: null, datepicker: { weekStart: 0, startView: 0, minViewMode: 0, autoclose: false }, clear: '&times; clear' }); $.fn.editabletypes.date = Date;
}(window.jQuery)); (function ($) { "use strict"; var DateField = function (options) { this.init('datefield', options, DateField.defaults); this.initPicker(options, DateField.defaults); }; $.fn.editableutils.inherit(DateField, $.fn.editabletypes.date); $.extend(DateField.prototype, { render: function () { this.$input = this.$tpl.find('input'); this.setClass(); this.setAttr('placeholder'); this.$input.bdatepicker(this.options.datepicker); this.$input.off('focus keydown'); this.$input.keyup($.proxy(function () { this.$tpl.removeData('date'); this.$tpl.bdatepicker('update'); }, this)); }, value2input: function (value) { this.$input.val(value ? this.dpg.formatDate(value, this.parsedViewFormat, this.options.datepicker.language) : ''); this.$tpl.bdatepicker('update'); }, input2value: function () { return this.html2value(this.$input.val()); }, activate: function () { $.fn.editabletypes.text.prototype.activate.call(this); }, autosubmit: function () { } }); DateField.defaults = $.extend({}, $.fn.editabletypes.date.defaults, { tpl: '<div class="input-append date"><input type="text"/><span class="add-on"><i class="icon-th"></i></span></div>', inputclass: 'input-small', datepicker: { weekStart: 0, startView: 0, minViewMode: 0, autoclose: true } }); $.fn.editabletypes.datefield = DateField; }(window.jQuery)); (function ($) {
    "use strict"; var DateTime = function (options) { this.init('datetime', options, DateTime.defaults); this.initPicker(options, DateTime.defaults); }; $.fn.editableutils.inherit(DateTime, $.fn.editabletypes.abstractinput); $.extend(DateTime.prototype, {
        initPicker: function (options, defaults) {
            if (!this.options.viewformat) { this.options.viewformat = this.options.format; }
            options.datetimepicker = $.fn.editableutils.tryParseJson(options.datetimepicker, true); this.options.datetimepicker = $.extend({}, defaults.datetimepicker, options.datetimepicker, { format: this.options.viewformat }); this.options.datetimepicker.language = this.options.datetimepicker.language || 'en'; this.dpg = $.fn.datetimepicker.DPGlobal; this.parsedFormat = this.dpg.parseFormat(this.options.format, this.options.formatType); this.parsedViewFormat = this.dpg.parseFormat(this.options.viewformat, this.options.formatType);
        }, render: function () { this.$input.datetimepicker(this.options.datetimepicker); this.$input.on('changeMode', function (e) { var f = $(this).closest('form').parent(); setTimeout(function () { f.triggerHandler('resize'); }, 0); }); if (this.options.clear) { this.$clear = $('<a href="#"></a>').html(this.options.clear).click($.proxy(function (e) { e.preventDefault(); e.stopPropagation(); this.clear(); }, this)); this.$tpl.parent().append($('<div class="editable-clear">').append(this.$clear)); } }, value2html: function (value, element) { var text = value ? this.dpg.formatDate(this.toUTC(value), this.parsedViewFormat, this.options.datetimepicker.language, this.options.formatType) : ''; if (element) { DateTime.superclass.value2html.call(this, text, element); } else { return text; } }, html2value: function (html) { var value = this.parseDate(html, this.parsedViewFormat); return value ? this.fromUTC(value) : null; }, value2str: function (value) { return value ? this.dpg.formatDate(this.toUTC(value), this.parsedFormat, this.options.datetimepicker.language, this.options.formatType) : ''; }, str2value: function (str) { var value = this.parseDate(str, this.parsedFormat); return value ? this.fromUTC(value) : null; }, value2submit: function (value) { return this.value2str(value); }, value2input: function (value) { if (value) { this.$input.data('datetimepicker').setDate(value); } }, input2value: function () { var dt = this.$input.data('datetimepicker'); return dt.date ? dt.getDate() : null; }, activate: function () { }, clear: function () { this.$input.data('datetimepicker').date = null; this.$input.find('.active').removeClass('active'); if (!this.options.showbuttons) { this.$input.closest('form').submit(); } }, autosubmit: function () { this.$input.on('mouseup', '.minute', function (e) { var $form = $(this).closest('form'); setTimeout(function () { $form.submit(); }, 200); }); }, toUTC: function (value) { return value ? new Date(value.valueOf() - value.getTimezoneOffset() * 60000) : value; }, fromUTC: function (value) { return value ? new Date(value.valueOf() + value.getTimezoneOffset() * 60000) : value; }, parseDate: function (str, format) {
            var date = null, formattedBack; if (str) { date = this.dpg.parseDate(str, format, this.options.datetimepicker.language, this.options.formatType); if (typeof str === 'string') { formattedBack = this.dpg.formatDate(date, format, this.options.datetimepicker.language, this.options.formatType); if (str !== formattedBack) { date = null; } } }
            return date;
        }
    }); DateTime.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, { tpl: '<div class="editable-date well"></div>', inputclass: null, format: 'yyyy-mm-dd hh:ii', formatType: 'standard', viewformat: null, datetimepicker: { todayHighlight: false, autoclose: false }, clear: '&times; clear' }); $.fn.editabletypes.datetime = DateTime;
}(window.jQuery)); (function ($) { "use strict"; var DateTimeField = function (options) { this.init('datetimefield', options, DateTimeField.defaults); this.initPicker(options, DateTimeField.defaults); }; $.fn.editableutils.inherit(DateTimeField, $.fn.editabletypes.datetime); $.extend(DateTimeField.prototype, { render: function () { this.$input = this.$tpl.find('input'); this.setClass(); this.setAttr('placeholder'); this.$tpl.datetimepicker(this.options.datetimepicker); this.$input.off('focus keydown'); this.$input.keyup($.proxy(function () { this.$tpl.removeData('date'); this.$tpl.datetimepicker('update'); }, this)); }, value2input: function (value) { this.$input.val(this.value2html(value)); this.$tpl.datetimepicker('update'); }, input2value: function () { return this.html2value(this.$input.val()); }, activate: function () { $.fn.editabletypes.text.prototype.activate.call(this); }, autosubmit: function () { } }); DateTimeField.defaults = $.extend({}, $.fn.editabletypes.datetime.defaults, { tpl: '<div class="input-append date"><input type="text"/><span class="add-on"><i class="icon-th"></i></span></div>', inputclass: 'input-medium', datetimepicker: { todayHighlight: false, autoclose: true } }); $.fn.editabletypes.datetimefield = DateTimeField; }(window.jQuery));