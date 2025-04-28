var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
var orderstatus = {}, tree = { "index": [] };
var utrvalidty = null
var countryCode = 'IN'
var currencyCode = 'INR';

$("#id_payment_date").attr("max", today);

$(function () {
    bsCustomFileInput.init();
});

$(document).on("change", "#id_group_id", function () {
    reset_customer();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "customers/groupcustomers/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (resp) {
                console.log(resp);
                countryCode = resp[0].cnt_code;
                currencyCode = resp[0].for_cur;
                $("#id_customerid").empty().append('<option selected="">Select Customer</option>');
                $.each(resp, function (i_resp, value) {

                    $("#id_customerid").append("<option value='" + value.id + "'>" + value.name + ' - '+ value.state_name + "</option>");
                });
                if (resp.length < 2) { $("#id_customerid").val(resp[0].id).trigger('change'); }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {});
    }
});

function reset_customer() {
    $("#id_customerid").val("").empty();
    tree = { "index": [] }
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
                $.each(resp, function (index, value) {
                    get_orderstatus(value.id, value.po_no);
                });
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
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
            console.log(resp);
            var custPO = []
            tree[po_id] = {}
            tree[po_id]["pending"] = { "index": [] }
            tree[po_id]["proforma"] = { "index": [] }
            if (tree.hasOwnProperty("cleared") == false) { tree["cleared"] = { "index": [] } }
            if (resp.payment_completed) {
                $.each(resp.payment_completed, function (i_cleared, value) {
                    if (tree["cleared"].hasOwnProperty(value.cheque_utr_no) == false) {
                        tree["cleared"][value.cheque_utr_no] = [];
                    }
                    tree["cleared"][value.cheque_utr_no].push(value);
                    if (tree["cleared"]["index"].indexOf(value.cheque_utr_no) < 0) {
                        tree["cleared"]["index"].push(value.cheque_utr_no);
                    }
                });
            }
            fill_cleared_payment()
            // if only Proforma is created
            if (!resp.payment_pending && resp.payment_proforma) {
                $.each(resp.payment_proforma, function (i_pending, value) {
                    value["proforma"] = true;
                    tree[po_id]["pending"][value.id] = value;
                    if (tree[po_id]["pending"]["index"].indexOf(value.id) < 0) {
                        tree[po_id]["pending"]["index"].push(value.id);
                    }
                });
                if (!custPO.includes(po_id)) { custPO.push(po_id); $("#id_order_id").append("<option value='" + po_id + "'>" + po_no + "</option>"); }
            } else if (resp.payment_pending || resp.payment_proforma) {
                // if proforma & invoice is created
                $.each(resp.payment_pending, function (i_pending, value) {
                    value["proforma"] = false;
                    tree[po_id]["pending"][value.id] = value;
                    if (tree[po_id]["pending"]["index"].indexOf(value.id) < 0) { tree[po_id]["pending"]["index"].push(value.id); }
                    if (!custPO.includes(po_id)) { custPO.push(po_id); $("#id_order_id").append("<option value='" + po_id + "'>" + po_no + "</option>"); }
                });
                $.each(resp.payment_proforma, function (i_pending, value) {
                    var notFound = true
                    $.each(resp.payment_pending, function (i_proforma, proval) {
                        if (value["order_id"] == proval["order_id"] && value["customer_id"] == proval["customer_id"] && value["order_total"] == proval["order_total"] && value["description"] == proval["description"]) { notFound = false; }
                    });
                    if (notFound) {
                        value["proforma"] = true;
                        tree[po_id]["proforma"][value.id] = value;
                        if (tree[po_id]["proforma"]["index"].indexOf(value.id) < 0) { tree[po_id]["proforma"]["index"].push(value.id); }
                        if (!custPO.includes(po_id)) { custPO.push(po_id); $("#id_order_id").append("<option value='" + po_id + "'>" + po_no + "</option>"); }
                    }
                });
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { });
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
    $("#id_clearedpayments, #id_pendingpayments").show();
    var orderList = $(this).val();
    $("#tbody_pendingpayment").empty();
    $.each(orderList, function (order_index, orderId) {
        $.each(tree[orderId]["pending"]["index"], function (i_index, Id) {
            payment_row_creator(orderId, tree[orderId]["pending"][Id]);
        });
        $.each(tree[orderId]["proforma"]["index"], function (i_index, Id) {
            payment_row_creator(orderId, tree[orderId]["proforma"][Id], true);
        });
    });
});


