
$.jMaskGlobals = {
    maskElements: 'input,td,span,div',
    dataMaskAttr: '*[data-mask]',
    dataMask: true,
    watchInterval: 300,
    watchInputs: true,
    watchDataMask: false,
    byPassKeys: [9, 16, 17, 18, 36, 37, 38, 39, 40, 91],
    translation: {
        '0': {pattern: /\d/},
        '9': {pattern: /\d/, optional: true},
        '#': {pattern: /\d/, recursive: true},
        'A': {pattern: /[a-zA-Z0-9]/},
        'S': {pattern: /[a-zA-Z]/}
    }
};


function createComboTreeByElement(element, listOfModels) {

    $(element).combotree({
        valueField: 'id',
        textField: 'text',
        prompt: 'یک گزینه انتخاب کنید',
        data: listOfModels,
        loadMsg: 'در حال بارگزاری',
        separator: '،',
        //selected: true,
        onLoadSuccess: function (node, data) {
        },
        onBeforeCheck: function (node, checked) {
        },
        onCheck: function (node, checked) {
        }
    });

    $(element).combotree('tree').tree("collapseAll");

}


function convertArray(array) {
    var map = {};
    for (var i = 0; i < array.length; i++) {
        var obj = array[i];
        obj.children = [];

        map[obj.id] = obj;

        var parent = obj.parent || '#';
        if (!map[parent]) {
            map[parent] = {
                children: []
            };
        }
        map[parent].children.push(obj);
    }

    return map['#'].children;

}

function initialSwitchery(elem) {
    $('#chk_' + elem).on('click', function () {
        if ($(this).is(':checked')) {
            $('#' + elem).val(true);
        } else {
            $('#' + elem).val(false);
        }
    });
}

function toggleSwitch(switch_elem, on) {
    if (on) { // turn it on
        if ($(switch_elem)[0].checked) { // it already is so do
            // nothing
        } else {
            $(switch_elem).trigger('click').attr("checked", "checked"); // it was off, turn it on
        }
    } else { // turn it off
        if ($(switch_elem)[0].checked) { // it's already on so
            $(switch_elem).trigger('click').removeAttr("checked"); // turn it off
        } else { // otherwise
            // nothing, already off
        }
    }
}

var exceptionEnum = {
    "FATAL": 1,
    "ERROR": 2,
    "validationIgnored": 201,
    "tokenInvalid": 103,
    "tokenEmpty": 102,
    "idEmpty": 122,
    "readDataFailed": 152,
    "webUiExceptions": 153,
    "CUSTOMER_RUNTIME_EXCEPTION": 400,
    "CUSTOMER_DATABASE_CONNECTION_CLOSED": 401,
    "CUSTOMER_DATA_ACCESS_EXCEPTION": 402,
    "CUSTOMER_NOT_FOUND_RECORD": 407,
    "RECORD_NOT_FOUND_RECORD": 403,
    "CUSTOMER_PERMISSION_DENIED": 404,
    "COMMODITY_PERMISSION_DENIED": 305,
    "COLLATERAL_PERMISSION_DENIED": 306,
    "SERVER_EXCEPTION": 202,
    "LOAN_RECEIVE_NOT_FOUND_RECORD": 503,
    "LOAN_KINDS_NOT_FOUND_RECORD": 307,
    "REGISTER_APPROVAL_DENIED": 314,
    "BRANCH_NOT_FOUND_RECORD": 219,
    "DEPOSIT_SPECIES_NOT_FOUND_RECORD": 2007
};

var openedToast_formBuilder = null;

var currentRow_formBuilder = null;

