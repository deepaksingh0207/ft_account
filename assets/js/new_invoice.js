var baseUrl = window.location.origin + "/ft_account/";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var today = yyyy + "-" + mm + "-" + dd;
var orderlist = customerlist = grouplist = [], groupid, customerid, orderid, gstdict, cgst = 0, sgst = 0, igst = 0, cgstval, sgstval, igstval, invoicetotal = 0, oldid=0, DEBUG = true;

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
  $(".record").removeAttr("disabled").show();
  $("#id_pono").val("");
  $("#id_salesperson").val("");
  $("#bill_id").val("");
  $("#ship_id").val("");
  $("#comment_id").val("");
  $("#id_ordertype").text("");
  $("#orderlist_edit").empty();
  tridupdate("")
  $("#order_list_layout_edit").hide();
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
        igst = parseFloat(gstdict.igst);
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
    igst = cgst = sgst = 0;
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
    filledititems(orderlist.items);
  }
  if (val == 2) {
    $("#id_ordertype").text("Project Sale");
  }
  if (val == 3) {
    $("#id_ordertype").text("AMC Support Sale");
    filledititems(orderlist.items);
  }
  if (val == 4) {
    $("#id_ordertype").text("Man-days-Support Sale");
    filledititems(orderlist.items);
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
      $("#sgst").empty();
      $("#sgst").append('<b>SGST ( ' + sgst + '.00% )</b>');
      $("#cgst").empty();
      $("#cgst").append('<b>CGST ( ' + cgst + '.00% )</b>');
    } else {
      $("#igst").empty();
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
    // $("#id_ordertotal").val(orderlist.order.ordertotal);
  }
}

function filledititems(list) {
	
  if (list != "") {
    $("#orderlist_edit").empty();
    $.each(list, function (index, value) {
    	
      readOnly = "";
      if(value.bal_qty == 0) {
       readOnly = 'readonly="readonly"';
      }
      
      $("#orderlist_edit").append('<tr id="order_edit' + value.id + '"></tr>');
      $("#orderlist_edit").append('<input type="hidden" name="order_item_id[]" id="id_order_item_id' + value.id + '" value="' + value.id + '">');

      $("#order_edit" + value.id).append('<td id="item_edit' + value.id + '" class="pt-3">' + value.item + '</td>');
      $("#item_edit" + value.id).append('<input type="hidden"  name="item[]" id="id_item' + value.id + '" value="' + value.item + '">');

      $("#order_edit" + value.id).append('<td id="description_edit' + value.id + '" class="pt-2"></td>');
      $("#description_edit" + value.id).append('<input type="text" '+ readOnly +' class="form-control desp" name="description[]" id="id_descp' + value.id + '" value="' + value.description + '">');

      $("#order_edit" + value.id).append('<td id="qty_edit' + value.id + '" class="pt-2"></td>');
      
      $("#qty_edit" + value.id).append('<input type="number" '+ readOnly +' class="form-control qty" name="qty[]" id="id_qty' + value.id + '" min="0" value="' + value.bal_qty + '" max="' + value.bal_qty + '">');

      $("#order_edit" + value.id).append('<td id="uom_id_edit' + value.id + '" class="pt-3">' + setuom(value.uom_id) + '</td>');
      $("#uom_id_edit" + value.id).append('<input type="hidden"  name="uom[]" id="id_uom' + value.id + '" value="' + value.uom_id + '">');

      $("#order_edit" + value.id).append('<td id="unit_price_edit' + value.id + '" class="pt-3">' + value.unit_price + '</td>');
      $("#unit_price_edit" + value.id).append('<input type="hidden"  name="unit_price[]" id="id_unitprice' + value.id + '" value="' + value.unit_price + '">');

      $("#order_edit" + value.id).append('<td id="total_edit' + value.id + '" class="pt-3">' + humanamount(value.total) + '</td>');
      $("#orderlist_edit").append('<input type="hidden"  name="total[]" id="id_total' + value.id + '" value="' + value.total + '">');
      
    });
    $("#ordertotal_edit").text(humanamount(orderlist.order.sub_total));
    $("#id_sub_total_edit").val(orderlist.order.sub_total);
    $("#id_sub_total_edit").val(orderlist.order.sub_total);
    if (gstdict.state == "same") {
      $("#ordersgstdiv_edit").show();
      $("#ordercgstdiv_edit").show();
      $("#orderigstdiv_edit").hide();
      $("#sgst_edit").empty();
      $("#sgst_edit").append('<b>SGST ( ' + sgst + '.00% )</b>');
      $("#cgst_edit").empty();
      $("#cgst_edit").append('<b>CGST ( ' + cgst + '.00% )</b>');
    } else {
      $("#igst_edit").empty();
      $("#igst_edit").append('<b>IGST ( ' + igst + '.00% )</b>');
      $("#ordersgstdiv_edit").hide();
      $("#ordercgstdiv_edit").hide();
      $("#orderigstdiv_edit").show();
    }
    $("#sgstval_edit").text(humanamount(orderlist.order.sgst));
    $("#cgstval_edit").text(humanamount(orderlist.order.cgst));
    $("#igstval_edit").text(humanamount(orderlist.order.igst));
    $("#totalval_edit").text(humanamount(orderlist.order.ordertotal));
    $("#order_list_layout_edit").show();
    
    $( ".qty" ).trigger( "change" );
  }
}

