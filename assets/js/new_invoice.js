var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
var groupdata, customerid, customerdata, orderdata, orderdata_order, gstlist, previewlist = [], oldgen = 0;

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
        $("#customerid_id").removeAttr('disabled');
        filldata("#customerid_id", groupdata, "Select Customer", ['id', 'name']);
        if (groupdata.length == 1) {
          $("#customerid_id").val(groupdata[0].id);
          $("#customerid_id").trigger('change');
          $("#id_orderid").removeAttr('disabled');
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

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
        $("#id_orderid").removeAttr('disabled');
        customerdata = data
        filldata("#id_orderid", customerdata, "Select Order", ['id', 'po_no']);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
    customerid = $(this).val();
  }
});

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

function resetongroup() {
  $("#customerid_id").empty().attr('disabled', true);
  resetoncustomer();
}

function filldata(id, data, msg, field) {
  $(id).empty().append("<option value=''>" + msg + "</option>");
  $.each(data, function (index, value) {
    val = []
    for (var key in value) { if (field.includes(key, 0)) { val.push(value[key]); } }
    $(id).append("<option value='" + val[0] + "'>" + val[1] + "</option>");
  });
}

function resetoncustomer() {
  $("#id_orderid").empty().attr('disabled', true);
  resetonorder();
}

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

function resetonorder() {
  $("#id_orderblock").hide();
  $("#orderlist").empty();
  $("#id_invoiceblock").hide();
  $("#id_invoiceblock_body").empty();
  $("#preview_modal_body").empty();
  $("#id_invoiceblock_body").empty();
}

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

$(document).on("click", ".paytrm", function () {
  $("#generate_" + oldgen).attr('disabled', true);
  $("#generate_" + $(this).data('id')).removeAttr('disabled');
  oldgen = $(this).data('id');
});

function fillinvoices_body(val, listname) {
  if (val) {
    $("#id_invoiceblock_body").empty().append('<table class="table"><thead><tr><th>Item</th><th>Description</th><th>Qty.</th><th>UOM</th><th>Unit Price</th><th>Total</th><th></th></tr></thead><tbody id="id_invoicebody"></tbody></table>');
    $.each(val, function (index, value) {
      if (listname == 'items') {
        $("#id_invoicebody").append('<tr><td><div class="icheck-primary d-inline"><input type="radio" id="id_paytrm' + index + '" name="payment_term" class="paytrm" data-id="' + index + '"><label for="id_paytrm' + index + '"></label></div></td><td>' + value.item + '</td><td>' + value.description + '</td><td>' + value.qty + '</td><td>' + setuom(value.uom_id) + '</td><td>' + value.unit_price + '</td><td>' + value.total + '</td><td><button type="button" class="btn btn-sm btn-light generate" id="generate_' + index + '" data-id="' + index + '" data-list="' + listname + '" disabled>Generate&nbsp; <i class="fas fa-chevron-right"></i></button></td></tr>');
      } else {
        $("#id_invoicebody").append('<tr><td></td><td>' + value.item + '</td><td>' + value.description + '</td><td>' + value.qty + '</td><td>' + setuom(value.uom_id) + '</td><td>' + value.unit_price + '</td><td>' + value.total + '</td><td><button type="button" class="btn btn-sm btn-light generate" data-id="' + index + '" data-list="' + listname + '" >Generate&nbsp; <i class="fas fa-chevron-right"></i></button></td></tr>');
      }
    });
    $("#id_invoiceblock").show();
  }
}

function orderdetails() {
  $("#id_pono").val(orderdata_order.po_no);
  $("#id_salesperson").val(orderdata_order.sales_person);
  $("#bill_id").val(orderdata_order.bill_to);
  $("#ship_id").val(orderdata_order.ship_to);
  setordertype(orderdata_order.order_type);
  fillorder(orderdata.items);
  fieldlist = ["1", "2"]
  if (fieldlist.includes(orderdata_order.order_type, 0)) {
    if (orderdata.payment_term.length > 0) { fillinvoices_body(orderdata.payment_term, 'payment_term'); }
  } else {
    if (orderdata.items.length > 0) { fillinvoices_body(orderdata.items, 'items'); }
  }
}



function getordertype() {
  if (orderdata_order.order_type == 1) { return 'On-Site Support Sale' }
  else if (orderdata_order.order_type == 2) { return 'Project Sale' }
  else if (orderdata_order.order_type == 3) { return 'AMC Support Sale' }
  else if (orderdata_order.order_type == 4) { return 'Man-days-Support Sale' }
  else if (orderdata_order.order_type == 5) { return 'SAP License Sale' }
  else if (orderdata_order.order_type == 6) { return 'Hardware Sale' }
}