$(document).ready(function () {

    //setInterval(function(){SetParentHeight();},1000)

    setTimeout(function () {
        SetParentHeight();
    }, 1000);

    setTimeout(function () {
        SetParentHeight();
    }, 3500);


    //mask for date
    $('.dateTxt').mask("0000/00/00", {placeholder: "____/__/__"});
    $('.timeTxt').mask("00:00", {placeholder: "__:__"});

    //date picker
    $(".dateTxt").pDatepicker({
        format: "YYYY/MM/DD",
        autoClose: true
    });
    $(".dateTxt").val('');


    // show date picker by click icon calendar
    $(document).delegate(".input-group-addon", "click", function () {
        // $(".dateTxt").blur();
        var elem = $(this).parent().closest('div').find('.dateTxt');
        $(elem).focus();
        setTimeout(function () {
            $(elem).focus();
        }, 5);
    });




    $('.chosen').chosen({
        width: '100%',
        no_results_text: 'موردی یافت نشد',
        placeholder_text_single: 'یک گزینه انتخاب کنید',
        placeholder_text_multiple: 'انتخاب گزینه های مورد نظر',
        search_contains: true
    });


    $(document).delegate(".numeric", "keydown", function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


    $(document).delegate(".pointNumeric", "keydown", function (e) {
        // Allow: backspace, delete, tab, escape, and enter
        if (event.keyCode == 110) {
            if ($(this).val().indexOf(".") > -1)
                event.preventDefault();
            else
                return;
        }

        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });

    $(document).delegate('.amount , .price', 'keyup change paste click', function (event) {

        let _maxLength = $(this).prop('maxlength');

        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function (index, value) {

            value = value.replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            if (_maxLength > 0) {
                if (value.length > parseInt(_maxLength)) {
                    value = value.substring(parseInt(value.length - _maxLength))
                }
            }

            return value;
        });
    });


    $(document).delegate('.remove-row-formbuilder', 'click', function () {

        var key = $(this).data('key');
        currentRow_formBuilder = $(this);
        swal({
            title: "هشدار",
            text: "آیا از حذف رکورد مطمئن هستید ؟ ",
            icon: "warning",
            buttons: {
                ok: {
                    text: "" +
                        "بله" +
                        "",
                    value: "delete",
                    visible: true,
                    className: " btn btn-primary  btn-balance-width waves-effect waves-light pointer",
                    closeModal: false,
                },
                cancel: {
                    text: "" +
                        " بازگشت " +
                        "",
                    value: false,
                    visible: true,
                    className: " btn btn-default  btn-balance-width waves-effect waves-light pointer",
                }
            },
            closeOnClickOutside: false,
            closeOnEsc: false,

        }).then((value) => {
            switch (value) {

                case
                "delete": {

                    registerData_FormBuilder = jQuery.grep(
                        registerData_FormBuilder,
                        function (item, index) {
                            return item.recordNumber != key;
                        });

                    if (registerData_FormBuilder.length == 0) {
                        ValidFormBuilder = false;
                    }

                    var table1 = $('#attribute-table').DataTable();
                    var row = table1.row(currentRow_formBuilder.parents('tr'));

                    row.remove();
                    table1.draw();

                    //for (var i = 0; i < registerData_FormBuilder.length; i++) {
                    //registerData_FormBuilder[i].recordNumber = i + 1;

                    //table1.cell(i, 1).data(i + 1);

                    //}


                    currentRow_formBuilder = null;

                    clearElements_FormBuilder($('.cancel-formbulider').parents('form'));

                    window.parent.postMessage('{"funcName":"sweetAlert","parameters": "عملیات با موفقیت انجام شد"}', '*');
                    break;
                }

            }
        });

    });

    $(document).delegate('.edit-row-formbuilder', 'click', function () {

        var key = $(this).data('key');
        for (var i in registerData_FormBuilder) {
            if (registerData_FormBuilder[i].recordNumber == key) {

                if (registerData_FormBuilder[i].type != "checkbox" && registerData_FormBuilder[i].type != "radio") {
                    $('[data-key="' + registerData_FormBuilder[i].hashID + '"]').val(registerData_FormBuilder[i].content);
                }
                else if (registerData_FormBuilder[i].type == "checkbox") {
                    $('[data-key="' + registerData_FormBuilder[i].hashID + '"]').prop('checked', registerData_FormBuilder[i].content);
                }
                else if (registerData_FormBuilder[i].type == "radio") {
                    $('input[type="radio"][data-key="' + registerData_FormBuilder[i].hashID + '"]').each(function (j, obj) {
                        if ($(this).val() == registerData_FormBuilder[i].content) {
                            $(this).prop('checked', true);
                        }
                    });

                }
            }
        }

        currentRow_formBuilder = $(this);
        $('.edit-formbulider').data("key", key);
        $('.chosen').trigger("chosen:updated");
        $('.cancel-formbulider').removeClass("hide");
        $('.edit-formbulider').removeClass("hide");
        $('.register-formbulider').addClass("hide");


    });

    $(document).delegate('.cancel-formbulider', 'click', function () {
        var currentForm = $(this).parents('form');

        clearElements_FormBuilder(currentForm);

    });

    $(document).delegate('.edit-formbulider', 'click', function () {
        var currentForm = $(this).parents('form');

        if (validation_FormBuilder(currentForm) == true) {
            return false;
        }

        var key = $(this).data('key');

        registerData_FormBuilder = jQuery.grep(
            registerData_FormBuilder,
            function (item, index) {
                return item.recordNumber != key;
            });

        var tblRow = [];

        tblRow.push('<td><span class="cursor-pointer padding-5 blue-600 edit-row-formbuilder" data-key="' + key + '"><i class="fa fa-pencil  operation-icon  text-primary datatable-operation-font-size"></i></span>' +
            '<span class="cursor-pointer padding-5 red-600  remove-row-formbuilder" data-key="' + key + '"><i class="fa fa-trash  operation-icon  text-danger datatable-operation-font-size"></i></span></td></tr>');


        tblRow.push(key);
        currentForm.find('input[type=text],input[type=radio],input[type=checkbox],select').each(function (i, obj) {

            if ($(this).attr('name') != undefined) {
                var model;
                if ($(this).attr('type') != 'radio' && $(this).attr('type') != 'checkbox') {
                    model = {
                        hashID: $(this).data('key'),
                        content: $(this).val(),
                        type: null,
                        recordNumber: key
                    }
                    tblRow.push($(this).val());
                }
                else if ($(this).attr('type') == 'checkbox') {
                    model = {
                        hashID: $(this).data('key'),
                        content: $(this).is(':checked'),
                        type: $(this).attr('type'),
                        recordNumber: key
                    }
                    var checkedCheckbox = '';
                    if ($(this).is(':checked')) {
                        checkedCheckbox = 'checked';
                    }
                    tblRow.push('<td><label style="top:3px" class="tgl-checkbox"><input class="tgl tgl-ios module-checkbox" disabled id="" ' + checkedCheckbox + ' name="" type="checkbox"><label class="tgl-btn" for=""></label></label><label class="control-label inline m-r-5" for=""></label></td>');
                    // tblRow.push('<td><div class="checkbox-custom checkbox-primary"><input disabled type="checkbox" ' + checkedCheckbox + ' /><label></label></div></td>');
                }
                else if ($(this).attr('type') == 'radio' && $(this).is(':checked')) {
                    model = {
                        hashID: $(this).data('key'),
                        content: $(this).val(),
                        type: $(this).attr('type'),
                        recordNumber: key
                    }
                    tblRow.push($(this).val());
                }

                if (model != undefined) {
                    registerData_FormBuilder.push(model);
                }

            }
        });


        var table1 = $('#attribute-table').DataTable();
        var row = table1.row(currentRow_formBuilder.parents('tr'));
        row.remove();
        table1.draw();
        currentRow_formBuilder = null;


        var rowNode = table1.row.add(tblRow).draw().node();
        $('#attribute-table tbody tr').addClass('text-center');

        clearElements_FormBuilder(currentForm);

    });


    $(' input[pattern]').on('input', function () {
        var pos = this.selectionStart;
        var re = $(this).attr('pattern');
        $(this).val($(this).val().match(re)[0]);

        // Restore caret position after setting value
        this.setSelectionRange(pos, pos);
    });


    $(".chosen").closest(".form-group").find("select").change(function () {
        $(this).closest(".form-group").removeClass("has-error");
        $(this).closest(".form-group").find(".s-help-block").html("");
    });


    // حذف '.' از تکست باکس
    // $('.non-point').keyup(function (e) {
    $(document).delegate(".non-point", "keyup", function () {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    });


    $('.easy-ctree input').combotree({

        onChange: function (newValue, oldValue) {
            if (newValue !== null && newValue !== "") {
                $(this).closest(".form-group").removeClass("has-error");
                $(this).closest(".form-group").find(".s-help-block").html("");
            }
        }
    });

});

