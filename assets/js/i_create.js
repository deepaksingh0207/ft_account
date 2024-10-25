
var groupdata,
  customerid,
  customerdata,
  orderdata,
  od_order,
  od_items,
  od_invoices,
  od_invoiceitems,
  od_creditnotes,
  od_creditnote_items,
  od_payment_term,
  gstlist,
  oldgen = 0,
  invoicevalidityflag = null,
  processing_proforma = false,
  NRI = false,
  country,
  currency,
  firstselector = [],
  previewList = [],
  paytermlist = [],
  payterm_ordertype = ["1", "2", "3"],
  items_for_invoicing = [],
  tree = {};

function createbookeeper() {
  for (var key in od_order) { tree[key] = od_order[key]; }

  tree["creditnotes"] = { ids: [] };
  tree["credit_note_items"] = { ids: [] };
  tree["items"] = { ids: [] };
  tree["invoice"] = { ids: [] };
  tree["proforma"] = { ids: [] };


  $.each(od_creditnote_items, function (icredit_note_items, credit_note_item) {

    tree["credit_note_items"]["ids"].push(credit_note_item.id); tree["credit_note_items"][credit_note_item.id] = credit_note_item

  });


  $.each(od_creditnotes, function (iCreditnotes, creditnote) { tree["creditnotes"]["ids"].push(creditnote.id); tree["creditnotes"][creditnote.id] = creditnote });
  $.each(od_proforma, function (iProforma, proforma) { tree["proforma"]["ids"].push(proforma.id); tree["proforma"][proforma.id] = proforma });
  $.each(od_invoices, function (iInvoices, invoice) { tree["invoice"]["ids"].push(invoice.id); tree["invoice"][invoice.id] = invoice });

  $.each(od_items, function (i, item) {
    tree["items"]["ids"].push(item.id);
    tree["items"][item.id] = item
    tree["items"][item.id]["ot"] = item.order_type
    tree["items"][item.id]["payment"] = { ids: [] }
    tree["items"][item.id]["proforma"] = { ids: [] }
    tree["items"][item.id]["creditnote"] = { ids: [] }
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
              tree["items"][item.id]["payment"][payment.id]["proforma"][proforma.id]["invoice"] = { ids: [] }
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
          tree["items"][item.id]["proforma"][proforma.id]["invoice"] = { ids: [] }
        }
      });
      $.each(od_creditnote_items, function (k, creditnote) {
        if (item.id == creditnote.order_item_id) {
          tree["items"][item.id]["creditnote"]["ids"].push(creditnote.id);
          tree["items"][item.id]["creditnote"][creditnote.id] = creditnote
          tree["items"][item.id]["creditnote"]["ot"] = item.order_type
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
          if (groupdata[0].country != "101") { symbol = '$ '; NRI = true; }
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
        console.log(jqXHR, textStatus, errorThrown);
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
        console.log(jqXHR, textStatus, errorThrown);
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
        od_creditnotes = orderdata.creditnote;
        od_creditnote_items = orderdata.creditnote_items;
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
        console.log(jqXHR, textStatus, errorThrown);
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
  preview_footer();
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
    .fail(function (jqXHR, textStatus, errorThrown) {
      $("#modal_body").empty().append(error);
      console.log(jqXHR, textStatus, errorThrown);
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
  var OrderId = od_order.id;
  fetchCreditNotesByOrderId(OrderId);
}

function refreshpreview() {
  $("#togglepdf").text("Preview");
  $("#gene").hide();
  $("#t2").data("state", "hide").hide();
  $("#t1").data("state", "show").show();
}

function preview_builder() {
  processing_proforma = false;
  var processing_taxinvoice = false;
  $.each(items_for_invoicing, function (i, id) {
    if ($("#" + id).is(':checked')) {
      var item = $("#" + id).data("item");
      var payment = $("#" + id).data("payment");
      var proformaId = $("#" + id).data("proformaid");
      if ($("#" + proformaId).is(':checked') && $("#" + proformaId).is(':disabled')) { processing_taxinvoice = true; }
      else if ($("#" + proformaId).is(':checked')) { processing_proforma = true; }
      else { processing_taxinvoice = true; }
    }
  });
  $("#preview_modal_body").empty();

  if (processing_taxinvoice == processing_proforma) { $("#preview_modal_body").append("Either created Proforma or Tax Invoice"); }
  else {
    var c = 0
    previewList = []
    var invoice_date_template = `
    <div class="col-sm-12 col-lg-3">
      <label for="id_invoicedate">Invoice Date</label>
      <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate" value="">
    </div>`;
    if (processing_proforma == false) { invoice_date_template = `` }
    console.log(od_order.order_type);
    var preview_modal_body = `
    <div class="row" id="t1" data-state="show">
      <div class="col-sm-12 col-lg-12">
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">` + preview_label() + `Invoice</div>
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Description</th>
                      <th>` + setheader(od_order.order_type) + `</th>
                      
                      <th>UOM</th>
                      <th>Unit Price</th>
                      <th>HSN Code</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody id="preview_tbody"></tbody>
                </table>
              </div>
              <div class="card-footer" id="preview_footer"></div>
            </div>
          </div>
          `+ invoice_date_template + `
          <div class="col-sm-12 col-lg-3">
            <label for="id_due_date">Due Date</label>
            <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date" value="">
          </div>
          <div class="col-sm-12 col-lg-3">
            <label for="id_invoice_no">Invoice No.</label>
            <input type="number" value="" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no">
          </div>`;
    if (NRI) {
      preview_modal_body = preview_modal_body + `
      <div class="col-sm-12 col-lg-3">
        <label for="id_exchangerate">Exchange Rate</label>
        <input type="number" class="form-control ftsm" name="exchangerate" required id="id_exchangerate" >
        <input type="hidden" class="form-control ftsm" name="nri" required id="id_nri" value="1" >
      </div>`;
    } else {
      preview_modal_body = preview_modal_body + `<input type="hidden" class="form-control ftsm" name="nri" required id="id_nri" value="0" >`
    }
    if (od_order.open_po == '1') {
      preview_modal_body += `<div class="col-sm-12 col-lg-3 pt-4">
                              <div class="form-group mt-1">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                  <input type="checkbox" class="custom-control-input" name="hidepo" id="id_hidepo">
                                  <label class="custom-control-label" for="id_hidepo">PO No : As per mail</label>
                                </div>
                              </div>
                            </div>`;
    }
    preview_modal_body += `</div>
                          </div>
                        </div>
                        <div class="row" id="t2" data-state="hide"></div>`
    $("#preview_modal_body").empty().append(preview_modal_body);

    // if (proformaguard){
    //   $("#preview_tbody").append('<input type="hidden" name="proforma" value="1">');
    // } else {
    //   $("#preview_tbody").append('<input type="hidden" name="proforma" value="0">');
    // }

    $.each(items_for_invoicing, function (i, id) {

      var item = $("#" + id).data("item");
      var payment = $("#" + id).data("payment");
      var proforma = $("#" + id).data("proforma");

      // Non Payment-Term Item
      if (payment == 0) {
        if (proforma == 0) { t = tree["items"][item] }
        else { t = tree["items"][item]["proforma"][proforma] }
      } else {
        if (proforma == 0) { t = tree["items"][item]["payment"][payment] }
        else { t = tree["items"][item]["payment"][payment]["proforma"][proforma] }
      }

      if ($("#" + id).is(':checked')) {

        var maxqty = t.qty;

        $("#preview_tbody").append('<tr id="ptb' + c + '"></tr>');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="' + payment + '">');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][order_item_id]" id="id_order_item_id' + c + '" value="' + item + '">');
        $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][item]" id="id_item' + c + '" value="' + t.item + '">');
        $("#ptb" + c).append('<td><input type="hidden" name="proforma" id="id_p_proforma' + c + '" value="' + get_proforma(item, payment) + '">' + t.item + '</td>');

        if (processing_proforma == false) {
          if (t.hasOwnProperty('proforma_invoice_item_id')) {
            $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][proforma_invoice_item_id]" value="' + t.proforma_invoice_item_id + '">');
          } else {
            $("#ptb" + c).append('<input type="hidden" class="form-control desp" required name="order_details[' + c + '][proforma_invoice_item_id]" id="id_descp' + c + '" value="' + t.qty + '">');
            $("#ptb" + c).append('<input type="hidden" name="order_details[' + c + '][proforma_invoice_item_id]" value="0">');
          }
        }

        $("#ptb" + c).append('<td ><input type="text" class="form-control desp" required name="order_details[' + c + '][description]" id="id_descp' + c + '" value="' + t.description + '"></td>');

        $.each(t.invoice.ids, function (k, l) { maxqty -= parseInt(t.invoice[l].qty); });

        $.each(od_creditnote_items, function (icredit_note_items, credit_note_item) {

          tree["credit_note_items"]["ids"].push(credit_note_item.id);
          tree["credit_note_items"][credit_note_item.id] = credit_note_item;
          maxqty += parseInt(credit_note_item.qty);

        });
        // alert(t.total);
        $("#ptb" + c).append('<td class="minmax150"><input type="number" class="form-control qty" required name="order_details[' + c + '][qty]" id="id_qty' + c + '" min="1" value="' + maxqty + '" data-index="' + c + '" data-up="' + t.unit_price + '" data-uom="' + t.uom_id + '" max="' + maxqty + '"></td>');
        $("#ptb" + c).append('<td class="pt-3" >' + get_uom_display(t.uom_id) + '<input type="hidden" required name="order_details[' + c + '][uom_id]" id="id_uom' + c + '" value="' + t.uom_id + '"></td>');
        $("#ptb" + c).append('<td class="pt-3"><input type="number" class="form-control pup" required style="width: 10rem;" name="order_details[' + c + '][unit_price]" data-index="' + c + '" data-up="' + t.unit_price + '" id="id_unitprice' + c + '" value="' + t.unit_price + '"></td>');
        $("#ptb" + c).append('<td id="preview_row_hsn' + c + '" class="pt-3"><select class="form-control" style="width:15vw;" name="order_details[' + c + '][hsn_id]" id="id_hsn_id' + c + '"></select></td>');
        var invoice_total = maxqty * t.unit_price;
        $("#ptb" + c).append('<td id="preview_row_total' + c + '" class="pt-3">' + symbol + invoice_total + '</td>');//vk
        $("#ptb" + c).append('<input type="hidden" required name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + invoice_total + '">');
        fillhsnselect('#id_hsn_id' + c)
        previewList.push(c)
        c++;
      }
    });
  }
}

function fillhsnselect(id) {
  $.ajax({
    type: "GET",
    url: baseUrl + "hsn/getDetails/",
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      $.each(data, function (x, y) {
        $(id).append('<option value="' + y.id + '">' + y.code + ' - ' + y.description + '</option>');
      });
    })
    .fail(function (jqXHR, textStatus, errorThrown) { console.log(jqXHR, textStatus, errorThrown) })
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
  mydata = { invoice_no: $(this).val() }
  if (processing_proforma) {
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/proforma_validty/",
      data: mydata,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        invoicevalidityflag = data
        if (data == false) {
          $(".say").remove()
          $("#id_invoice_no")
            .addClass("is-invalid")
            .parent()
            .append(
              '<span id="id_po_no-error" class="say error invalid-feedback">Proforma No exist.</span>'
            )
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Cannot validate PO No.")
        console.log(jqXHR, textStatus, errorThrown);
      })
  } else {
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/invoice_validty/",
      data: mydata,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        invoicevalidityflag = data
        if (data == false) {
          $(".say").remove()
          $("#id_invoice_no")
            .addClass("is-invalid")
            .parent()
            .append(
              '<span id="id_po_no-error" class="say error invalid-feedback">Invoice No exist.</span>'
            )
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Cannot validate PO No.")
        console.log(jqXHR, textStatus, errorThrown);
      })
  }
})

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
      '<tr><td><input type="hidden" name="order_details[0][order_payterm_id]" value="0"><input type="hidden" name="order_details[0][order_item_id]" id="id_order_item_id1" value="' + od_items[index].id + '"><input type="hidden" name="order_details[0][item]" id="id_item1" value="' + od_items[index].item + '">' + od_items[index].item + '</td><td ><input type="text" class="form-control desp" required name="order_details[0][description]" id="id_descp1" value="' + od_items[index].description + '"></td><td class="minmax150"><input type="number" class="form-control qty" required name="order_details[0][qty]" id="id_qty1" min="1" value="' + remaining_qty + '" data-index="1" data-up="' + od_items[index].unit_price + '" data-uom="' + od_items[index].uom_id + '" max="' + remaining_qty + '"></td><td class="pt-3" >' + get_uom_display(od_items[index].uom_id) + '<input type="hidden" required name="order_details[0][uom_id]" id="id_uom1" value="' + od_items[index].uom_id + '"></td><td class="pt-3"><input type="number" required name="order_details[0][unit_price]" style="width: 10rem;" class="form-control pup" id="id_unitprice1" value="' + od_items[index].unit_price + '"></td><td id="preview_row_total1" class="pt-3">' + symbol + '0.00</td>   <input type="hidden" required name="order_details[0][total]" id="id_total1" value="0"></tr>'
    );
    // previewlist.push(1);
    preview_footer();
    $(".qty").trigger("change");
    preview_total();
  } else {
    $("#preview_modal_body")
      .empty()
      .append(
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">' + getordertype() + '</div><div class="card-body p-0"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>Qty./Unit</th><th>Unit Price</th><th>	Total Value</th> </tr></thead><tbody id="preview_tbody"></tbody></table></div><div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label><input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label><input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div><div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label>    <input type="number" class="form-control numberonly" pattern="[0-9]{7}" minlength="7" maxlength="7" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div></div></div></div><div class="row" id="t2" data-state="hide"></div>'
      );
    $("#preview_tbody").empty();

    $.each(firstselector, function (index, value) {
      $("#preview_tbody").append(
        '<tr><td class="max100"><input type="hidden" name="order_details[' + index + '][order_payterm_id]" value="' + od_payment_term[value].id + '"><input type="hidden" name="order_details[' + index + '][order_item_id]" value="' + od_payment_term[value].order_item_id + '">' + od_payment_term[value].item + '<input type="hidden" name="order_details[' + index + '][item]" value="' + od_payment_term[value].item + '"></td><td class="max150"><input type="text" required name="order_details[' + index + '][description]" id="id_description" class="form-control" value="' + od_payment_term[value].description + '">   </td><td>' + od_payment_term[value].qty + ' <input type="hidden" name="order_details[' + index + '][qty]" value="' + od_payment_term[value].qty + '"> / ' + get_uom_display(od_payment_term[value].uom_id) + '<input type="hidden" name="order_details[' + index + '][uom_id]" value="' + od_payment_term[value].uom_id + '"></td><td><input type="number" name="order_details[' + index + '][unit_price]" style="width: 10rem;" class="form-control pup" value="' + od_payment_term[value].unit_price + '"></td><td>' + od_payment_term[value].total + '  <input type="hidden" name="order_details[' + index + '][total]" value="' + od_payment_term[value].total + '"></td></tr>'
      );
      i += 1;
    });
    preview_footer();
  }
  $("#id_due_date").attr("min", tomorrow);
}

