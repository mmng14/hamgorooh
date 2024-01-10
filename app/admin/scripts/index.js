$(document).ready(function () {
    $('#menu_home').addClass('active');
    //$('#menu_ads > ul').show();
    //$('#menu_ads_add').addClass('active');

    $('#updateHomePageAdsProgress').hide();
    $('#updateHomePageSubjectsProgress').hide();
    $('#updateHomePageProgress').hide();
    $('#updateHomePageSliderProgress').hide();


});

function updateHomePageAds() {
    
    $('#updateHomePageAdsProgress').show();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/index/",
        data: "check=V32pXXww826AR34HLHLKcbvcg&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                $('#updateHomePageAdsProgress').hide();
            }

        }
    });
}

function updateHomePageSubjects() {
    
    $('#updateHomePageSubjectsProgress').show();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/index/",
        data: "check=V32pXXw4545PItCBfkhkUIOP&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                $('#updateHomePageSubjectsProgress').hide();
            }

        }
    });
}


function updateHomePage() {
    
    $('#updateHomePageProgress').show();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/index/",
        data: "check=V32pX45BQkjKLJHgyw826ARYkhkhkUIOP&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                $('#updateHomePageProgress').hide();
            }

        }
    });
}


function updateHomePageSlider() {
    
    $('#updateHomePageSliderProgress').show();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/index/",
        data: "check=V3CveOPas34GXXww826ARYkhkhkUIOP&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                $('#updateHomePageSliderProgress').hide();
            }

        }
    });
}


