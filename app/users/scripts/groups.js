$(document).ready(function () {

    $('#menu_all_subjects').addClass('active');


});



function requestMembershipForSubject(id,name) {
   
    var _csrf = $("#_csrf").val();
    LoadElement("#subject_widget_" + id);
    $.ajax({
        type: "POST",
        url: HOST_NAME + "users/groups/",
        data: "subject_id=" + id + "&subject_name="+ name  + "&_csrf="+ _csrf  + "&check=" + $('#insert_code').val(),
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement("#subject_widget_" + id);
            if (result.status == '1') {
                var _html = "<button class=\"btn  bg-yellow full-width\">درخواست ارسال شد <svg class=\"olymp-happy-face-icon\"><use xlink:href=\"#olymp-happy-face-icon\"></use></svg></button>";
                $('#membership_status_' + id).html(result.html);
                toastr["success"](result.message);
            }else{
                toastr["error"](result.message);
            }

        },
        error: function (error) {
            UnLoadElement("#subject_widget_" + id);
            toastr["error"]("خطا در ارسال اطلاعات");
        }
    });
}

