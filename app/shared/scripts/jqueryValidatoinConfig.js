jQuery.extend(
    jQuery.validator.messages, {
        required: " این فیلد نباید خالی باشد",
        remote: "Please fix this field.",
        email: "ایمیل اشتباه وارد شده است",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "فقط عدد وارد کنید",
        digits: "فقط عدد وارد کنید",
        creditcard: "Please enter a valid credit card number.",
        equalTo: "Please enter the same value again.",
        accept: "فرمت فایل اپلود شده مجاز نیست",
        maxlength: jQuery.validator.format("حداکثر {0} کاراکتر وارد کنید"),
        minlength: jQuery.validator.format("حداقل {0} کاراکتر وارد کنید"),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
        range: jQuery.validator.format("لطفا مقدار بین {0} و {1} باشد."),
        // range: jQuery.validator.format("ورودی صحیح نمی باشد"),
        max: jQuery.validator.format("لطفا یک مقدار کوچکتر یا برابر {0} وارد نمایید"),
        min: jQuery.validator.format("لطفا یک مقدار بزرگتر یا برابر {0} وارد نمایید"),
    }
);


jQuery.validator.setDefaults({
    highlight: function (element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    errorElement: 'span',
    errorClass: 's-help-block',
    errorPlacement: function (error, element) {
        var $formGroup = $(element).closest('.form-group');

        if ($formGroup.find('.s-help-block').length === 0) {
            $formGroup.append('<span id= "' + element.attr("id") + '-error" class="s-help-block"></span>');
        }

        $formGroup.find('.s-help-block').html(error.html());
        $formGroup.find('.s-help-block').css({display: "block"});


    }
});


$(document).ready(function () {

    $.validator.addMethod("accept", function (value, element, param) {

        // Split mime on commas in case we have multiple types we can accept
        var typeParam = typeof param === "string" ? param.replace(/\s/g, "") : "image/*",
            optionalValue = this.optional(element),
            i, file, regex;

        // Element is optional
        if (optionalValue) {
            return optionalValue;
        }

        if ($(element).attr("type") === "file") {

            // Escape string to be used in the regex
            // see: https://stackoverflow.com/questions/3446170/escape-string-for-use-in-javascript-regex
            // Escape also "/*" as "/.*" as a wildcard
            typeParam = typeParam
                .replace(/[\-\[\]\/\{\}\(\)\+\?\.\\\^\$\|]/g, "\\$&")
                .replace(/,/g, "|")
                .replace(/\/\*/g, "/.*");

            // Check if the element has a FileList before checking each file
            if (element.files && element.files.length) {
                regex = new RegExp(".?(" + typeParam + ")$", "i");
                for (i = 0; i < element.files.length; i++) {
                    file = element.files[i];

                    return true;
                    // Grab the mimetype from the loaded file, verify it matches
                    /* if (!(file.name.split("."))[file.name.split(".").length-1].match(regex)) {
                         return false;
                     }*/
                }
            }
        }

        // Either return true because we've validated each file, or because the
        // browser does not support element.files and the FileList feature
        return true;
    }, $.validator.format("فرمت فایل اپلود شده مجاز نیست"));


    $.validator.addMethod("requiredCommodity_userCtrl",
        function (value, element, params) {
            return ($(params[0]).find('input').eq(0).val() !== "");
        }, "این فیلد نباید خالی باشد");


    $.validator.addMethod("correctCommodity_userCtrl",
        function (value, element, params) {
            return !($(params[0]).find('input').eq(0).val() !== "" && $(params[0]).find('input').eq(4).val() !== "");
        }, "کد نامعتبر است");


    $.validator.addMethod("digitStr",
        function (value, element) {
            if (!isNaN(Number(value.replace(new RegExp(',', 'g'), "")))) {
                return true
            }
            else {
                return false;
            }
        }, "لطفا عدد وارد نمایید");


    $.validator.addMethod("treeNotNull",
        function (value, element, param) {
            try {

                var _id = $("#" + param).combotree('getValue');
                return _id !== null && _id !== "";
            }
            catch (e) {
                return false;
            }
        }, 'این فیلد نباید خالی باشد');


    $.validator.addMethod("greaterThan",
        function (value, element, params) {

            if ((value != "" && value != null) && ($(params).val() != "" && $(params).val() != null)) {
                if (!/Invalid/.test(new Date(value))) {
                    return new Date(value) >= new Date($(params).val());
                }
            }
            else return true;
        }, 'تاریخ پایان باید از تاریخ شروع بزرگتر باشد');


    $.validator.addMethod("amountRange",
        function (value, element, params) {
            var min = parseFloat(params[0].replace(/\D/g, ""));
            var max = parseFloat(params[1].replace(/\D/g, ""));
            var amount = parseFloat(value.replace(/\D/g, ""));


            if ((value !== "" && value != null)) {
                if (amount < min || amount > max) {
                    return false;
                }
                else {
                    return true;
                }
            }
            else return true;
        }, 'مبلغ بین {0} و {1} ریال وارد کنید');


    $.validator.addMethod("amountGreaterSum2Param",
        function (value, element, params) {

            var smAmount = Number($(params[0]).val().replace(/\D/g, "")) + Number($(params[1]).val().replace(/\D/g, ""));
            var amount = Number(value.replace(/\D/g, ""));

            if ((value !== "" && value != null)) {
                return amount >= smAmount;
            }
            else return true;
        }, '{2} باید برابر یا بزرگتر از مجموع {3} و {4} باشد');


    $.validator.addMethod("dateGreaterThan",
        function (value, element, params) {

            if ((value != "" && value != null) && ($(params[0]).val() != "" && $(params[0]).val() != null)) {
                if (!/Invalid/.test(new Date(value))) {
                    return new Date(value) >= new Date($(params[0]).val());
                }
            }
            else return true;
        }, 'تاریخ {1} باید از تاریخ {2} بزرگتر یا برابر باشد');


    $.validator.addMethod("dateSmallerThan",
        function (value, element, params) {

            if ((value != "" && value != null) && ($(params[0]).val() != "" && $(params[0]).val() != null)) {
                if (!/Invalid/.test(new Date(value))) {
                    return new Date(value) <= new Date($(params[0]).val());
                }
            }
            else return true;
        }, 'تاریخ {1} باید از تاریخ {2} کوچکتر یا برابر باشد');


    $.validator.addMethod("greaterThanNumber",
        function (value, element, params) {

            if ((value != "" && value != null) && ($(params).val() != "" && $(params).val() != null)) {
                if (!/Invalid/.test(parseFloat(value))) {
                    return parseFloat(value) >= parseFloat($(params).val());
                }
            }
            else return true;
        }, function (value, element) {
            return element.value + " بزرگتر از " + $(value).val() + " نیست";
        });


    $.validator.addMethod("greaterThanDigit",
        function (value, element, params) {

            if ((value != "" && value != null) && ($(params[0]).val() != "" && $(params[0]).val() != null)) {
                if (!/Invalid/.test(value)) {
                    return parseInt(value) >= parseInt($(params[0]).val());
                }
            }
            else return true;
        }, ' {1} باید از {2} بزرگتر باشد');


   /* $.validator.addMethod("postalCode",
        function (value) {


            if (value === "") {
                return true;
            }

            return /(^\d{5}-\d{5}$)/.test(value);


        }, 'کد پستی معتبر وارد کنید');*/


    $.validator.addMethod("dateFrom", function (value, element, params) {

            if (value === "") {
                return true;
            }

            try {
                var dateParam = parseInt(params[0].replace(new RegExp('/', 'g'), ""));
                var dateValue = parseInt(value.replace(new RegExp('/', 'g'), ""));

                if (dateParam === 0) {
                    ndt = new Date();
                    g_y = ndt.getFullYear();
                    g_m = ndt.getMonth() + 1;
                    g_d = ndt.getDate();
                    shamsi = gregorian_to_jalali(g_y, g_m, g_d);

                    var day = (shamsi[2].toString());
                    var month = (shamsi[1].toString());
                    var year = (shamsi[0].toString());

                    if (month.length === 1) {
                        month = "0" + month;
                    }

                    if (day.length === 1) {
                        day = "0" + day;
                    }
                    dateParam = parseInt(year + month + day);
                }
                return dateValue >= dateParam;
            } catch (e) {
                return false;
            }


        },
        $.validator.format('تاریخ قبل از {1} غیر مجاز است'));

    $.validator.addMethod("dynamicFloatNumber", function (value, element) {


        return this.optional(element) || /^\d{0,3}(\.\d{0,1})?$/i.test(value);
    }, "مقدار را به صورت 3 رقم صحیح و 1 رقم اعشاری وارد کنید");

    $.validator.addMethod("dateTo", function (value, element, params) {

            if (value === "") {
                return true;
            }

            try {
                var dateParam = parseInt(params[0].replace(new RegExp('/', 'g'), ""));
                var dateValue = parseInt(value.replace(new RegExp('/', 'g'), ""));

                if (dateParam === 0) {
                    ndt = new Date();
                    g_y = ndt.getFullYear();
                    g_m = ndt.getMonth() + 1;
                    g_d = ndt.getDate();
                    shamsi = gregorian_to_jalali(g_y, g_m, g_d);

                    var day = (shamsi[2].toString());
                    var month = (shamsi[1].toString());
                    var year = (shamsi[0].toString());

                    if (month.length === 1) {
                        month = "0" + month;
                    }

                    if (day.length === 1) {
                        day = "0" + day;
                    }
                    dateParam = parseInt(year + month + day);
                }
                return dateValue <= dateParam;
            } catch (e) {
                return false;
            }


        },
        $.validator.format('تاریخ نمیتواند از تاریخ روز بزرگتر باشد'));


    $.validator.addMethod("amountLength", function (value, element, param) {

            if (value === "") {
                return true;
            }

            try {
                var valueWithoutComma = value.replace(new RegExp(',', 'g'), "");

                return valueWithoutComma.length <= param;

            } catch (e) {
                return false;
            }


        },
        $.validator.format('حداکثر {0} کاراکتر وارد کنید'));


    $.validator.addMethod("exactLengthNumber", function (value, element, param) {

            if (value === "") {
                return true;
            }

            try {
                return value.length == param;

            } catch (e) {
                return false;
            }

        },
        $.validator.format('باید {0} رقم وارد کنید'));


    $.validator.addMethod("notZero",
        function (value, element) {

            if (value == "" || value > 0) {
                if (!/Invalid/.test(value)) {
                    return true;
                }
            }
            else return false;
        }, 'مقدار بزرگتر از صفر وارد نمایید');


    $.validator.addMethod("notZeroMoney",
        function (value, element) {
            var valueMoney = value.replace(/\D/g, "");
            if (valueMoney == "" || valueMoney > 0) {
                if (!/Invalid/.test(valueMoney)) {
                    return true;
                }
            }
            else return false;
        }, 'مقدار بزرگتر از صفر وارد نمایید');

    $.validator.addMethod("dateRange",
        function (value) {

            var month = value.substring(5, 7);
            var day = value.substring(8, 10);
            var year = value.substring(0, 4);

            if (value == "" || value == null)
                return true;

            else if (month.length != 2 || month < 1 || month > 12)
                return false;
            else if ((parseInt(month) > 0 && parseInt(month) < 7) && (day.length != 2 || parseInt(day) < 1 || parseInt(day) > 31))
                return false;
            else if ((parseInt(month) > 6 && parseInt(month) < 13) && (day.length != 2 || parseInt(day) < 1 || parseInt(day) > 30))
                return false;

            else if (month == 12 && day == 30) {
                // a=> تعریف متغیر برای برسی دوره ۸ ساله
                // b=> متغیر شروع سال کبیسه
                // c=> متغیر ورودی توسط کاربر
                var a = 0, b = 1309;
                //
                for (var i = 1309; i <= year - 4; i += 4) {
                    // اضافه کردن یک دوره سال کبیسه
                    b += 4;
                    // اضافه کردن یک دوره برای برسی دوره ۸ ساله
                    a += 1;
                    //
                    if (a % 8 == 0) b++;
                }
                // اگر عدد به دست آمده‌ی ما با سال ورودی یکسان بود آن سال کبیسه می‌باشد در غیر اینصورت کبیسه نمی‌باشد
                if (year != b)
                    return false;
            }

            return (year > 1250 ? true : false);

        }, 'تاریخ را معتبر وارد کنید');



    $.validator.addMethod("postalCode",
        function (value) {

            if (value.toString().length!==10)
            {
                return false;
            }else{
                return true;
            }


        }, 'کد پستی معتبر وارد کنید');



    $.validator.addMethod("justEnglish",
        function (value, element) {
            if (/[^A-Za-z 0-9,\+-]/g.test(value)) {
                return false;
            } else {
                return true;
            }

        }, "فقط اعداد و حروف لاتین مجاز است");


    $.validator.addMethod("justEnglishWithUnderLineAndNoSpace",
        function (value, element) {
            if (/[^A-Za-z 0-9,_]/g.test(value)) {


                return false;
            } else {

                if (value.indexOf(" ") >= 0)
                {
                    return false;

                }
                else{
                    return true;

                }

            }

        }, "فقط اعداد و حروف لاتین مجاز است");

    /*   $.validator.addMethod("justEnglishWithNumber",
           function (value, element) {
               if (/[^A-Za-z 0-9,\+-]/g.test(value)) {
                   return false;
               } else {
                   return true;
               }

           }, "فقط حروف لاتین و رقم وارد کنید");*/

    /*  $.validator.addMethod("justEnglishWithoutSpace",
          function (value, element) {
              if (/[^A-Za-z-_]/g.test(value)) {
                  return false;
              } else {
                  return true;
              }

          }, "فقط حروف لاتین بدون فاصله وارد کنید");*/

    /*   $.validator.addMethod("justPersianWithNumber",
           function (value, element) {
               if (/[^\u0600-\u06FF 0-9,\+-]/g.test(value)) {
                   return false;
               } else {
                   return true;
               }

           }, "فقط اعداد و حروف فارسی مجاز است");
   */
    $.validator.addMethod("justPersian",
        function (value, element) {
            if (/[^\u0600-\u06FF 0-9,\+-,\s]/g.test(value)) {
                return false;
            } else {
                return true;
            }

        }, "فقط اعداد و حروف فارسی مجاز است");


    $.validator.addMethod("noHtmlTag",
        function (value, element) {

            if (/<\/?[^>]+(>|$)/g.test(value)) {
                return false;
            } else {
                return true;
            }
        }, "نباید حاوی تگ های html باشد");


    $.validator.addMethod("checkNationalCode",
        function (input, element) {

            if (input == "") {
                return true;
            }

            if (!/^\d{10}$/.test(input)
                || input == '0000000000'
                || input == '1111111111'
                || input == '2222222222'
                || input == '3333333333'
                || input == '4444444444'
                || input == '5555555555'
                || input == '6666666666'
                || input == '7777777777'
                || input == '8888888888'
                || input == '9999999999')
                return false;
            var check = parseInt(input[9]);
            var sum = 0;
            var i;
            for (i = 0; i < 9; ++i) {
                sum += parseInt(input[i]) * (10 - i);
            }
            sum %= 11;
            return (sum < 2 && check == sum) || (sum >= 2 && check + sum == 11);

        }, "کد ملی اشتباه است");


    // اعتبارسنجی رشته که آیا عددی است یا نه برای مبالغ
    $.validator.addMethod("digitStr",
        function (value, element) {
            if (!isNaN(Number(value.replace(new RegExp(',', 'g'), "")))) {
                return true
            }
            else {
                false
            }
        }, "لطفا عدد وارد نمایید");

    // اعتبارسنجی رشته که براساس زمان باشد
    $.validator.addMethod("time",
        function (value, element) {
            if (!isNaN(Number(value.replace(new RegExp(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/, 'g'), ""))) && value.length == 5) {
                return true
            }
            else {
                false
            }
        }, "لطفا زمان معتبر وارد نمایید");


    //اعتبار سنجی مقدار وارد شده برای رعداد اعشاری
    $.validator.addMethod("floatNumber", function (value, element) {
        return this.optional(element) || /^\d{0,3}(\.\d{0,1})?$/i.test(value);
    }, "مقدار را به صورت 3 رقم صحیح و 1 رقم اعشاری وارد کنید");


    $.validator.addMethod("smallerThan_Amount",

        function (value, element, param) {
            if (value != "" && $(param).val() != "") {
                return parseInt(value.replace(/,/g, "")) <= parseInt($(param).val().replace(/,/g, ""));
            } else return true;
        },
        "مبلغ از باید کوچکتر مساوی مبلغ تا باشد"
    );


    $.validator.addMethod("greaterThan_Amount",
        function (value, element, params) {

            if (value !== "" && value != null && $(params[0]).val() !== "" && $(params[0]).val() != null) {
                return parseInt(value.replace(/,/g, "")) > parseInt($(params[0]).val().replace(/,/g, ""));
            } else return true;
        },
        "{1} باید بزرگتر مساوی {2} باشد"
    );


    // ولیدیشن یوزرکنترل ها
    $.validator.addMethod("errorCollateral",
        function (value, element) {

            if ($("#collateralNumber_UsrCtrl_error").val() == "") {
                return true;
            }
            else {
                return false;
            }
        }, "کد وثیقه نامعتبر است");

    $.validator.addMethod("errorCustomer",
        function (value, element) {

            if ($("#customerNumber_UsrCtrl_error").val() == "") {
                return true
            }
            else {
                return false;
            }
        }, "شماره مشتری نامعتبر است");

    $.validator.addMethod("errorDepositSpecies",
        function (value, element) {

            if ($("#depositSpeciesNumber_UsrCtrl_error").val() == "") {
                return true
            }
            else {
                return false;
            }
        }, "شماره نوع سپرده نامعتبر است");

    $.validator.addMethod("errorLoanKind",
        function (value, element) {

            if ($("#loanKindsSearch_UsrCtrl_error").val() == "") {
                return true
            }
            else {
                return false;
            }
        }, "کد نوع وثیقه نامعتبر است");

    $.validator.addMethod("errorBranch",
        function (value, element) {

            if ($("#branchNumber_UsrCtrl_error").val() == "") {
                return true
            }
            else {
                return false;
            }
        }, "کد شعبه نامعتبر است");

    $.validator.addMethod("errorCommodity",
        function (value, element) {

            if ($("#Commodity_UsrCtrl_error").val() == "") {
                return true
            }
            else {
                return false;
            }
        }, "کد کالا نامعتبر است");


    // $.validator.addMethod("comboTree_required",
    //
    //     function (value, element, param) {
    //
    //         var val = $(param).combotree('getValue');
    //
    //         return !(val === undefined || val == null || val === "");
    //     },
    //     "این فیلد را وارد نمایید"
    // );


    $.validator.addMethod('validIP', function (value) {

        if (value === "") {
            return true;
        }

        var split = value.split('.');
        if (split.length !== 4) {
            return false;
        }

        for (var i = 0; i < split.length; i++) {
            var s = split[i];
            if (isNaN(s) || s.length === 0 || s < 0 || s > 255) {
                return false;
            }
        }

        return true;
    }, ' IP نامعتبر است');


});