function resetongroup() {
  $("#customerid_id").empty().attr("readonly", true);
  symbol = '₹ '; NRI = false;
  resetoncustomer();
}

function filldata(id, data, msg, field) {
  $(id)
    .empty()
    .append("<option value=''>" + msg + "</option>");
  $.each(data, function (index, value) {
    val = [];
    for (var key in value) { if (field.includes(key, 0)) { val.push(value[key]); } }
    if (val[2] != null) { $(id).append("<option value='" + val[0] + "'>" + val[1] + " - " + val[2] + "</option>"); }
    else { $(id).append("<option value='" + val[0] + "'>" + val[1] + "</option>"); }
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
      console.log(jqXHR, textStatus, errorThrown);
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
  list = ["", "Month", "Payment Slab", "Qty.", "Qty.", "Qty", "Qty"]
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
      $("#orderlist").append('<tr data-widget="expandable-table" aria-expanded="false" id="parent_' + i_item + '"><td class="text-left"><i class="fas fa-caret-right fa-fw"></i>' + tree["items"][value]["item"] + '</td><td>' + tree["items"][value]["description"] + '</td><td>' + tree["items"][value]["qty"] + '</td><td>' + get_uom_display(tree["items"][value]["uom_id"]) + '</td><td>' + ra(tree["items"][value]["unit_price"], NRI) + '</td><td>' + ra(tree["items"][value]["total"], NRI) + '</td></tr>');
    } else {
      $("#orderlist").append('<tr id="parent_' + i_item + '"><td class="text-left">' + tree["items"][value]["item"] + '</td><td>' + tree["items"][value]["description"] + '</td><td>' + tree["items"][value]["qty"] + '</td><td>' + get_uom_display(tree["items"][value]["uom_id"]) + '</td><td>' + ra(tree["items"][value]["unit_price"], NRI) + '</td><td>' + ra(tree["items"][value]["total"], NRI) + '</td></tr>');
    }

    if ((tree["items"][value]["payment"]["ids"]).length > 0) {
      $("#orderlist").append('<tr class="expandable-body d-none" id="child_1_' + i_item + '"><td colspan="8"><div class="p-0" style="display: none;"><table class="table table-hover m-0"><tbody id="child_1_' + i_item + '_1"><tr><th style="width: 230px" class="text-info">Sr No.</th><th class="text-info">Description</th><th class="text-info"> Qty./Unit </th><th style="width: 165px" class="text-info">Unit Price</th><th style="width: 180px" class="text-info">Total</th></tr></tbody></table></div></td></tr>');
      $.each(tree["items"][value]["payment"]["ids"], function (i_payment, pay) {
        $("#child_1_" + i_item + "_1").append('<tr><td class="text-info">' + (i_payment + 1) + '</td><td class="text-info">' + tree["items"][value]["payment"][pay]["description"] + '</td><td class="text-info">' + tree["items"][value]["payment"][pay]["qty"] + '</td><td class="text-info">' + ra(tree["items"][value]["payment"][pay]["unit_price"], NRI) + '</td><td class="text-info">' + ra(tree["items"][value]["payment"][pay]["total"], NRI) + '</td></tr>');
      });
    }
  });
}

