var groupdata,
  customerid,
  customerdata,
  orderdata,
  od_order,
  od_items,
  od_invoices,
  od_invoiceitems,
  firstselector = [],
  od_payment_term,
  gstlist,
  previewlist = [1],
  oldgen = 0,
  first_checked_ordertype = [],
  paytermlist = [],
  payterm_ordertype = ["1", "2", "3"],
  proformaguard = true;

var tree = {},
  items_for_invoicing = [],
  payment_for_invoicing = [];

function createbookeeper() {
  for (var key in od_order) {
    tree[key] = od_order[key];
  }
  tree["items"] = { ids: [] };
  tree["invoice"] = { ids: [] };
  tree["proforma"] = { ids: [] };
  $.each(od_proforma, function (iProforma, proforma) {
    tree["proforma"][proforma.id] = proforma
  });
  $.each(od_invoices, function (iInvoices, invoice) {
    tree["invoice"][invoice.id] = invoice
  });
  $.each(od_items, function (i, item) {
    tree["items"]["ids"].push(item.id);
    tree["items"][item.id] = item
    tree["items"][item.id]["ot"] = item.order_type
    tree["items"][item.id]["payment"] = { ids: [] }
    tree["items"][item.id]["proforma"] = { ids: [] }
    tree["items"][item.id]["invoice"] = { ids: [] }
    // Payment Terms Order Types Leaves
    if (item.order_type < 4 || item.order_type == 7) {
      $.each(od_payment_term, function (j, payment) {
        if (payment.order_item_id == item.id) {
          tree["items"][item.id]["payment"]["ids"].push(payment.id);
          tree["items"][item.id]["payment"][payment.id] = payment
          tree["items"][item.id]["payment"][payment.id]["ot"] = item.order_type
          tree["items"][item.id]["payment"][payment.id]["invoice"] = { ids: [] }
          $.each(od_invoiceitems, function (k, invoiceItem) {
            if (item.id == invoiceItem.order_item_id && payment.id == invoiceItem.order_payterm_id) {
              tree["items"][item.id]["payment"][payment.id]["invoice"]["ids"].push(invoiceItem.id);
              tree["items"][item.id]["payment"][payment.id]["invoice"][invoiceItem.id] = invoiceItem
              tree["items"][item.id]["payment"][payment.id]["invoice"]["ot"] = item.order_type
            }
          });
          tree["items"][item.id]["payment"][payment.id]["proforma"] = { ids: [] }
          $.each(od_proforma_items, function (k, proforma) {
            if (item.id == proforma.order_item_id && payment.id == proforma.order_payterm_id) {
              tree["items"][item.id]["payment"][payment.id]["proforma"]["ids"].push(proforma.id);
              tree["items"][item.id]["payment"][payment.id]["proforma"][proforma.id] = proforma
              tree["items"][item.id]["payment"][payment.id]["proforma"]["ot"] = item.order_type
            }
          });
        }
      });
    } else {
      $.each(od_invoiceitems, function (k, invoiceItem) {
        if (item.id == invoiceItem.order_item_id && 0 == invoiceItem.order_payterm_id) {
          tree["items"][item.id]["invoice"]["ids"].push(invoiceItem.id);
          tree["items"][item.id]["invoice"][invoiceItem.id] = invoiceItem
          tree["items"][item.id]["invoice"]["ot"] = item.order_type
        }
      });
      $.each(od_proforma_items, function (k, proforma) {
        if (item.id == proforma.order_item_id && 0 == proforma.order_payterm_id) {
          tree["items"][item.id]["proforma"]["ids"].push(proforma.id);
          tree["items"][item.id]["proforma"][proforma.id] = proforma
          tree["items"][item.id]["proforma"]["ot"] = item.order_type
        }
      });
    }
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
        if (data != false) {
          groupdata = data;
          $("#customerid_id").removeAttr("readonly");
          filldata("#customerid_id", groupdata, "Select Customer", [
            "id",
            "name",
          ]);
          if (groupdata.length == 1) {
            $("#customerid_id").val(groupdata[0].id);
            $("#customerid_id").trigger("change");
            $("#id_orderid").removeAttr("readonly");
          }
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

$("#customerid_id").change(function () {
  resetoncustomer();
  if ($(this).val()) {
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/getOrderListByCustomer/" + $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#id_orderid").removeAttr("readonly");
        customerdata = data;
        filldata("#id_orderid", customerdata, "Select Order", [
          "id",
          "po_no",
          "item",
        ]);
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
        od_order = orderdata.order;
        od_items = orderdata.items;
        od_invoices = orderdata.invoices;
        od_invoiceitems = orderdata.invoice_items;
        od_payment_term = orderdata.payment_term;
        od_proforma = orderdata.proforma;
        od_proforma_items = orderdata.proforma_items;
        createbookeeper();
        $("#setheader").text(setheader(od_order.order_type));
        gst_details(customerid);
        orderdetails();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});

$(document).on("click", ".generate", function () {
  preview_builder();
  refreshpreview();
  // preview_modal_body($(this).data("id"), $(this).data("list"));
  preview_footer($(this).data("id"), $(this).data("list"));
  $("#preview_modal").trigger("click");
});

$(document).on("click", ".proforma", function () {
  proforma_guard()
  if (proformaguard) {
    $.each(items_for_invoicing, function (i, x) {
      if ($("#id_proforma_" + x.id).is(':checked') == false) {
        if ($("#id_paytrm" + x.id).is(':checked')) {
          $("#id_paytrm" + x.id).trigger("click");
        }
      };
    });
    $.each(payment_for_invoicing, function (j, y) {
      if ($("#id_proforma_" + y.order_item_id).is(':checked') == false) {
        if ($("#id_paytrm" + y.order_item_id + "_" + y.id).is(':checked')) {
          $("#id_paytrm" + y.order_item_id + "_" + y.id).trigger("click");
        }
      };
    });
  }
});

$(document).on("click", ".paytrm", function () {
  proforma_guard()

  if (proformaguard) {
    $.each(items_for_invoicing, function (i, x) {
      if ($("#id_proforma_" + x.id).is(':checked') == false) {
        $("#id_proforma_" + x.id).trigger("click");
      };
    });
    $.each(payment_for_invoicing, function (j, y) {
      if ($("#id_proforma_" + y.order_item_id).is(':checked') == false) {
        $("#id_proforma_" + y.order_item_id).trigger("click");
      };
    });
  }

  if ($(this).is(':checked')) {
    $("#generate_" + $(this).data("id")).show();
  } else {
    $("#generate_" + $(this).data("id")).hide();
  }
});

$(document).on("click", "#gene", function () {
  $(this).attr("disabled", true);
});

$(document).on("change", ".qty", function () {
  if ($("#id_uom" + $(this).data("index")).val() != 3) {
    val = $("#id_qty" + $(this).data("index")).val() * $("#id_unitprice" + $(this).data("index")).val()
  } else {
    val = parseInt($("#id_qty" + $(this).data("index")).val()) / 100 * parseFloat($("#id_unitprice" + $(this).data("index")).val())
  }
  previewtotal($(this).data("index"), val);
  preview_total();
});

$(document).on("click", ".pdf", function () {
  url = $(this).data("href");
  error =
    '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>';
  $.get(url)
    .done(function (responseText) {
      a = responseText;
      if (a.search("Customer List") < 0) {
        $("#modal_body")
          .empty()
          .append(
            '<embed src="' +
            url +
            '" type="application/pdf" style="width: 100%; height: 513px;">'
          );
      } else {
        $("#modal_body").empty().append(error);
      }
    })
    .fail(function () {
      $("#modal_body").empty().append(error);
    });
  $("#modelpdf").click();
});

function orderdetails() {
  $("#id_pono").val(od_order.po_no);
  $("#id_salesperson").val(od_order.sales_person);
  $("#bill_id").val(od_order.bill_to);
  $("#ship_id").val(od_order.ship_to);
  setordertype(od_order.order_type);
  fillorder(od_items);
  fillinvoice_body();
}

function refreshpreview() {
  $("#togglepdf").text("Preview");
  $("#gene").hide();
  $("#t2").data("state", "hide").hide();
  $("#t1").data("state", "show").show();
}

function preview_builder() {
  var c = 0
  $("#preview_modal_body").empty().append(
    '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + preview_label() + 'Invoice</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>' +
    setheader(od_order.order_type) +
    '</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div> <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label> <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label> <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div> <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label> <input type="number" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div> </div></div></div><div class="row" id="t2" data-state="hide"></div>'
  );
  if (items_for_invoicing.length > 0) {
    $.each(items_for_invoicing, function (i, t) {
      if ($("#id_paytrm" + t.id).is(':checked')) {
        $("#preview_tbody").append(
          '<tr><td><input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="0"><input type="hidden" name="order_details[' + c + '][order_item_id]" id="id_order_item_id' + c + '" value="' + t.id + '"><input type="hidden" name="order_details[' + c + '][item]" id="id_item' + c + '" value="' + t.item + '"><input type="hidden" name="proforma" id="id_p_proforma' + c + '" value="' + get_proforma(t.id) + '">' + t.item + '</td><td ><input type="text" class="form-control desp" required name="order_details[' + c + '][description]" id="id_descp' + c + '" value="' + t.description + '"></td><td class="minmax150"><input type="number" class="form-control qty" required name="order_details[' + c + '][qty]" id="id_qty' + c + '" min="1" value="' + t.bal_qty + '" data-index="' + c + '" data-up="' + t.unit_price + '" data-uom="' + t.uom_id + '" max="' + t.bal_qty + '"></td><td class="pt-3" >' + get_uom_display(t.uom_id) + '<input type="hidden" required name="order_details[' + c + '][uom_id]" id="id_uom' + c + '" value="' + t.uom_id + '"></td><td class="pt-3"><input type="number" class="form-control pup" required style="width: 10rem;" name="order_details[' + c + '][unit_price]" data-index="' + c + '" data-up="' + t.unit_price + '" id="id_unitprice' + c + '" value="' + t.unit_price + '"></td><td id="preview_row_total' + c + '" class="pt-3">₹' + (t.unit_price * t.bal_qty) + '</td><input type="hidden" required name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + (t.unit_price * t.bal_qty) + '"></tr>');
        c++;
      }
    });
  }
  if (payment_for_invoicing.length > 0) {
    $.each(payment_for_invoicing, function (j, p) {
      if ($("#id_paytrm" + p.order_item_id + "_" + p.id).is(':checked')) {
        $("#preview_tbody").append(
          '<tr><td class="max100"><input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="' + p.id + '"><input type="hidden" name="order_details[' + c + '][order_item_id]" value="' + p.order_item_id + '"><input type="hidden" name="proforma" id="id_p_proforma' + c + '" value="' + get_proforma(p.order_item_id) + '">' + p.item + '<input type="hidden" name="order_details[' + c + '][item]" value="' + p.item + '"></td><td class="max150"><input type="text" required name="order_details[' + c + '][description]" id="id_description" class="form-control" value="' + p.description + '"></td><td>' + p.qty + ' <input type="hidden" name="order_details[' + c + '][qty]" value="' + p.qty + '"></td><td class="text-left">' + get_uom_display(p.uom_id) + '</td><td><input type="number" style="width: 10rem;" name="order_details[' + c + '][unit_price]" class="form-control pup" data-qty="' + p.qty + '" data-uom="' + p.uom_id + '" data-index="' + c + '" value="' + p.unit_price + '"><input type="hidden" name="order_details[' + c + '][uom_id]" value="' + p.uom_id + '"></td><td><span id="id_total_span' + c + '">' + p.total + '</span><input type="hidden" name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + p.total + '"></td></tr>');
        c++;
      }
    });
  }
}

$(document).on("change", ".pup", function () {
  if ($(this).data('uom') == 3) {
    $("#id_total_span" + $(this).data('index')).text($(this).val() * $(this).data('qty') / 100);
    $("#id_total" + $(this).data('index')).val($(this).val() * $(this).data('qty') / 100);
  } else {
    $("#id_total_span" + $(this).data('index')).text($(this).val());
    $("#id_total" + $(this).data('index')).val($(this).val());
  }
  $("#id_qty" + $(this).data('index')).trigger('change');
  preview_total()
});

$(document).on("change", "#id_invoice_no", function () {
  mydata = { invoice_no: $(this).val() };
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/invoice_validty/",
    data: mydata,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      if (data == false) {
        $(".say").remove();
        $("#id_invoice_no")
          .addClass("is-invalid")
          .parent()
          .append(
            '<span id="id_po_no-error" class="say error invalid-feedback">Invoice No exist.</span>'
          );
      } else {

      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("Cannot validate PO No.");
    });
});

function preview_modal_body(index, listname) {
  i = 0;
  if (listname == "items") {
    $("#preview_modal_body")
      .empty()
      .append(
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' +
        getordertype() +
        '</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>' +
        setheader(od_order.order_type) +
        '</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div> <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label> <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label> <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div> <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label> <input type="number" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div> </div></div></div><div class="row" id="t2" data-state="hide"></div>'
      );
    $("#preview_tbody").empty();
    remaining_qty = parseInt(od_items[index].qty);
    $.each(od_invoiceitems, function (i, value) {
      if (od_items[index].id == value.order_item_id) {
        remaining_qty -= value.qty;
      }
    });
    $("#preview_tbody").append(
      '<tr><td><input type="hidden" name="order_details[0][order_payterm_id]" value="0"><input type="hidden" name="order_details[0][order_item_id]" id="id_order_item_id1" value="' + od_items[index].id + '"><input type="hidden" name="order_details[0][item]" id="id_item1" value="' + od_items[index].item + '">' + od_items[index].item + '</td><td ><input type="text" class="form-control desp" required name="order_details[0][description]" id="id_descp1" value="' + od_items[index].description + '"></td><td class="minmax150"><input type="number" class="form-control qty" required name="order_details[0][qty]" id="id_qty1" min="1" value="' + remaining_qty + '" data-index="1" data-up="' + od_items[index].unit_price + '" data-uom="' + od_items[index].uom_id + '" max="' + remaining_qty + '"></td><td class="pt-3" >' + get_uom_display(od_items[index].uom_id) + '<input type="hidden" required name="order_details[0][uom_id]" id="id_uom1" value="' + od_items[index].uom_id + '"></td><td class="pt-3"><input type="number" required name="order_details[0][unit_price]" style="width: 10rem;" class="form-control pup" id="id_unitprice1" value="' + od_items[index].unit_price + '"></td><td id="preview_row_total1" class="pt-3">₹0.00</td>   <input type="hidden" required name="order_details[0][total]" id="id_total1" value="0"></tr>'
    );
    // previewlist.push(1);
    preview_footer(index, listname);
    $(".qty").trigger("change");
    preview_total();
  } else {
    $("#preview_modal_body")
      .empty()
      .append(
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' +
        getordertype() +
        '</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th>   <th>Qty./Unit</th><th>Unit Price</th><th>	Total Value</th> </tr></thead><tbody id="preview_tbody"></tbody></table></div><div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label><input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label><input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div><div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label>    <input type="number" class="form-control numberonly" pattern="[0-9]{7}" minlength="7" maxlength="7" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div></div></div></div><div class="row" id="t2" data-state="hide"></div>'
      );
    $("#preview_tbody").empty();

    $.each(firstselector, function (index, value) {
      $("#preview_tbody").append(
        '<tr><td class="max100"><input type="hidden" name="order_details[' + index + '][order_payterm_id]" value="' + od_payment_term[value].id + '"><input type="hidden" name="order_details[' + index + '][order_item_id]" value="' + od_payment_term[value].order_item_id + '">' + od_payment_term[value].item + '<input type="hidden" name="order_details[' + index + '][item]" value="' + od_payment_term[value].item + '"></td><td class="max150"><input type="text" required name="order_details[' + index + '][description]" id="id_description" class="form-control" value="' + od_payment_term[value].description + '">   </td><td>' + od_payment_term[value].qty + ' <input type="hidden" name="order_details[' + index + '][qty]" value="' + od_payment_term[value].qty + '"> / ' + get_uom_display(od_payment_term[value].uom_id) + '<input type="hidden" name="order_details[' + index + '][uom_id]" value="' + od_payment_term[value].uom_id + '"></td><td><input type="number" name="order_details[' + index + '][unit_price]" style="width: 10rem;" class="form-control pup" value="' + od_payment_term[value].unit_price + '"></td><td>' + od_payment_term[value].total + '  <input type="hidden" name="order_details[' + index + '][total]" value="' + od_payment_term[value].total + '"></td></tr>'
      );
      i += 1;
    });
    preview_footer(index, listname);
  }
  $("#id_due_date").attr("min", tomorrow);
}

function resetongroup() {
  $("#customerid_id").empty().attr("readonly", true);
  resetoncustomer();
}

function filldata(id, data, msg, field) {
  $(id)
    .empty()
    .append("<option value=''>" + msg + "</option>");
  $.each(data, function (index, value) {
    val = [];
    for (var key in value) {
      if (field.includes(key, 0)) {
        val.push(value[key]);
      }
    }
    if (val[2] != null) {
      $(id).append(
        "<option value='" +
        val[0] +
        "'>" +
        val[1] +
        " - " +
        val[2] +
        "</option>"
      );
    } else {
      $(id).append("<option value='" + val[0] + "'>" + val[1] + "</option>");
    }
  });
}

function resetoncustomer() {
  $("#id_orderid").empty().attr("readonly", true);
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
      gstlist.push(data.state);
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
  firstselector = [];
  $("#id_orderblock").hide();
  $("#orderlist").empty();
  $("#id_invoiceblock").hide();
  $("#preview_modal_body").empty();
  $("#id_invoiceblock_body").empty();
}

function setheader(index) {
  list = ["", "Month", "Payment Slab", "Qty."]
  return list[index]
}

function setordertype(val) {
  if (val == 2) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>Project Sale");
  } else if (val == 5) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>SAP License Sale");
  } else if (val == 1) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>On-Site Support Sale");
  } else if (val == 3) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>AMC Support Sale");
  } else if (val == 4) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>Man-days-Support Sale");
  } else if (val == 6) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>Hardware Sale");
  } else if (val == 7) {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>Open Order");
  } else {
    $("#id_ordertype")
      .show()
      .empty()
      .append("<label>Order Type :</label><br>Custom Order");
  }
}


