$(document).ready(function () {

    $('.contact-form').submit(function(e) {

        e.preventDefault();

        let fullName = $('#fname').val() + " "  + $('#lname').val();
        let email = $('#email').val();
        let title = $('#subject').val();
        let message = $('#message').val();
        console.log(fullName + "-" +email+ "-" +  title+ "-" + message)

        LoadElement(".contact-form");
        $.ajax({
            type: "POST",
            url: HOST_NAME + "contact/",
            data: "name=" + fullName + "&email=" + email + "&title=" + title + "&message=" + message + "&check=" + CONTACT_MESSAGE_CODE,
            dataType: "json",
            cache: false,
            success: function (result) {
                UnLoadElement(".contact-form");
                $(".contact-form")[0].reset();
                if(result.status==="1") {
                    toastr["success"](result.message);
                }
                if(result.status==="0" || result.status==="-1") {
                    toastr["error"](result.message);
                }
                console.log(result);
            },
            error: function (xhr, textStatus, errorThrown) {
                UnLoadElement(".contact-form");
                toastr["error"]("خطا در ارسال داده ها");

            },

        });
    });
});