function sgst_details() {
  $("#igst_details, #cgst_details, #sgst_details").hide();
  $("#subtotal_details").removeClass("col-4");
  $("#subtotal_details").addClass("col-3");
  $("#total_details").removeClass("col-4");
  $("#total_details").addClass("col-3");
  if (!NRI) {
    $("#sgst_details").show();
    $("#sgst_label").empty().append("<b>SGST ( " + gstlist[1] + ".00% )</b>");
    $("#sgst_val").text(ra(od_order.sgst, NRI));
  }
}

function cgst_details() {
  if (!NRI) {
    $("#cgst_details").show();
    $("#cgst_label").empty().append("<b>CGST ( " + gstlist[2] + ".00% )</b>");
    $("#cgst_val").text(ra(od_order.cgst, NRI));
  }
}

function igst_details() {
  $("#sgst_details, #cgst_details, #igst_details").hide();
  $("#subtotal_details").removeClass("col-3");
  $("#subtotal_details").addClass("col-4");
  $("#total_details").removeClass("col-3");
  $("#total_details").addClass("col-4");
  $("#igst_details").show();
  if (!NRI) {
    $("#igst_label").empty().append("<b>IGST ( " + gstlist[1] + ".00% )</b>");
    $("#igst_val").text(ra(od_order.igst, NRI));
  }
}

