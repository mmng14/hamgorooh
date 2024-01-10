$(document).ready(function () {

    $(document.body).on('change', 'select[name^="user_group_"]', function() {
        let role = $(this).val();
        let uId =  $(this).data('user');
        let gId = document.getElementById('thisCategoryId').value;
        let sId = document.getElementById('thisSubjectId').value;
        setGroupAccess(role,uId,gId,sId);
    })

    $('#menu_users').addClass('active');
    loadData();

    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        LoadElement("#results"); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        var exp = document.getElementById('txtsearch').value;
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        var cat = document.getElementById('thisCategoryId').value;
        var subj = document.getElementById('thisSubjectId').value;

        $("#results").load(HOST_NAME + "group_admin/user_management/", {"cat":cat,"subj":subj, "page": page, "order": order, "perpage": perpage,"exp": exp, "cmd": $("#listing_code").val(),"_csrf" : $("#_csrf").val() },
            function () { //get content from PHP page
                $('#page_num').val(page);
                var url = window.location.href;
                window.history.pushState('obj', 'newtitle', HOST_NAME + 'group_admin/user_management/'+ page);


                UnLoadElement("#results");
            });
    });


    // $('.group-access').on('change',function(){
    //     let role = $(this).val();
    //     let uId =  $(this).data('user');
    //     let gId = document.getElementById('thisCategoryId').value;
    //     setGroupAccess(role,uId,gId);
    // });

});

function loadData() {
    LoadElement("#results"); //show loading element
    var order = $('#cmbsort').val();
    var perpage = $('#cmbnumberPage').val();
    var page = $('#txtpagenum').val();
    var cat = document.getElementById('thisCategoryId').value;
    var subj = document.getElementById('thisSubjectId').value;
    $("#results").load(HOST_NAME + "group_admin/user_management/", { "cat":cat,"subj":subj,"page": page, "order": order, "perpage": perpage, "cmd": $("#listing_code").val(),"_csrf" : $("#_csrf").val() }, function () { //get content from PHP page
        UnLoadElement("#results"); //once done, hide loading element

    });

}

function setGroupAccess(role,uId,gId,sId) {
    LoadElement('#results');
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "group_admin/user_management/",
        data: "subjId=" + sId +"&catId=" + gId + "&userId=" + uId + "&role=" + role + "&check=" + $("#insert_code").val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            console.log(result);
            UnLoadElement('#results');
            if (result.status == '1') {
                toastr["success"](result.message);
            }
            else {
                toastr["error"](result.message);
            }
        }
    });
}