var registerData_FormBuilder = [];

function reset_FormBuilder() {
    registerData_FormBuilder = [];
}

function createElements_FormBuilder(model, flag_float, index) {

    var element = "";

    if ((model.type != 4) && model.isRequired == true) {
        element += '<div class="form-group col-sm-6 required">';
    } else {
        element += '<div class="form-group col-sm-6">';
    }
    // element += '<div class="form-group col-sm-6">';

    element += '<label for="';
    element += model.titleEn;
    element += '" class=" control-label">';
    if (model.type != 4) {
        element += model.titleFa;
    }
    element += '</label>';

    element += '<div class="" style="margin-bottom: 8px;">';

    var element_required = '';
    if (model.isRequired == true) {
        element_required = 'required';
    }

    var element_duplicate = '';
    if (model.isDuplicate == true) {
        element_duplicate = ' duplicate ';
    }

    switch (model.type) {
        case 0://text
            element += '<input type="text" class="input-sm form-control direction-right text-right ' + element_required + element_duplicate + '" data-key="' + model.hashId + '" maxlength="2000" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';

            break;
        case 1://number
            var non_point = flag_float ? ' non-point ' : '';
            element += '<input type="text" class="input-sm form-control numeric direction-left text-left ' + non_point + element_required + element_duplicate + '" data-key="' + model.hashId + '" maxlength="18" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 2://money
            element += '<input type="text" class="input-sm form-control amount direction-left text-left  ' + element_required + element_duplicate + '" data-key="' + model.hashId + '" maxlength="23" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 3://Date
            element += '<input type="text" class="dateTxt datePickerDaynamic input-sm form-control  text-left ' + element_required + element_duplicate + '" data-key="' + model.hashId + '" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 4://CheckBox
            element += '<label class="tgl-checkbox">' +
                '<input class="tgl tgl-ios module-checkbox" data-key="' + model.hashId + '" ' +
                'id="' + model.titleEn.replace(/ /g, '_') + '"' +
                'name="' + model.titleEn.replace(/ /g, '_') + '"' +
                'type="checkbox">' +
                '<label class="tgl-btn" for="' + model.titleEn.replace(/ /g, '_') + '"></label></label>' +
                '<label class="control-label inline m-r-5" for="gain_isActive"> ' + model.titleFa + '</label>';


            break;
        case 5://Radio

            var items = model.selectingText.split(',');

            for (i = 0; i < items.length; i++) {

                var _checked = "";

                if (/*model.isRequired == true && */i == 0) {
                    _checked = " checked='checked'";
                }
                else {
                    _checked = "";
                }

                element += '<div class="radio-custom  direction-right text-right radio-primary radio-inline ' + element_required + element_duplicate + ' "><input ' + _checked + ' data-key="' + model.hashId + '"  name="' + model.titleEn.replace(/ /g, '_') + '" value="' + items[i] + '" class="direction-right text-right" type="radio"><label>';
                element += items[i];
                element += '</label></div>';
            }

            break;
        case 6://combobox
            element += '<select class="input-sm form-control direction-right text-right chosen ' + element_required + element_duplicate + '" data-key="' + model.hashId + '" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '"><option value="">یک گزینه انتخاب کنید</option>';
            if (model.selectingText != null && model.selectingText != '') {
                var items = model.selectingText.split(',');
                for (i = 0; i < items.length; i++) {
                    element += '<option value="' + items[i] + '">' + items[i] + '</option>';
                }
            }
            else {
                //ajax request and get items depend table name
            }
            element += '</select>'
            break;
        default:
            return;
    }
    element += '<span class="s-help-block help-block-message" ></span></div></div>';

    if ((index + 1) % 2 === 0) {
        element += '<div class="lineBreaker"></div>';
    }

    return element;

}