function fillorderfooter(subtotal, ordertotal) {
  $("#ordertotal_txt").text(ra(subtotal, NRI));
  $("#total_val").text(ra(ordertotal, NRI));
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
  $.each(previewList, function (i, id) { subtotal += parseFloat($("#id_total" + id).val()); });
  $("#preview_subtotal_txt").text(ra(subtotal, NRI));
  $(".previewsubtotal").val(subtotal);
  if (!NRI) {
    if (parseInt(od_order.tax_rate) == 9) {
      gst = subtotal * ($("#preview_sgst_val").data("gst") / 100);
      $("#preview_sgst_val").text(ra(gst, NRI));
      $("#preview_cgst_val").text(ra(gst, NRI));
      $("#previewsgst").val(gst);
      $("#previewcgst").val(gst);
      $("#previewigst").val(0);
      total = subtotal + gst + gst;
    } else {
      gst = subtotal * ($("#preview_igst_val").data("gst") / 100);
      $("#previewsgst").val(0);
      $("#previewcgst").val(0);
      $("#preview_igst_val").text(ra(gst, NRI));
      $("#previewigst").val(gst);
      total = subtotal + gst;
    }
  } else { total = subtotal; }
  $("#previewinvoice_sub_total").val((subtotal).toFixed(0));
  $("#previewinvoice_total").val((total).toFixed(0));
  $("#preview_total_val").text(ra((total).toFixed(0), NRI));
}

