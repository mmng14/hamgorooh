$.extend(true, $.fn.dataTable.defaults, {
    "autoWidth": true,
    "pageLength": 10,
    "pagingType": "simple_numbers",
    "scrollX": true,
    "order": [[ 1, "desc" ]],
    "language": {
        "decimal": "",
        "emptyTable": "هیچ موردی برای نمایش یافت نشد",
        "info": "نمایش _START_ تا _END_ از _TOTAL_ مورد",
        "infoEmpty": "",
        "infoFiltered": "(فیلتر شده از مجموع _MAX_ مورد)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "نمایش : _MENU_",
        "loadingRecords": "لطفا کمی صبر کنید...",
        "processing": "",
        "search": "جستجو:",
        "zeroRecords": "هیچ موردی یافت نشد",
        "paginate": {
            "first": "اولین",
            "last": "آخرین",
            "next": "بعدی",
            "previous": "قبلی"
        },
        "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
        }
    },
    /*
        "dom": '<"pull-right"f><"pull-left"B><"line-breaker">t<"line-breaker"><"pull-right"l><"pull-right margin-right-10"i><"pull-left"p><"line-breaker">',
    */
    "dom": '<"pull-right"f><"pull-left"B><"pull-left margin-left-10"l><"line-breaker">t<"line-breaker"><"pull-right "i><"pull-left"p><"line-breaker">',
    buttons: {

        buttons: [
            {
                extend: 'copyHtml5',
                className: 'btn btn-default',
                text: '<span data-toggle="tooltip" data-placement="bottom" title="کپی"><i class=" icon-copy4" aria-hidden="true"></i></span>',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'excelHtml5',
                className: 'btn btn-default',
                text: '<span data-toggle="tooltip" data-placement="bottom" title="اکسل"><i class="icon-file-excel" aria-hidden="true"></i></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            /*{
                extend: 'pdfHtml5',
                className: 'btn btn-info',
                text: '<span data-toggle="tooltip" data-placement="bottom" title="پی دی اف"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },*/
            {
                extend: 'print',
                text: '<span data-toggle="tooltip" data-placement="bottom" title="چاپ"><i class=" icon-printer2" aria-hidden="true"></i></span>',
                className: 'btn btn-default'
            },
            {
                extend: 'colvis',
                text: '<span data-toggle="tooltip" data-placement="bottom" title="جزئیات">' +
                    '<i class="icon-three-bars" aria-hidden="true"></i>' +
                    '&nbsp;' +
                    '<span class="caret"></span>' +
                    '</span>',
                className: 'btn btn-default bg-blue datatable-column-font-size'
            }
        ]
    },
    "drawCallback": function( settings ) {
        $('[data-toggle="tooltip"]').tooltip();
        SetParentHeight();
    },
    "columnDefs":
        [
            {
                "searchable": false,
                "orderable": false,
                "targets": 0
            }
        ]
    ,
    /*"drawCallback": function (settings) {
        $('[data-toggle="tooltip"]').tooltip();
    }*/
    /* columnDefs: [
         {orderable: false, targets: -1}
    /*,
     fixedColumns: {
         leftColumns: 1,
         rightColumns: 1
     }*/
});








function initialClientSideDataTableZeroRowOperation(tableBody,$_tableSelector ) {

    $($_tableSelector + ' tbody').html(tableBody);


    var table =   $($_tableSelector).DataTable({
        "columnDefs":
            [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "searchable": false,
                    "orderable": true,
                    "targets": 1
                }
            ]
    });

    table.on('order.dt search.dt', function () {
        table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    SetParentHeight();
    return table;

}





function initialClientSideDataTable(tableBody,$_tableSelector ) {

    $($_tableSelector + ' tbody').html(tableBody);


    var table =   $($_tableSelector).DataTable({
        "columnDefs":
            [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "searchable": false,
                    "orderable": true,
                    "targets": 1
                }
            ]
    });

    table.on('order.dt search.dt', function () {
        table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });


    return table;

}




function initialClientSideDataTableFullCustomOption(tableBody,$_tableSelector,options ) {

    $($_tableSelector + ' tbody').html(tableBody);





    var table =   $($_tableSelector).DataTable(options);


    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    //SetParentHeight();
    return table;

}



function initialClientSideDataTableCustomOptionsWithoutOperation(tableBody,$_tableSelector,options ) {

    $($_tableSelector + ' tbody').html(tableBody);





    var table =   $($_tableSelector).DataTable(options);



    table.on('order.dt search.dt', function () {
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });
    //SetParentHeight();

    return table;

}


function initialClientSideDataTableCustomOptions(tableBody,$_tableSelector,options ) {

    $($_tableSelector + ' tbody').html(tableBody);





    var table =   $($_tableSelector).DataTable(options);



    table.on('order.dt search.dt', function () {
        table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    //SetParentHeight();
    return table;

}

function initialClientSideDataTableWithoutSort(tableBody,$_tableSelector ) {

    $($_tableSelector + ' tbody').html(tableBody);



    var options = {};

    options["paging"] = true;
    options["ordering"] = false;
    options["info"] = true;
    options["searching"] = true;


    var table =   $($_tableSelector).DataTable(options);




    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    SetParentHeight();
    return table;

}


function initialClientSideDataTableWithOutOptions(tableBody,$_tableSelector,height) {

    $($_tableSelector + ' tbody').html(tableBody);


    var options = {};

    options["paging"] = false;
    options["ordering"] = true;
    options["info"] = false;
    options["searching"] = false;
    options["dom"] = "t";

    if (height!=null&&height>0){
        options["scrollY"] = height+"px";
        options["scrollCollapse"] = true;
    }






    var table =   $($_tableSelector).DataTable(options);

    table.on('order.dt search.dt', function () {
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    //SetParentHeight();
    return table;

}


function dataTableConfiguration($_tableSelector , table) {

    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });


}

function clearSelectedRow(tableName) {
    $(tableName + ' tbody').find('tr').removeClass("selected");
}


function initialRawDataTable(tableBody,$_tableSelector ) {

    $($_tableSelector + ' tbody').html(tableBody);


    var table =   $($_tableSelector).DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        buttons: []
    });

    // table.on('order.dt search.dt', function () {
    //     table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
    //         cell.innerHTML = i + 1;
    //     });
    // }).draw();


    $($_tableSelector + ' tbody').on('click', 'tr', function () {
        $(this).parents('tbody').find('tr').removeClass("selected");
        $(this).addClass('selected');
    });

    //SetParentHeight();
    return table;

}


