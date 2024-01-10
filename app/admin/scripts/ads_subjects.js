$(document).ready(function () {
    $('#menu_ads').addClass('active');
});
window.onload = function () {


    $("#loader").show();
    console.log(HOST_NAME);
    $("#results").load(HOST_NAME +  "admin/ads_subjects/", {"cmd": $('#listing_code').val(),"_csrf" : $("#_csrf").val()}); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME +  "admin/ads_subjects/", {
                "page": page,
                "order": order,
                "perpage": perpage,
                "_csrf" : $("#_csrf").val(),
                "cmd": $('#listing_code').val()
            },
            function () { //get content from PHP page
                $(".loading-div").hide(); //once done, hide loading element
            });
    });
};

function loadData() {
    var order = document.getElementById('cmbsort').value;
    var perpage = document.getElementById('cmbnumberPage').value;
    var page = document.getElementById('page_num').value;
    $("#results").load(HOST_NAME +  "admin/ads_subjects/", {
        "_csrf" : $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "cmd": $('#listing_code').val()
    }, function () {
        $(".loading-div").hide(); //once done, hide loading element
    });
}


function sendToAll(id){

    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME +  "admin/ads_subjects/",
        data: "obj=" + id + "&check=" + $('#send_to_all_subjects_code').val(),
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

function sendToSubjects(id){

    LoadElement("#results");
    var adsId = $('#adsId').val();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME +  "admin/ads_subjects/",
        data: "obj=" + id + "&ads_id="  + adsId +  "&check=" + $('#send_to_subjects_code').val() + "&_csrf=" + _csrf,
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


function updateToSubjects(id){

    LoadElement("#results");
    var adsId = $('#adsId').val();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME +  "admin/ads_subjects/",
        data: "obj=" + id + "&ads_id="  + adsId +  "&check= " + $('#update_code').val() +  " &_csrf=" + _csrf,
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

function deleteToSubjects(id){

    LoadElement("#results");
    var adsId = $('#adsId').val();
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME +  "admin/ads_subjects/",
        data: "obj=" + id + "&ads_id="  + adsId +  "&check=" + $('#delete_code').val() +"&_csrf=" + _csrf,
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


function checkElement() {
    if (document.getElementById("txttitle").value == "") {
        alert(" پر کردن عنوان الزامی است");
        return false;
    }
    return true;
}



