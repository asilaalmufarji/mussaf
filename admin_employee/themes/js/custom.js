function language_switch(lang) { setCookie("lang", lang, 365); window.location = removeParams("lang"); }
function removeParams(sParam) {
    var url = window.location.href.split('?')[0] + '?'; var sPageURL = decodeURIComponent(window.location.search.substring(1)), sURLVariables = sPageURL.split('&'), sParameterName, i; console.log(sParam)
    for (i = 0; i < sURLVariables.length; i++) { sParameterName = sURLVariables[i].split('='); if (sParameterName[0] != sParam && !sParam.includes(sParameterName[0])) { url = url + sParameterName[0] + '=' + sParameterName[1] + '&' } }
    return url.substring(0, url.length - 1);
}
function setCookie(cname, cvalue, exdays) { var d = new Date(); d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000)); var expires = "expires=" + d.toUTCString(); document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/"; }
function getCookie(cname) {
    var name = cname + "="; var decodedCookie = decodeURIComponent(document.cookie); var ca = decodedCookie.split(';'); for (var i = 0; i < ca.length; i++) {
        var c = ca[i]; while (c.charAt(0) == ' ') { c = c.substring(1); }
        if (c.indexOf(name) == 0) { return c.substring(name.length, c.length); }
    }
    return "";
}
document.addEventListener('DOMContentLoaded', function () {
    if ($().uniform) { $('.form-control-uniform').uniform(); $('.form-input-styled').uniform({ fileButtonClass: 'action btn bg-warning' }); }
    if (typeof select2 != 'undefined') { $('.form-control-select2').select2(); }
    var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery')); elems.forEach(function (html) { var switchery = new Switchery(html); });
}); var lang = "en"; if (getCookie("lang") == "ar") { lang = "ar"; }
$(document).ready(function () {
    $(".disabledUntilReady").removeAttr('disabled'); $('.js-copy').click(function () { var text = $(this).attr('data-copy'); var el = $(this); copyToClipboard(text, el); }); if ($().Lazy) { $('.lazy').Lazy(); }
    $('body').on('click', function (e) { $('[data-toggle="popover"]').each(function () { if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) { $(this).popover('hide'); } }); }); if (lang == "ar") { $.extend($.validator.messages, { required: "Ù‡Ø°Ø§ Ø§Ù„Ø­Ù‚Ù„ Ø¥Ù„Ø²Ø§Ù…ÙŠ", remote: "ÙŠØ±Ø¬Ù‰ ØªØµØ­ÙŠØ­ Ù‡Ø°Ø§ Ø§Ù„Ø­Ù‚Ù„ Ù„Ù„Ù…ØªØ§Ø¨Ø¹Ø©", email: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ù†ÙˆØ§Ù† Ø¨Ø±ÙŠØ¯ Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ ØµØ­ÙŠØ­", url: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ù†ÙˆØ§Ù† Ù…ÙˆÙ‚Ø¹ Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ ØµØ­ÙŠØ­", date: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ ØªØ§Ø±ÙŠØ® ØµØ­ÙŠØ­", dateISO: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ ØªØ§Ø±ÙŠØ® ØµØ­ÙŠØ­ (ISO)", number: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ø¯Ø¯ Ø¨Ø·Ø±ÙŠÙ‚Ø© ØµØ­ÙŠØ­Ø©", digits: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø£Ø±Ù‚Ø§Ù… ÙÙ‚Ø·", creditcard: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø±Ù‚Ù… Ø¨Ø·Ø§Ù‚Ø© Ø§Ø¦ØªÙ…Ø§Ù† ØµØ­ÙŠØ­", equalTo: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ù†ÙØ³ Ø§Ù„Ù‚ÙŠÙ…Ø©", extension: "Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ù…Ù„Ù Ø¨Ø§Ù…ØªØ¯Ø§Ø¯ Ù…ÙˆØ§ÙÙ‚ Ø¹Ù„ÙŠÙ‡", maxlength: $.validator.format("Ø§Ù„Ø­Ø¯ Ø§Ù„Ø£Ù‚ØµÙ‰ Ù„Ø¹Ø¯Ø¯ Ø§Ù„Ø­Ø±ÙˆÙ Ù‡Ùˆ {0}"), minlength: $.validator.format("Ø§Ù„Ø­Ø¯ Ø§Ù„Ø£Ø¯Ù†Ù‰ Ù„Ø¹Ø¯Ø¯ Ø§Ù„Ø­Ø±ÙˆÙ Ù‡Ùˆ {0}"), rangelength: $.validator.format("Ø¹Ø¯Ø¯ Ø§Ù„Ø­Ø±ÙˆÙ ÙŠØ¬Ø¨ Ø£Ù† ÙŠÙƒÙˆÙ† Ø¨ÙŠÙ† {0} Ùˆ {1}"), range: $.validator.format("Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ø¯Ø¯ Ù‚ÙŠÙ…ØªÙ‡ Ø¨ÙŠÙ† {0} Ùˆ {1}"), max: $.validator.format("Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ø¯Ø¯ Ø£Ù‚Ù„ Ù…Ù† Ø£Ùˆ ÙŠØ³Ø§ÙˆÙŠ {0}"), min: $.validator.format("Ø±Ø¬Ø§Ø¡ Ø¥Ø¯Ø®Ø§Ù„ Ø¹Ø¯Ø¯ Ø£ÙƒØ¨Ø± Ù…Ù† Ø£Ùˆ ÙŠØ³Ø§ÙˆÙŠ {0}") }); }
    $.validator.setDefaults({
        ignore: 'input[type=hidden], .select2-search__field', errorClass: 'validation-invalid-label', successClass: 'validation-valid-label', validClass: 'validation-valid-label', highlight: function (element, errorClass) { $(element).removeClass(errorClass); }, unhighlight: function (element, errorClass) { $(element).removeClass(errorClass); }, errorPlacement: function (error, element) {
            if (element.parents().hasClass('form-check')) { error.appendTo(element.parents('.form-check').parent()); }
            else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) { error.appendTo(element.parent()); }
            else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) { error.appendTo(element.parent().parent()); }
            else { error.insertAfter(element); }
        },
    }); $('[data-toggle="tooltip"]').tooltip(); popover_placement = 'right'; if (lang == "ar") { popover_placement = 'left'; }
    $('.sidebar-main-toggle').on('click', function (e) { if ($('body').hasClass("sidebar-xs")) { setCookie("hide_sidebar", 1, 365); } else { setCookie("hide_sidebar", 0, 0); } }); ajaxloading = true; spinner_loading_msg = "Updating data"; var submit_btn = null; if (lang == "ar") { spinner_loading_msg = "Ø§Ù„Ø±Ø¬Ø§Ø¡ Ø§Ù„Ø¥Ù†ØªØ¸Ø§Ø± .."; }
    $.ajaxPrefilter(function (options) { if (options.type.toLowerCase() == 'post') { ajaxloading = false; $.blockUI({ message: '<span class="font-weight-semibold"><i class="icon-spinner4 spinner mr-2"></i>&nbsp;' + spinner_loading_msg + '</span>', overlayCSS: { backgroundColor: '#1b2024', opacity: 0.8, zIndex: 1200, cursor: 'wait' }, css: { border: 0, color: '#fff', padding: 0, zIndex: 1201, backgroundColor: 'transparent' } }); } }); $(document).ajaxStop(function () {
        $.unblockUI()
        ajaxloading = true;
    }); $('button[type="submit"]').click(function () {
        submit_btn = $(this); var loadingText = '<i class="fa fa-circle-notch fa-spin"></i>'; if (submit_btn.html() != submit_btn.text()) { var loadingText = '<i class="fa fa-circle-notch fa-spin mr-1"></i>' + submit_btn.text(); }
        if ($(this).html() != loadingText) { submit_btn.data('original-text', $(this).html()); setTimeout(function () { submit_btn.html(loadingText); }, 100); }
        var check_ajaxloading_nterval = setInterval(function () { if (ajaxloading == true) { submit_btn.html(submit_btn.data('original-text')); setTimeout(function () { submit_btn.html(submit_btn.data('original-text')); }, 100); clearInterval(check_ajaxloading_nterval); } }, 300);
    });
}); function startdaterangepicker(id, start, end, targetpage) {
    opens = "left"; ranges = { 'Today': [moment(), moment()], 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)], 'Last 7 Days': [moment().subtract('days', 6), moment()], 'Last 30 Days': [moment().subtract('days', 29), moment()], 'This Month': [moment().startOf('month'), moment().endOf('month')], 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')] }
    separator = ' to '
    applyLabel = 'Apply'
    cancelLabel = 'Cancel'
    startLabel = 'Start date:'
    endLabel = 'End date:'
    fromLabel = 'From'
    toLabel = 'To'
    customRangeLabel = 'Custom Range'
    daysOfWeek = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
    monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
    if (lang == "ar") {
        opens = "right"; ranges = { 'Ø§Ù„ÙŠÙˆÙ…': [moment(), moment()], 'Ø£Ù…Ø³': [moment().subtract('days', 1), moment().subtract('days', 1)], 'Ø¢Ø®Ø± 7 Ø£ÙŠØ§Ù…': [moment().subtract('days', 6), moment()], 'Ø¢Ø®Ø± 30 ÙŠÙˆÙ…': [moment().subtract('days', 29), moment()], 'Ù‡Ø°Ø§ Ø§Ù„Ø´Ù‡Ø±': [moment().startOf('month'), moment().endOf('month')], 'Ø§Ù„Ø´Ù‡Ø± Ø§Ù„Ù…Ø§Ø¶ÙŠ': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')] }
        separator = ' Ø§Ù„Ù‰ '
        applyLabel = 'Ù…ÙˆØ§ÙÙ‚'
        cancelLabel = 'Ø§Ù„ØºØ§Ø¡'
        startLabel = 'ØªØ§Ø±ÙŠØ® Ø§Ù„Ø¨Ø¯Ø¡:'
        endLabel = 'ØªØ§Ø±ÙŠØ® Ø§Ù„Ø§Ù†ØªÙ‡Ø§Ø¡:'
        fromLabel = 'Ù…Ù†'
        toLabel = 'Ø§Ù„Ù‰'
        customRangeLabel = 'ØªØ§Ø±ÙŠØ® Ù…Ø­Ø¯Ø¯'
        daysOfWeek = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
        monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
    }
    $(id).daterangepicker({ opens: (opens), startDate: moment(start), endDate: moment(end), dateLimit: { days: 360 }, showDropdowns: false, showWeekNumbers: true, timePicker: false, timePickerIncrement: 1, timePicker12Hour: true, ranges: ranges, buttonClasses: ['btn btn-sm'], applyClass: 'btn-small btn-primary  btn-block', cancelClass: 'btn-small btn-light btn-block', format: 'MM/DD/YYYY', separator: separator, locale: { applyLabel: applyLabel, cancelLabel: cancelLabel, startLabel: startLabel, endLabel: endLabel, fromLabel: fromLabel, toLabel: toLabel, customRangeLabel: customRangeLabel, daysOfWeek: daysOfWeek, monthNames: monthNames, firstDay: 1 } }); cb(moment(start), moment(end))
    $('#dashboard-report-range').on('apply.daterangepicker', function (ev, picker) { window.location = targetpage + "&startdate=" + picker.startDate.format('YYYY-MM-DD') + "&enddate=" + picker.endDate.format('YYYY-MM-DD'); console.log(picker.startDate.format('YYYY-MM-DD')); console.log(picker.endDate.format('YYYY-MM-DD')); });
}
function cb(start, end) { $('#dashboard-report-range .daterange-custom-display').html(start.format('<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>') + '<em> &#8211; </em>' + end.format('<i>D</i> <b><i>MMM</i> <i>YYYY</i></b>')); }
if (typeof Noty != 'undefined') { Noty.overrideDefaults({ theme: 'limitless', layout: 'topRight', type: 'alert', closeWith: ['button'], timeout: 6000 }); }
function show_notification(text, state, sound) {
    switch (state) {
        case "success": theme = ' alert alert-success alert-styled-left p-0 bg-white'
            break; case "error": theme = ' alert alert-danger alert-styled-left p-0'
            break;
    }
    new Noty({ theme: theme, text: text, type: state, progressBar: true, closeWith: ['button'] }).show();
}
function bootbox_confirm(params, refresh, title, message) {
    default_title = "Confirmation Message"; default_message = "are you sure !"; cancel = "Cancel"; confirm = "Confirm"; if (lang == "ar") { default_title = "Ø±Ø³Ø§Ù„Ø© ØªØ£ÙƒÙŠØ¯"; default_message = "Ù‡Ù„ Ø£Ù†Øª Ù…ØªØ£ÙƒØ¯ !"; cancel = "Ø¥Ù„ØºØ§Ø¡"; confirm = "ØªØ£ÙƒÙŠØ¯"; }
    if (title == "") title = '<i class="far fa-question-circle mr-2 fa-lg"></i>' + default_title; if (message == "") message = default_message; bootbox.confirm({ size: 'small', animate: false, title: title, message: message, buttons: { cancel: { label: '<i class="fa fa-times mr-1"></i>' + cancel }, confirm: { label: '<i class="fa fa-check  mr-1"></i>' + confirm } }, callback: function (result) { if (result) { send_post_reqeust(params, refresh) } } });
}
function validate_submit(form_id, rules, refresh) {
    $(form_id).validate({
        rules: rules, submitHandler: function (form) {
            $(form).ajaxSubmit({
                beforeSubmit: function () { $(form).find(":submit").prop("disabled", true); }, success: function (result) {
                    $(form).find(":submit").prop("disabled", false); if (result.error) { show_notification(result.error, "error", "error") }
                    if (result.success) {
                        show_notification(result.success, "success", "success")
                        if (refresh) { window.location.reload(); }
                    }
                }, error: function (result) { $(form).find(":submit").prop("disabled", false); }
            });
        }
    });
}
function editable_submit(td_id, type, params, refresh) {
    $(td_id).editable({
        type: type, url: 'request/post.php', showbuttons: true, params: params, validate: function (value) {
            if ($.trim(value) == '')
                return 'This field is required';
        }, success: function (data) {
            console.log(data); if (data.error) { show_notification(data.error, "error", "error") }
            if (data.success) {
                show_notification(data.success, "success", "success")
                if (refresh) { window.location.reload(); }
            }
        }
    });
}
function send_post_reqeust(params, refresh) {
    $.post("/request/post.php", params, function (result) {
        if (result.error) { show_notification(result.error, "error", "error") }
        if (result.success) {
            show_notification(result.success, "success", "success")
            if (refresh == 1) { window.location.reload(); }
            if (refresh.length > 3) { $("#" + refresh).remove(); }
        }
    });
}
function set_settings_cookie(name, value) {
    setCookie(name, value, 365)
    window.location.reload();
}
function copyToClipboard(text, el) {
    var copyTest = document.queryCommandSupported('copy'); var elOriginalText = el.attr('data-original-title'); if (copyTest === true) {
        var copyTextArea = document.createElement("textarea"); copyTextArea.value = text; document.body.appendChild(copyTextArea); copyTextArea.select(); try { var successful = document.execCommand('copy'); var msg = successful ? 'Copied!' : 'Whoops, not copied!'; el.attr('data-original-title', msg).tooltip('show'); } catch (err) { console.log('Oops, unable to copy'); }
        document.body.removeChild(copyTextArea); el.attr('data-original-title', elOriginalText); el.removeAttr('data-original-title');
    } else { window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text); }
}
function changeSwitchery(element, checked) { if ((element.is(':checked') && checked == false) || (!element.is(':checked') && checked == true)) { element.parent().find('.switchery').trigger('click'); } }
function timeConverter(UNIX_timestamp) { var a = new Date(UNIX_timestamp * 1000); var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; var year = a.getFullYear(); var month = months[a.getMonth()]; var month = a.getMonth() + 1; var date = a.getDate(); var hour = a.getHours(); var min = a.getMinutes(); var sec = a.getSeconds(); var time = date + '/' + month + '/' + year + ' ' + hour + ':' + min + ':' + sec; return time; }