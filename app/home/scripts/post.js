$(document).ready(function () {

    $('.comment-form').submit(function(e) {

        e.preventDefault();

        var _csrf = $("#_csrf").val();
        var afid = $('#afid').val();
        var sid = $('#sid').val();
        var cid = $('#cid').val();
        var scid = $('#scid').val();
        var pid = $('#pid').val();
        var puid = $('#puid').val();

        let fullName = $('#fullName').val();
        let email = $('#userEmail').val();
        let comment = $('#comment').val();

        LoadElement(".comment-form");
        $.ajax({
            type: "POST",
            url: HOST_NAME + "shared/comment/",
            data: "afid=" + afid +"&_csrf=" + _csrf +  "&sid=" + sid + 
            "&cid=" + cid + "&scid=" + scid + "&pid=" + pid + "&puid=" + puid + 
            "&fullName=" + fullName + "&email=" + email + "&comment=" + comment  
            + "&check=COMMENT_OP_CODE",

            dataType: "json",
            cache: false,
            success: function (result) {
                UnLoadElement(".comment-form");
                $(".comment-form")[0].reset();
                if(result.status==="1") {
                    toastr["success"](result.message);
                }
                if(result.status==="0" || result.status==="-1") {
                    toastr["error"](result.message);
                }
                console.log(result);
            },
            error: function (xhr, textStatus, errorThrown) {
                UnLoadElement(".comment-form");
                toastr["error"]("خطا در ارسال داده ها");

            },

        });
    });
});


function userRate(rate){

    var _csrf = $("#_csrf").val();
    var afid = $('#afid').val();
    var sid = $('#sid').val();
    var cid = $('#cid').val();
    var scid = $('#scid').val();
    var pid = $('#pid').val();
    var puid = $('#puid').val();

    
    LoadElement("#choose_post_rate");
    $.ajax({
        type: "POST",
        async: true,
        dataType: "json",
        data: "afid=" + afid +"&_csrf=" + _csrf +  "&sid=" + sid + "&cid=" + cid + "&scid=" + scid + "&pid=" + pid + "&puid=" + puid + "&rate=" + rate + "&check=RATE_OP_CODE" ,
        url: HOST_NAME + "shared/rate/",
        cache: false,
        success: function (result) {
            console.log(result);
            UnLoadElement("#choose_post_rate");
            if(result.status==="1") {
                toastr["success"](result.message);
            }else{
                toastr["error"](result.message);
            }
        }
    });

}