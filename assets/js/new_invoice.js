var baseUrl = window.location.origin + "/ft_account/";
var gst = 9;
var orderidlist = [];
var invoiceidlist = [];
var invoicetotal = 0
var pendingtotal = 0
var ordertotal = 0
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;

$(function () {
  $("#id_invoicedate").val(today);
  $(".select2").select2();
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click(); //Activating Modal
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
      group_id: {
        required: "Please select customer group.",
      },
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
  res = jQuery.grep(orderidlist, function (b) {
    return b !== a;
  });
  orderidlist = res
}

// Customer Ajax
$("#customerid_id").change(function () {
  resetform()
  var customerid = $(this).val();
  $("#id_orderid").val("");
  $("#id_orderid")
    .find("option")
    .remove()
    .end()
    .val("");
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
              $("<option>", { value: value.id }).text(value.po_no)
            );
          }
        });
        $("#id_orderid").prepend(
          $("<option>", { value: "", selected: true }).text("")
        );
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
    resetform();
    $("#id_orderid").attr("disabled", "");
    $("#id_orderid").val("");
    $("#id_orderid")
      .find("option")
      .remove()
      .end()
      .append('<option value=""></option>')
      .val("");
  }
});

function resetform() {
  $("#id_orderid").val("");
  $("#id_pono").val("");
  $("#id_salesperson").val("");
  $("#bill_id").val("");
  $("#ship_id").val("");
  $("#comment_id").val("");
  if (orderidlist != "") {
    $.each(orderidlist, function (index, value) {
      tridupdate(value);
    });
  }
  $("#order_list_layout").hide("");
  $("#paytype_div").hide("");
  $("#invoice_list_layout").hide();
}

