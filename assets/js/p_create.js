var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
var orderstatus = {}, tree = { "index": [] };

$("#id_payment_date").attr("max", today);

$(function () {
    bsCustomFileInput.init();
});

$(document).on("change", "#id_group_id", function () {
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "customers/groupcustomers/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (resp) {
                dlog(resp)
                $("#id_customerid").empty().append('<option selected="">Select Customer</option>');
                $.each(resp, function (i_resp, value) {
                    $("#id_customerid").append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
                if (resp.length < 2) { $("#id_customerid").val(resp[0].id).trigger('change'); }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                plog(jqXHR, textStatus, errorThrown);
            });
    } else { reset_customer(); }
});

function reset_customer() {
    $("#id_customerid").val("").empty();
    reset_order();
}

function reset_order() {
    $("#id_order_id").val("").empty();
    reset_cards();
}

function reset_cards() {
    $("#id_clearedpayments").hide();
    $("#tbody_clearedpayment").empty().append('<tr><td colspan="4" class="text-center">No Cleared Payments</td></tr>');
    $("#id_pendingpayments").hide();
    $("#tbody_pendingpayment").empty();
}

$(document).on("change", "#id_customerid", function () {
    reset_order();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "orders/getOrderListByCustomer/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (resp) {
                dlog(resp);
                $.each(resp, function (index, value) {
                    get_orderstatus(value.id, value.po_no);
                });
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                plog(jqXHR, textStatus, errorThrown);
            });
    }
});

