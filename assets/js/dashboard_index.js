var dtable;

$(function () {
    $("#popup").trigger('click');
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        var a = appendcode(datediff(tabledates[index]));
        console.log(duedate);
        $("#due" + value).empty();
        if (a[2] == '') {
            $("#age" + value).append('<span class="description-percentage text-' + a[0] + '">' + a[1] + '</span>');
            $("#pop" + value).append('<span class="description-percentage">' + a[1] + '</span>');
            $("#poprow" + value).css({"background-color": '#f67161', "color": "#f9dd54"});
            $("#due" + value).append('<span class="description-percentage text-' + a[0] + '">' + duedate + '</span>');
        } else {
            $("#age" + value).append('<span class="description-percentage text-' + a[0] + '"><i class="fas fa-caret-' + a[2] + '"></i> ' + a[1] + '</span>');
            $("#pop" + value).append('<span class="description-percentage"><i class="fas fa-caret-' + a[2] + '"></i> ' + a[1] + '</span>');
            if (0 < a[3] && a[3] < 10){
                $("#poprow" + value).css({"background-color": '#f67161', "color": "#FFF"});
            } else if (11 < a[3] && a[3] < 20){
                $("#poprow" + value).css({"background-color": '#FFE77AFF', "color": "#2C5F2DFF"});
            } else if (21 < a[3] && a[3] < 31){
                $("#poprow" + value).css({"background-color": '#2C5F2DFF', "color": "#FFE77AFF"});
            } else {
                $("#poprow" + value).remove();
            }
            $("#due" + value).append('<span class="description-percentage text-' + a[0] + '">' + duedate + '</span>');
        }
    });
    $('#example1').DataTable({
        "ordering": false,
        "searching": false,
    });
    $('#example2').DataTable({
        "ordering": false,
        "searching": false,
    });
});

// function fill_datatable(appliedfilter = {}) {
//     dtable = $("#example1").DataTable({
//         "processing": true,
//         "ordering": false,
//         "bLengthChange": false,
//         "pageLength": 10,
//         "order": [],
//         "searching": false,
//         "columns": [ //data: 0 => invoice_id
//             { data: 1 },
//             { data: 2 },
//             { data: 3 },
//             { data: 4 },
//             { data: 5 }
//         ],
//         createdRow: function (row, data, dataIndex) {
//             $(row).attr('data-href', data[0]).children('td').addClass('sublist pointer align-middle text-center');
//         },
//         "ajax": {
//             url: baseUrl + "dashboard/search/",
//             type: "POST",
//             data: appliedfilter
//         }
//     });
// }

$("#id_startdate").on("change", function () {
    $("#id_enddate").attr('min', $(this).val());
});

$(document).on("click", ".sublist", function () {
    var parent_id = $(this).parent("tr").data('href');
    window.location = baseUrl + 'invoices/view/' + parent_id;
});

$(".update").on("click", function () {
    var f = {};
    if ($("#id_startdate").val()) {
        f.startdate = $("#id_startdate").val()
    }
    if ($("#id_enddate").val()) {
        f.enddate = $("#id_enddate").val()
    }
    if ($("#id_customer").val()) {
        f.customer_id = $("#id_customer").val()
    }
    dtable.destroy();
    fill_datatable(f);
});

function appendcode(val) {
    var val = parseInt(val)
    var day = 0
    if (val > 24) {
        day = parseInt(val / 24)
        if (val > 168) {
            val = ['success', day + ' Days', 'up', day]
            return val
        } else {

            val = ['warning', day + ' Days', 'up', day]
            return val
        }
    }
    else if (val < -48) {
        day = parseInt((val * -1) / 24)
        val = ['danger', day + ' Days ago', 'down', day]
        return val
    }
    else if (0 < val) {
        val = ['warning', 'Tomorrow', 'down', 1]
        return val
    }
    else if (val < -24) {
        val = ['danger', 'Yesterday', 'down', -1]
        return val
    }
    else {
        val = ['warning', 'Today', '', 0]
        return val
    }
}

function datediff(fromdate) {
    // Return value in Hrs.
    return (new Date(fromdate).getTime() / 3600000) - (new Date().getTime() / 3600000);
}