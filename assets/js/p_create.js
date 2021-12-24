var lastSelectedId;
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
var invoice_details = {};
function resetongroup() {
    $("#customerid_id").val("").empty().attr("disabled", true);
    resetoncustomer();
}


$(document).on("change", "#id_group_id", function () {
    resetongroup();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "customers/groupcustomers/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                $("#customerid_id").removeAttr('disabled').append("<option value=''>Select Customer</option>");
                $.each(data, function (index, value) {
                    $("#customerid_id").append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
                if (data.length < 2) {
                    $("#customerid_id").val(data[0].id).trigger('change');
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No customer found against this customer group.");
            });
    }
});

function resetoncustomer() {
    $("#id_orderid").val("").empty().attr("disabled", true);
    resetonorder();
}

$(document).on("change", "#customerid_id", function () {
    resetoncustomer();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "orders/getOrderListByCustomer/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                $("#id_orderid").removeAttr('disabled').append("<option value=''>Select Order</option>");
                $.each(data, function (index, value) {
                    $("#id_orderid").append("<option value='" + value.id + "'>" + value.po_no + ' ' + value.item.substring(3, value.item.length) + "</option>");
                });
                if (data.length < 2) {
                    $("#id_orderid").val(data[0].id).trigger('change');
                }

            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No orders found against this customer.");
            });
    }
});

function resetonorder() {
    $("#id_pending_payments").hide();
    $("#invoice_list_body").empty();
    $("#headid_pending").hide();
    $("#bodyid_pending").empty();
    $("#id_cleared_payments").hide();
    $("#headid_cleared").hide();
    $("#bodyid_cleared").empty();
}

$(document).on("click", ".sublist", function () {
    url = baseUrl + 'utr_file/' + $(this).data("href")
    error = '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>'
    $.get(url)
        .done(function (responseText) {
            a = responseText
            if (a.search("Customer List") < 0) {
                $("#utr_body").empty().append('<embed src="' + url + '" type="application/pdf" style="width: 100%; height: 513px;">');
            } else {
                $("#utr_body").empty().append(error);
            }
        }).fail(function () {
            $("#utr_body").empty().append(error);
        });
    // $("#modal_body").empty().append('<iframe src="'+url+'" width="100%" height="513px">');
    $("#modelutr").click();
});