function previewtotal(index, value) {
  $("#preview_row_total" + index).text(ra(value, NRI));
  $("#id_total" + index).val(value);
  preview_total();
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

function preview_footer() {
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
      if (proforma == 0) { t = tree["items"][item] }
      else { t = tree["items"][item]["proforma"][proforma] }
    } else {
      if (proforma == 0) { t = tree["items"][item]["payment"][payment] }
      else { t = tree["items"][item]["payment"][payment]["proforma"][proforma] }
    }

    if ($("#" + id).is(':checked')) {

      //  subtotal += parseFloat(t.total)
      var total_value = parseFloat($('#id_total' + c).val());
      subtotal += total_value;

    }

  });

  if (!NRI) {
    if (gstlist.length > 2) {
      sgst_total = (gstlist[1] / 100) * subtotal;
      cgst_total = (gstlist[2] / 100) * subtotal;
    } else { igst_total = (gstlist[1] / 100) * subtotal; }
  }
  total = sgst_total + cgst_total + igst_total + subtotal;

  if (!NRI) {
    $("#preview_footer").append(
      `<div class="row text-center">
        <div id="previewgst"><b>Sub Total : </b>
          <span id="preview_subtotal_txt">` + symbol + subtotal.toFixed(2) + `</span>
        </div>
        <input type="hidden" name="order_total" class="previewsubtotal" value="` + subtotal.toFixed(2) + `">
        <input type="hidden" name="sub_total" id="previewinvoice_sub_total" value="` + subtotal.toFixed(2) + `">
        <div id="sgstclass" style="display: none;">
          <b>SGST ( <span>` + parseInt(gstlist[1]) + ` %</span> ) : </b>
          <span id="preview_sgst_val" data-gst="` + parseInt(gstlist[1]) + `">` + symbol + sgst_total.toFixed(2) + `</span>
          <input type="hidden" name="sgst" id="previewsgst" value="` + sgst_total.toFixed(2) + `">
        </div>
        <div id="cgstclass" style="display: none;">
          <b>CGST ( <span>` + parseInt(gstlist[2]) + ` %</span> ) : </b>
          <span id="preview_cgst_val">₹` + cgst_total.toFixed(2) + `</span>
          <input type="hidden" name="cgst" id="previewcgst" value="` + cgst_total.toFixed(2) + `">
        </div>
        <div id="igstclass" style="display: none;">
          <b>IGST ( <span>` + parseInt(gstlist[1]) + ` %</span> ) : </b>
          <span id="preview_igst_val" data-gst="` + parseInt(gstlist[1]) + `">` + symbol + igst_total.toFixed(2) + `</span>
          <input type="hidden" name="igst" id="previewigst" value="` + igst_total.toFixed(2) + `">
        </div>
        <div id="totalclass" style="color: mediumslateblue;">
          <b>Total : </b>
          <span id="preview_total_val">` + symbol + total.toFixed(2) + `</span>
          <input type="hidden" name="invoice_total" id="previewinvoice_total" value="` + total.toFixed(2) + `">
        </div>
      </div>`);
    if (parseInt(gstlist[1]) == 9) {
      $("#previewgst").addClass("col-3");
      $("#sgstclass").show().addClass("col-3");
      $("#cgstclass").show().addClass("col-3");
      $("#igstclass").hide().addClass("col-0");
      $("#preview_total_val, #totalclass").addClass("col-3");
    } else {
      $("#previewgst").addClass("col-4");
      $("#sgstclass").hide().addClass("col-0");
      $("#cgstclass").hide().addClass("col-0");
      $("#igstclass").show().addClass("col-4");
      $("#preview_total_val, #totalclass").addClass("col-4");
    }
  } else {
    $("#preview_footer").append(
      `<div class="row text-center">
        <div id="previewgst" class="col-4">
          <b>Sub Total : </b>
          <span id="preview_subtotal_txt">` + symbol + subtotal.toFixed(2) + `</span>
        </div>
        <input type="hidden" name="order_total" class="previewsubtotal" value="` + subtotal.toFixed(2) + `">
        <input type="hidden" name="sub_total" id="previewinvoice_sub_total" value="` + subtotal.toFixed(2) + `">
        <div class="col-4">
          <input type="hidden" name="cgst" value="0">
          <input type="hidden" name="igst" value="0">
          <input type="hidden" name="sgst" value="0">
        </div>
        <div id="totalclass" class="col-4" style="color: mediumslateblue;">
          <b>Total : </b>
          <span id="preview_total_val">` + symbol + total.toFixed(2) + `</span>
          <input type="hidden" name="invoice_total" id="previewinvoice_total" value="` + total.toFixed(2) + `">
        </div>
      </div>`);
  }
}

