$(document).ready(function () {

    //toastr config

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "rtl": true,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


    //handle category filter change

    $('#homeCategoryFilter').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        homeUpdateSubCategory(valueSelected);
    });


    $('#btnLoginMaster').click(function(e){
        e.preventDefault();
        loginHomeMaster();
    });

});


function homeUpdateSubCategory(categoryId){

    if(categoryId==0){
        var _emptySelectHtml = "<option value=''>چیزی انتخاب نشده است</option>";
        $('#homeSubCategoryFilter').html(_emptySelectHtml);
        $("#homeSubCategoryFilter").selectpicker('refresh');
        return;
    }

    LoadElement("#homeFilterContainer");
    $.ajax({
        type: "POST",
        url: HOST_NAME + "home/",
        data: "categoryId=" + categoryId +  "&check=" + GET_SUBCATEGORY_LIST_CODE,
        dataType: "json",
        cache: false,
        success: function (result) {
            console.log(result.html);
            UnLoadElement("#homeFilterContainer");

            if(result.status=="1") {
                toastr["success"](result.message);
                //window.location.replace(result.redirect);
                $('#homeSubCategoryFilter').html(result.html);
                $("#homeSubCategoryFilter").selectpicker('refresh');
                // $('.selectpicker').selectpicker('refresh');
                
            }
            else {
                toastr["error"](result.message);
            }
     
        },
        error: function (xhr, textStatus, errorThrown) {
            UnLoadElement("#homeFilterContainer");
            toastr["error"]("خطا در ارسال داده ها");

        },

    });

}

function homeFilterData(){
    var homeSubjectBaseURL = $('#homeSubjectBaseURL').val();
    var categoryId=$("#homeCategoryFilter option:selected" ).val();
    //var categoryName=$("#homeCategoryFilter option:selected" ).html();
    var subCategoryId=$("#homeSubCategoryFilter option:selected" ).val();
    //var subCategoryName=$("#homeSubCategoryFilter option:selected" ).html();
    var searchQuery = $('#searchQuery').val();
   
    LoadElement("#homeFilterContainer");
    $.ajax({
        type: "POST",
        url: HOST_NAME + "home/",
        data: "categoryId=" + categoryId + "&subCategoryId=" + subCategoryId+ "&searchQuery=" + searchQuery +  "&homeSubjectBaseURL=" + homeSubjectBaseURL + "&check=" + FILTER_DATA_CODE,
        dataType: "json",
        cache: false,
        success: function (result) {
            console.log(result.html);
            UnLoadElement("#homeFilterContainer");

            if(result.status=="1") {
                toastr["success"](result.message);
                console.log(result);
                window.location.replace(result.redirect);  
            }
            else {
                toastr["error"](result.message);
            }
     
        },
        error: function (xhr, textStatus, errorThrown) {
            UnLoadElement("#homeFilterContainer");
            toastr["error"]("خطا در ارسال داده ها");

        },

    });

}


function loginHomeMaster() {

    let username = $('#username_master').val();
    let userpass = $('#userpass_master').val();

    let remember = false; //$('#remember_me:checked').val();
  
    LoadElement("#frmLoginMaster");
    $.ajax({
      type: "POST",
      url: HOST_NAME + "signin/",
      data:
        "username=" + username + "&userpass=" + userpass+ "&remember=" + remember + "&check=" + LOGIN_CODE,
      dataType: "json",
      cache: false,
      success: function (result) {
        console.log(result);
        UnLoadElement("#frmLoginMaster");
        // $("#frmLogin")[0].reset();
        if (result.status == "1") {
          toastr["success"](result.message);
          window.location.replace(result.redirect);
        } else {
          toastr["error"](result.message);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        UnLoadElement("#frmLoginMaster");
        toastr["error"]("خطا در ارسال داده ها");
      },
    });
  }

function LoadElement(pSelector) {

    $(pSelector).block({
        message: '<i class="fas fa-circle-notch fa-spin fa-3x fa-fw" style="color:#FF763A"></i><span class="text-semibold display-block">   </span>',
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


function setRate(){

    var _csrf = $("#_csrf").val();
    var afid = $('#afid').val();
    var sid = $('#sid').val();
    var cid = $('#cid').val();
    var scid = $('#scid').val();
    var pid = $('#pid').val();
    var puid = $('#puid').val();

    $.ajax({
        type: "POST",
        async: true,
        dataType: "json",
        data: "afid=" + afid +"&_csrf=" + _csrf + "&sid=" + sid + "&cid=" + cid + "&scid=" + scid + "&pid=" + pid + "&puid=" + puid + "&check=RATE_OP_CODE" ,
        url: HOST_NAME + "shared/setRate/",
        cache: false,
        success: function (result) {
            console.log(result);
        }
    });

}

function setComment(){

    var _csrf = $("#_csrf").val();
    var afid = $('#afid').val();
    var sid = $('#sid').val();
    var cid = $('#cid').val();
    var scid = $('#scid').val();
    var pid = $('#pid').val();
    var puid = $('#puid').val();

    $.ajax({
        type: "POST",
        async: true,
        dataType: "json",
        data: "afid=" + afid +"&_csrf=" + _csrf + "&sid=" + sid + "&cid=" + cid + "&scid=" + scid + "&pid=" + pid + "&puid=" + puid + "&check=COMMENT_OP_CODE" ,
        url: HOST_NAME + "shared/setComment/",
        cache: false,
        success: function (result) {
            console.log(result);
        }
    });

}