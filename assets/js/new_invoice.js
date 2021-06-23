var baseUrl = window.location.origin + "/ft_account/";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
var orderlist = customerlist = grouplist = [], groupid, customerid, orderid, gstdict, cgst = 0, sgst = 0, igst = 0, cgstval, sgstval, igstval, invoicetotal = 0, DEBUG = true;

function debug(val) {
  if (DEBUG == true) {
    console.log(val);
  }
}

function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

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
    "'></td><td id='id_uom" +
    charlie +
    "'></td><td id='id_unitprice" +
    charlie +
    "'></td><td><span id='ordertotal" +
    charlie +
    "'></span></td></tr>"
  );
}

function tridupdate(a) {
  if (a != "") {
    $("#" + a).remove();
    orderlist = jQuery.grep(orderlist, function (b) {
      return b !== a;
    });
  }
  else {
    if (orderlist.length > 0) {
      $.each(orderlist, function (index, value) {
        tridupdate(value);
      });
    }
  }
  debug(orderlist)
}

function resetform() {
  $("#id_pono").val("");
  $("#id_salesperson").val("");
  $("#bill_id").val("");
  $("#ship_id").val("");
  $("#comment_id").val("");
  $("#id_ordertype").text("");
  tridupdate("")
  $("#order_list_layout").hide();
  $("#invoice_list_layout").hide();
  $("#id_paymenttermdiv").hide();
}