function get_uom_display(index) {
  list = ["", "Day(s)", "AU", "Percentage (%)", "PC"]
  return list[index];
}

function fillorderbody(items) {
  $("#orderlist").empty();
  $.each(tree["items"]["ids"], function (i_item, value) {

    if ((tree["items"][value]["payment"]["ids"]).length > 0) {
      $("#orderlist").append('<tr data-widget="expandable-table" aria-expanded="false" id="parent_' + i_item + '"><td class="text-left"><i class="fas fa-caret-right fa-fw"></i>' + tree["items"][value]["item"] + '</td><td>' + tree["items"][value]["description"] + '</td><td>' + tree["items"][value]["qty"] + '</td><td>' + get_uom_display(tree["items"][value]["uom_id"]) + '</td><td>' + humanamount(tree["items"][value]["unit_price"]) + '</td><td>' + humanamount(tree["items"][value]["total"]) + '</td></tr>');
    } else {
      $("#orderlist").append('<tr id="parent_' + i_item + '"><td class="text-left">' + tree["items"][value]["item"] + '</td><td>' + tree["items"][value]["description"] + '</td><td>' + tree["items"][value]["qty"] + '</td><td>' + get_uom_display(tree["items"][value]["uom_id"]) + '</td><td>' + humanamount(tree["items"][value]["unit_price"]) + '</td><td>' + humanamount(tree["items"][value]["total"]) + '</td></tr>');
    }

    if ((tree["items"][value]["payment"]["ids"]).length > 0) {
      $("#orderlist").append('<tr class="expandable-body d-none" id="child_1_' + i_item + '"><td colspan="8"><div class="p-0" style="display: none;"><table class="table table-hover m-0"><tbody id="child_1_' + i_item + '_1"><tr><th style="width: 230px" class="text-info">Sr No.</th><th class="text-info">Description</th><th class="text-info"> Qty./Unit </th><th style="width: 165px" class="text-info">Unit Price</th><th style="width: 180px" class="text-info">Total</th></tr></tbody></table></div></td></tr>');
      $.each(tree["items"][value]["payment"]["ids"], function (i_payment, pay) {
        $("#child_1_" + i_item + "_1").append('<tr><td class="text-info">' + (i_payment + 1) + '</td><td class="text-info">' + tree["items"][value]["payment"][pay]["description"] + '</td><td class="text-info">' + tree["items"][value]["payment"][pay]["qty"] + '</td><td class="text-info">' + humanamount(tree["items"][value]["payment"][pay]["unit_price"]) + '</td><td class="text-info">' + humanamount(tree["items"][value]["payment"][pay]["total"]) + '</td></tr>');
      });
    }

  });
}

