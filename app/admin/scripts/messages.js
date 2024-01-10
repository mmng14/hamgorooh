$(document).ready(function () {
    $('#menu_messages').addClass('active');
    loadData();

    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        LoadElement("#results"); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        var exp = document.getElementById('txtsearch').value;
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;

        $("#results").load(HOST_NAME + "admin/messages/", { "page": page, "order": order, "perpage": perpage,"exp": exp, "cmd": $('#listing_code').val() },
            function () { //get content from PHP page
                $('#page_num').val(page);
                var url = window.location.href;
                window.history.pushState('obj', 'newtitle', HOST_NAME + 'admin/messages/'+ page);
                UnLoadElement("#results");
            });
    });
});


function loadData() {
    LoadElement("#results"); //show loading element
    var order = $('#cmbsort').val();
    var perpage = $('#cmbnumberPage').val();
    var page = $('#txtpagenum').val();
    $("#results").load(HOST_NAME + "admin/messages/", { "page": page, "order": order, "perpage": perpage, "cmd": $('#listing_code').val() }, function () { //get content from PHP page
        UnLoadElement("#results"); //once done, hide loading element
    });
}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/messages/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() + "&_csrf=" + _csrf,
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
        url: HOST_NAME + "admin/messages/",
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

function deleteData(id) {
    var check = $("#delete_code").val();//DELETE_CODE;
    var checkInputs = true;
    var _csrf = $("#_csrf").val();
    if (checkInputs == true) {
        Swal.fire({
            title: "آیا از حذف این گزینه اطمینان دارید؟",
            text: "امکان برگشت این رکود وجود ندارد!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "بله",
            cancelButtonText: "خیر",
        }).then((result) => {
            if (result.isConfirmed) {
                LoadElement("#results");

                $.ajax({
                    url: HOST_NAME + "admin/messages/",
                    type: "POST",
                    data: {
                        obj: id,
                        _csrf: _csrf,
                        check: check,
                    },
                    dataType: "json",
                    success: function (data) {
                        UnLoadElement("#results");
                        if (data.result == "1") {
                            // window.location.reload();
                            toastr["success"]("اطلاعات با موفقیت حذف شد");
                            loadData();
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        toastr["error"]("خطا در انجام عملیات");
                        UnLoadElement("#results");
                    },
                });
            }
        });
    }
}