function createTable_FormBuilder(model) {

    var tags = '';
    tags += ("<div class='clearfix margin-top-10'></div>");

    var tblTh = '';
    $.each(model, function (i, item) {

        tblTh += "<th class=\"table-edit\">";
        tblTh += (item.titleFa);
        tblTh += ("</th>");
    });
    tags += ("<table class='table table-striped' style='width: 100%' id='attribute-table'><thead><tr><th class=\"table-edit no-sort\">عملیات</th><th class=\"table-edit\">ردیف</th>" + tblTh + "</tr></thead><tbody></tbody></table>");
    return tags;
}

function activeTags_FormBuilder() {
    $('.table').dataTable();
    $('.chosen').chosen({
        width: '100%',
        no_results_text: 'موردی یافت نشد',
        placeholder_text_single: 'یک گزینه انتخاب کنید',
        placeholder_text_multiple: 'انتخاب گزینه های مورد نظر',
        search_contains: true,

    });
    $(".datePickerDaynamic").pDatepicker({
        format: "YYYY/MM/DD",
        autoClose: true,
    });
    $(".datePickerDaynamic").val('');
}

function validation_FormBuilder(currentForm) {

    var hasError = false;
    currentForm.find('input[type=text],select').each(function (i, obj) {
        var hasError_required = false;

        if ($(this).attr('name') != undefined) {

            //check required
            if ($(this).hasClass('required') && $(this).val() == '') {
                $(this).parents('.form-group').addClass('has-error');
                $(this).parent().find('span.s-help-block').html($(this).parents('.form-group').find('label').html() + ' ' + 'الزامی است ');
                hasError = true;
                hasError_required = true;
            }
            else if ($(this).attr('required') && $(this).val() != '') {
                $(this).parents('.form-group').removeClass('has-error');
                $(this).parent().find('span.s-help-block').html('');

                hasError = vaildation2_FormBuilder($(this), hasError);
                hasError_required = vaildation2_FormBuilder($(this), hasError_required);
            }

            if ($(this).hasClass('required') && $(this).val() != '') {

                hasError = vaildation2_FormBuilder($(this), hasError);
                hasError_required = vaildation2_FormBuilder($(this), hasError_required);
            }


            //check duplicate
            if ((hasError_required == false) && $(this).hasClass('duplicate')) {

                var i = 0;

                /*$(".year_val").each(function () {
                    if (($(this).val() == "" || value == "") || $(this).val() != value)
                        return true;
                    else {
                        i++;
                    }
                });*/

                for (var j = 0; j < registerData_FormBuilder.length; j++) {
                    if ($(this).val() == registerData_FormBuilder[j].content && $(this).data('key') == registerData_FormBuilder[j].hashID &&
                        ($('.edit-formbulider').data("key") == undefined || $('.edit-formbulider').data("key") != registerData_FormBuilder[j].recordNumber))
                        i++;

                }

                // for (var j = 0; j < registerData_FormBuilder1.length; j++) {
                //     if ($(this).val() == registerData_FormBuilder1[j].content && $(this).data('key') == registerData_FormBuilder1[j].commodityAttribute_hashId &&
                //         ($('.edit-formbulider1').data("key") == undefined || $('.edit-formbulider1').data("key") != registerData_FormBuilder1[j].recordNumber))
                //         i++;
                //
                // }

                if (i > 0) {

                    $(this).parents('.form-group').addClass('has-error');
                    $(this).parent().find('span.s-help-block').html($(this).parents('.form-group').find('label').html() + ' ' + 'تکراری است ');
                    hasError = true;

                } else {

                    $(this).parents('.form-group').removeClass('has-error');
                    $(this).parent().find('span.s-help-block').html('');

                    hasError = vaildation2_FormBuilder($(this), hasError);
                }
            }
            else if ($(this).attr('duplicate') && $(this).val() != '') {
                $(this).parents('.form-group').removeClass('has-error');
                $(this).parent().find('span.s-help-block').html('');

                hasError = vaildation2_FormBuilder($(this), hasError);
            }
        }
    });

    currentForm.find('input[type=radio]:checked').each(function (i, obj) {

        //safe html
        var xssReg = new RegExp(/^[^<>]*$/);
        if (!xssReg.test($(this).val())) {
            $(this).parents('.form-group').addClass('has-error');
            $(this).parent().parent().find('span.s-help-block').html('ورود کاراکترهای غیر مجاز');
            hasError = true;
        }
        else {
            $(this).parents('.form-group').removeClass('has-error');
            $(this).parent().parent().find('span.s-help-block').html('');
        }

    });
    return hasError;

}

