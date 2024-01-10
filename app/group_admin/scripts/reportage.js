$(document).ready(function () {
    $('#menu_reportage').addClass('active');
    $(".loading-div").show();
});

window.onload = function () {


    $("#results").load(HOST_NAME + "group_admin/reportage/", {"cmd": $("#listing_code").val(),"_csrf" : $("#_csrf").val()}); //load initial records
    $(".loading-div").hide();

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "group_admin/reportage/", {
                "page": page,
                "order": order,
                "perpage": perpage,
                "_csrf" : $("#_csrf").val(),
                "cmd": $("#listing_code").val()// LISTING_CODE
            },
            function () { //get content from PHP page
                $(".loading-div").hide(); //once done, hide loading element
            });
    });
};

function loadData() {
    $(".loading-div").show();
    var order = document.getElementById('cmbsort').value;
    var perpage = document.getElementById('cmbnumberPage').value;
    var page = document.getElementById('page_num').value;
    $("#results").load(HOST_NAME + "group_admin/reportage/", {
        "_csrf" : $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "cmd": $("#listing_code").val()// LISTING_CODE
    }, function () {
        $(".loading-div").hide(); //once done, hide loading element
    });
}

function deleteData(id) {
    var check = $("#delete_code").val();// DELETE_CODE;
    var checkInputs = true;
    var _csrf = $("#_csrf").val();
    if (checkInputs == true) {

        swal({

                title: "",
                text: "<div style='text-align:right;font-size:14px;'>"
                    + "<strong> آیا مطمعن هستید که قصد حذف این گزینه  را دارید؟ </strong>"
                    + "</div>"
                ,

                showCancelButton: true,
                confirmButtonColor: "#4fbaaf",
                confirmButtonText: "بله",
                className: "confirm-swal-btn",
                cancelButtonColor: "#EF5350",
                cancelButtonText: "خیر",
                closeOnConfirm: true,
                //imageUrl: '/Content/assets/images/question.png',
                html: true,
                closeOnCancel: true

            },
            function (isConfirm) {
                if (isConfirm) {

                   // LoadElement('#results');
                    $(".loading-div").show();
                    $.ajax({
                        url: HOST_NAME + "group_admin/reportage/",
                        type: 'POST',
                        data: {
                            obj: id,
                            _csrf : _csrf,
                            check: check,

                        },
                        dataType: "json",
                        success: function (data) {
                            UnLoadElement('#results');
                            if (data.result == "1") {
                                // window.location.reload();
                                loadData();
                            }

                        },
                        error: function (xhr, textStatus, errorThrown) {
                            //UnLoadElement('#results');
                            $(".loading-div").hide();
                        },
                    });

                } else {
                    //Cancel the delete
                }
            });
    }


}

function sendToSubjects(id){

    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "group_admin/reportage/",
        data: "obj=" + id + "&check=" + $('#send_to_subjects_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement("#results");
            if(result.status==="1")
            {
              console.log(result);
            }
            else
            {
                console.log("Failed");
            }

        }
    });

}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "group_admin/reportage/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"deactivate(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }

        }
    });
}

function deactivate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "group_admin/reportage/",
        data: "obj=" + id + "&check=" + $('#deactivate_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"activate(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }

        }
    });
}