function payment_row_creator(o, d, proforma = false) {
    var invoice_base = parseFloat(d["invoice_total"]) - parseFloat(d["igst"]) - parseFloat(d["sgst"]) - parseFloat(d["cgst"]);
    var invoice_gst = parseFloat(d["igst"]) + parseFloat(d["sgst"]) + parseFloat(d["cgst"]);
    var rowID = parseInt(d["id"]);
    if (proforma) { rowID += tree[o]["pending"]["index"].length }
    $("#tbody_pendingpayment").append('<tr id="' + rowID + '"></tr>');

    // Invoice No.
    if (d["proforma"]) {
        $("#" + rowID).append('<td class="align-middle"><div class="icheck-primary d-inline mt-3"><input type="checkbox" id="id_invoice_id_' + rowID + '" data-proforma="1" data-index="' + rowID + '" class="checkbox" value="' + d["id"] + '"><label for="id_invoice_id_' + rowID + '">PI-' + d["invoice_no"] + '</label></div></td>');
    } else {
        $("#" + rowID).append('<td class="align-middle"><div class="icheck-primary d-inline mt-3"><input type="checkbox" id="id_invoice_id_' + rowID + '" data-proforma="0" data-index="' + rowID + '" class="checkbox" value="' + d["id"] + '"><label for="id_invoice_id_' + rowID + '">' + d["invoice_no"] + '</label></div></td>');
    }

    // Description
    $("#" + rowID).append('<td class="align-middle"><input type="hidden"  id="id_order_id' + rowID + '" value="' + o + '">' + d["description"] + '</td>');

    // Base Amount
    $("#" + rowID).append('<td class="align-middle"><input type="hidden" class="row' + rowID + '" id="id_basic_value' + rowID + '" value="' + invoice_base + '">' + ra(invoice_base) + '</td>');

    // GST Amount
    $("#" + rowID).append('<td class="align-middle"><input type="hidden" class="row' + rowID + '" id="id_gst_amount' + rowID + '" value="' + invoice_gst + '">' + ra(invoice_gst) + '</td>');

    // Invoice Amount
    $("#" + rowID).append('<td class="align-middle"><input type="hidden" class="row' + rowID + '" id="id_invoice_amount' + rowID + '" value="' + d["invoice_total"] + '">' + ra(d["invoice_total"]) + '</td>');

    // Paid Amount
    $("#" + rowID).append('<td class="align-middle"><input type="hidden"  id="id_receivable_amt' + rowID + '" value="' + d["balance"] + '"><input type="hidden"  id="id_balance_amt' + rowID + '" value="0">' + ra(d["invoice_total"] - d["balance"]) + '</td>');

    // TDS %
    $("#" + rowID).append('<td class="align-middle">' + freezetds(rowID, invoice_base, d["tds_deducted"], d["tds_percent"]) + '<input type="hidden" value="0" id="id_tds_deducted' + rowID + '"><span class="text-info" style="font-size: small;" id="span' + rowID + '">' + ra(d["tds_deducted"]) + '</span></td>');

    // Allocated Amount
    $("#" + rowID).append('<td> <input type="number" id="alloc' + rowID + '" class="form-control form-control-sm allcate row' + rowID + '" data-tds="' + d["tds_deducted"] + '" data-total="' + d["balance"] + '" data-index="' + rowID + '" max="' + parseFloat(d["balance"] - d["tds_deducted"]).toFixed(2) + '" value=""><span class="text-info" style="font-size: small;">Balance (₹) : ' + parseFloat(d["balance"] - d["tds_deducted"]).toFixed(2) + '</span></td>');
}

