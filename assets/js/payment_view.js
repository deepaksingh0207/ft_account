$(function () {
    $.ajax({
        type: "POST",
        url: baseUrl + "orders/getinvoicesforpayments/" + id,
        data: id,
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
                        .append('<td id="pdg_invoice' + index + '">' + value.invoice_no + '</td>')
                        .append('<td id="pdg_descp' + index + '">' + value.description + '</td>')
                        .append('<td id="pdg_total' + index + '">' + value.invoice_total + '</td>')
                        .append('<td id="pdg_date' + index + '">' + value.payment_date + '</td>')
                        .append('<td id="pdg_utr' + index + '">' + value.cheque_utr_no + '</td>')
                        .append('<td id="pdg_attach' + index + '"><i class="fas fa-paperclip sublist pointer" data-href="' + value.utr_file + '"></i></td>');
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
});
