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
      form.submit();
    },
  });
  $("#quickForm").validate({
    rules: {
      customer_id: {
        required: true,
      },
      invoice_date: {
        required: true,
        date: true,
      },
      order_id: {
        required: true,
      },
      pay_days: {
        required: true,
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
      "'><td><input class='form-control ftsm' list='item" +
      charlie +
      "_list' name='item[]' id='id_item" +
      charlie +
      "' placeholder='Type or select...' disabled/><datalist id='item" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input class='form-control ftsm' list='description" +
      charlie +
      "_list' name='description[]' id='id_description" +
      charlie +
      "' placeholder='Type or select...' disabled /> <datalist id='description" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input type='number' class='form-control ftsm qty' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='qty[]' id='id_quantity" +
      charlie +
      "' disabled/></td><td><input type='number' class='form-control ftsm unitprice' name='unit_price[]' id='id_unitprice" +
      charlie +
      "' disabled/></td><td>₹<input type='hidden' class='form-control ftsm rowtotal' name='total[]' id='total" +
      charlie +
      "'><span id='id_total" +
      charlie +
      "'>0.00</span></td><td><i class='fas fa-minus-circle trash' style='color: darkgrey' disabled ></i></td></tr>"
  );
}

// Delete & Return
$(".killrow").click(function () {
  var a = $(this).attr("id");
  tridupdate(a);
  ttotal();
  $("#byemodal").click();
});

function tridupdate(a) {
  $("#" + a).remove();
  var arr = $("#id_tr").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b !== a;
  });
  $("#id_tr").val(res);
}

// Monitoring Quantity Field
$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#total" + id[0]).val(subtotal);
  // $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Monitoring Unit Price Field
$(document).on("change", ".unitprice", function () {
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#total" + id[0]).val(subtotal);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Customer Ajax
$("#customerid_id").change(function () {
  var customerid = $(this).val();
  if (customerid) {
    $("#id_orderid").removeAttr("disabled");
    $("#add_item").removeAttr("disabled");
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getOrderListByCustomer/" + customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#paytype_div").show();
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
    $("#add_item").attr("disabled", "");
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

$("#id_orderid").change(function () {
  total = 0;
  var idlist = $("#id_tr").val().split(",");
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      tridupdate(value);
    });
  }
  var orderId = $(this).val();
  if (orderId) {
    console.log(orderId);
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getdetails/" + orderId,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#id_payindays").val(data.order.pay_days);
        $("#id_pono").val(data.order.po_no);
        $("#id_salesperson").val(data.order.sales_person);
        $("#bill_id").val(data.order.bill_to);
        $("#ship_id").val(data.order.ship_to);
        fillorderitems(data.items);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
  }
});

function fillorderitems(datadict) {
  var ttotal = 0;
  var arr = $("#id_tr").val().split(",");
  var i = 0;
  var data = eval(datadict);
  for (var key in data) {
    arr[i] = data[key].id;
    i++;
    if (data.hasOwnProperty(key)) {
      if (key != "") {
        var quantity = data[key].qty;
        var item = data[key].item;
        var description = data[key].description;
        var unitprice = data[key].unit_price;
        var tax = data[key].tax;
        var total = data[key].total;
        var di = parseInt(data[key].id, 10);
        addrow(di);
        $("#id_quantity" + di).val(quantity);
        $("#id_item" + di).val(item);
        $("#id_description" + di).val(description);
        $("#id_unitprice" + di).val(unitprice);
        $("#id_tax" + di).val(tax);
        $("#id_total" + di).val(total);
        var total = 0;
        if (quantity != "" && unitprice != "") {
          total = unitprice * quantity;
          // if (tax != "") {
          //   total += total * (tax / 100);
          // }
        }
        $("#total" + di).val(total);
        $("#id_total" + di).text(parseFloat(total).toFixed(2));
      }
    }
    ttotal += total;
  }
  $("#id_tr").val(arr);
  $("#id_ordertotal").val(ttotal);
  // $("#subtotal_id").text(parseFloat(ttotal).toFixed(2));
  $("#total").text(parseFloat(ttotal).toFixed(2));
}

// Monitoring Quantity Field
$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Calculation Sub Total & Total
function ttotal() {
  var idlist = $("#id_tr").val().split(",");
  total = 0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      total += parseFloat($("#id_total" + value).text());
    });
    $("#id_ordertotal").val(total);
    // $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  } else {
    total = 0.0;
    $("#id_ordertotal").val(total);
    // $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  }
}