// On quantity Change
$(document).on("change", ".qty", function () {
  qty_id = $(this).attr("id");
  id = qty_id.match(/\d+/)[0];
  qty_val = $(this).val();
  unitprice_val = $("#id_unitprice" + id).val();
  if ($("#id_uom" + id).val() != 3) {
    rowvalue = qty_val * unitprice_val
  } else {
    rowvalue = (qty_val / 100) * unitprice_val
  }
  $("#id_total" + id).val(rowvalue);
  $("#total_edit" + id).text(humanamount(rowvalue));
  total = 0;
  $.each(orderlist.items, function (index, value) {
    total += parseFloat($("#id_total" + value.id).val());
  });
  total = parseFloat(total)
  if (total < 1.0) {
    $(".record").attr("disabled", true).hide();
  }
  $("#id_ordertotal_edit").val(total);
  $("#id_sub_total_edit").val(total);
  $("#ordertotal_edit").text(humanamount(total));
  if (gstdict.state == "same") {
    cgstval = (cgst / 100) * total
    cgstval = parseFloat(cgstval)
    $("#cgstval_edit").text(humanamount(cgstval));
    $("#id_cgst_edit").val(cgstval);
    sgstval = (sgst / 100) * total
    sgstval = parseFloat(sgstval)
    $("#sgstval_edit").text(humanamount(sgstval));
    $("#id_sgst_edit").val(sgstval);
    grandtotal = total + cgstval + sgstval;
  } else {
    igstval = (igst / 100) * total
    igstval = parseFloat(igstval)
    $("#igstval_edit").text(humanamount(igstval));
    $("#id_igst_edit").val(igstval);
    grandtotal = total + igstval;
  }
  $("#totalval_edit").text(humanamount(grandtotal));
  $("#id_ordertotal_edit").val(grandtotal);
});

invoicetotal = 0;
function fillinvoices(list) {
  if (list.length > 0) {
    $("#invoiceheader").empty();
    $("#invoiceheader").append('<tr> <th class="min100">Invoice No.</th> <th class="min100">Pay Term</th> <th class="min100">Pay Percent</th> <th class="min100">Sub Total</th> <th class="min100">IGST</th> <th class="min100">CGST</th> <th class="min100">SGST</th> <th class="min100">Total</th> <th class="min100">Date</th></tr>');
    $.each(list, function (index, value) {
      $("#invoicelist").append("<tr><td>" + value.id + "</td><td>" + value.payment_term + "</td><td>" + value.pay_percent + "</td><td>" + value.sub_total + "</td><td>" + value.igst + "</td><td>" + value.cgst + "</td><td>" + value.sgst + "</td><td>" + value.invoice_total + "</td><td>" + value.invoice_date + "</td></tr>");
      invoicetotal += parseFloat(value.invoice_total)
    });
  }
  balTotal = orderlist.order.ordertotal - invoicetotal;
  if(balTotal < 0) {
  	balTotal = 0;
  }
  $("#pendingbalance").text(balTotal);
  $("#invoice_list_layout").show();
}


function fillpaymentterm(list) {
  if (orderlist.order.order_type == 2) {
    $("#id_paymentterm_list").empty();
    $.each(list, function (key, value) {
      $("#id_paymentterm_list").append('<tr id="id_tr' + value.id + '"></tr>');
      $("#id_tr" + value.id).append('<td><div class="icheck-primary d-inline"><input required="" type="radio" id="id_paytrm' + value.id + '" name="payment_term" class="paytrm" value="' + value.id + '"><label for="id_paytrm' + value.id + '"></label></div></td>');
      $("#id_tr" + value.id).append('<td>' + value.item + '</td>');
      $("#id_tr" + value.id).append('<td id="paytrm'+value.id+'">' + value.description + '</td>');
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
          // $("#id_sgst").val(orderlist.order.sgst);
          // $("#id_cgst").val(orderlist.order.cgst);
          // $("#id_igst").val(orderlist.order.igst);
          $("#id_sgst_edit").val(orderlist.order.sgst);
          $("#id_cgst_edit").val(orderlist.order.cgst);
          $("#id_igst_edit").val(orderlist.order.igst);
        } else {
          fillpaymentterm(orderlist.payment_term);
        }
        $("#id_order_total_edit").val(orderlist.order.sub_total);
        $("#id_ordertotal_edit").val(orderlist.order.ordertotal);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});

$(document).on("click", ".paytrm", function () {
  if (oldid != 0){
    olddata = $("#id_description").val();
    $("#paytrm" + oldid).empty();
    $("#paytrm" + oldid).text(olddata);
  }
  id = $(this).val();
  oldid = id;
  value = $("#paytrm" + id).text();
  $("#paytrm" + id).empty();
  $("#paytrm" + id).append('<input type="text" name="payment_description" id="id_description" class="form-control" value="'+value+'">');
  $.each(orderlist.payment_term, function (key, value) {
    if (value.id == id) {
      subtotal = parseFloat(value.total);
      $("#totaldiv_edit").append('<input type="hidden" name="pay_percent" id="id_pay_percent" value="' + value.qty + '"></input>');
      cgstval = subtotal * (cgst / 100);
      sgstval = subtotal * (sgst / 100);
      igstval = subtotal * (igst / 100);
    }
  });
  total = igstval + sgstval + cgstval + subtotal
  $("#id_sub_total_edit").val(subtotal);
  $("#id_ordertotal_edit").val(total);
  $("#id_sgst_edit").val(sgstval);
  $("#id_cgst_edit").val(cgstval);
  $("#id_igst_edit").val(igstval);
});