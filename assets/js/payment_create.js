var lastSelectedId;
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
function resetongroup() {
    $("#customerid_id").val("").empty().attr("disabled", true);
    resetoncustomer();
}


$(document).on("change", "#id_group_id", function () {
    resetongroup();
    if ($(this).val()) {
        $.ajax({
            type: "POST",
            url: baseUrl + "customers/groupcustomers/" + id,
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
            type: "POST",
            url: baseUrl + "orders/getinvoicesforpayments/" + $(this).val(),
            data: $(this).val(),
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
                        $("#pdg_date" + index).append('<input type="date" class="form-control max250 mb-1 ptdate" data-id="' + index + '" id="id_payment_date' + index + '" max="' + today + '"><input placeholder="UTR Number" data-id="' + index + '" type="text" class="form-control max250 utr" id="id_utr' + index + '">');
                        $("#pdg_attach" + index).append('<input type="file" accept="application/pdf" id="id_attach' + index + '" class="wrp max150 attach" disabled>');
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
    }
});

$(document).on("change", ".ptdate", function () {
    if ($(this).val()) {
        $(this).removeClass("is-invalid");
    }
    if ($("#id_utr" + $(this).data('id')).val()) {
        $("#id_utr" + $(this).data('id') + "-error").remove();
    }
});
$(document).on("change", ".utr", function () {
    if ($(this).val()) {
        $(this).removeClass("is-invalid");
    }
    if ($("#id_payment_date" + $(this).data('id')).val()) {
        $("#id_utr" + $(this).data('id') + "-error").remove();
    }
});


$(document).on("click", ".pdgselect", function () {
    $("#pdg_save" + $(this).data('id')).empty().append('<button type="button" class="btn btn-primary save" data-id="' + $(this).data('id') + '" id="pdgsave' + $(this).data('id') + '">Save</button>');
    $("#id_invoice_id" + $(this).data('id')).attr('name', 'invoice_id');
    $("#id_payment_date" + $(this).data('id')).attr('name', 'payment_date').attr('required', true);
    $("#id_utr" + $(this).data('id')).attr('name', 'cheque_utr_no').attr('required', true);
    $("#id_attach" + $(this).data('id')).attr('name', 'utr_file').removeAttr("disabled");
    if ($(this).data('id') != lastSelectedId) {
        $("#pdg_save" + lastSelectedId).empty();
        $("#id_invoice_id" + lastSelectedId).val('').attr('name', 'invoice_id');
        $("#id_payment_date" + lastSelectedId).val('').removeAttr('name', 'payment_date').removeAttr('required', true);
        $("#id_utr" + lastSelectedId).val('').removeAttr('name', 'cheque_utr_no').removeAttr('required', true);
        $("#id_attach" + lastSelectedId).val('').removeAttr('name', 'utr_file').attr("disabled", true);
        lastSelectedId = $(this).data('id');
    }
});

var match = ['application/pdf'];
$(document).on("change", ".attach", function () {
    var id = $(this).attr('id')
    var file = this.files;
    var fileType = file[0].type;
    $.each(match, function (index, value) {
        if (fileType != value) {
            $("#"+id).addClass('is-invalid').val('').parent().children('span').remove();
            $("#"+id).parent().append('<span id="' + id + '-error" class="error invalid-feedback">Upload only PDF.</span>')
            return false;
        } else {
            $("#"+id).parent().children('span').remove();
        }
    });
});

$(document).on("click", ".save", function () {
    $("#id_utr" + $(this).data('id') + "-error").remove();
    if ($("#id_payment_date" + $(this).data('id')).val() == "") {
        $("#id_payment_date" + $(this).data('id')).addClass('is-invalid');
        $("#pdg_date" + $(this).data('id')).append('<span id="' + $("#id_utr" + $(this).data('id')).attr('id') + '-error" class="error invalid-feedback">Please fill the details.</span>');
        if ($("#id_utr" + $(this).data('id')).val() == "") {
            $("#id_utr" + $(this).data('id')).addClass('is-invalid');
        }
    } else if ($("#id_utr" + $(this).data('id')).val() == "") {
        $("#id_utr" + $(this).data('id')).addClass('is-invalid');
        $("#pdg_date" + $(this).data('id')).append('<span id="' + $("#id_utr" + $(this).data('id')).attr('id') + '-error" class="error invalid-feedback">Please enter the UTR No.</span>');
        if ($("#id_payment_date" + $(this).data('id')).val() == "") {
            $("#id_payment_date" + $(this).data('id')).addClass('is-invalid');
        }
    } else {
        $("#modal_body").empty().append('Are you sure to save this payment details.');
        $("#modelpdf").trigger('click');
    }
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
        }
    });
});

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