function sgst_details() {
  $("#sgst_details").show();
  $("#igst_details").hide();
  $("#sgst_label")
    .empty()
    .append("<b>SGST ( " + gstlist[1] + ".00% )</b>");
  $("#sgst_val").text(humanamount(od_order.sgst));
}

function cgst_details() {
  $("#cgst_details").show();
  $("#cgst_label")
    .empty()
    .append("<b>CGST ( " + gstlist[2] + ".00% )</b>");
  $("#cgst_val").text(humanamount(od_order.cgst));
}

function igst_details() {
  $("#sgst_details").hide();
  $("#cgst_details").hide();
  $("#igst_details").show();
  $("#igst_label")
    .empty()
    .append("<b>IGST ( " + gstlist[1] + ".00% )</b>");
  $("#igst_val").text(humanamount(od_order.igst));
}

function fillorderfooter(subtotal, ordertotal) {
  $("#ordertotal_txt").text(humanamount(subtotal));
  $("#total_val").text(humanamount(ordertotal));
  $("#id_order_total_edit").val(subtotal);
  $("#id_sub_total_edit").val(subtotal);
}

function fillorder(items) {
  // Filling Order Items
  if (items) {
    fillorderbody(items);
    fillorderfooter(od_order.sub_total, od_order.ordertotal);
    $("#id_orderblock").show();
  }
}