$("#quickForm").on('submit', function (e) {
    e.preventDefault();
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
                $("#modal_body").empty().append(response.message);
                $("#modalclose").trigger('click');
                $("#modalsubmit").removeAttr("disabled");
                $("#id_orderid").trigger('change');
            } else {
                $("#modal_body").empty().append('Submit Failed.<br>Please try again by clicking "Submit".');
                $("#modalsubmit").removeAttr("disabled");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on("change", "#id_orderid", function () {
    resetonorder();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "orders/getinvoicesforpayments/" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                console.log(data)
                if (data.payment_pending) {
                    invoice_details = {}
                    $("#id_pending_payments").show();
                    $("#headid_pending").show();
                    // Crawling Invoice Id details
                    $.each(data.payment_pending, function (index, value) {
                        $.ajax({
                            type: "POST",
                            url: baseUrl + "invoices/getdetails/" + value.id,
                            data: value.id,
                            dataType: "json",
                            encode: true,
                        })
                            .done(function (data) {
                                console.log('invoice_data', data)
                                invoice_details[data.id] = data;
                                $("#invoice_list_body").append('<div class="card" id="invoice_list_' + index + '"></div>');

                                $("#invoice_list_" + index).append('<div class="card-header" id="card_header_' + index + '"></div>');

                                $("#card_header_" + index).append('<div class="icheck-primary d-inline mt-3">                                                   <input type="radio" id="id_invoice_id_' + index + '" data-invoice="' + value.id + '" data-id="' + index + '" name="invoice_id" class="radio" value="' + value.id + '"><label for="id_invoice_id_' + index + '">' + check_proforma(value.proforma) +'Invoice No. : ' + value.invoice_no + '</label><input type="hidden" id="id_tdsdata_invoice_id_' + index + '" class="payment" value="' + value.id + '"></div>');

                                $("#card_header_" + index).append('<div class="card-tools"><button type="button" data-id="' + index + '" class="btn btn-primary save">Save</button ></div >');

                                $("#invoice_list_" + index).append('<div class="card-body" id="card_body_' + index + '"><div class="row">                   <div class="col-4" id="col_description_' + index + '"></div>                                                                <div class="col-2" id="col_base_value_' + index + '"></div>                                                                 <div class="col-2" id="col_gst_amount_' + index + '"></div>                                                                  <div class="col-2" id="col_invoice_amount_' + index + '"></div>                                                              <div class="col-2" id="col_paid_amount_' + index + '"></div></div></div>');

                                $("#col_description_" + index).append('<b>Description</b><br>' + value.description + '</div>');

                                $("#col_base_value_" + index).append('<b>Base Value</b><br><input type="hidden" id="id_tdsdata_basic_value_' + index + '" class="payment" value="' + data.sub_total + '">' + data.sub_total + '');

                                $("#col_gst_amount_" + index).append('<b>GST Amount</b><br><input type="hidden" id="id_tdsdata_gst_amount_' + index + '" class="payment" value="' + (parseFloat(data.cgst) + parseFloat(data.sgst) + parseFloat(data.igst)) + '">' + (parseFloat(data.cgst) + parseFloat(data.sgst) + parseFloat(data.igst)));

                                $("#col_invoice_amount_" + index).append('<b>Invoice Amount</b><br><input type="hidden" id="id_tdsdata_invoice_amount_' + index + '" class="payment" value="' + data.invoice_total + '">' + data.invoice_total + '');

                                $("#col_paid_amount_" + index).append('<b>Paid Amount</b><br>' + data.invoice_total);

                                $("#invoice_list_" + index).append('<div class="card-footer" id="card_footer_' + index + '"><div class="row">                <div class="col-3" id="col_tds_percent_' + index + '"></div>                                                                   <div class="col-2" id="col_allocated_amt_' + index + '"></div>                                                              <div class="col-2" id="col_cheque_utr_no_' + index + '"></div>                                                              <div class="col-2" id="col_utr_file_' + index + '"></div>                                                                    <div class="col-3" id="col_payment_date_' + index + '"></div></div>');

                                $("#col_tds_percent_" + index).append('<label for="id_tdsdata_tds_percent_' + index + '">TDS %</label><div  class="input-group"><input type="number" class="form-control monitortds payment" id="id_tdsdata_tds_percent_' + index + '" max="100" min="0" data-index="' + index + '"><input type="hidden" id="id_tdsdata_tds_deducted_' + index + '" class="payment" value="' + value.id + '"><div class="input-group-append"><span class="input-group-text" id="pdg_tdsamt' + index + '" data-index="' + index + '">₹ 0.0</span></div></div>');

                                $("#col_allocated_amt_" + index).append('<label for="id_tdsdata_allocated_amt_' + index + '">Received Amount</label><input type="number" id="id_tdsdata_allocated_amt_' + index + '" class="form-control monitorallocated_amt payment" data-index="' + index + '" data-total="' + value.invoice_total + '" value="' + value.invoice_total + '"><input type="hidden" id="id_tdsdata_receivable_amt_' + index + '" class="payment" value="' + value.invoice_total + '"><input type="hidden" id="id_received_amt_' + index + '" class="payment" value="' + value.invoice_total + '"><input type="hidden" id="id_tdsdata_balance_amt_' + index + '" class="payment" value="' + value.invoice_total + '">');

                                $("#col_cheque_utr_no_" + index).append('<label for="id_cheque_utr_no_' + index + '">UTR</label><input data-id="' + index + '" type="text" class="form-control max250 utr payment" id="id_cheque_utr_no_' + index + '">');

                                $("#col_payment_date_" + index).append('<label for="id_payment_date_' + index + '">Payment Date</label><input type="date" class="form-control max250 mb-3 ptdate payment" data-id="' + index + '" id="id_payment_date_' + index + '" max="' + today + '">');

                                $("#col_utr_file_" + index).append('<label for="id_utr_file_' + index + '">Attachment</label><input type="file" accept="application/pdf" id="id_utr_file_' + index + '" class="wrp max150 attach payment" disabled></div>');
                                if (data.payments) {
                                    // $.each(data.payments, function (j, value) {
                                    $("#id_tdsdata_allocated_amt_" + index).val(data.payments.balance_amt);
                                    if (data.payments.tds_deducted > 0) {
                                        $("#id_tdsdata_tds_percent_" + index).val(data.payments.tds_percent).attr('readonly', true).trigger('change');
                                        $("#pdg_tdsamt" + index).val(humanamount(data.payments.tds_deducted));
                                    }
                                    $("#id_tdsdata_receivable_amt_" + index).val(data.payments.receivable_amt);
                                    // });
                                }
                            });
                    });
                }
                if (data.payment_completed) {
                    $("#id_cleared_payments").show();
                    $("#headid_cleared").show();
                    // Fill cleared table
                    $.each(data.payment_completed, function (index, value) {
                        $("#bodyid_cleared").append('<tr id="clr_row' + index + '"></tr>');
                        $("#clr_row" + index)
                            .append('<td id="clr_invoice' + index + '">' + value.invoice_no + '</td>')
                            .append('<td id="clr_descp' + index + '">' + value.description + '</td>')
                            .append('<td id="clr_total' + index + '">' + value.invoice_total + '</td>')
                            .append('<td id="clr_date' + index + '">' + value.payment_date + '</td>')
                            .append('<td id="clr_utr' + index + '">' + value.cheque_utr_no + '</td>')
                            .append('<td id="clr_attach' + index + '"><i class="fas fa-paperclip sublist pointer" data-href="' + value.utr_file + '"></i></td>');
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No orders found against this customer.");
            });
    }
});

$(document).on("change", ".monitorallocated_amt", function () {
    $("#id_received_amt_" + $(this).data('index')).val($(this).val());
});

$(document).on("change", ".monitortds", function () {
    var tds_percent = $(this).val();
    var invoice_amt = $("#id_tdsdata_basic_value_" + $(this).data('index')).val();
    $("#pdg_tdsamt" + $(this).data('index')).text(humanamount((invoice_amt * tds_percent / 100).toFixed(2)));
    $("#id_tdsdata_tds_deducted_" + $(this).data('index')).val((invoice_amt * tds_percent / 100).toFixed(2));
    $("#id_tdsdata_allocated_amt_" + $(this).data('index')).val($("#id_tdsdata_allocated_amt_" + $(this).data('index')).data('total') - (invoice_amt * tds_percent / 100).toFixed(2));
    $("#id_tdsdata_receivable_amt_" + $(this).data('index')).val($("#id_tdsdata_allocated_amt_" + $(this).data('index')).data('total') - (invoice_amt * tds_percent / 100).toFixed(2));
});

$(document).on("click", ".radio", function () {
    var index = $(this).data('id');
    var invoice_id = $(this).data('invoice');
    $(".payment").removeAttr("name");
    $(".attach").attr("disabled", true);
    $("#pdg_tdsamt" + index).text(humanamount(0));
    $("#id_payment_date_" + index).attr("name", "payment_date");
    $("#id_cheque_utr_no_" + index).attr("name", "cheque_utr_no");
    $("#id_received_amt_" + index).attr("name", "received_amt");
    $("#id_utr_file_" + index).removeAttr("disabled").attr("name", "utr_file");
    $("#id_tdsdata_invoice_id_" + index).attr("name", "tds_data[0][invoice_id]");
    $("#id_tdsdata_basic_value_" + index).attr("name", "tds_data[0][basic_value]");
    $("#id_tdsdata_gst_amount_" + index).attr("name", "tds_data[0][gst_amount]");
    $("#id_tdsdata_invoice_amount_" + index).attr("name", "tds_data[0][invoice_amount]");
    $("#id_tdsdata_tds_percent_" + index).attr("name", "tds_data[0][tds_percent]").trigger('change');
    $("#id_tdsdata_tds_deducted_" + index).attr("name", "tds_data[0][tds_deducted]");
    $("#id_tdsdata_receivable_amt_" + index).attr("name", "tds_data[0][receivable_amt]");
    $("#id_tdsdata_received_amt_" + index).attr("name", "received_amt");
    $("#id_tdsdata_allocated_amt_" + index).attr("name", "tds_data[0][allocated_amt]");
    $("#id_tdsdata_invoice_id_" + index).attr("name", "tds_data[0][invoice_id]");
    $("#id_tdsdata_balance_amt_" + index).attr("name", "tds_data[0][balance_amt]");
});

$(document).on("click", ".save", function () {
    $("#id_cheque_utr_no_" + $(this).data('id') + "-error").remove();
    if ($("#id_payment_date_" + $(this).data('id')).val() == "") {
        $("#id_payment_date_" + $(this).data('id')).addClass('is-invalid');
        $("#col_payment_date_" + $(this).data('id')).append('<span id="' + $("#id_utr" + $(this).data('id')).attr('id') + '-error" class="error invalid-feedback">Please fill the details.</span>');
        if ($("#id_cheque_utr_no_" + $(this).data('id')).val() == "") {
            $("#id_cheque_utr_no_" + $(this).data('id')).addClass('is-invalid');
        }
    } else if ($("#id_cheque_utr_no_" + $(this).data('id')).val() == "") {
        $("#id_cheque_utr_no_" + $(this).data('id')).addClass('is-invalid');
        $("#col_payment_date_" + $(this).data('id')).append('<span id="' + $("#id_utr" + $(this).data('id')).attr('id') + '-error" class="error invalid-feedback">Please enter the UTR No.</span>');
        if ($("#col_payment_date_" + $(this).data('id')).val() == "") {
            $("#col_payment_date_" + $(this).data('id')).addClass('is-invalid');
        }
    } else {
        $("#modal_body").empty().append('Are you sure to save this payment details.')
        $("#modelpdf").trigger('click');
        $('#modalsubmit').removeAttr('disabled');
    }

});


function check_proforma(val){
    if(val == 1){
        return "Performa "
    } else {
        return ""
    }
}