// Row Data Calculator
function rowcollector(id) {
  rowqty = $("#id_quantity" + id).val();
  rowunitprice = $("#id_unitprice" + id).val();
  rowtax = $("#id_tax" + id).val();
  total = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    total = rowunitprice * rowqty;
    // if (rowtax[0] != "") {
    //   total += total * (rowtax / 100);
    // }
  }
  return total;
}

$("#days_id").on("keypress", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

// Add Order Item Click Action
$("#add_item").on("click", function () {
  var a = $("#id_paytype_val").val().split(",");
  console.log(a);
  if (a.length < 2 && a[0] == "") {
    addpaytype(1);
    a[0] = 1;
  } else {
    var lastid = a[a.length - 1];
    lastid++;
    addpaytype(lastid);
    a.push("" + lastid + "");
  }
  var i = 1;
  $.each(a, function (index, value) {
    $("#row" + value)
      .children()
      .first()
      .html(i);
    i++;
  });
  $("#id_paytype_val").val(a);
  console.log($("#id_paytype_val").val());
});

function addpaytype(charlie) {
  $("#id_paytype_body").append(
    '<tr id="row' +
      charlie +
      '"><td>' +
      charlie +
      '<input type="hidden" name="pay_typeid[]" id="id_paytypeid' +
      charlie +
      '" value="' +
      charlie +
      '"></td><td class="text-left"><input type="text" name="paytype[]" id="id_paytype' +
      charlie +
      '" class="form-control ftsm"></td><td><div class="input-group" style="justify-content: center;"><input type="tel" class="form-control ftwm ftsm subtotal minmax100" name="subtotal[]" id="id_subtotal' +
      charlie +
      '"><div class="input-group-append"><div class="input-group-text"><i class="fas fa-percentage"></i></div></div></div></td><td><i class="fas fa-minus-circle bin mt-1" style="color: red" id="id_bin' +
      charlie +
      '"></i></td><td id="gsttotal' +
      charlie +
      '"><div></div><input type="hidden" name="paytotal[]" id="id_paytotal' +
      charlie +
      '" ></td></tr>"'
  );
}

$(".bin").on("click", function () {
  var qtyid = $(this).attr("id");
  deleteid = qtyid.match(/\d+/);
  $("#row" + deleteid).remove();
  var arr = $("#id_paytype_val").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b != deleteid;
  });
  var i = 1;
  $.each(res, function (index, value) {
    $("#row" + value)
      .children()
      .first()
      .html(i);
    i++;
  });
  $("#id_paytype_val").val(res);
  grandtotal();
});

// function gsttotal() {
//   var idlist = $("#id_paytype_val").val().split(",");
//   total = 0;
//   if (idlist != "") {
//     $.each(idlist, function (index, value) {
//       total += parseFloat($("#gsttotal" + value).text());
//     });
//     $("#gsttotal").val(total);
//     // $("#subtotal_id").text(parseFloat(total).toFixed(2));
//     $("#id_subtotal").text(parseFloat(total).toFixed(2));
//   } else {
//     total = 0.0;
//     $("#gsttotal").val(0.0);
//     // $("#subtotal_id").text(parseFloat(total).toFixed(2));
//     $("#id_subtotal").text(0.0);
//   }
// }

$(document).on("keypress", ".subtotal", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$(document).on("change", ".subtotal", function () {
  var idlist = $("#id_paytype_val").val().split(",");
  var cent = 100;
  var total = 0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      if ($("#id_subtotal" + value).val() != "") {
        newval = parseInt($("#id_subtotal" + value).val());
        total += newval;
      }
    });
  }
  if (total > cent) {
    $(this).val($(this).val() - (total - cent));
  }

  var valeu = parseInt($(this).val());
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = parseFloat($("#total").text());
  breakvalue = (valeu / 100) * subtotal;
  total = (breakvalue * gst) / 100 + breakvalue;
  $("#gsttotal" + id[0])
    .children()
    .first()
    .html(total.toFixed(2));
  $("#id_paytotal" + id[0]).val(total.toFixed(2));
  grandtotal();
});

function grandtotal() {
  var idlist = $("#id_paytype_val").val().split(",");
  var total = 0.0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      if ($("#id_paytotal" + value).val() != "") {
        total += parseFloat($("#id_paytotal" + value).val());
      }
    });
    $("#id_gsttotal").val(total);
    $("#gsttotal").text(parseFloat(total.toFixed(2)));
  } else {
    total = 0.0;
    $("#id_gsttotal").val(total);
    $("#gsttotal").text(parseFloat(total.toFixed(2)));
  }
}
