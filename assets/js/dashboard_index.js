var dtable;

$(function () {
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        diff = appendcode(datediff(tabledates[index]));
        console.log(duedate);
        $("#due" + value).empty();
        if (diff[2] == '') {
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '">' + diff[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + diff[0] + '">' + duedate + '</span>');
        } else {
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '"><i class="fas fa-caret-' + diff[2] + '"></i> ' + diff[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + diff[0] + '">' + duedate + '</span>');
        }
    });
    $(".select2").select2();
    $(document).ready( function () {
        $('#example1').DataTable({
            "ordering": false,
            "searching": false,
        });
    } );
    // fill_datatable();
});

function fill_datatable(appliedfilter = {}) {
    dtable = $("#example1").DataTable({
        "processing": true,
        "ordering": false,
        "bLengthChange": false,
        "pageLength": 10,
        "order": [],
        "searching": false,
        "columns": [ //data: 0 => invoice_id
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 }
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-href', data[0]).children('td').addClass('sublist pointer align-middle text-center');
        },
        "ajax": {
            url: baseUrl + "dashboard/search/",
            type: "POST",
            data: appliedfilter
        }
    });
}

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
    val = parseInt(val)
    if (val > 24) {
        if (val > 168) {
            val = ['success', parseInt(val / 24) + ' Days', 'up']
            return val
        } else {
            val = ['warning', parseInt(val / 24) + ' Days', 'up']
            return val
        }
    }
    else if (val < -48) {
        val = ['danger', parseInt((val * -1) / 24) + ' Days ago', 'down']
        return val
    }
    else if (0 < val) {
        val = ['warning', 'Tomorrow', 'down']
        return val
    }
    else if (val < -24) {
        val = ['danger', 'Yesterday', 'down']
        return val
    }
    else {
        val = ['warning', 'Today', '']
        return val
    }
}

function datediff(fromdate) {
    // Return value in Hrs.
    return (new Date(fromdate).getTime() / 3600000) - (new Date().getTime() / 3600000);
}