function getordertype() {
  if (od_order.order_type == 1) {
    return "On-Site Support Sale";
  } else if (od_order.order_type == 2) {
    return "Project Sale";
  } else if (od_order.order_type == 3) {
    return "AMC Support Sale";
  } else if (od_order.order_type == 4) {
    return "Man-days-Support Sale";
  } else if (od_order.order_type == 5) {
    return "SAP License Sale";
  } else if (od_order.order_type == 6) {
    return "Hardware Sale";
  }
}

function preview_total() {
  var c = 0
  var subtotal = 0;
  $.each(items_for_invoicing, function (index, value) {
    if ($("#id_paytrm" + value.id).is(':checked')) {
      subtotal += parseFloat($("#id_total" + c).val());
      c++;
    }
  });
  $.each(payment_for_invoicing, function (index, value) {
    if ($("#id_paytrm" + value.order_item_id + "_" + value.id).is(':checked')) {
      subtotal += parseFloat($("#id_total" + c).val());
      c++;
    }
  });
  $("#preview_subtotal_txt").text(humanamount(subtotal));
  $("#previewsubtotal").val(subtotal);
  if (parseInt(od_order.tax_rate) == 9) {
    gst = subtotal * ($("#preview_sgst_val").data("gst") / 100);
    $("#preview_sgst_val").text(humanamount(gst));
    $("#preview_cgst_val").text(humanamount(gst));
    $("#previewsgst").val(gst);
    $("#previewcgst").val(gst);
    total = subtotal + gst + gst;
  } else {
    gst = subtotal * ($("#preview_igst_val").data("gst") / 100);
    $("#preview_igst_val").text(humanamount(gst));
    $("#previewigst").val(gst);
    total = subtotal + gst;
  }
  $("#previewinvoice_total").val((total).toFixed(2));
  $("#preview_total_val").text(humanamount(total));
}