$("#id_orderid").change(function () {
  $("#invoice_list_layout").hide();
  if ($(this).val() == "") {
    resetform();
  } else {
    total = 0;
    if (orderidlist != "") {
      $.each(orderidlist, function (index, value) {
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
        $("#id_pono").val(data.order.po_no);
        $("#id_salesperson").val(data.order.sales_person);
        $("#bill_id").val(data.order.bill_to);
        $("#ship_id").val(data.order.ship_to);
        var invoicedata = data.invoices
        if (invoicedata.length > 0) {
          fillOrderInvoices(data.invoices);
        }
        fillorderitems(data.items);
        $("#invoice_list_layout").show();
        $("#order_list_layout").show();
        if (data.order.order_type == 2){
          $("#paytype_div").hide();
          $("#id_paymenttermdiv").show();
          $("#id_paymentterm_list").empty();
          $.each(data.payment_term, function (key, value) {
            $("#id_paymentterm_list").append('<tr id="id_tr'+ value.id +'"></tr>');
            $("#id_tr"+value).append('<td><input type="radio" name="paytm" class="form-control" id="id_paytrm" value="'+ value.id +'"></td>');
            $("#id_tr"+value).append('<td>'+ value.item +'</td>');
            $("#id_tr"+value).append('<td>'+ value.description +'</td>');
            $("#id_tr"+value).append('<td>'+ value.qty +'</td>');
            $("#id_tr"+value).append('<td>'+ value.uom_id +'</td>');
            $("#id_tr"+value).append('<td>'+ value.unit_price +'</td>');
            $("#id_tr"+value).append('<td>'+ value.total +'</td>');
          });
        } else {
          $("#id_paymenttermdiv").hide();
          $("#paytype_div").show();
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});


function fillOrderInvoices(datadict) {
  var data = eval(datadict);
  invoicetotal = 0
  $("#invoiceheader").empty();
  $("#invoiceheader").append('<tr> <th class="min100">Invoice No.</th> <th class="min100">Pay Term</th> <th class="min100">Pay Percent</th> <th class="min100">Sub Total</th> <th class="min100">IGST</th> <th class="min100">CGST</th> <th class="min100">SGST</th> <th class="min100">Total</th> <th class="min100">Date</th></tr>');
  for (var key in data) {
    invoicetotal += parseFloat(data[key].sub_total);
    console.log(invoicetotal);
    if (data.hasOwnProperty(key)) {
      if (key != "") {
        $("#invoicelist").append(
          "<tr><td>" +
          data[key].id +
          "</td><td>" +
          data[key].payment_term +
          "</td><td>" +
          data[key].pay_percent +
          "</td><td>" +
          data[key].sub_total +
          "</td><td>" +
          data[key].igst +
          "</td><td>" +
          data[key].cgst +
          "</td><td>" +
          data[key].sgst +
          "</td><td>" +
          data[key].invoice_total +
          "</td><td>" +
          data[key].invoice_date +
          "</td></tr>"
        );
      }
    }
  }
}

function fillorderitems(datadict) {
  ordertotal = 0;
  var i = 0;
  var data = eval(datadict);
  var total = 0;
  for (var key in data) {
    orderidlist[i] = data[key].id;
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
        // ordertotal = parseFloat(total).toFixed(2)
      }
    }
    ordertotal += total;
  }

  $("#ordertotal").text(parseFloat(ordertotal).toFixed(2));
  $("#id_order_total").val(parseFloat(ordertotal).toFixed(2));
  pendingtotal = ordertotal - invoicetotal;
  $("#pendingbalance").text(pendingtotal);
  $("#id_paypercent").val("");
  $("#id_paytype").val("");
  calcy();
}

// $(document).on("change", "#id_paypercent", function () {
//   if ($(this).val() > 100) {
//     $(this).val("100");
//   }
//   if ($(this).val() == 100) {
//     $("#id_paytype").val("Full Payment");
//   }
//   calcy();
// });

$(document).on("change", "#id_paytype", function () {
  if ($(this).val() == "Full Payment") {
    $("#id_paypercent").val("100");
  }
  calcy();
});

$(document).on("change", "#id_group_id", function () {
  $("#customerid_id").empty();
  resetform()
  $.ajax({
    type: "POST",
    url: baseUrl + "customers/groupcustomers/" + $(this).val(),
    data: $(this).val(),
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      $("#customerid_id").append("<option value=''>&nbsp;</option>");
      $.each(data, function (index, value) {
        $("#customerid_id").append("<option value='" + value.id + "'>" + value.name + "</option>");
      });
      $("#customerid_id").removeAttr('disabled');
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("No details found against this customer.");
      $("#customerid_id").attr('disabled', true);
      $("#customerid_id").empty();
      resetform();
      $("#id_orderid").attr("disabled", "");
      $("#id_orderid").val("");
      $("#id_orderid")
        .find("option")
        .remove()
        .end()
        .append('<option value=""></option>')
        .val("");
    });
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
      if (data.state == "same") {
        console.log(data);
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
  // $("#sgstpercent").text(sgst);
  // $("#cgstpercent").text(cgst);
  // $("#igstpercent").text(igst);
  grandtotal(sgst, cgst, igst);
}

$(document).on("keypress", "#id_paypercent", function (event) {
  // var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

  // if (key > 100) {
  //   $(this).val("100");
  // }
  // if (key == 100) {
  //   $("#id_paytype").val("Full Payment");
  // }
  calcy();
});

function grandtotal(sgst, cgst, igst) {
  if ($("#id_paypercent").val() == "") {
    paypercent = 0;
  } else {
    paypercent = $("#id_paypercent").val();
  }
  qtyid = (ordertotal * paypercent) / 100;
  // qtyid = (pendingtotal * paypercent) / 100;
  sgstval = (sgst * qtyid) / 100;
  cgstval = (cgst * qtyid) / 100;
  igstval = (igst * qtyid) / 100;
  total = qtyid + sgstval + cgstval + igstval;

  $("#id_igst").val(igstval);
  $("#id_cgst").val(cgstval);
  $("#id_sgst").val(sgstval);

  $("#sgstvalue").text(sgstval);
  $("#cgstvalue").text(cgstval);
  $("#igstvalue").text(igstval);
  $("#id_paytotal_div").children().first().html(qtyid);
  $("#id_paytotal").val(qtyid);
  $("#gstvalue").text(total.toFixed(2));
  $("#id_invoicetotal").val(total);
}
