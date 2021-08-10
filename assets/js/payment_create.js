var lastSelectedId;
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
    $("#colid_pending").hide();
    $("#headid_pending").hide();
    $("#bodyid_pending").empty();
    $("#colid_cleared").hide();
    $("#headid_cleared").hide();
    $("#bodyid_cleared").empty();
}

$(document).on("change", "#id_orderid", function () {
    resetonorder();
    if ($(this).val()) {
        $.ajax({
            type: "GET",
            url: baseUrl + "orders/getinvoicesforpayments/" + $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                if (data.payment_pending) {
                    $("#colid_pending").show();
                    $("#headid_pending").show();
                    // Fill pending table
                    $.each(data.payment_pending, function (index, value) {
                        $("#bodyid_pending").append('<tr id="pdg_row' + index + '"></tr>');
                        $("#pdg_row" + index)
                            .append('<td id="pdg_select' + index + '" style="width: 53px;"><div class="icheck-primary d-inline">            <input type="radio" id="select' + index + '" data-id="' + index + '" name="received_amt" class="pdgselect" value="' + value.invoice_total + '">                                                                                         <input type="hidden" id="id_invoice_id' + index + '" value="' + value.id + '">                                <label for="select' + index + '"></label></div></td>')
                            .append('<td id="pdg_invoice' + index + '" style="width: 98px;">' + value.invoice_no + '</td>')
                            .append('<td id="pdg_descp' + index + '" class="max238">' + value.description + '</td>')
                            .append('<td id="pdg_amt' + index + '">' + value.invoice_total + '</td>')
                            .append('<td id="pdg_date' + index + '"></td>')
                            .append('<td id="pdg_attach' + index + '"></td>')
                            .append('<td id="pdg_save' + index + '" style="width: 81px;"></td>');
                        $("#pdg_date" + index).append('<input type="date" class="form-control max250 mb-1" id="id_payment_date' + index + '"><input placeholder="UTR Number" type="text" class="form-control max250" id="id_utr' + index + '">');
                        $("#pdg_attach" + index).append('<input type="file" id="id_attach' + index + '" class="wrp max150">');
                    });
                }
                if (data.payment_completed) {
                    $("#colid_cleared").show();
                    $("#headid_cleared").show();
                    // Fill cleared table
                    $.each(data.payment_completed, function (index, value) {
                        $("#bodyid_cleared").append('<tr id="clr_row' + index + '"></tr>');
                        $("#clr_row" + index)
                            .append('<td id="clr_invoice' + index + '">' + value.invoice_no + '</td>')
                            .append('<td id="clr_descp' + index + '">' + value.description + '</td>')
                            .append('<td id="clr_date' + index + '">' + value.payment_date + '</td>')
                            .append('<td id="clr_utr' + index + '">' + value.cheque_utr_no + '</td>')
                            .append('<td id="clr_attach' + index + '">' + value.utr_file + '</td>')
                            .append('<td id="clr_total' + index + '">' + value.invoice_total + '</td>');
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No orders found against this customer.");
            });
    }
});


$(document).on("click", ".pdgselect", function () {
    $("#pdg_save" + $(this).data('id')).empty().append('<button type="button" class="btn btn-primary save" data-id="' + $(this).data('id') + '" id="pdgsave' + $(this).data('id') + '">Save</button>');
    $("#id_invoice_id" + $(this).data('id')).attr('name', 'invoice_id');
    $("#id_payment_date" + $(this).data('id')).attr('name', 'payment_date').attr('required', true);
    $("#id_utr" + $(this).data('id')).attr('name', 'cheque_utr_no').attr('required', true);
    $("#id_attach" + $(this).data('id')).attr('name', 'utr_file');
    if ($(this).data('id') != lastSelectedId) {
        $("#pdg_save" + lastSelectedId).empty();
        $("#id_invoice_id" + lastSelectedId).attr('name', 'invoice_id');
        $("#id_payment_date" + lastSelectedId).removeAttr('name', 'payment_date').removeAttr('required', true);
        $("#id_utr" + lastSelectedId).removeAttr('name', 'cheque_utr_no').removeAttr('required', true);
        $("#id_attach" + lastSelectedId).removeAttr('name', 'utr_file');
        lastSelectedId = $(this).data('id');
    }

});

$(document).on("click", ".save", function () {
    if ($("#id_payment_date" + $(this).data('id')).val() == "") {
        alert('Payment Date cannot be empty');
    } else if ($("#id_utr" + $(this).data('id')).val() == "") {
        alert('UTR field cannot be empty');
    } else {
        $("#modelpdf").trigger('click');
        
    }
});

$(document).on("click", "#modalsubmit", function () {
    $(this).attr("disabled", true);
    // var files = $('#id_utr'+lastSelectedId).files[0];
    var formdata = $("#quickForm").serialize();
    $.ajax({
        type: "POST",
        url: baseUrl + "payments/create",
        data: formdata,
        dataType: 'json',
    }).done(function (data) {
        console.log(data);
        console.log(data.status);
        if (data.status == 1) {
            $("#modal_body").empty().append(data.message);
            $("#modalclose").trigger('click');
            $("#id_orderid").trigger('change');
            $("#modalsubmit").removeAttr("disabled");
        } else {
            $("#modal_body").empty().append('Submit Failed.<br>Please try again by clicking "Submit".');
            $("#modalsubmit").removeAttr("disabled");
        }
    }).fail(function (data) {
        $("#modal_body").empty().append('Submit Failed.<br>Please try again by clicking "Submit".');
        $("#modalsubmit").removeAttr("disabled");
    });
});