function get_orderstatus(po_id, po_no) {
    $.ajax({
        type: "POST",
        url: baseUrl + "orders/getinvoicesforpayments/" + po_id,
        data: po_id,
        dataType: "json",
        encode: true,
    })
        .done(function (resp) {
            dlog(po_no, resp);
            if (resp.payment_pending) {
                tree[po_id] = {}
                tree[po_id]["pending"] = { "index": [] }
                $.each(resp.payment_pending, function (i_pending, value) {
                    get_invoicedetails(po_id, value.id)
                    tree[po_id]["pending"][value.id] = value;
                    tree[po_id]["pending"]["index"].push(value.id);
                });
                $.each(resp.payment_completed, function (i_cleared, value) {
                    tree[po_id]["cleared"][value.id] = value;
                    tree[po_id]["cleared"]["index"].push(value.id);
                });
                $("#id_order_id").append("<option value='" + po_id + "'>" + po_no + "</option>");
                tree["index"].push(po_id);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            plog(jqXHR, textStatus, errorThrown);
        });
}

function get_invoicedetails(po_id, inv_id) {
    $.ajax({
        type: "POST",
        url: baseUrl + "invoices/getdetails/" + inv_id,
        data: inv_id,
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            for (var i in data) {
                tree[po_id]["pending"][inv_id][i] = data[i];
            }
        });
}

$(document).on("change", "#id_order_id", function () {
    $("#id_clearedpayments").show();
    $("#id_pendingpayments").show();
    var orderList = $(this).val();
    $("#tbody_pendingpayment").empty();
    $.each(orderList, function (order_index, orderId) {
        $.each(tree[orderId]["pending"]["index"], function (i_index, Id) {
            payment_row_creator(tree[orderId]["pending"][Id]);
        });
    });
});


function payment_row_creator(d) {
    $("#tbody_pendingpayment").append('<tr id="' + d["id"] + '"></tr>');

    $("#" + d["id"]).append('<td class="align-middle"><div class="icheck-primary d-inline mt-3"><input type="checkbox" id="id_invoice_id_' + d["id"] + '" data-index="' + d["id"] + '" class="checkbox" value="' + d["invoice_no"] + '"><label for="id_invoice_id_' + d["id"] + '">' + d["invoice_no"] + '</label></div></td>');

    $("#" + d["id"]).append('<td class="align-middle">' + d["description"] + '</td>');

    $("#" + d["id"]).append('<td class="align-middle"><input type="hidden" class="row' + d["id"] + '" id="id_basic_value' + d["id"] + '" value="' + d["sub_total"] + '">' + ra(d["sub_total"]) + '</td>');

    $("#" + d["id"]).append('<td class="align-middle"><input type="hidden" class="row' + d["id"] + '" id="id_gst_amount' + d["id"] + '" value="' + (parseFloat(d["invoice_total"]) - parseFloat(d["sub_total"])) + '">' + ra((parseFloat(d["invoice_total"]) - parseFloat(d["sub_total"]))) + '</td>');

    $("#" + d["id"]).append('<td class="align-middle"><input type="hidden" class="row' + d["id"] + '" id="id_invoice_amount' + d["id"] + '" value="' + d["invoice_total"] + '">' + ra(d["invoice_total"]) + '</td>');

    $("#" + d["id"]).append('<td class="align-middle"><input type="hidden"  id="id_receivable_amt' + d["id"] + '" value="' + d["invoice_total"] + '"><input type="hidden"  id="id_balance_amt' + d["id"] + '" value="' + (parseFloat(d["invoice_total"])-500) + '">' + ra(0) + '</td>');

    $("#" + d["id"]).append('<td class="align-middle"><input type="number" id="tds' + d["id"] + '" max="100" min="0" data-base="' + d["sub_total"] + '" data-span="span' + d["id"] + '" class="form-control form-control-sm tdscontrol row' + d["id"] + '" data-tdsamt="id_tds_deducted' + d["id"] + '"><input type="hidden"  id="id_tds_deducted' + d["id"] + '"><span class="text-info" id="span' + d["id"] + '">' + ra(0) + '</span></td>');

    $("#" + d["id"]).append('<td> <input type="number" id="alloc' + d["id"] + '" class="form-control form-control-sm allcate row' + d["id"] + '"></td>');
}

$(document).on("change", ".allcate", function () {
    var orderList = $("#id_order_id").val();
    var receivedamt = 0
    $.each(orderList, function (order_index, orderId) {
        $.each(tree[orderId]["pending"]["index"], function (i_index, Id) {
            var d = tree[orderId]["pending"][Id]
            if ($("#id_invoice_id_" + d["id"]).is(':checked')) {
                receivedamt += parseFloat($("#alloc" + d["id"]).val());
            }
        });
    });
    $("#id_received_amt").val(receivedamt).removeClass('is-invalid');

});

$(document).on("change", ".rvdamt", function () {
    var orderList = $("#id_order_id").val();
    var receivedamt = 0
    $.each(orderList, function (order_index, orderId) {
        $.each(tree[orderId]["pending"]["index"], function (i_index, Id) {
            var d = tree[orderId]["pending"][Id]
            if ($("#id_invoice_id_" + d["id"]).is(':checked')) {
                receivedamt += parseFloat($("#alloc" + d["id"]).val());
            }
        });
    });
    if ($("#id_received_amt").val() != receivedamt) {
        $("#id_received_amt").addClass('is-invalid');
    } else {
        $("#id_received_amt").removeClass('is-invalid');
    }
});

$(document).on("change", ".tdscontrol", function () {
    var spanid = $(this).data("span");
    var tdsamt = $(this).data("tdsamt");
    var basreval = parseFloat($(this).data("base"));
    var ttl = basreval * parseFloat($(this).val()) / 100;
    $("#" + spanid).text(ra(ttl));
    $("#" + tdsamt).val(ttl);
});

$("#quickForm").on('submit', function (e) {
    e.preventDefault();
    var c = 0
    $('.checkbox').each(function (i, obj) {
        var ID = $(this).data("index");
        if ($(this).is(':checked')) {
            $("#id_invoice_id_" + ID).attr("name", "payment_invoice[" + c + "][invoice_id]");
            $("#id_basic_value" + ID).attr("name", "payment_invoice[" + c + "][basic_value]");
            $("#id_gst_amount" + ID).attr("name", "payment_invoice[" + c + "][gst_amount]");
            $("#id_invoice_amount" + ID).attr("name", "payment_invoice[" + c + "][invoice_amount]");
            $("#tds" + ID).attr("name", "payment_invoice[" + c + "][tds_percent]");
            $("#id_tds_deducted" + ID).attr("name", "payment_invoice[" + c + "][tds_deducted]");
            $("#alloc" + ID).attr("name", "payment_invoice[" + c + "][allocated_amt]");
            $("#id_receivable_amt" + ID).attr("name", "payment_invoice[" + c + "][receivable_amt]");
            $("#id_balance_amt" + ID).attr("name", "payment_invoice[" + c + "][balance_amt]");
            c++;
        } else {
            $("#row" + ID).removeAttr("name");
        }
    });
    $.ajax({
        type: 'POST',
        url: baseUrl + "payments/create",
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $('#modalsubmit').attr("disabled", "disabled");
        },
        success: function (response) {
            if (response.status == 1) {
                location.reload();
            } else {
                alert('Submit Failed.<br>Please try again by clicking "Submit".');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            $("#responsemodal").click();
        },
    });
    $("#quickForm").validate({
        rules: {
            group_id: {
                required: true,
            },
            customer_id: {
                required: true,
            },
            order_id: {
                required: true,
            },
            utr_file: {
                required: true,
            },
            cheque_utr_no: {
                required: true,
            },
            received_amt: {
                required: true,
            },
            payment_date: {
                required: true,
            },
        },
        messages: {
            group_id: {
                required: "Select Group ID",
            },
            customer_id: {
                required: "Select Customer.",
            },
            order_id: {
                required: "Select Order PO",
            },
            utr_file: {
                required: "Attach UTR File",
            },
            cheque_utr_no: {
                required: "Please enter cheque or UTR",
            },
            received_amt: {
                required: "Please enter received amount.",
            },
            payment_date: {
                required: "Please enter payment date.",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });
});