$(document).on("change", ".allcate", function () {
    var index = $(this).data('index');
    var invoicetotal = parseFloat($(this).data('total'));
    $("#id_balance_amt" + index).val(invoicetotal - parseFloat($(this).val()) - parseFloat($(this).data('tds')));
    // if ($(this).data('tds') < 1) {}
    //     var orderList = $("#id_order_id").val();
    //     var receivedamt = 0
    //     $.each(orderList, function (order_index, orderId) {
    //         $.each(tree[orderId]["pending"]["index"], function (i_index, Id) {
    //             var d = tree[orderId]["pending"][Id]
    //             if ($("#id_invoice_id_" + d["id"]).is(':checked')) {
    //                 receivedamt += parseFloat($("#alloc" + d["id"]).val());
    //             }
    //         });
    //     });
    //     $("#id_received_amt").val(receivedamt).removeClass('is-invalid');
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

function dupesave() {
    $("#id_save").toggle();
    $("#id_dup_save").toggle();
}

$(document).on("change", ".tdscontrol", function () {
    var spanid = $(this).data("span");
    var tdsamt = $(this).data("tdsamt");
    var index = $(this).data("index");
    var baseval = parseFloat($(this).data("base"));
    var receiveableval = parseFloat($("#id_receivable_amt" + index).val());
    var ttl = 0;
    if ($(this).val()) { ttl = parseFloat((baseval * parseFloat($(this).val()) / 100).toFixed(2)); }
    $("#" + spanid).text(ra(ttl));
    $("#" + tdsamt).val(ttl);
    var max_alloc = parseFloat((receiveableval - ttl).toFixed(2));
    $("#alloc" + index).val(max_alloc).attr("max", max_alloc);
});


function checkme() {
    var c = 0;
    var gatepass = false;
    var amtpass = true;
    $('.checkbox').each(function (i, obj) {
        var ID = $(this).data("index");
        if ($(this).is(':checked')) {
            gatepass = true
            if($("#id_invoice_id_" + ID).data('proforma') == '1')
            {$("#id_invoice_id_" + ID).attr("name", "payment_invoice[" + c + "][proforma_id]");}
            else {$("#id_invoice_id_" + ID).attr("name", "payment_invoice[" + c + "][invoice_id]");}
            $("#id_order_id" + ID).attr("name", "payment_invoice[" + c + "][order_id]");
            $("#id_basic_value" + ID).attr("name", "payment_invoice[" + c + "][basic_value]");
            $("#id_gst_amount" + ID).attr("name", "payment_invoice[" + c + "][gst_amount]");
            $("#id_invoice_amount" + ID).attr("name", "payment_invoice[" + c + "][invoice_amount]");
            $("#tds" + ID).attr("name", "payment_invoice[" + c + "][tds_percent]");
            $("#id_tds_deducted" + ID).attr("name", "payment_invoice[" + c + "][tds_deducted]");
            $("#alloc" + ID).attr("name", "payment_invoice[" + c + "][allocated_amt]");
            $("#id_receivable_amt" + ID).attr("name", "payment_invoice[" + c + "][receivable_amt]");
            $("#id_balance_amt" + ID).attr("name", "payment_invoice[" + c + "][balance_amt]");
            if (parseFloat($("#alloc" + ID).val()) > parseFloat($("#alloc" + ID).attr("max"))) {
                amtpass = false
            }
            c++;
        } else {
            $("#id_order_id" + ID).removeAttr("name");
            $("#id_invoice_id_" + ID).removeAttr("name");
            $("#id_basic_value" + ID).removeAttr("name");
            $("#id_gst_amount" + ID).removeAttr("name");
            $("#id_invoice_amount" + ID).removeAttr("name");
            $("#tds" + ID).removeAttr("name");
            $("#id_tds_deducted" + ID).removeAttr("name");
            $("#alloc" + ID).removeAttr("name");
            $("#id_receivable_amt" + ID).removeAttr("name");
            $("#id_balance_amt" + ID).removeAttr("name");
        }
    });

    if (gatepass && amtpass && utrvalidty) { return true; }
    else if (amtpass != true) { alert('Allocated Amt greater than Balance Amt'); }
    else if (utrvalidty != true) { alert('UTR Exist.'); }
    else { alert('Invoice not selected.'); }
    dupesave();
    return false;
};


$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            dupesave();
            if (checkme()) {
                form.submit();
            }
        },
    });
    $("#quickForm").validate({
        rules: {
            group_id: { required: true, },
            customer_id: { required: true, },
            order_id: { required: true, },
            utr_file: { required: true, },
            cheque_utr_no: { required: true, },
            received_amt: { required: true, },
            payment_date: { required: true, },
        },
        messages: {
            group_id: { required: "Select Group ID", },
            customer_id: { required: "Select Customer.", },
            order_id: { required: "Select Order PO", },
            utr_file: { required: "Attach UTR File", },
            cheque_utr_no: { required: "Please enter cheque or UTR", },
            received_amt: { required: "Please enter received amount.", },
            payment_date: { required: "Please enter payment date.", },
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


function freezetds(id, subtotal, deduct, percent = 0) {
    // Comment Code since tds can be deducted as much times as needed for each invoice
    if (deduct > 0) {
        return '<input type="hidden" id="tds' + id + '" class="form-control form-control-sm row' + id + '" value="0" readonly><input type="number" class="form-control form-control-sm row' + id + '" value="' + percent + '" readonly>'
    }
    return '<input type="number" id="tds' + id + '" max="100" min="0" data-base="' + subtotal + '" data-index="' + id + '" data-span="span' + id + '" class="form-control form-control-sm tdscontrol row' + id + '" data-tdsamt="id_tds_deducted' + id + '" value="' + percent + '" >'
}

function fill_cleared_payment() {
    if ((tree["cleared"]["index"]).length > 0) {
        $("#tbody_clearedpayment").empty()
        $.each(tree["cleared"]["index"], function (i_clear, clear) {
            $("#tbody_clearedpayment").append('<tr id="parent' + clear + '" data-widget="expandable-table" aria-expanded="false"></tr>');
            $("#parent" + clear).append('<td><i class="fas fa-caret-right fa-fw"></i>' + tree["cleared"][clear][0]["payment_date"] + '</td>');
            $("#parent" + clear).append('<td>' + tree["cleared"][clear][0]["received_amt"] + '</td>');
            $("#parent" + clear).append('<td>' + tree["cleared"][clear][0]["cheque_utr_no"] + '</td>');
            $("#parent" + clear).append('<td><a data-href="' + baseUrl + 'utr_file/' + tree["cleared"][clear][0]["utr_file"] + '" class="pdf">' + tree["cleared"][clear][0]["utr_file"] + '</a></td>');
            $("#tbody_clearedpayment").append('<tr class="expandable-body d-none"><td colspan="4"><div class="p-0" ><table class="table table-hover m-0" style="width: 100%;"><thead><tr><th class="text-info">Invoice No.</th><th class="text-info">Base</th><th class="text-info">GST</th><th class="text-info">Invoice</th><th class="text-info">TDS %</th><th class="text-info">Allocated Amount</th></tr></thead><tbody id="child' + clear + '"><tbody></table></div></td></tr>');
            $.each(tree["cleared"][clear], function (i_clearpay, clearpay) {
                $("#child" + clear).append('<tr data-widget="expandable-table" aria-expanded="false"><td class="text-info">' + tree["cleared"][clear][i_clearpay]["invoice_no"] + '</td><td class="text-info">' + tree["cleared"][clear][i_clearpay]["basic_value"] + '</td><td class="text-info">' + tree["cleared"][clear][i_clearpay]["gst_amount"] + '</td><td class="text-info">' + tree["cleared"][clear][i_clearpay]["invoice_amount"] + '</td><td class="text-info">' + tree["cleared"][clear][i_clearpay]["tds_percent"] + '</td><td class="text-info">' + tree["cleared"][clear][i_clearpay]["allocated_amt"] + '</td></tr>');
            });
        });
    }
}

$(document).on("focusout", "#id_cheque_utr_no", function () {
    mydata = { cheque_utr_no: $(this).val() };
    $.ajax({
        type: "POST",
        url: baseUrl + "payments/utr_validty/",
        data: mydata,
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            if (data == false) {
                $(".say").remove();
                $("#id_cheque_utr_no")
                    .addClass("is-invalid")
                    .parent()
                    .append(
                        '<span id="id_po_no-error" class="say error invalid-feedback">UTR exist.</span>'
                    );
            } else {
                utrvalidty = true;
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
        });
});

$(document).on("click", ".pdf", function () {
    url = $(this).data("href");
    error =
        '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>';
    $.get(url)
        .done(function (responseText) {
            $("#modal_body")
                .empty()
                .append(
                    '<embed src="' +
                    url +
                    '" type="application/pdf" style="width: 100%; height: 513px;">'
                );
        })
        .fail(function () {
            $("#modal_body").empty().append(error);
        });
    $("#modelpdf").click();
});