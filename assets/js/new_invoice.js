var baseUrl = window.location.origin + "/ft_account/";
var gst = 9;

$(function () {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();
  today = yyyy + "-" + mm + "-" + dd;
  $("#id_invoicedate").val(today);
  $(".select2").select2();
  // Form Validation
  $.validator.setDefaults({
    submitHandler: function () {
      // form.submit();
      $("#responsemodal").click();
    },
  });
  $("#quickForm").validate({
    rules: {
      customer_id: {
        required: true,
      },
      order_id: {
        required: true,
      },
      invoice_date: {
        required: true,
        date: true,
      },
      po_no: {
        required: true,
      },
      sales_person: {
        required: true,
      },
      bill_to: {
        required: true,
      },
      ship_to: {
        required: true,
      },
      remarks: {
        required: true,
      },
    },
    messages: {
      customer_id: {
        required: "Please select this customer.",
      },
      order_id: {
        required: "Please select the order number.",
      },
      invoice_date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      pay_days: {
        required: "Please enter days count.",
      },
      po_no: {
        required: "Please enter Customer PO.",
      },
      sales_person: {
        required: "Please provide a salesperson.",
        tel: "Invalid Detail.",
      },
      bill_to: {
        required: "Please provide a bill to address.",
        tel: "Invalid Detail.",
      },
      ship_to: {
        required: "Please provide ship to address.",
        tel: "Invalid Detail.",
      },
      remarks: {
        required: "Please provide your comments.",
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

// Dynamic Row Appending Function
function addrow(charlie) {
  $("#orderlist").append(
    "<tr id='" +
      charlie +
      "'><td id='id_item" +
      charlie +
      "'></td><td id='id_description" +
      charlie +
      "'></td><td id='id_quantity" +
      charlie +
      "'></td><td id='id_unitprice" +
      charlie +
      "'></td><td>₹<span id='ordertotal" +
      charlie +
      "'></span></td></tr>"
  );
}

function tridupdate(a) {
  $("#" + a).remove();
  var arr = $("#id_tr").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b !== a;
  });
  $("#id_tr").val(res);
}

// Customer Ajax
$("#customerid_id").change(function () {
  var customerid = $(this).val();
  if (customerid) {
    $("#id_orderid").removeAttr("disabled");
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getOrderListByCustomer/" + customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $.each(data, function (key, value) {
          if (key == "gst") {
            gst = value.gst;
          } else {
            $("#id_orderid").append(
              $("<option>", { value: value.id }).text(value.id)
            );
          }
        });
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
    $("#paytype_div").hide();
    $("#id_orderid").attr("disabled", "");
    $("#id_orderid").val("");
    var idlist = $("#id_tr").val().split(",");
    if (idlist != "") {
      $.each(idlist, function (index, value) {
        tridupdate(value);
      });
    }
    $("#id_orderid")
      .find("option")
      .remove()
      .end()
      .append('<option value=""></option>')
      .val("");
  }
});

function resetform() {
  $("#id_pono").val("");
  $("#id_salesperson").val("");
  $("#bill_id").val("");
  $("#ship_id").val("");
  var idlist = $("#id_tr").val().split(",");
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      tridupdate(value);
    });
  }
  $("#paytype_div").hide("");
}

$("#id_orderid").change(function () {
  if ($(this).val() == "") {
    resetform();
  } else {
    total = 0;
    var idlist = $("#id_tr").val().split(",");
    if (idlist != "") {
      $.each(idlist, function (index, value) {
        tridupdate(value);
      });
    }
    var orderId = $(this).val();
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getdetails/" + orderId,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#paytype_div").show();
        $("#id_pono").val(data.order.po_no);
        $("#id_salesperson").val(data.order.sales_person);
        $("#bill_id").val(data.order.bill_to);
        $("#ship_id").val(data.order.ship_to);
        fillorderitems(data.items);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

function fillorderitems(datadict) {
  var ttotal = 0;
  var arr = $("#id_tr").val().split(",");
  var i = 0;
  var data = eval(datadict);
  var total = 0;
  for (var key in data) {
    arr[i] = data[key].id;
    i++;
    if (data.hasOwnProperty(key)) {
      if (key != "") {
        var quantity = data[key].qty;
        var item = data[key].item;
        var description = data[key].description;
        var unitprice = data[key].unit_price;
        var total = data[key].total;
        var di = parseInt(data[key].id, 10);
        addrow(di);
        $("#id_quantity" + di).text(quantity);
        $("#id_item" + di).text(item);
        $("#id_description" + di).text(description);
        $("#id_unitprice" + di).text(unitprice);
        if (quantity != "" && unitprice != "") {
          total = 0;
          total = unitprice * quantity;
        }
        $("#ordertotal" + di).text(parseFloat(total).toFixed(2));
      }
    }
    ttotal += total;
  }
  $("#id_tr").val(arr);
  $("#id_ordertotal").val(ttotal);
  $("#ordertotal").text(parseFloat(ttotal).toFixed(2));
  $("#id_paypercent").val("");
  $("#id_paytype").val("");

  calcy();
}

$(document).on("change", "#id_paypercent", function () {
  if ($(this).val() == 100) {
    $("#id_paytype").val("Full Payment");
  }
  calcy();
});

$(document).on("change", "#id_paytype", function () {
  if ($(this).val() == "Full Payment") {
    $("#id_paypercent").val("100");
  }
  calcy();
});

function calcy() {
  var sgst = 0;
  var cgst = 0;
  var igst = 0;
  var customerId = $("#customerid_id").val();
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + customerId,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      igst = 0;
      cgst = 0;
      sgst = 0;

      if (data.state == "same") {
        $("#sgstpercent").text(data.sgst);
        $("#sgstdiv").show();
        sgst = data.sgst;

        $("#cgstpercent").text(data.cgst);
        $("#cgstdiv").show();
        cgst = data.cgst;

        $("#igstdiv").hide();
      } else {
        $("#igstpercent").text(data.igst);
        $("#igstdiv").show();
        igst = data.igst;
      }

      grandtotal(sgst, cgst, igst);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      // alert("No tax details found.");
    });
  // test purpose
  $("#sgstpercent").text(sgst);
  $("#cgstpercent").text(cgst);
  $("#igstpercent").text(igst);
  grandtotal(sgst, cgst, igst);
}

$(document).on("keypress", ".paypercent", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

function grandtotal(sgst, cgst, igst) {
  ordertotal = parseFloat($("#ordertotal").text()).toFixed(2);
  if ($("#id_paypercent").val() == "") {
    paypercent = 0;
  } else {
    paypercent = $("#id_paypercent").val();
  }
  qtyid = (ordertotal * paypercent) / 100;
  sgstval = (sgst * qtyid) / 100;
  cgstval = (cgst * qtyid) / 100;
  igstval = (igst * qtyid) / 100;
  total = qtyid + sgstval + cgstval + igstval;
  $("#sgstvalue").text(sgstval);
  $("#cgstvalue").text(cgstval);
  $("#igstvalue").text(igstval);
  $("#id_paytotal_div").children().first().html(qtyid);
  $("#id_paytotal").val(qtyid);
  $("#gstvalue").text(total);
  $("#id_invoicetotal").val(total);
}