function previewtotal(index, value) {
  $("#preview_row_total" + index).text(humanamount(value));
  $("#id_total" + index).val(value);
  // preview_total();
}

function tax_system(tax, total, apitax = gstlist[1]) {
  if (apitax == parseInt(tax)) {
    return parseFloat(((tax / 100) * total).toFixed(2));
  } else {
    return 0;
  }
}

function listval(index, list, itemname) {
  if (list == "items") {
    return od_items[index];
  } else {
    return od_payment_term[index];
  }
}

function preview_footer(val, listname) {
  var total = 0,
    subtotal = 0,
    cgst_total = 0,
    sgst_total = 0,
    igst_total = 0, c = 0;
  $.each(items_for_invoicing, function (index, value) {
    if ($("#id_paytrm" + value.id).is(':checked')) {
      subtotal += parseFloat($("#id_total" + c).val());
      c++;
    }
  });
  $.each(payment_for_invoicing, function (index, value) {
    if ($("#id_paytrm" + value.order_item_id + "_" + value.id).is(':checked')) {
      subtotal += parseFloat($("#id_total" + c).val());
      c++;
    }
  });
  if (gstlist.length > 2) {
    sgst_total = (gstlist[1] / 100) * subtotal;
    cgst_total = (gstlist[2] / 100) * subtotal;
  } else {
    igst_total = (gstlist[1] / 100) * subtotal;
  }
  total = sgst_total + cgst_total + igst_total + subtotal;
  $("#preview_footer").append(
    '<div class="row text-center"><div id="previewigst"><b>Sub Total : </b><span id="preview_subtotal_txt">₹' +
    (subtotal).toFixed(2) +
    '</span></div><input type="hidden" name="sub_total" id="previewsubtotal" value="' +
    (subtotal).toFixed(2) +
    '"><div id="sgstclass" style="display: none;"><b>SGST ( <span>' +
    parseInt(gstlist[1]) +
    ' %</span> ) : </b>     <span id="preview_sgst_val" data-gst="' +
    parseInt(gstlist[1]) +
    '">₹ ' +
    (sgst_total).toFixed(2) +
    '</span><input type="hidden" name="sgst" id="previewsgst" value="' +
    (sgst_total).toFixed(2) +
    '"></div><div id="cgstclass" style="display: none;"><b>CGST ( <span>' +
    parseInt(gstlist[2]) +
    ' %</span> ) : </b>     <span id="preview_cgst_val">₹' +
    (cgst_total).toFixed(2) +
    '</span><input type="hidden" name="cgst" id="previewcgst" value="' +
    (cgst_total).toFixed(2) +
    '"></div><div id="igstclass" style="display: none;"><b>IGST ( <span>' +
    parseInt(gstlist[1]) +
    ' %</span> ) : </b><span id="preview_igst_val" data-gst="' +
    parseInt(gstlist[1]) +
    '">₹ ' +
    (igst_total).toFixed(2) +
    '</span><input type="hidden" name="igst" id="previewigst" value="' +
    (igst_total).toFixed(2) +
    '"></div><div id="totalclass" style="color: mediumslateblue;"><b>Total : </b><span id="preview_total_val">₹ ' +
    (total).toFixed(2) +
    '</span><input type="hidden" name="invoice_total" id="previewinvoice_total" value="' +
    (total).toFixed(2) +
    '"></div></div>'
  );
  if (parseInt(gstlist[1]) == 9) {
    $("#previewigst").addClass("col-3");
    $("#sgstclass").show().addClass("col-3");
    $("#cgstclass").show().addClass("col-3");
    $("#igstclass").hide().addClass("col-0");
    $("#preview_total_val").addClass("col-3");
  } else {
    $("#previewigst").addClass("col-4");
    $("#sgstclass").hide().addClass("col-0");
    $("#cgstclass").hide().addClass("col-0");
    $("#igstclass").show().addClass("col-4");
    $("#preview_total_val").addClass("col-4");
  }
}

