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
            type: "POST",
            url: baseUrl + "" + $(this).val(),
            data: $(this).val(),
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                if (data != ""){
                    $.each(data, function (index, value) {
                        $("#id_pending").append('<tr id="pendingrow'+index+'"></tr>');
                        $("#pendingrow"+index)
                        .append('<td>'+value+'</td>')
                        .append('<td>'+value+'</td>')
                        .append('<td>'+value+'</td>')
                        .append('<td>'+value+'</td>')
                        .append('<td>'+value+'</td>')
                        .append('<td>'+value+'</td>');
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No orders found against this customer.");
            });
    }
});