$(document).on("change", "#id_group_id", function () {
  resetform();
  $("#customerid_id").val("").empty().attr("disabled", true);
  $("#id_orderid").val("").empty().attr("disabled", true);
  groupid = $(this).val();
  if (groupid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + $(this).val(),
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        grouplist = data
        $("#customerid_id").append("<option></option>");
        $.each(grouplist, function (index, value) {
          $("#customerid_id").append("<option value='" + value.id + "'>" + value.name + "</option>");
        });
        $("#customerid_id").removeAttr('disabled');
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

function getgst(customerid) {
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + customerid,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      gstdict = data
      debug(gstdict)
      if (gstdict.state == "same") {
        cgst = parseFloat(gstdict.cgst);
        sgst = parseFloat(gstdict.sgst);
      } else {
        sgst = parseFloat(gstdict.igst);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("No tax details found.");
    });
}

$("#customerid_id").change(function () {
  $("#id_orderid").val("").empty().attr("disabled", true);
  resetform()
  customerid = $(this).val();
  if (customerid) {
    getgst(customerid);
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getOrderListByCustomer/" + customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        customerlist = data
        $("#id_orderid").append('<option></option>');
        $.each(customerlist, function (key, value) {
          $("#id_orderid").append('<option value="' + value.id + '">' + value.po_no + '</option>');
        });
        $("#id_orderid").removeAttr('disabled');
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

function setordertype(val) {
  if (val == 1) {
    $("#id_ordertype").text("On-Site Support Sale");
  }
  if (val == 2) {
    $("#id_ordertype").text("Project Sale");
  }
  if (val == 3) {
    $("#id_ordertype").text("AMC Support Sale");
  }
  if (val == 4) {
    $("#id_ordertype").text("Man-days-Support Sale");
  }
  if (val == 5) {
    $("#id_ordertype").text("SAP License Sale");
  }
  if (val == 6) {
    $("#id_ordertype").text("Hardware Sale");
  }
}

function setuom(val) {
  if (val == 1) {
    return 'Day(s)';
  }
  if (val == 2) {
    return 'Nos';
  }
  if (val == 3) {
    return 'Percentage (%)';
  }
  if (val == 4) {
    return 'PC';
  }
}

function fillitems(list) {
  if (list != "") {
    $("#orderlist").empty();
    $.each(list, function (index, value) {
      $("#orderlist").append('<tr id="order' + value.id + '"></tr>');
      $("#order" + value.id).append('<td id="item' + value.id + '">' + value.item + '</td>');
      $("#order" + value.id).append('<td id="description' + value.id + '">' + value.description + '</td>');
      $("#order" + value.id).append('<td id="qty' + value.id + '">' + value.qty + '</td>');
      $("#order" + value.id).append('<td id="uom_id' + value.id + '">' + setuom(value.uom_id) + '</td>');
      $("#order" + value.id).append('<td id="unit_price' + value.id + '">' + value.unit_price + '</td>');
      $("#order" + value.id).append('<td id="total' + value.id + '">' + humanamount(value.total) + '</td>');
    });
    $("#ordertotal").text(humanamount(orderlist.order.sub_total));
    if (gstdict.state == "same") {
      $("#ordersgstdiv").show();
      $("#ordercgstdiv").show();
      $("#orderigstdiv").hide();
      $("#sgst").append('<b>SGST ( ' + sgst + '.00% )</b>');
      $("#cgst").append('<b>CGST ( ' + cgst + '.00% )</b>');
    } else {
      $("#igst").append('<b>IGST ( ' + igst + '.00% )</b>');
      $("#ordersgstdiv").hide();
      $("#ordercgstdiv").hide();
      $("#orderigstdiv").show();
    }
    $("#sgstval").text(humanamount(orderlist.order.sgst));
    $("#cgstval").text(humanamount(orderlist.order.cgst));
    $("#igstval").text(humanamount(orderlist.order.igst));
    $("#totalval").text(humanamount(orderlist.order.ordertotal));
    $("#order_list_layout").show();
    $("#id_order_total").val(orderlist.order.sub_total);
    $("#id_sub_total").val(orderlist.order.sub_total);
    $("#id_ordertotal").val(orderlist.order.ordertotal);
    $("#id_sgst").val(orderlist.order.sgst);
    $("#id_cgst").val(orderlist.order.cgst);
    $("#id_igst").val(orderlist.order.igst);
  }
}

function fillinvoices(list) {
  if (list.length > 0) {
    $("#invoiceheader").empty();
    $("#invoiceheader").append('<tr> <th class="min100">Invoice No.</th> <th class="min100">Pay Term</th> <th class="min100">Pay Percent</th> <th class="min100">Sub Total</th> <th class="min100">IGST</th> <th class="min100">CGST</th> <th class="min100">SGST</th> <th class="min100">Total</th> <th class="min100">Date</th></tr>');
    $.each(list, function (index, value) {
      $("#invoicelist").append("<tr><td>" + value.id + "</td><td>" + value.payment_term + "</td><td>" + value.pay_percent + "</td><td>" + value.sub_total + "</td><td>" + value.igst + "</td><td>" + value.cgst + "</td><td>" + value.sgst + "</td><td>" + value.invoice_total + "</td><td>" + value.invoice_date + "</td></tr>");
      invoicetotal += value.invoice_total
    });
  }
  $("#pendingbalance").text(orderlist.order.ordertotal - invoicetotal);
  $("#invoice_list_layout").show();
}


function fillpaymentterm(list) {
  if (orderlist.order.order_type == 2) {
    $("#id_paymentterm_list").empty();
    $.each(list, function (key, value) {
      $("#id_paymentterm_list").append('<tr id="id_tr' + value.id + '"></tr>');
      $("#id_tr" + value.id).append('<td><div class="icheck-primary d-inline"><input required="" type="radio" id="id_paytrm' + value.id + '" name="payment_term" class="paytrm" value="' + value.id + '"><label for="id_paytrm' + value.id + '"></label></div></td>');
      $("#id_tr" + value.id).append('<td>' + value.item + '</td>');
      $("#id_tr" + value.id).append('<td>' + value.description + '</td>');
      $("#id_tr" + value.id).append('<td>' + value.qty + '</td>');
      $("#id_tr" + value.id).append('<td>' + setuom(value.uom_id) + '</td>');
      $("#id_tr" + value.id).append('<td>' + value.unit_price + '</td>');
      $("#id_tr" + value.id).append('<td>' + humanamount(value.total) + '</td>');
    });
    $("#id_paymenttermdiv").show();
  }
}

$("#id_orderid").change(function () {
  resetform();
  orderid = $(this).val();
  if (orderid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getdetails/" + orderid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        orderlist = data;
        $("#id_pono").val(orderlist.order.po_no);
        $("#id_salesperson").val(orderlist.order.sales_person);
        $("#bill_id").val(orderlist.order.bill_to);
        $("#ship_id").val(orderlist.order.ship_to);
        setordertype(orderlist.order.order_type);
        fillitems(orderlist.items);
        fillinvoices(orderlist.invoices);
        if (orderlist.order.order_type != 2) {
          $("#id_sgst").val(orderlist.order.sgst);
          $("#id_cgst").val(orderlist.order.cgst);
          $("#id_igst").val(orderlist.order.igst);
        } else {
          fillpaymentterm(orderlist.payment_term);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});

$(document).on("click", ".paytrm", function () {
  id = $(this).val();
  $.each(orderlist.payment_term, function (key, value) {
    if (value.id == id) {
      subtotal = parseFloat(value.total);
      $("#id_pay_percent").val(value.qty);
      cgstval = subtotal * (cgst / 100);
      sgstval = subtotal * (sgst / 100);
      igstval = subtotal * (igst / 100);
    }
  });
  total = igstval + sgstval + cgstval + subtotal
  $("#id_order_total").val(subtotal);
  $("#id_sub_total").val(subtotal);
  $("#id_ordertotal").val(total);
  $("#id_sgst").val(sgstval);
  $("#id_cgst").val(cgstval);
  $("#id_igst").val(igstval);
});