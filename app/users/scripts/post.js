var postTable = null;

$(document).ready(function () {});

window.onload = function () {
  LoadElement("#divResults");
  var cat_filter = document.getElementById("category_filter").value;
  var sub_cat_filter = document.getElementById("sub_category_filter").value;
  var this_subject_id = $("#this_subject_id").val();
  var this_category_id = $("#this_category_id").val();
  var this_subcategory_id = $("#this_subcategory_id").val();

  var page = $("#page_num").val();
  $("#results").load(HOST_NAME + "users/posts/", {
    cmd: $("#listing_code").val(), //LISTING_CODE,
    page: page,
    s_id: this_subject_id,
    cf: cat_filter,
    scf: sub_cat_filter,
    _csrf: $("#_csrf").val(),
  }); //load initial records

  UnLoadElement("#divResults");

  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    LoadElement("#divResults"); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    var exp = document.getElementById("txtsearch").value;
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    var cat_filter = $("#this_category_id").val();
    var sub_cat_filter = document.getElementById("sub_category_filter").value;

    $("#results").load(
      HOST_NAME + "users/posts/",
      {
        page: page,
        order: order,
        perpage: perpage,
        cf: cat_filter,
        scf: sub_cat_filter,
        s_id: this_subject_id,
        exp: exp,
        _csrf: $("#_csrf").val(),
        cmd: $("#listing_code").val(), //LISTING_CODE
      },
      function () {
        //get content from PHP page
        $("#page_num").val(page);
        var url = window.location.href;
        window.history.pushState(
          "obj",
          "newtitle",
          HOST_NAME + "users/posts/" + s_id + "/" + page
        );
        UnLoadElement("#divResults");
      }
    );
  });

  $("#imgSearch").click(function () {
    loadData();
  });

  $("#category_filter").change(function () {
    getSubCategories();
    //loadData();
  });

  $("#sub_category_filter").change(function () {
    //loadData();
  });

  $("#cmbnumberPage").change(function () {
    loadData();
  });

  $("#cmbsort").change(function () {
    loadData();
  });

  function loadData() {
    LoadElement("#divResults"); //show loading element
    var page = $("#page_num").val();
    var exp = document.getElementById("txtsearch").value;
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    var cat_filter = document.getElementById("category_filter").value;
    var sub_cat_filter = document.getElementById("sub_category_filter").value;

    $("#results").load(
      HOST_NAME + "users/posts/",
      {
        page: page,
        order: order,
        perpage: perpage,
        cf: cat_filter,
        scf: sub_cat_filter,
        s_id: this_subject_id,
        exp: exp,
        _csrf: $("#_csrf").val(),
        cmd: $("#listing_code").val(), //LISTING_CODE
      },
      function () {
        //get content from PHP page
        $("#page_num").val(page);
        UnLoadElement("#divResults");
      }
    );
  }

  function getSubCategories() {
    console.log("print");
    //var htmlOptions = '<oprion value="1">test</option>';
    //$('#sub_category_filter').html(htmlOptions);
    //$('#sub_category_filter').selectpicker('refresh');
    //$("#sub_category_filter").html(htmlOptions).selectpicker('refresh'); //.empty().append(htmlOptions).selectpicker('refresh').trigger('change');
    var cat_id = document.getElementById("category_filter").value;
    var check = $("#get_subcategory_list_code").val(); // get sub cageory list;
    var checkInputs = true;
  
    if (checkInputs == true) {
      //LoadElement("#results");
      $(".loading-div").show();
      $.ajax({
        url: HOST_NAME + "users/posts/",
        type: "POST",
        data: {
          c: cat_id,
          sc: 0,
          check: check,
          _csrf: $("#_csrf").val(),
        },
        dataType: "json",
        success: function (result) {
          UnLoadElement("#results");
          $(".loading-div").hide();
          console.log(result.html);
          $("#sub_category_filter").html(result.html).selectpicker("refresh");
          //loadData();
        },
        error: function (xhr, textStatus, errorThrown) {
          toastr["error"]("خطا در انجام عملیات");
          //UnLoadElement("#results");
          $(".loading-div").hide();
        },
      });
    }
  }
  
};



function deleteData(id) {
  var subject_id = $("#this_subject_id").val();
  var check = $("#delete_code").val(); // DELETE_CODE;
  var checkInputs = true;

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
        //LoadElement("#results");
        $(".loading-div").show();
        $.ajax({
          url: HOST_NAME + "users/posts/",
          type: "POST",
          data: {
            obj: id,
            s_id: subject_id,
            check: check,
            _csrf: $("#_csrf").val(),
          },
          dataType: "json",
          success: function (data) {
            UnLoadElement("#results");
            $(".loading-div").hide();
            if (data.result == "1") {
              // window.location.reload();
              toastr["success"]("اطلاعات با موفقیت حذف شد");
              location.reload();
              //loadData();
            } else {
              toastr["error"](data.message);
            }
          },
          error: function (xhr, textStatus, errorThrown) {
            toastr["error"]("خطا در انجام عملیات");
            //UnLoadElement("#results");
            $(".loading-div").hide();
          },
        });
      }
    });
  }
}

function checkedAll() {
  var inputs = document.querySelectorAll("input[type='checkbox']");
  if (document.getElementById("selectall").checked) {
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].checked = true;
    }
  } else {
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].checked = false;
    }
  }
}

function checkElement() {
  var inputs = document.querySelectorAll("input[type='checkbox']");
  var count = 0;
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].checked == true) count++;
  }
  if (count == 0) {
    alert("پستی برای حذف انتخاب نشده است");
    return false;
  }
  return true;
}
