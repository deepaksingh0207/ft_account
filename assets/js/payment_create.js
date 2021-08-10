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

$("#customerid_id").change(function () {
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
    console.log(true);
}

$("#id_orderid").change(function () {
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
                    // Fill pending table
                    $.each(payment_pending, function (index, value) {
                        $("#id_pending").append('<tr id="pdg_row' + index + '"></tr>');
                        $("#pendingrow" + index)
                            .append('<td id="pdg_invoice' + index + '">' + value + '</td>')
                            .append('<td id="pdg_descp' + index + '">' + value + '</td>')
                            .append('<td id="pdg_date' + index + '"></td>')
                            .append('<td id="pdg_utr' + index + '"></td>')
                            .append('<td id="pdg_attach' + index + '"></td>')
                            .append('<td id="pdg_select' + index + '"></td>');
                        $("#pdg_date" + index).append('<input type="text" class="form-control" name="payment_date[]" id="id_payment_date' + index + '">');
                        $("#pdg_utr" + index).append('<input type="text" class="form-control" name="utr[]" id="id_utr' + index + '">');
                        $("#pdg_attach" + index).append('<input type="file" name="attach[]" id="id_attach' + index + '">');
                    });
                }
                if (data.payment_completed) {
                    // Fill cleared table
                    $.each(data, function (index, value) {
                        $("#id_pending").append('<tr id="clr_row' + index + '"></tr>');
                        $("#pendingrow" + index)
                            .append('<td id="clr_invoice' + index + '">' + value + '</td>')
                            .append('<td id="clr_descp' + index + '">' + value + '</td>')
                            .append('<td id="clr_date' + index + '">' + value + '</td>')
                            .append('<td id="clr_utr' + index + '">' + value + '</td>')
                            .append('<td id="clr_attach' + index + '">' + value + '</td>')
                            .append('<td id="clr_total' + index + '">' + value + '</td>');
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No orders found against this customer.");
            });
    }
});