function vaildation2_FormBuilder(elem, error) {

    var hasError = error;
    var xssReg = new RegExp(/^[^<>]*$/);
    var dateReg = new RegExp(/^(?:1[234]\d{2})(\/)((?:0?[1-6])(\/)(?:0?[1-9]|[12][0-9]|3[01])|(0?[7-9]|1[0-2])(\/)(?:0?[1-9]|[12][0-9]|3[0]))$/);
    var numberReg = new RegExp(/^[0-9]*$/);
    var moneyReg = new RegExp(/^\$?[\d,]+(\.\d*)?$/);

    //safe html
    if (!xssReg.test(elem.val())) {
        elem.parents('.form-group').addClass('has-error');
        elem.parent().find('span.s-help-block').html('ورود کاراکترهای غیر مجاز');
        hasError = true;
    }
    else {
        elem.parents('.form-group').removeClass('has-error');
        elem.parent().find('span.s-help-block').html('');

        if (elem.val().length > 2000) {
            elem.parents('.form-group').addClass('has-error');
            elem.parent().find('span.s-help-block').html('حداکثر 2000 کاراکتر وارد کنید');
            hasError = true;
        }
        else {
            elem.parents('.form-group').removeClass('has-error');
            elem.parent().find('span.s-help-block').html('');
        }
    }

    if (elem.attr('class').indexOf('numeric') != -1 && elem.val() != '') {
        if (!numberReg.test(elem.val())) {


            elem.parents('.form-group').addClass('has-error');
            elem.parent().find('span.s-help-block').html('فقط عدد وارد نمایید');
            hasError = true;
        }
        else {
            elem.parents('.form-group').removeClass('has-error');
            elem.parent().find('span.s-help-block').html('');
        }

        if (elem.val().length > 18) {
            elem.parents('.form-group').addClass('has-error');
            elem.parent().find('span.s-help-block').html('حداکثر 18 کاراکتر وارد کنید');
            hasError = true;
        }
        else {
            elem.parents('.form-group').removeClass('has-error');
            elem.parent().find('span.s-help-block').html('');
        }
    }

    if (elem.attr('class').indexOf('price') != -1 && elem.val() != '') {
        if (!moneyReg.test(elem.val())) {
            elem.parents('.form-group').addClass('has-error');
            elem.parent().find('span.s-help-block').html('فقط عدد وارد نمایید');
            hasError = true;
        }
        else {
            var str = elem.val().split(",");
            var flag = false;
            for (var i = 0; i < str.length; i++) {
                if (i == 0 && isNaN(Number(str[i]))) {
                    flag = true;
                    break;
                }
                if (i > 0 && (str[i].length != 3 || isNaN(Number(str[i])))) {
                    flag = true;
                    break;
                }
            }
            if (flag == false) {
                elem.parents('.form-group').removeClass('has-error');
                elem.parent().find('span.s-help-block').html('');

                if (elem.val().length > 23) {
                    elem.parents('.form-group').addClass('has-error');
                    elem.parent().find('span.s-help-block').html('حداکثر 18 کاراکتر وارد کنید');
                    hasError = true;
                }
                else {
                    elem.parents('.form-group').removeClass('has-error');
                    elem.parent().find('span.s-help-block').html('');
                }

            } else {
                elem.parents('.form-group').addClass('has-error');
                elem.parent().find('span.s-help-block').html('فقط عدد وارد نمایید');
                hasError = true;
            }
        }
    }

    if (elem.attr('class').indexOf('amount') != -1 && elem.val() != '') {
        if (!moneyReg.test(elem.val())) {
            elem.parents('.form-group').addClass('has-error');
            elem.parent().find('span.s-help-block').html('فقط عدد وارد نمایید');
            hasError = true;
        }
        else {
            var str = elem.val().split(",");
            var flag = false;
            for (var i = 0; i < str.length; i++) {
                if (i == 0 && isNaN(Number(str[i]))) {
                    flag = true;
                    break;
                }
                if (i > 0 && (str[i].length != 3 || isNaN(Number(str[i])))) {
                    flag = true;
                    break;
                }
            }
            if (flag == false) {
                elem.parents('.form-group').removeClass('has-error');
                elem.parent().find('span.s-help-block').html('');

                if (elem.val().length > 23) {
                    elem.parents('.form-group').addClass('has-error');
                    elem.parent().find('span.s-help-block').html('حداکثر 18 کاراکتر وارد کنید');
                    hasError = true;
                }
                else {
                    elem.parents('.form-group').removeClass('has-error');
                    elem.parent().find('span.s-help-block').html('');
                }

            } else {
                elem.parents('.form-group').addClass('has-error');
                elem.parent().find('span.s-help-block').html('فقط عدد وارد نمایید');
                hasError = true;
            }
        }
    }

    if (elem.attr('class').indexOf('dateTxt') != -1 && elem.val() != '') {
        if (!dateReg.test(elem.val())) {
            elem.parents('.form-group').addClass('has-error');
            elem.parent().parent().find('span.s-help-block').html('تاریخ وارد شده معتبر نمی باشد');
            hasError = true;
        }
        else {
            elem.parents('.form-group').removeClass('has-error');
            elem.parent().parent().find('span.s-help-block').html('');

            if (elem.val().length > 10) {
                elem.parents('.form-group').addClass('has-error');
                elem.parent().find('span.s-help-block').html('حداکثر 8 کاراکتر وارد کنید');
                hasError = true;
            }
            else {
                elem.parents('.form-group').removeClass('has-error');
                elem.parent().find('span.s-help-block').html('');
            }
        }
    }
    return hasError;

}

