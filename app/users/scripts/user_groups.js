$(document).ready(function () {

    $('#menu_my_subjects').addClass('active');


    // $(document.body).on('change', 'select[name^="user_group_"]', function() {
    //     let role = $(this).val();
    //     let uId =  $(this).data('user');
    //     let gId = document.getElementById('thisCategoryId').value;
    //     let sId = document.getElementById('thisSubjectId').value;
    //     setGroupAccess(role,uId,gId,sId);
    // })
    //
    // $('#menu_users').addClass('active');
    // loadData();
    //
    // $("#results").on("click", ".pagination a", function (e) {
    //     e.preventDefault();
    //     LoadElement("#results"); //show loading element
    //     var page = $(this).attr("data-page"); //get page number from link
    //     var exp = document.getElementById('txtsearch').value;
    //     var order = document.getElementById('cmbsort').value;
    //     var perpage = document.getElementById('cmbnumberPage').value;
    //     var cat = document.getElementById('thisCategoryId').value;
    //     var subj = document.getElementById('thisSubjectId').value;
    //
    //     $("#results").load(HOST_NAME + "app/controllers/group_admin/ajax/ajax_user_management.php", {"cat":cat,"subj":subj, "page": page, "order": order, "perpage": perpage,"exp": exp, "cmd": "S271ff22518A" },
    //         function () { //get content from PHP page
    //             $('#page_num').val(page);
    //             var url = window.location.href;
    //             window.history.pushState('obj', 'newtitle', HOST_NAME + 'group_admin/user_management/'+ page);
    //
    //
    //             UnLoadElement("#results");
    //         });
    // });
    //


});





// function loadData() {
//     LoadElement("#results"); //show loading element
//     var order = $('#cmbsort').val();
//     var perpage = $('#cmbnumberPage').val();
//     var page = $('#txtpagenum').val();
//     var cat = document.getElementById('thisCategoryId').value;
//     var subj = document.getElementById('thisSubjectId').value;
//     $("#results").load(HOST_NAME + "app/controllers/group_admin/ajax/ajax_user_management.php", { "cat":cat,"subj":subj,"page": page, "order": order, "perpage": perpage, "cmd": "S271ff22518A" }, function () { //get content from PHP page
//         UnLoadElement("#results"); //once done, hide loading element
//
//     });
//
// }



// function setGroupAccess(role,uId,gId,sId) {
//     LoadElement('#results');
//     $.ajax({
//         type: "POST",
//         url: HOST_NAME + "app/controllers/group_admin/ajax/ajax_user_management.php",
//         data: "subjId=" + sId +"&catId=" + gId + "&userId=" + uId + "&role=" + role + "&check=S2p5kk82XzrTPTYjkhuihiUIYYTIU",
//         dataType: "json",
//         cache: false,
//         success: function (result) {
//             console.log(result);
//             UnLoadElement('#results');
//             if (result.status == '1') {
//                 toastr["success"](result.message);
//             }
//             else {
//                 toastr["error"](result.message);
//             }
//         }
//     });
// }