function checker() {
  var check = true;
  if ($("#id_invoicedate").val() == "") {
    $("#id_invoicedate").addClass("is-invalid");
    check = false;
  }
  if ($("#id_due_date").val() == "" && check) {
    $("#id_due_date").addClass("is-invalid");
    check = false;
  }
  if ($("#id_invoice_no").val().length != 7 && check) {
    $("#id_invoice_no").addClass("is-invalid");
    check = false;
  }
  if (invoicevalidityflag && check) { check = true; }
  else { check = false; }
  if (check) {
    if ($("#t1").data("state") == "show") {
      $("#t1").data("state", "hide").hide();
      $("#t2").data("state", "show").show();
      $("#togglepdf").text("Back To Editing");
      $("#gene").show();
      var formdata = $("#quickForm").serialize();
      $.ajax({
        type: "POST",
        url: baseUrl + "invoices/geninv",
        data: formdata,
      })
        .done(function (data) {
          $("#t2")
            .empty()
            .html(data);
          // .find("style")
          // .remove()
          // .children("td")
          // .children("img")
          // .css("max-width", "925px");
        })
        .fail(function (jqXHR, textStatus, errorThrown) { console.log(jqXHR, textStatus, errorThrown) });
    } else { refreshpreview(); }
  }
}

function fillinvoice_body() {
  // Showing Invoice card
  $("#id_invoiceblock").show();

  // Items that can be invoiced
  items_for_invoicing = [];

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
            $("#row0" + itm + ptm + ptmPro).append('<td>' + ra(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["unit_price"], NRI) + '</td>');
            $("#row0" + itm + ptm + ptmPro).append('<td>' + ra(tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["total"], NRI) + '</td>');
            if ((tree["items"][itm]["payment"][ptm]["invoice"]["ids"]).length > 0) {
              var ptmProInvList = [];
              var linkList = "";
              $.each(tree["items"][itm]["payment"][ptm]["invoice"]["ids"], function (iPtmInv, ptmInv) {
                if (tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["order_item_id"] == tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["order_item_id"] && tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["order_payterm_id"] == tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["order_payterm_id"]) {
                  ptmProInvList.push(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"]);
                  linkList += '<a class="dropdown-item pdf" data-href="' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"], false) + '.pdf">' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"] + '</a>';

                }
              });
              if (ptmProInvList.length == 1) {
                $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><a type="button" class="btn btn-primary btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"] + '/1">Proforma Invoice</a><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu"><a class="dropdown-item pdf" target="_blank" href=" ' + baseUrl + 'invoices/geninv/' + ptmProInvList[0] + '">Tax Invoice</a></div></div></td>');
              } else {
                $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><a type="button" class="btn btn-primary btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"] + '">Tax Invoice</a><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu">' + linkList + '</div></div></td>');
              }
            } else {
              $("#row0" + itm + ptm + ptmPro).append('<td><div class="btn-group"><button type="button" class="btn btn-primary btn-sm generate" id="generate_' + itm + '_' + ptm + '_' + ptmPro + '" data-id="' + itm + '_' + ptm + '_' + ptmPro + '" data-list="items">Generate</button><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu"><a class="dropdown-item pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["payment"][ptm]["proforma"][ptmPro]["proforma_invoice_id"] + '/1">Proforma Invoice</a></div></div></td>');
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
            $("#row" + itm + ptm + ptmInv).append('<td>' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["qty"] + ' / ' + get_uom_display(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["uom_id"]) + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + ra(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["unit_price"], NRI) + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td>' + ra(tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["total"], NRI) + '</td>');
            $("#row" + itm + ptm + ptmInv).append('<td class="align-middle"><a class="btn btn-default btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["payment"][ptm]["invoice"][ptmInv]["invoice_id"] + '" type="button">Tax Invoice</a></td>');
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
          $("#row" + itm + ptm).append('<td>' + ra(tree["items"][itm]["payment"][ptm].unit_price, NRI) + '</td>');
          $("#row" + itm + ptm).append('<td>' + ra(tree["items"][itm]["payment"][ptm].total, NRI) + '</td>');
          if (plock) {
            $("#row" + itm + ptm).append('<td class="py-0" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '_' + ptm + '" data-id="' + itm + '_' + ptm + '" data-list="payments" >Generate <i class="fas fa-chevron-right"></i></button></td>');
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
          $("#row" + iInv + itm + inv).append('<td>' + tree["items"][itm]["invoice"][inv]["qty"] + ' / ' + get_uom_display(tree["items"][itm]["invoice"][inv]["uom_id"]) + '</td>');
          balQty -= parseInt(tree["items"][itm]["invoice"][inv]["qty"]);
          $("#row" + iInv + itm + inv).append('<td>' + ra(tree["items"][itm]["invoice"][inv]["unit_price"], NRI) + '</td>');
          $("#row" + iInv + itm + inv).append('<td>' + ra(tree["items"][itm]["invoice"][inv]["total"], NRI) + '</td>');


          //-----add credit note button-----------

          var invoiceId = tree["items"][itm]["invoice"][inv]["invoice_id"];
          // Find if any credit note matches the current invoice ID
          var creditNote = tree["credit_note_items"]["ids"].find(function (creditNoteId) {
            return tree["credit_note_items"][creditNoteId]["invoice_id"] === invoiceId;
          });

          // if (creditNote) {
          //   $("#row" + iInv + itm + inv).append('<td class="align-middle"><a class="btn btn-default btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + invoiceId + '" type="button">Tax Invoice</a>&nbsp;&nbsp;<a class="btn btn-default btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/gencbn/' + invoiceId + '" type="button">Credit Notes</a></td>');
          // } else {
          //   $("#row" + iInv + itm + inv).append('<td class="align-middle"><a class="btn btn-default btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + invoiceId + '" type="button">Tax Invoice</a></td>');
          // }

          if (creditNote) {
            $("#row" + iInv + itm + inv).append(`
                <td class="align-middle">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tax Invoice
                        </button>
                            <div class="dropdown-menu" style="width: 150px;"> 
                            <a class="dropdown-item" target="_blank" href="${baseUrl}invoices/geninv/${invoiceId}" style="background-color: transparent;" onmouseover="this.style.backgroundColor='#e0e0e0';" onmouseout="this.style.backgroundColor='transparent';">Tax Invoice</a>
                            <a class="dropdown-item" target="_blank" href="${baseUrl}invoices/gencbn/${invoiceId}" style="background-color: transparent;" onmouseover="this.style.backgroundColor='#e0e0e0';" onmouseout="this.style.backgroundColor='transparent';">Credit Notes</a>
                          </div>
                    </div>
                </td>
            `);
          } else {
            $("#row" + iInv + itm + inv).append(`<td class="align-middle"> <a class="btn btn-default btn-sm pdf" target="_blank" href="${baseUrl}invoices/geninv/${invoiceId}" type="button">Tax Invoice</a></td>`);
          }

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
          $("#row" + itm + pro + iPro).append('<td>' + tree["items"][itm]["proforma"][pro]["qty"] + ' / ' + get_uom_display(tree["items"][itm]["proforma"][pro]["uom_id"]) + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + ra(tree["items"][itm]["proforma"][pro]["unit_price"], NRI) + '</td>');
          $("#row" + itm + pro + iPro).append('<td>' + ra(tree["items"][itm]["proforma"][pro]["total"], NRI) + '</td>');
          if ((tree["items"][itm]["invoice"]["ids"]).length == 0) {
            $("#row" + itm + pro + iPro).append('<td class="align-middle"><button class="btn btn-default btn-sm pdf" data-href=" ' + baseUrl + 'pdf/invoice_' + getInvoiceNo(tree["items"][itm]["proforma"][pro]["proforma_invoice_id"], true) + '.pdf" type="button">Proforma Invoice</button></td>');
            $("#row" + itm + pro + iPro).append('<td><div class="btn-group"><button type="button" class="btn btn-primary btn-sm generate" id="generate_' + itm + '_' + pro + '_' + iPro + '" data-id="' + itm + '_' + pro + '_' + iPro + '" data-list="items">Generate</button><button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only">Toggle Dropdown</span></button><div class="dropdown-menu p-1" role="menu"><a class="dropdown-item pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["proforma"][pro]["proforma_invoice_id"] + '/1">Proforma Invoice</a></div></div></td>');
          } else {
            $("#row" + itm + pro + iPro).append('<td><a class="btn btn-default btn-sm pdf" target="_blank" href="' + baseUrl + 'invoices/geninv/' + tree["items"][itm]["proforma"][pro]["proforma_invoice_id"] + '/1" type="button">Proforma Invoice</a></td>');
          }
        })
      }

      //vivek starts changes
      //-------------creditNotes--------------------  

      if ((tree["items"][itm]["creditnote"]["ids"]).length > 0) {

        $.each(tree["items"][itm]["creditnote"]["ids"], function (iCN, CNt) {
          balQty += parseInt(tree["items"][itm]["creditnote"][CNt]["qty"]);

        })
      }

      if (balQty > 0) {
        //alert(balQty);
        $("#id_invoicetable").append('<tr id="row0' + itm + '"></tr>');
        $("#row0" + itm).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox genebox" id="inv' + itm + '" data-id="' + itm + '" data-item="' + itm + '" data-payment="0"  data-proformaid="pro' + itm + '" data-proforma="0" checked><label for="inv' + itm + '"></label></div></td>');
        items_for_invoicing.push('inv' + itm)
        $("#row0" + itm).append('<td><div class="icheck-primary d-inline"><input type="checkbox" class="cbox probox" id="pro' + itm + '" ><label for="pro' + itm + '"></label></div></td>');
        $("#row0" + itm).append('<td>' + tree["items"][itm]["item"] + '</td>');
        $("#row0" + itm).append('<td>' + tree["items"][itm]["description"] + '</td>');
        $("#row0" + itm).append('<td>' + balQty + '</td>');
        $("#row0" + itm).append('<td>' + ra(tree["items"][itm]["unit_price"], NRI) + '</td>');
        $("#row0" + itm).append('<td>' + ra(balQty * tree["items"][itm]["unit_price"], NRI) + '</td>');
        $("#row0" + itm).append('<td class="py-0" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' + itm + '" data-id="' + itm + '" data-list="items">Generate <i class="fas fa-chevron-right"></i></button></td>');
      }

    }
  });
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
  if (processing_proforma) { return "Proforma "; } else {
    return "";
  }
}