function checker() {
  var check = true;
  if ($("#id_invoicedate").val() == "") {
    $("#id_invoicedate").addClass("is-invalid");
    check = false;
  }
  if ($("#id_due_date").val() == "") {
    $("#id_due_date").addClass("is-invalid");
    check = false;
  }
  if ($("#id_invoice_no").val().length != 7) {
    $("#id_invoice_no").addClass("is-invalid");
    check = false;
  }
  if (check) {
    if ($("#t1").data("state") == "show") {
      $("#t1").data("state", "hide").hide();
      $("#t2").data("state", "show").show();
      $("#togglepdf").text("Back To Editing");
      $("#gene").show();
      var formdata = $("#quickForm").serialize();
      $.ajax({
        type: "POST",
        url: baseUrl + "invoices/preview",
        data: formdata,
      })
        .done(function (data) {
          $("#t2")
            .empty()
            .append(data)
            .find("style")
            .remove()
            .children("div.container")
            .children("img")
            .css("max-width", "925px");
        })
        .fail(function (data) {
          debug("FAILED");
        });
    } else {
      refreshpreview();
    }
  }
}

function fillinvoice_body() {
  $("#id_invoiceblock").show();
  payment_for_invoicing = [];
  items_for_invoicing = [];
  var v_total = 0
  $("#id_invoiceblock_body").append('<table class="table" id="id_invoicetable"><tr><th><div class="icheck-primary d-inline"> <input type="checkbox" id="inv0" required class="paytrm"><label for="inv0"></label></div></th><th><div class="icheck-primary d-inline"> <input type="checkbox" id="pro0" required class="paytrm"><label for="pro0">Proforma</label></div></th><th>Item</th><th>Description</th><th>Qty./Unit</th><th>Unit Price</th><th>Total Value</th><th class="min110"></th></tr></table>');
  $.each(tree["items"]["ids"], function (iItm, itm) {
    var pt_list = []
    // List invoiced items and payment terms
    if ((tree["items"][itm]["invoice"]["ids"]).length > 0) {
      $.each(tree["items"][itm]["invoice"]["ids"], function (iInv, inv) {
        // Invoiced
        $("#id_invoicetable").append('<tr><td></td><td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="id_proforma' + itm + '" ' + check_proforma(tree["items"][itm]["invoice"][inv]["order_item_id"], tree["items"][itm]["invoice"][inv]["order_payterm_id"]) + '><label for="id_proforma' + itm + '"></label></div> </td><td>' + tree["items"][itm]["invoice"][inv].item + "</td><td>" + tree["items"][itm]["invoice"][inv].description + "</td><td>" + tree["items"][itm]["invoice"][inv].qty + " / " + get_uom_display(tree["items"][itm]["invoice"][inv].uom_id) + "</td><td>" + humanamount(tree["items"][itm]["invoice"][inv].unit_price) + "</td><td>" + humanamount(tree["items"][itm]["invoice"][inv].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + "pdf/invoice_" + tree["items"][itm]["invoice"][inv]["invoice_no"] + '.pdf" type="button">View Invoice</button></td></tr>');
        if (tree["items"][itm]["invoice"][inv].order_payterm_id != 0) {
          // Capturing invoiced Payment term Ids
          pt_list.push(tree["items"][itm]["invoice"][inv].order_payterm_id);
        }
      });
    };
    // List non-invoiced order items
    if (3 < tree["items"][itm].order_type && tree["items"][itm].order_type < 7 || (tree["items"][itm].hasOwnProperty('payment') == true && tree["items"][itm]["payment"]["ids"]).length == 0) {
      if (tree["items"][itm].bal_qty > 0) {
        $("#id_invoicetable").append('<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" class="cbox genebox" id="id_paytrm' + itm + '" required class="paytrm" data-id="' + itm + '" checked><label for="id_paytrm' + itm + '"></label></div></td><td> <div class="icheck-primary d-inline"> <input type="checkbox"  class="cbox probox" class="proforma" id="id_proforma_' + itm + '" required class="" data-id="' + itm + '" ><label for="id_proforma_' + itm + '"></label></div></td><td>' + tree["items"][itm].item + "</td><td>" + tree["items"][itm].description + "</td><td>" + tree["items"][itm].bal_qty + "</td><td>" + humanamount(tree["items"][itm].unit_price) + "</td><td>" + humanamount(tree["items"][itm].bal_qty * tree["items"][itm].unit_price) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '" data-id="' + iItm + '" data-list="items" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
        v_total += parseFloat(tree["items"][itm].total)
        items_for_invoicing.push(tree["items"][itm]);
      }
      // }
    }
    // List non-invoiced payment terms & cleared
    var unchecked_paymentterm = false
    if (tree["items"][itm].order_type < 4 && (tree["items"][itm]["payment"]["ids"]).length > 0) {
      $.each(tree["items"][itm]["payment"]["ids"], function (iPtm, ptm) {
        if (pt_list.includes(ptm) == false) {
          if (unchecked_paymentterm) {
            // List disabled payment terms
            // $("#id_invoicetable").append('<tr><td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="id_paytrm' + iI + '_' + pTI + '" required class="paytrm" data-id="' + iI + '_' + pTI + '" disabled><label for="id_paytrm' + iI + '_' + pTI + '"></label></div></td><td></td><td>' + tree["items"][iI]["payment"][pTI].item + "</td><td>" + tree["items"][iI]["payment"][pTI].description + "</td><td>" + tree["items"][iI]["payment"][pTI].qty + " / " + get_uom_display(tree["items"][iI]["payment"][pTI].uom_id) + "</td><td>" + humanamount(tree["items"][iI]["payment"][pTI].unit_price) + "</td><td>" + humanamount(tree["items"][iI]["payment"][pTI].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' + b + '" data-id="' + b + '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
          } else {
            unchecked_paymentterm = true
            // List enabled payment terms
            $("#id_invoicetable").append('<tr><td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="id_paytrm' + itm + '_' + ptm + '" required class="paytrm" data-id="' + itm + '_' + ptm + '" checked><label for="id_paytrm' + itm + '_' + ptm + '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox"  class="cbox probox" class="proforma" id="id_proforma_' + itm + '" required class="" data-id="' + itm + '" ><label for="id_proforma_' + itm + '"></label></div></td><td>' + tree["items"][itm]["payment"][ptm].item + "</td><td>" + tree["items"][itm]["payment"][ptm].description + "</td><td>" + tree["items"][itm]["payment"][ptm].qty + " / " + get_uom_display(tree["items"][itm]["payment"][ptm].uom_id) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].unit_price) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '_' + ptm + '" data-id="' + iItm + '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
            v_total += parseFloat(tree["items"][itm]["payment"][ptm].total)
            payment_for_invoicing.push(tree["items"][itm]["payment"][ptm]);
          }
        }
      });
    }
    // List non-invoiced Custom order items
    if (tree["items"][itm].order_type == 7) {
      // List enabled order items
      $("#id_invoicetable").append('<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" class="cbox genebox" id="id_paytrm' + itm + '" required class="paytrm" data-id="' +
        itm + '" checked><label for="id_paytrm' + itm + '"></label></div></td><td></td><div class="icheck-primary d-inline"> <input type="checkbox"  class="cbox probox" class="proforma" id="id_proforma_' + itm + '" required class="" data-id="' + itm + '"><label for="id_proforma_' + itm + '"></label></div><td>' + tree["items"][itm].item + "</td><td>" + tree["items"][itm].description + "</td><td>" + tree["items"][itm].bal_qty + "</td><td>" + humanamount(tree["items"][itm].unit_price) + "</td><td>" + humanamount(tree["items"][itm].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '" data-id="' + iItm + '" data-list="items" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
      v_total += parseFloat(tree["items"][itm].total)
      items_for_invoicing.push(tree["items"][itm]);
      var unchecked_custom = false
      $.each(tree["items"][itm]["payment"]["ids"], function (iPtm, ptm) {
        if (unchecked_custom) {
          // List disabled payment terms
          $("#id_invoicetable").append('<tr><td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="id_paytrm' + itm + '_' + ptm + '" required class="paytrm" data-id="' + itm + '_' + ptm + '" disabled><label for="id_paytrm' + itm + '_' + ptm + '"></label></div></td><td></td><td>' + tree["items"][itm]["payment"][ptm].item + "</td><td>" + tree["items"][itm]["payment"][ptm].description + "</td><td>" + tree["items"][itm]["payment"][ptm].qty + " / " + get_uom_display(tree["items"][itm]["payment"][ptm].uom_id) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].unit_price) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' + itm + '_' + ptm + '" data-id="' + iItm + '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
        } else {
          unchecked_custom = true
          // List enabled payment terms
          $("#id_invoicetable").append('<tr><td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="id_paytrm' + itm + '_' + ptm + '" required class="paytrm" data-id="' + itm + '_' + ptm + '" checked><label for="id_paytrm' + itm + '_' + ptm + '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" disabled class="proforma cbox probox" id="id_proforma_' + itm + '" required class="" data-id="' + itm + '" ><label for="id_proforma_' + itm + '"></label></div></td><td>' + tree["items"][itm]["payment"][ptm].item + "</td><td>" + tree["items"][itm]["payment"][ptm].description + "</td><td>" + tree["items"][itm]["payment"][ptm].qty + " / " + get_uom_display(tree["items"][itm]["payment"][ptm].uom_id) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].unit_price) + "</td><td>" + humanamount(tree["items"][itm]["payment"][ptm].total) + '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '_' + ptm + '" data-id="' + iItm + '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>');
          v_total += parseFloat(tree["items"][itm]["payment"][ptm].total)
          payment_for_invoicing.push(tree["items"][itm]["payment"][ptm]);
        }
      });
    }
  });
  $("#id_invoiceblock_body").append('<input type="hidden" name="order_total" value="' + v_total + '">');
}

$(document).on("click", "#inv0", function () {
  if ($("#inv0").is(':checked')) {
    $(".genebox").each(function () {
      if ($(this).is(':checked') == false) {
        $(this).trigger('click');
      }
    });
  }
  else {
    $(".genebox").each(function () {
      if ($(this).is(':checked')) {
        $(this).trigger('click');
      }
    });
  }
});

$(document).on("click", "#pro0", function () {
  if ($("#pro0").is(':checked')) {
    $(".probox").each(function () {
      if ($(this).is(':checked') == false) {
        $(this).trigger('click');
      }
    });
  }
  else {
    $(".probox").each(function () {
      if ($(this).is(':checked')) {
        $(this).trigger('click');
      }
    });
  }
});

function check_proforma(item_id, paymentterm_id) {
  var check = true;
  $.each(od_proforma_items, function (i, item) {
    if (item.order_item_id == item_id && item.order_payterm_id == paymentterm_id) {
      check = false
    }
  });
  if (check) {
    return ""
  } else {
    return 'checked';
  }
}

function get_proforma(value) {
  if ($("#id_proforma_" + value).is(':checked')) {
    return 1
  }
  else {
    return 0
  }
}

function proforma_guard() {
  // Reseting performa to grab change
  proformaguard = false
  // Looping over invoicing items for performa tick
  $.each(items_for_invoicing, function (i, x) {
    if ($("#id_paytrm" + x.id).is(':checked')) {
      if ($("#id_proforma_" + x.id).is(':checked')) {
        proformaguard = true
      }
    }
  });
  $.each(payment_for_invoicing, function (j, y) {
    if ($("#id_paytrm" + y.order_item_id + "_" + y.id).is(':checked')) {
      if ($("#id_proforma_" + y.order_item_id).is(':checked')) {
        proformaguard = true
      }
    }
  });
}

function preview_label() {
  if (proformaguard) { return "Proforma "; } else {
    return "";
  }
}
