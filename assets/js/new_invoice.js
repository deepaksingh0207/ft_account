var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
var groupdata, customerid, customerdata, orderdata, orderdata_order, gstlist;

function resetongroup() { }

function filldata(id, data, msg, field) {
  $(id).empty().append("<option>" + msg + "</option>");
  $.each(data, function (index, value) {
    val = []
    for (var key in value) { if (field.includes(key, 0)) { val.push(value[key]); } }
    $(id).append("<option value='" + val[0] + "'>" + val[1] + "</option>");
  });
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
        groupdata = data;
        filldata("#customerid_id", groupdata, "Select Customer", ['id', 'name']);
        if (groupdata.length == 1) {
          $("#customerid_id").val(groupdata[0].id);
          $("#customerid_id").trigger('change');
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

function resetoncustomer() { }

function gst_details(customerid) {
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + customerid,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      gstlist = [];
      gstlist.push(data.state)
      if (gstlist[0] == "same") {
        gstlist.push(data.sgst);
        gstlist.push(data.cgst);
        sgst_details();
        cgst_details();
      } else {
        gstlist.push(data.igst);
        igst_details();
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("No tax details found.");
    });
}

$("#customerid_id").change(function () {
  resetoncustomer()
  if ($(this).val()) {
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getOrderListByCustomer/" + $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        customerdata = data
        filldata("#id_orderid", customerdata, "Select Order", ['id', 'po_no']);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
    customerid = $(this).val();
  }
});

function resetonorder() { }

function setordertype(val) {
  if (val == 2 || val == 5) {
    if (val == 2) {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>Project Sale");
    } else {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>SAP License Sale");
    }
  } else {
    if (val == 1) {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>On-Site Support Sale");
    } else if (val == 3) {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>AMC Support Sale");
    } else if (val == 4) {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>Man-days-Support Sale");
    } else if (val == 6) {
      $("#id_ordertype").show().empty().append("<label>Order Type :</label><br>Hardware Sale");
    }
    // filledititems(orderlist.items);
  }
}

function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

function setuom(val) {
  if (val == 1) {
    return 'Day(s)';
  }
  if (val == 2) {
    return 'AU';
  }
  if (val == 3) {
    return 'Percentage (%)';
  }
  if (val == 4) {
    return 'PC';
  }
}

function fillorderbody(val) {
  $("#orderlist").empty();
  $.each(val, function (index, value) {
    $("#orderlist").append('<tr id="order' + index + '"></tr>');
    $("#order" + index)
      .append('<td id="item' + index + '">' + value.item + '</td>')
      .append('<td id="description' + index + '">' + value.description + '</td>')
      .append('<td id="qty' + index + '">' + value.qty + '</td>')
      .append('<td id="uom_id' + index + '">' + setuom(value.uom_id) + '</td>')
      .append('<td id="unit_price' + index + '">' + value.unit_price + '</td>')
      .append('<td id="total' + index + '">' + humanamount(value.total) + '</td>');
  });
}

function sgst_details() {
  $("#sgst_details").show();
  $("#igst_details").hide();
  $("#sgst_label").empty().append('<b>SGST ( ' + gstlist[1] + '.00% )</b>');
  $("#sgst_val").text(humanamount(orderdata_order.sgst));
}

function cgst_details() {
  $("#cgst_details").show();
  $("#cgst_label").empty().append('<b>CGST ( ' + gstlist[2] + '.00% )</b>');
  $("#cgst_val").text(humanamount(orderdata_order.cgst));
}

function igst_details() {
  $("#sgst_details").hide();
  $("#cgst_details").hide();
  $("#igst_details").show();
  $("#igst_label").empty().append('<b>IGST ( ' + gstlist[1] + '.00% )</b>');
  $("#igst_val").text(humanamount(orderdata_order.igst));
}

function fillorderfooter(subtotal, ordertotal) {
  $("#ordertotal_txt").text(humanamount(subtotal));
  $("#total_val").text(humanamount(ordertotal));
  $("#id_order_total_edit").val(subtotal);
  $("#id_sub_total_edit").val(subtotal);
}

function fillorder(val) {
  if (val) {
    fillorderbody(val);
    fillorderfooter(orderdata_order.sub_total, orderdata_order.ordertotal);
    $("#id_orderblock").show();
  }
}

function fillinvoices_body(val, listname) {
  $("#id_invoiceblock_body").empty().append('<table class="table"><thead><tr><th>Item</th><th>Description</th><th>Qty.</th><th>UOM</th><th>Unit Price</th><th>Total</th><th></th></tr></thead><tbody id="id_invoicebody"></tbody></table>');
  $.each(val, function (index, value) {
    $("#id_invoicebody").append('<tr><td>' + value.item + '</td><td>' + value.description + '</td><td>' + value.qty + '</td><td>' + value.uom_id + '</td><td>' + value.unit_price + '</td><td>' + value.total + '</td><td><button type="button" class="btn btn-sm btn-light generate" data-id="' + value.id + '" data-id="' + listname + '">Generate&nbsp; <i class="fas fa-chevron-right"></i></button></td></tr>');
  });
  $("#id_invoiceblock_footer").empty().hide();
}

function fillinvoices_footer(val, listname) {
  $("#preview_modal_body").append('<div class="row"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12 mt-3"><div class="card"><div class="card-body"><table class="table"><thead><tr><th>Item</th><th>Description</th><th>Qty.</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label><input type="date" class="form-control ftsm" name="invoice_date" id="id_invoicedate"></div></div></div></div>');
  $.each(val, function (index, value) {
    $("#preview_tbody").append('<tr><td class="max100"><input type="text" name="item" id="id_item" class="form-control"></td><td class="max150"><input type="text" name="description" id="id_description" class="form-control"></td><td></td><td></td><td></td><td></td></tr>');
  });
}

function orderdetails() {
  $("#id_pono").val(orderdata_order.po_no);
  $("#id_salesperson").val(orderdata_order.sales_person);
  $("#bill_id").val(orderdata_order.bill_to);
  $("#ship_id").val(orderdata_order.ship_to);
  setordertype(orderdata_order.order_type);
  fillorder(orderdata.items);
  $("#id_invoiceblock").show();
  fieldlist = [1, 2]
  if (fieldlist.includes(orderdata.order_type, 0)) {
    fillinvoices_body(orderdata.items, 'item');
  } else {
    fillinvoices_body(orderdata.payment_term, 'payment_term');
  }
}

$("#id_orderid").change(function () {
  resetonorder();
  if ($(this).val()) {
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getdetails/" + $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        orderdata = data;
        orderdata_order = orderdata.order;
        gst_details(customerid);
        orderdetails();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});

$(document).on("click", ".generate", function () {
  $("#preview_modal").trigger('click');
  fieldlist = [1, 2]
  if (fieldlist.includes(orderdata.order_type, 0)) {
    fillinvoices_footer(orderdata.payment_term, 'payment_term');
  } else {
    fillinvoices_footer(orderdata.payment_term, 'payment_term');
  }
});