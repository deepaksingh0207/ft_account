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
  oldgen = 0,
  previewList = [],
  paytermlist = [],
  payterm_ordertype = ["1", "2", "3"],
  proformaguard = false,
  tree = {},
  items_for_invoicing = [];

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
        filldata("#id_orderid", customerdata, "Select Order", ["id", "po_no", "item",]);
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
        fillsalesperson(customerid);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No Order Item details found against this order.");
      });
  }
});

function fillsalesperson(id) {
  $.ajax({
    type: "POST",
    url: baseUrl + "customers/getdetails/" + id,
    data: id,
    dataType: "json",
    encode: true,
  })
    .done(function (r) {
      $("#id_salesperson").val(r.contact_person);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("No details found against this customer.");
      console.log(jqXHR, textStatus, errorThrown);
    });
}

$(document).on("click", ".generate", function () {
  preview_builder();
  refreshpreview();
  // preview_modal_body($(this).data("id"), $(this).data("list"));
  preview_footer($(this).data("id"), $(this).data("list"));
  $("#preview_modal").trigger("click");
});

$(document).on("click", ".genebox", function () {
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
  var rowId = $(this).data("index");
  if ($("#id_qty" + rowId).data("uom") != 3) {
    val = $("#id_qty" + rowId).val() * $("#id_unitprice" + rowId).val()
  } else {
    val = parseInt($("#id_qty" + rowId).val()) / 100 * parseFloat($("#id_unitprice" + rowId).val())
  }
  previewtotal(rowId, val);
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
  // $("#id_salesperson").val(od_order.sales_person);
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
  proformaguard = false;
  var check = false;
  $.each(items_for_invoicing, function (i, id) {
    if ($("#" + id).is(':checked')) {
      var item = $("#" + id).data("item");
      var payment = $("#" + id).data("payment");
      var proformaId = $("#" + id).data("proformaid");
      if ($("#" + proformaId).is(':checked') && $("#" + proformaId).is(':disabled')) {
        check = true;
      } else if ($("#" + proformaId).is(':checked')) {
        proformaguard = true;
      } else {
        check = true;
      }
    }
  });
  $("#preview_modal_body").empty();
  if (check == proformaguard) {
    $("#preview_modal_body").append("Either created Proforma or Tax Invoice");
  } else {
    var c = 0
    previewList = []
    $("#preview_modal_body").empty().append(
      '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + preview_label() + 'Invoice</div><div class="card-body p-0"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>' + setheader(od_order.order_type) + '</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div> <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label> <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate" value="2021-12-16"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label> <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date" value="2021-12-16"></div> <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label> <input type="number" value="000000" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div> </div></div></div><div class="row" id="t2" data-state="hide"></div>'
    );
    // if (proformaguard){
    //   $("#preview_tbody").append('<input type="hidden" name="proforma" value="1">');
    // } else {
    //   $("#preview_tbody").append('<input type="hidden" name="proforma" value="0">');
    // }
    $.each(items_for_invoicing, function (i, id) {
      var item = $("#" + id).data("item");
      var payment = $("#" + id).data("payment");
      var proforma = $("#" + id).data("proforma");
      if (payment == 0) {
        if (proforma == 0) {
          t = tree["items"][item]
        } else {
          t = tree["items"][item]["proforma"][proforma]
        }
      } else {
        if (proforma == 0) {
          t = tree["items"][item]["payment"][payment]
        } else {
          t = tree["items"][item]["payment"][payment]["proforma"][proforma]
        }
      }
      if ($("#" + id).is(':checked')) {
        $("#preview_tbody").append('<tr id="ptb' + c + '"></tr>');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="' + payment + '">');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][order_item_id]" id="id_order_item_id' + c + '" value="' + item + '">');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][item]" id="id_item' + c + '" value="' + t.item + '">');
        $("#ptb" + c).append('<td><input type="hidden" name="proforma" id="id_p_proforma' + c + '" value="' + get_proforma(item, payment) + '">' + t.item + '</td>');
        if (proformaguard == false) {
          if (t.hasOwnProperty('proforma_invoice_item_id')) {
            $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][proforma_invoice_item_id]" value="' + t.proforma_invoice_item_id + '">');
          } else {
            $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][proforma_invoice_item_id]" value="0">');
          }
        }
        $("#ptb" + c).append('<td ><input type="text" class="form-control desp" required name="order_details[' + c + '][description]" id="id_descp' + c + '" value="' + t.description + '"></td>');
        $("#ptb" + c).append('<td class="minmax150"><input type="number" class="form-control qty" required name="order_details[' + c + '][qty]" id="id_qty' + c + '" min="1" value="' + t.qty + '" data-index="' + c + '" data-up="' + t.unit_price + '" data-uom="' + t.uom_id + '" max="' + t.qty + '"></td>');
        $("#ptb" + c).append('<td class="pt-3" >' + get_uom_display(t.uom_id) + '<input type="hidden" required name="order_details[' + c + '][uom_id]" id="id_uom' + c + '" value="' + t.uom_id + '"></td>');
        $("#ptb" + c).append('<td class="pt-3"><input type="number" class="form-control pup" required style="width: 10rem;" name="order_details[' + c + '][unit_price]" data-index="' + c + '" data-up="' + t.unit_price + '" id="id_unitprice' + c + '" value="' + t.unit_price + '"></td>');
        $("#ptb" + c).append('<td id="preview_row_total' + c + '" class="pt-3">₹' + t.total + '</td>');
        $("#ptb" + c).append('<input type="hidden" required name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + t.total + '">');
        previewList.push(c)
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
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + getordertype() + '</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>' + setheader(od_order.order_type) + '</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div> <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label> <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label> <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div> <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label> <input type="number" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div> </div></div></div><div class="row" id="t2" data-state="hide"></div>'
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
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + getordertype() + '</div><div class="card-body p-0"> <table class="table"><thead><tr><th>Item</th><th>Description</th>   <th>Qty./Unit</th><th>Unit Price</th><th>	Total Value</th> </tr></thead><tbody id="preview_tbody"></tbody></table></div><div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label><input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label><input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div><div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label>    <input type="number" class="form-control numberonly" pattern="[0-9]{7}" minlength="7" maxlength="7" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div></div></div></div><div class="row" id="t2" data-state="hide"></div>'
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
      $(id).append("<option value='" + val[0] + "'>" + val[1] + " - " + val[2] + "</option>");
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
  list[99] = "Qty."
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
  $("#subtotal_details").removeClass("col-4");
  $("#subtotal_details").addClass("col-3");
  $("#total_details").removeClass("col-4");
  $("#total_details").addClass("col-3");
  $("#sgst_label").empty().append("<b>SGST ( " + gstlist[1] + ".00% )</b>");
  $("#sgst_val").text(humanamount(od_order.sgst));
}

function cgst_details() {
  $("#cgst_details").show();
  $("#cgst_label").empty().append("<b>CGST ( " + gstlist[2] + ".00% )</b>");
  $("#cgst_val").text(humanamount(od_order.cgst));
}

function igst_details() {
  $("#sgst_details").hide();
  $("#cgst_details").hide();
  $("#igst_details").show();
  $("#subtotal_details").removeClass("col-3");
  $("#subtotal_details").addClass("col-4");
  $("#total_details").removeClass("col-3");
  $("#total_details").addClass("col-4");
  $("#igst_label").empty().append("<b>IGST ( " + gstlist[1] + ".00% )</b>");
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
  $.each(previewList, function (i, id) {
    subtotal += parseFloat($("#id_total" + id).val());
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
  $.each(items_for_invoicing, function (i, id) {
    var item = $("#" + id).data("item");
    var payment = $("#" + id).data("payment");
    var proforma = $("#" + id).data("proforma");
    if (payment == 0) {
      if (proforma == 0) {
        t = tree["items"][item]
      } else {
        t = tree["items"][item]["proforma"][proforma]
      }
    } else {
      if (proforma == 0) {
        t = tree["items"][item]["payment"][payment]
      } else {
        t = tree["items"][item]["payment"][payment]["proforma"][proforma]
      }
    }
    if ($("#" + id).is(':checked')) {
      subtotal += parseFloat(t.total)
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
    '<div class="row text-center"><div id="previewigst"><b>Sub Total : </b><span id="preview_subtotal_txt">₹' + subtotal.toFixed(2) + '</span></div><input type="hidden" name="sub_total" id="previewsubtotal" value="' + subtotal.toFixed(2) + '"><div id="sgstclass" style="display: none;"><b>SGST ( <span>' + parseInt(gstlist[1]) + ' %</span> ) : </b><span id="preview_sgst_val" data-gst="' + parseInt(gstlist[1]) + '">₹ ' + sgst_total.toFixed(2) + '</span><input type="hidden" name="sgst" id="previewsgst" value="' + sgst_total.toFixed(2) + '"></div><div id="cgstclass" style="display: none;"><b>CGST ( <span>' + parseInt(gstlist[2]) + ' %</span> ) : </b><span id="preview_cgst_val">₹' + cgst_total.toFixed(2) + '</span><input type="hidden" name="cgst" id="previewcgst" value="' + cgst_total.toFixed(2) + '"></div><div id="igstclass" style="display: none;"><b>IGST ( <span>' + parseInt(gstlist[1]) + ' %</span> ) : </b><span id="preview_igst_val" data-gst="' + parseInt(gstlist[1]) + '">₹ ' + igst_total.toFixed(2) + '</span><input type="hidden" name="igst" id="previewigst" value="' + igst_total.toFixed(2) + '"></div><div id="totalclass" style="color: mediumslateblue;"><b>Total : </b><span id="preview_total_val">₹ ' + total.toFixed(2) + '</span><input type="hidden" name="invoice_total" id="previewinvoice_total" value="' + total.toFixed(2) + '"></div></div>');
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
  // Showing Invoice card
  $("#id_invoiceblock").show();

  // Items that can be invoiced
  items_for_invoicing = [];
  var v_total = 0

  // Table Header
  $("#id_invoiceblock_body").append('<table class="table" id="id_invoicetable"><tr><th><div class="icheck-primary d-inline"> <input type="checkbox" id="inv0"><label for="inv0"></label></div></th><th><div class="icheck-primary d-inline"> <input type="checkbox" id="pro0" ><label for="pro0">Proforma</label></div></th><th>Item</th><th>Description</th><th>Qty./Unit</th><th>Unit Price</th><th>Total Value</th><th class="min110"></th></tr></table>');

  // Loop thru item
  $.each(tree["items"]["ids"], function (iItm, itm) {
    if ((tree["items"][itm]["payment"]["ids"]).length > 0) {

      // Order Payment Terms
      var plock = true
      $.each(tree["items"][itm]["payment"]["ids"], function (iPtm, ptm) {

        // Payment Terms Proforma Created Check
        if ((tree["items"][itm]["payment"][ptm]["proforma"]["ids"]).length > 0) {
          $.each(tree["items"][itm]["payment"][ptm]["proforma"]["ids"], function (iPtmPro, ptmPro) {
            $("#id_invoicetable").append('<tr id="row0' + itm + ptm + ptmPro + '"></tr>');
            if ((tree["items"][itm]["payment"][ptm]["invoice"]["ids"]).length > 0) {
              $("#row0" + itm + ptm + ptmPro).append('<td></td>');
            } else {
              $("#row0" + itm + ptm + ptmPro).append('<td><div class="icheck-primary d-inline"><input class="cbox genebox pbox" type="checkbox" data-id="' + itm + '_' + ptm + '" data-item="' + itm + '" data-payment="' + ptm + '"  data-proforma="' + ptmPro + '" data-proformaid="pro' + itm + '_' + ptm + '" id="inv' + itm + '_' + ptm + '" ><label for="inv' + itm + '_' + ptm + '"></label></div></td>');
              items_for_invoicing.push('inv' + itm + '_' + ptm);
            }
            $("#row0" + itm + ptm + ptmPro).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="pro' + itm + '_' + ptm + '" checked disabled><label for="pro' + itm + '_' + ptm + '"></label></div></td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["item"] + '</td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["description"] + '</td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["qty"] + " / " + get_uom_display(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["uom_id"]) + '</td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["unit_price"]) + '</td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["total"]) + '</td>');
            if ((tree["items"][itm]["payment"][ptm]["invoice"]["ids"]).length > 0) {
              var ptmProInvList = [];
              var linkList = "";
              $.each(tree["items"][itm]["payment"][ptm]["invoice"]["ids"], function (iPtmInv, ptmInv) {
                if (tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["order_item_id"] == tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["order_item_id"] && tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["order_payterm_id"] == tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["order_payterm_id"]) {
                  ptmProInvList.push(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"]);
                  linkList += '<a class="dropdown-item pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"], true) + '.pdf">' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"] + '</a>';

                }
              });
              if (ptmProInvList.length == 1) {
                $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><button type="button" class="btn btn-primary btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"], true) + '.pdf">Proforma Invoice</button><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu"><a class="dropdown-item pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(ptmProInvList[0], true) + '.pdf">Tax Invoice</a></div></div></td>');
              } else {
                $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><button type="button" class="btn btn-primary btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"], true) + '.pdf">Tax Invoice</button><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu">' + linkList + '</div></div></td>');
              }
            } else {
              $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><button type="button" class="btn btn-primary btn-sm generate" id="generate_' + itm + '" data-id="' + iItm + '" data-list="items">Generate</button><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu"><a class="dropdown-item pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"], true) + '.pdf">Proforma Invoice</a></div></div></td>');
            }
          });
        }

        // Payment Terms Tax Created Check
        else if ((tree["items"][itm]["payment"][ptm]["invoice"]["ids"]).length > 0) {
          $.each(tree["items"][itm]["payment"][ptm]["invoice"]["ids"], function (iPtmInv, ptmInv) {
            $("#id_invoicetable").append('<tr id="row' + itm + ptm + ptmInv + '"></tr>');
            $("#row" + itm + ptm + ptmInv).append('<td></td>');
            $("#row" + itm + ptm + ptmInv).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="pro' + itm + '_' + ptm + '" ' + createdProforma(tree["items"][itm]["payment"][ptm]["proforma"]["ids"]) + '><label for="pro' + itm + '_' + ptm + '"></label></div> </td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["item"] + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["description"] + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["qty"] + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["unit_price"]) + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["total"]) + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td class="align-middle"><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"], false) + '.pdf" type="button">Tax Invoice</button></td>');
          });
        }

        // Payment Terms With No Proforma Or Tax Created 
        else {
          $("#id_invoicetable").append('<tr id="row' + itm + ptm + '"></tr>');
          if (plock) {
            $("#row" + itm + ptm).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" data-id="' + itm + '_' + ptm + '" data-item="' + itm + '" data-proformaid="pro' + itm + '_' + ptm + '" data-payment="' + ptm + '"  data-proforma="0" id="inv' + itm + '_' + ptm + '" required class="paytrm" data-id="' + itm + '_' + ptm + '" checked><label for="inv' + itm + '_' + ptm + '"></label></div></td>');
            $("#row" + itm + ptm).append('<td><div class="icheck-primary d-inline"> <input type="checkbox"  class="cbox probox" class="proforma" id="pro' + itm + '_' + ptm + '" required class="" data-id="' + itm + '" ><label for="pro' + itm + '_' + ptm + '"></label></div></td>');
            items_for_invoicing.push('inv' + itm + '_' + ptm);
          } else {
            $("#row" + itm + ptm).append('<td></td><td></td>');
          }
          $("#row" + itm + ptm).append('<td>' + tree["items"][itm]["payment"][ptm].item + '</td>');
          $("#row" + itm + ptm).append('<td>' + tree["items"][itm]["payment"][ptm].description + '</td>');
          $("#row" + itm + ptm).append('<td>' + tree["items"][itm]["payment"][ptm].qty + " / " + get_uom_display(tree["items"][itm]["payment"][ptm].uom_id) + '</td>');
          $("#row" + itm + ptm).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm].unit_price) + '</td>');
          $("#row" + itm + ptm).append('<td>' + humanamount(tree["items"][itm]["payment"][ptm].total) + '</td>');
          if (plock) {
            $("#row" + itm + ptm).append('<td class="py-0" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '_' + ptm + '" data-id="' + iItm + '" data-list="payments" >Generate <i class="fas fa-chevron-right"></i></button></td>');
            plock = false;
          } else {
            $("#row" + itm + ptm).append('<td></td>');
          }
        }
      });
    } else {
      // Order Items
      var balQty = parseInt(tree["items"][itm]["qty"]);
      if ((tree["items"][itm]["invoice"]["ids"]).length > 0) {
        $.each(tree["items"][itm]["invoice"]["ids"], function (iInv, inv) {
          $("#id_invoicetable").append('<tr id="row' + iInv + itm + inv + '"></tr>');
          $("#row" + iInv + itm + inv).append('<td></td>');
          if ((tree["items"][itm]["proforma"]["ids"]).length > 0) {
            $("#row" + iInv + itm + inv).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="pro' + itm + inv + '" checked disabled><label for="pro' + itm + inv + '"></label></div></td>');
          } else {
            $("#row" + iInv + itm + inv).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="pro' + itm + inv + '" disabled><label for="pro' + itm + inv + '"></label></div></td>');
          }
          $("#row" + iInv + itm + inv).append('<td>' + tree["items"][itm]["invoice"][inv]["item"] + '</td>');
          $("#row" + iInv + itm + inv).append('<td>' + tree["items"][itm]["invoice"][inv]["description"] + '</td>');
          $("#row" + iInv + itm + inv).append('<td>' + tree["items"][itm]["invoice"][inv]["qty"] + '</td>');
          balQty -= parseInt(tree["items"][itm]["invoice"][inv]["qty"]);
          $("#row" + iInv + itm + inv).append('<td>' + humanamount(tree["items"][itm]["invoice"][inv]["unit_price"]) + '</td>');
          $("#row" + iInv + itm + inv).append('<td>' + humanamount(tree["items"][itm]["invoice"][inv]["total"]) + '</td>');
          $("#row" + iInv + itm + inv).append('<td class="align-middle"><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["invoice"][inv]["invoice_id"], false) + '.pdf" type="button">Tax Invoice</button></td>');
        })
      }
      if ((tree["items"][itm]["proforma"]["ids"]).length > 0) {
        $.each(tree["items"][itm]["proforma"]["ids"], function (iPro, pro) {
          $("#id_invoicetable").append('<tr id="row' + itm + pro + iPro + '"></tr>');
          if ((tree["items"][itm]["invoice"]["ids"]).length > 0) {
            $("#row" + itm + pro + iPro).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="inv' + itm + pro + '" checked disabled data-proformaid="pro' + itm + pro + '"><label for="inv' + itm + pro + '"></label></div></td>');
          } else {
            balQty -= parseInt(tree["items"][itm]["proforma"][pro]["qty"]);
            $("#row" + itm + pro + iPro).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox pbox" id="inv' + itm + pro + '" data-id="' + itm + pro + '" data-proformaid="pro' + itm + pro + '" data-item="' + itm + '" data-payment="0"  data-proforma="' + pro + '" ><label for="inv' + itm + pro + '"></label></div></td>');
            items_for_invoicing.push('inv' + itm + pro)
          }
          $("#row" + itm + pro + iPro).append('<td><div class="icheck-primary d-inline"><input type="checkbox" id="pro' + itm + pro + '" checked disabled><label for="pro' + itm + pro + '"></label></div></td>');
          $("#row" + itm + pro + iPro).append('<td>' + tree["items"][itm]["proforma"][pro]["item"] + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + tree["items"][itm]["proforma"][pro]["description"] + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + tree["items"][itm]["proforma"][pro]["qty"] + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + humanamount(tree["items"][itm]["proforma"][pro]["unit_price"]) + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + humanamount(tree["items"][itm]["proforma"][pro]["total"]) + '</td>');
          if ((tree["items"][itm]["invoice"]["ids"]).length == 0) {
            $("#row" + itm + pro + iPro).append('<td class="align-middle"><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["proforma"][pro]["proforma_invoice_id"], true) + '.pdf" type="button">Proforma Invoice</button></td>');
          } else {
            $("#row" + itm + pro + iPro).append('<td><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["proforma"][pro]["proforma_invoice_id"], true) + '.pdf" type="button">Proforma Invoice</button></td>');
          }
        })
      }
      if (balQty > 0) {
        $("#id_invoicetable").append('<tr id="row0' + itm + '"></tr>');
        $("#row0" + itm).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="inv' + itm + '" data-id="' + itm + '" data-item="' + itm + '" data-payment="0"  data-proformaid="pro' + itm + '" data-proforma="0" checked><label for="inv' + itm + '"></label></div></td>');
        items_for_invoicing.push('inv' + itm)
        $("#row0" + itm).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox probox" id="pro' + itm + '" ><label for="pro' + itm + '"></label></div></td>');
        $("#row0" + itm).append('<td>' + tree["items"][itm]["item"] + '</td>');
        $("#row0" + itm).append('<td>' + tree["items"][itm]["description"] + '</td>');
        $("#row0" + itm).append('<td>' + balQty + '</td>');
        $("#row0" + itm).append('<td>' + humanamount(tree["items"][itm]["unit_price"]) + '</td>');
        $("#row0" + itm).append('<td>' + humanamount(balQty * tree["items"][itm]["unit_price"]) + '</td>');
        $("#row0" + itm).append('<td class="py-0" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '" data-id="5" data-list="items">Generate <i class="fas fa-chevron-right"></i></button></td>');
      }
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
    $(".pbox").prop('checked', false);
  }
  else {
    $(".probox").each(function () {
      if ($(this).is(':checked')) {
        $(this).trigger('click');
      }
    });
  }
});

$(document).on("click", ".probox", function () {
  if ($(this).is(':checked')) {
    $(".pbox").each(function () {
      if ($(this).is(':checked')) {
        $(this).prop('checked', false);
      }
    });
  }
  if ($("#inv0").is(':checked')) {
    $("#inv0").prop('checked', false);
  }
});

$(document).on("click", ".pbox", function () {
  $(".probox").each(function () {
    if ($(this).is(':checked')) {
      $(this).trigger('click');
    }
  });
  if ($("#pro0").is(':checked')) {
    $("#pro0").prop('checked', false);
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

function createdProforma(val) {
  if (val.length > 0) {
    return "checked disabled"
  }
  return "disabled"
}

function get_proforma(item, paymentterm) {
  var cid = 0;
  if (paymentterm == 0) {
    cid = 'pro' + item;
  } else {
    cid = 'pro' + item + '_' + paymentterm;
  }
  if ($("#" + cid).is(':checked')) {
    if ($("#" + cid).prop('disabled')) {
      return 0
    } else {
      return 1
    }
  }
  else {
    return 0
  }
}

function preview_label() {
  if (proformaguard) { return "Proforma "; } else {
    return "";
  }
}

function getInvoiceNo(val, proforma = false) {
  if (proforma) {
    return tree["proforma"][val]["invoice_no"]
  } else {
    return tree["invoice"][val]["invoice_no"]
  }
}