function getInvoiceNo(val, proforma = false) {
  if (proforma) { return tree["proforma"][val]["invoice_no"] }
  else { return tree["invoice"][val]["invoice_no"] }
}


//vivek starts changes
//  ------------creditNotesList------------

function fetchCreditNotesByOrderId(orderId) {
  var orderId = od_order.id;
  $("#id_creditnoteblock").show();
  $.ajax({
    url: baseUrl + "invoices/creditNotesItemByOrderId/" + orderId,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var creditNoteBody = '';
      if (data.length > 0) {
        $.each(data, function (index, item) {
          creditNoteBody += '<tr>';
          creditNoteBody += '<td style="max-width:150px;">' + item.item + '</td>';
          creditNoteBody += '<td style="max-width:250px;">' + item.description + '</td>';
          creditNoteBody += '<td style="max-width:250px;">' + item.qty + '</td>';
          creditNoteBody += '<td style="max-width:250px;">' + item.unit_price + '</td>';
          creditNoteBody += '<td style="max-width:250px;">' + item.total + '</td>';
          creditNoteBody += '</tr>';
        });
      } else if (data.message) {

        creditNoteBody = '<tr><td colspan="5" style="text-align: center;">' + data.message + '</td></tr>';
      } else {
        creditNoteBody = '<tr><td colspan="5" style="text-align: center;">No credit notes available for this invoice.</td></tr>';
      }
      $('#creditnote_body').html(creditNoteBody);
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error: ' + status + ' ' + error);
    }
  });
}