function getAttributeValidationList(currentForm) {

    var requstListOfAttributes = [];

    var recordNumber = $('#attribute-table tbody tr').length + 1;


    currentForm.find('input[type=text],input[type=radio],input[type=checkbox],select').each(function (i, obj) {

        if ($(this).attr('name') != undefined) {


            var model = {};


            if ($(this).attr('type') != 'radio' && $(this).attr('type') != 'checkbox') {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).val(),
                    type: null,
                    recordNumber: recordNumber
                }
            }
            else if ($(this).attr('type') == 'checkbox') {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).is(':checked'),
                    type: $(this).attr('type'),
                    recordNumber: recordNumber
                }
                var checkedCheckbox = '';
                if ($(this).is(':checked')) {
                    checkedCheckbox = 'checked';
                }
            }
            else if ($(this).attr('type') == 'radio' && $(this).is(':checked')) {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).val(),
                    type: $(this).attr('type'),
                    recordNumber: recordNumber
                }
            }


            if (model != undefined) {
                requstListOfAttributes.push(model);
            }

        }
    });


    return requstListOfAttributes.concat(registerData_FormBuilder);

}

function getRegisterData_FormBuilder(currentForm) {

    if ($('#attribute-table tbody tr td').length == 1) {
        $('#attribute-table tbody').html("");
    }

    var tblRow = [];
    var recordNumber = $('#attribute-table tbody tr').length + 1;

    tblRow.push('<td><span class="cursor-pointer padding-5 blue-600 edit-row-formbuilder" data-key="' + recordNumber + '"><i class="fa fa-pencil  operation-icon  text-primary datatable-operation-font-size"></i></span>' +
        '<span class="cursor-pointer padding-5 red-600  remove-row-formbuilder" data-key="' + recordNumber + '"><i class="fa fa-trash  operation-icon  text-danger datatable-operation-font-size"></i></span></td></tr>');

    tblRow.push(recordNumber);


    currentForm.find('input[type=text],input[type=radio],input[type=checkbox],select').each(function (i, obj) {

        if ($(this).attr('name') != undefined) {


            var model = {};


            if ($(this).attr('type') != 'radio' && $(this).attr('type') != 'checkbox') {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).val(),
                    type: null,
                    recordNumber: recordNumber
                }
                tblRow.push($(this).val());
            }
            else if ($(this).attr('type') == 'checkbox') {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).is(':checked'),
                    type: $(this).attr('type'),
                    recordNumber: recordNumber
                }
                var checkedCheckbox = '';
                if ($(this).is(':checked')) {
                    checkedCheckbox = 'checked';
                }
                tblRow.push('<td><label style="top:3px" class="tgl-checkbox"><input class="tgl tgl-ios module-checkbox" disabled id="" ' + checkedCheckbox + ' name="" type="checkbox"><label class="tgl-btn" for=""></label></label><label class="control-label inline m-r-5" for=""></label></td>');
            }
            else if ($(this).attr('type') == 'radio' && $(this).is(':checked')) {
                model = {
                    hashID: $(this).data('key'),
                    content: $(this).val(),
                    type: $(this).attr('type'),
                    recordNumber: recordNumber
                }
                tblRow.push($(this).val());
            }


            if (model != undefined) {
                registerData_FormBuilder.push(model);
            }

        }
    });


    if ($.fn.DataTable.isDataTable('#attribute-table')) {
        $('#attribute-table').DataTable().destroy();
    }


    var table = $('#attribute-table').DataTable({"paging": false});

    var rowNode = table.row.add(tblRow).draw().node();
    $('#attribute-table tbody tr').addClass('text-center');

    clearElements_FormBuilder(currentForm);
}


function jsonModelBuilder(thisModel, tblRow, recordNumber) {


    return model;
}