function preview_modal_body(val, listname) {
  $("#preview_modal_body").empty().append('<div class="row"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + getordertype() + '</div><div class="card-body"><table class="table"><thead><tr><th></th><th>Item</th><th>Description</th><th>Qty.</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div><div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label><input type="date" class="form-control ftsm" name="invoice_date" id="id_invoicedate"></div><div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label><input type="date" class="form-control ftsm" name="due_date" id="id_due_date"></div></div></div></div>');
  if (listname == "item") {
    $("#preview_tbody").empty();
    previewlist = []
    $.each(val, function (index, value) {
      $("#preview_tbody").append('<tr><input type="hidden" name="order_item_id[]" id="id_order_item_id' + index + '" value="' + value.id + '"><td><input type="text" name="item[]" id="id_item' + index + '" class="form-control" value="' + value.item + '"></td><td ><input type="text" class="form-control desp" name="description[]" id="id_descp' + index + '" value="' + value.description + '"></td><td class="minmax150"><input type="number" class="form-control qty" name="qty[]" id="id_qty' + index + '" min="1" value="0" data-index="' + index + '" data-up="' + value.unit_price + '" max="' + value.qty + '"></td><td class="pt-3" >' + setuom(value.uom_id) + '<input type="hidden" name="uom[]" id="id_uom' + index + '" value="' + value.uom_id + '"></td><td class="pt-3">₹' + value.unit_price + '<input type="hidden" name="unit_price[]" id="id_unitprice' + index + '" value="' + value.unit_price + '"></td><td id="preview_row_total' + index + '" class="pt-3">₹0.00</td><input type="hidden" name="total[]" id="id_total' + index + '" value="0"></tr>');
      previewlist.push(index);
    });
    preview_footer();
  } else {
    $("#preview_tbody").empty().append('<tr><td class="max100"><input type="text" name="item" id="id_item" class="form-control" value="' + val.item + '"></td><td class="max150"><input type="text" name="description" id="id_description" class="form-control" value="' + val.description + '"></td><td>' + val.qty + '</td><td>' + setuom(val.uom_id) + '</td><td>' + val.unit_price + '</td><td>' + val.total + '</td></tr>');
    $("#preview_footer").hide();
  }
  $("#id_invoicedate").val(today);
  $('#id_due_date').attr("min", tomorrow).val(tomorrow);
}

function previewttotal() {
  subtotal = 0;
  $.each(previewlist, function (index, value) {
    subtotal += parseFloat($("#id_total" + value).val());
  });
  $("#preview_subtotal_txt").text(humanamount(subtotal));
  if (parseInt(orderdata_order.tax_rate) == 9) {
    gst = subtotal * ($("#preview_sgst_val").data('gst') / 100)
    $("#preview_sgst_val").text(humanamount(gst));
    $("#preview_cgst_val").text(humanamount(gst));
    $("#id_sgst_edit").val(gst);
    $("#id_cgst_edit").val(gst);
    total = subtotal + gst + gst
  }
  else {
    gst = subtotal * ($("#preview_igst_val").data('gst') / 100)
    $("#preview_igst_val").text(humanamount(gst));
    $("#id_igst_edit").val(gst);
    total = subtotal + gst
  }
  $("#id_ordertotal_edit").val(total);
  $("#preview_total_val").text(humanamount(total));
}

function previewtotal(index, value) {
  $("#preview_row_total" + index).text(humanamount(value));
  $("#id_total" + index).val(value);
  previewttotal();
}

$(document).on("change", ".qty", function () {
  previewtotal($(this).data('index'), $(this).val() * $(this).data('up'));
});

function preview_footer() {
  if (parseInt(orderdata_order.tax_rate) == 9) {
    $("#preview_footer").append('<div class="row text-center" id="preview_footer_row"><div class="col-3"><b>Sub Total : </b><span id="preview_subtotal_txt">₹0.00</span></div></div>');

    $("#preview_footer_row").append('<div class="col-3"><input type="hidden" name="sgst" id="id_sgst_edit"><b>SGST ( <span>' + parseInt(orderdata_order.tax_rate) + ' %</span> ) : </b><span id="preview_sgst_val" data-gst="' + parseInt(orderdata_order.tax_rate) + '">₹0.00</span></div><div class="col-3"><input type="hidden" name="cgst" id="id_cgst_edit"><input type="hidden" name="igst" id="id_igst_edit" value="0.00"><b>CGST ( <span>' + parseInt(orderdata_order.tax_rate) + ' %</span> ) : </b> <span id="preview_cgst_val">₹0.00</span> </div>');

    $("#preview_footer_row").append('<div class="col-3" id="preview_total_details" style="color: mediumslateblue;"> <b>Total</b> <span id="preview_total_val">₹0.00</span> </div>');
  }
  if (parseInt(orderdata_order.tax_rate) == 18) {
    $("#preview_footer").append('<div class="row text-center" id="preview_footer_row"><div class="col-4"><b>Sub Total : </b><span id="preview_subtotal_txt">₹0.00</span></div></div>');

    $("#preview_footer_row").append('<div class="col-4"><input type="hidden" name="sgst" id="id_sgst_edit" value="0.00"><input type="hidden" name="cgst" id="id_cgst_edit" value="0.00"><input type="hidden" name="igst" id="id_igst_edit"><b>IGST ( <span>' + parseInt(orderdata_order.tax_rate) + ' %</span> ) : </b><span id="preview_igst_val" data-gst="' + parseInt(orderdata_order.tax_rate) + '">₹0.00</span> </div>');

    $("#preview_footer_row").append('<div class="col-4" id="preview_total_details" style="color: mediumslateblue;"><input type="hidden" name="invoice_total" id="id_ordertotal_edit"><b>Total</b> <span id="preview_total_val">₹0.00</span> </div>');
  }

}

$(document).on("click", ".generate", function () {
  $("#preview_modal").trigger('click');
  fieldlist = ["1", "2"]
  if (fieldlist.includes(orderdata_order.order_type, 0)) {
    preview_modal_body(orderdata.payment_term[$(this).data('id')], 'payment_term')
  } else {
    preview_modal_body(orderdata.items, 'item');
  }
  // $("#preview_modal").trigger('click');
});