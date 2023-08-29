var dtable;

$(function () {
    if (popup) { $("#popup").trigger('click'); }
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        var a = appendcode(datediff(tabledates[index]));

        $("#due" + value).empty();
        if (a[2] == '') {
            $("#age" + value).append('<span class="description-percentage text-' + a[0] + '">' + a[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + a[0] + '">' + duedate + '</span>');
        } else {
            $("#age" + value).append('<span class="description-percentage text-' + a[0] + '"><i class="fas fa-caret-' + a[2] + '"></i> ' + a[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + a[0] + '">' + duedate + '</span>');
        }
    });

    fill_datatable()

    $('#example2').DataTable({
        "ordering": false,
        "searching": false,
    });
    $("#ordersummary").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true, "ordering": false,
        "buttons": ["excel"],
        initComplete: function () {
            this.api().columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) { that.search(this.value).draw(); }
                });
            });
        }
    }).buttons().container().appendTo('#ordersummary_wrapper .col-md-6:eq(0)');
    $('#example3').DataTable({
        rowsGroup: [0, 1, 2],
        "ordering": false,
        "searching": false,
    });
});

$(document).on("click", ".hidemon", function () {
    $.ajax({
        type: "POST",
        url: baseUrl + "dashboard/toggleMonitoringOrder/" + parseInt($(this).attr("name")),
        data: parseInt($(this).attr("name")),
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            if (data["disable_monitor"] == 1) { $("#hide" + data["id"]).prop('checked', true) }
            else { $("#hide" + data["id"]).prop('checked', false) }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert("Failed to update Order hide.");
            console.log(jqXHR, textStatus, errorThrown);
        });
});

$(document).on("click", ".ordersummary", function () {
    var parent_id = $(this).parent("tr").data('href');
    window.location = baseUrl + 'orders/view/' + parent_id;
});

$("#id_startdate").on("change", function () {
    $("#id_enddate").attr('min', $(this).val());
});

$(document).on("click", ".sublist", function () {
    var parent_id = $(this).parent("tr").data('href');
    window.location = baseUrl + 'invoices/view/' + parent_id;
});

$(document).on("click", ".ordlist", function () {
    var parent_id = $(this).parent("tr").data('href');
    window.location = baseUrl + 'orders/view/' + parent_id;
});

$(".update").on("click", function () {
    var f = {};
    if ($("#id_startdate").val()) { f['startdate'] = $("#id_startdate").val() }
    if ($("#id_enddate").val()) { f['enddate'] = $("#id_enddate").val() }
    if ($("#id_customer").val()) { f['customer_id'] = $("#id_customer").val() }
    dtable.destroy();
    fill_datatable(f);
});


function fill_datatable(appliedfilter = {}) {
    dtable = $("#example1").DataTable({
        "processing": true,
        "ordering": false,
        "bLengthChange": false,
        "pageLength": 10,
        "order": [],
        "searching": false,
        "columns": [
            { data: 'customer_name' },
            { data: 'invoice_no' },
            { data: 'invoice_date' },
            { data: 'invoice_amount' },
            { data: 'tds_deducted' },
            { data: 'recieved_amount' },
            { data: 'balance_amount' },
            { data: 'due_date' },
            { data: 'due_status' },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-href', data['invoice_id']).children('td').addClass('sublist pointer align-middle text-center');
        },
        "ajax": {
            url: baseUrl + "dashboard/search/",
            type: "POST",
            data: appliedfilter
        }
    });
}

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