function clearElements_FormBuilder(currentForm) {
    currentForm[0].reset();
    currentForm.closest('form').find(".chosen").trigger("chosen:updated");
    currentForm.closest('form').find(".has-error").removeClass("has-error");
    currentForm.closest('form').find(".s-help-block").html("");

    $('.edit-formbulider').data("key", '');
    $('.cancel-formbulider').addClass("hide");
    $('.edit-formbulider').addClass("hide");
    $('.register-formbulider').removeClass("hide");
}

//3 رقم 3 رقم جداسازی عدد
function formatMoney(str, lengthStr) {

    $(document).delegate('#' + str, "keyup", function () {
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function (index, value) {
            value = value.replace(/,/g, "");
            if (value.length > parseInt(lengthStr)) {
                value = value.substring(0, lengthStr)
            }

            $("#" + str).find('.help-block').css({display: "none"});

            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
}


// ساخت گرید دیتاتیبل درختی
function InitializationTable(treeColumnNumber, tableElem) {

    InitialTree();

    $('.tree-grid').treegrid({
        expanderExpandedClass: 'glyphicon glyphicon-minus',
        expanderCollapsedClass: 'glyphicon glyphicon-plus',
        initialState: 'collapsed',
        'saveState': true,
        treeColumn: 0

    });


    $(tableElem).dataTable({
        dom: '<"pull-left"B><"pull-right"f><"clearfix">t<"clearfix">',
        "ordering": false,
        "paging": false,
        "searching": false
    });

}

function InitialTree() {
    $(".tree-table tbody tr").each(function () {
        var id = $(this).data("id");
        var parent = $(this).data("parent");
        if (id != null && id != undefined) {
            $(this).addClass("treegrid-" + id);
        }

        if (parent != null && parent != undefined) {
            $(this).addClass("treegrid-parent-" + parent);
        }
    });
}


function createElements_FormBuilder2(model) {


    var element = "";

    // element += '<div class="form-group col-sm-6">';

    if ((model.type != 4) && model.isRequired == true) {
        element += '<div class="form-group col-sm-6 required">';
    } else {
        element += '<div class="form-group col-sm-6">';
    }

    element += '<label for="';
    element += model.titleEn;
    element += '" class="col-sm-12 control-label">';
    if (model.type != 4) {
        element += model.titleFa;
    }
    element += '</label>';

    element += '<div class="col-sm-12" style="margin-bottom: 8px;">';

    var element_required = '';
    if (model.isRequired == true) {
        element_required = ' required ';
    }

    var element_duplicate = '';
    if (model.isDuplicate == true) {
        element_duplicate = ' duplicate ';
    }

    element += "<input type=\"hidden\" id=\"" + model.titleEn.replace(/ /g, '_') + "_warehouseIODetail\" value=\"\"name=\"" + model.titleEn.replace(/ /g, '_') + "_warehouseIODetail\" data-key=\"" + model.hashId + "_warehouseIODetail\"/>";
    element += "<input type=\"hidden\" id=\"" + model.titleEn.replace(/ /g, '_') + "_hashId\" value=\"\"name=\"" + model.titleEn.replace(/ /g, '_') + "_hashId\" data-key=\"" + model.hashId + "_hashId\"/>";

    switch (model.type) {
        case 0://text
            element += '<input type="text" class="input-sm form-control direction-right text-right ' + element_required + element_duplicate + '" data-key="' + model.hashId + '" maxlength="2000" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 1://number
            element += '<input type="text" class="input-sm form-control numeric direction-left text-left ' + element_required + element_duplicate + '"  data-key="' + model.hashId + '" maxlength="18" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 2://money
            element += '<input type="text" class="input-sm form-control price direction-left text-left ' + element_required + element_duplicate + '"  data-key="' + model.hashId + '" maxlength="23" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">';
            break;
        case 3://Date
            element += '<div class="input-group"><input type="text" class="dateTxt datePickerDaynamic input-sm form-control  text-left ' + element_required + element_duplicate + '"  data-key="' + model.hashId + '" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '">' +
                ' <span class="input-group-addon">' +
                ' <i class="glyphicon glyphicon-calendar"></i></span>' +
                ' </div>';
            break;
        case 4://CheckBox
            element += '<div class="checkbox-custom checkbox-primary ' + element_required + element_duplicate + '"><input type="checkbox" name="' + model.titleEn.replace(/ /g, '_') + '" data-key="' + model.hashId + '" class="" id="' + model.titleEn.replace(/ /g, '_') + '"/><label>';
            element += model.titleFa;
            element += '</label></div>';
            break;
        case 5://Radio

            var items = model.selectingText.split(',');

            for (i = 0; i < items.length; i++) {

                var _checked = "";

                if (/*model.isRequired == true && */i == 0) {
                    _checked = " checked='checked'";
                }
                else {
                    _checked = "";
                }

                element += '<div class="radio-custom  direction-right text-right radio-primary radio-inline' + element_required + element_duplicate + '"><input ' + _checked + ' data-key="' + model.hashId + '"  name="' + model.titleEn.replace(/ /g, '_') + '" value="' + items[i] + '" class="direction-right text-right" type="radio"><label>';
                element += items[i];
                element += '</label></div>';
            }

            break;
        case 6://combobox
            element += '<select class="input-sm form-control direction-right text-right chosen ' + element_required + element_duplicate + '"  data-key="' + model.hashId + '" name="' + model.titleEn.replace(/ /g, '_') + '" id="' + model.titleEn.replace(/ /g, '_') + '"><option value="">یک گزینه انتخاب کنید</option>';
            if (model.selectingText != null && model.selectingText != '') {
                var items = model.selectingText.split(',');
                for (i = 0; i < items.length; i++) {
                    element += '<option value="' + items[i] + '">' + items[i] + '</option>';
                }
            }
            else {
                //ajax request and get items depend table name
            }
            element += '</select>'
            break;
        default:
            return;
    }
    element += '<span class="s-help-block help-block-message" ></span></div></div>';

    return element;

}

function createTable_FormBuilder2(model) {

    var tags = '';
    tags += ("<div class='clearfix margin-top-10'></div>");

    var tblTh = '';
    $.each(model, function (i, item) {

        // if (i < 8) {
        tblTh += "<th class=\"table-edit\">";
        tblTh += (item.titleFa);
        tblTh += ("</th>");
        // }
    });
    tags += ("<table class='table table-striped table-bordered' style='width: 100%' id='attribute-table'><thead><tr>" +
        "<th class=\"table-edit no-sort\">عملیات</th>" + "<th class=\"table-edit\">ردیف</th>" + tblTh + "</tr>" +
        "</thead><tbody></tbody></table>");

    tags += "<div class=\"\">\n" +
        "            <div class=\"show-pagination-options col-md-6\" id=\"record-per-page\">\n" +
        "                <label for=\"record-per-page-selector\" class=\"\">نمایش</label>\n" +
        "\n" +
        "                <select id=\"record-per-page-selector\" class=\"form-control text-right\">\n" +
        "                    <option value=\"10\">10</option>\n" +
        "                    <option value=\"20\">20</option>\n" +
        "                    <option value=\"50\">50</option>\n" +
        "                    <option value=\"100\">100</option>\n" +
        "                </select>\n" +
        "\n" +
        "                <label class=\"\">\n" +
        "                    از مجموع\n" +
        "                    <span id=\"show-total-records-modal\">10</span>\n" +
        "                    مورد یافت شده\n" +
        "                </label>\n" +
        "            </div>\n" +
        "            <div class=\"col col-md-6 pull-right\">\n" +
        "                <nav id=\"warehouseIOCommodityDetailsPagination\" class=\"pull-left\"></nav>\n" +
        "            </div>\n" +
        "        </div>";
    return tags;
}

function sweetAlertError(message) {

    swal({
        title: "خطا!",
        text: message,
        icon: "error",
        button: {
            text: "بستن",
            value: true,
            visible: true,
            className: " btn btn-danger waves-effect waves-light pointer",
            closeModal: true
        },
        closeOnClickOutside: false,
        closeOnEsc: false
    });
}


function moneyValue(str) {
    if (str != null) {
        return str.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } else
        return "";
}


function recordDelete(hashId, url, dataTable) {

    swal({
        title: "هشدار",
        text: "آیا از حذف رکورد مطمئن هستید ؟ ",
        icon: "warning",
        buttons: {
            ok: {
                text: "" +
                    "بله" +
                    "",
                value: "delete",
                visible: true,
                className: " btn btn-primary  btn-balance-width waves-effect waves-light pointer",
                closeModal: false,
            },
            cancel: {
                text: "" +
                    " بازگشت " +
                    "",
                value: false,
                visible: true,
                className: " btn btn-default  btn-balance-width waves-effect waves-light pointer",
            }
        },
        closeOnClickOutside: false,
        closeOnEsc: false,

    }).then((value) => {
            switch (value) {

                case
                "delete"
                : {

                    var data = {};

                    data["_csrf"] = $("#_csrf").val();
                    data["hashId"] = hashId;

                    $.ajax(url, {
                        type: 'GET',
                        dataType: 'json',
                        data: data,
                        cache: false,
                        enctype: 'application/json',
                        success: function (response) {

                            window.parent.postMessage('{"funcName":"sweetAlert","parameters": "' + response.message + '"}', '*');

                            swal.close();

                            if (dataTable != null) {
                                dataTable.draw();
                            }

                            $(document).trigger('recordDelete');

                        }
                    });
                    break;
                }

            }
        }
    )
    ;
}


function LoadElement(pSelector) {

    $(pSelector).block({
        message: '<i class="icon-spinner4 spinner"></i><span class="text-semibold display-block">لطفا منتظر بمانید...</span>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });

}

function UnLoadElement(pSelector) {

    $(pSelector).unblock();

}


function SetParentHeight() {
    window.parent.postMessage('{"funcName":"ResizeIframe","parameters": "' + document.body.scrollHeight + '"}', '*');
}