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
  payterm_ordertype = ["1", "2", "3"];
var tree = {},
  items_for_invoicing = [],
  payment_for_invoicing = [];

function createbookeeper() {
  for (var key in od_order) {
    tree[key] = od_order[key];
  }
  tree["items"] = { ids: [] };
  tree["invoices"] = { ids: [] };

  $.each(od_items, function (i, item) {
    tree["items"]["ids"].push(item.id);
    tree["items"][item.id] = item
    tree["items"][item.id]["ot"] = item.order_type
    if (item.order_type < 4 || item.order_type == 7) {
      tree["items"][item.id]["payment"] = { ids: [] }
      $.each(od_payment_term, function (j, payment) {
        if (payment.order_item_id == item.id) {
          tree["items"][item.id]["payment"]["ids"].push(payment.id);
          tree["items"][item.id]["payment"][payment.id] = payment
          tree["items"][item.id]["payment"][payment.id]["ot"] = item.order_type
        }
      });
    }
    tree["items"][item.id]["invoiced"] = { ids: [] }
    $.each(od_invoiceitems, function (k, invoiceitems) {
      if (invoiceitems.order_item_id == item.id) {
        tree["items"][item.id]["invoiced"]["ids"].push(invoiceitems.id);
        tree["items"][item.id]["invoiced"][invoiceitems.id] = invoiceitems
        tree["items"][item.id]["invoiced"][invoiceitems.id]["ot"] = item.order_type
      }
    });
  });

  $.each(od_invoices, function (a, invoice) {
    tree["invoices"]["ids"].push(invoice.id);
    tree["invoices"][invoice.id] = invoice
    tree["invoices"][invoice.id]["item"] = { ids: [] }
    $.each(od_invoiceitems, function (k, invoiceitem) {
      if (invoiceitem.invoice_id == invoice.id) {
        tree["invoices"][invoice.id]["item"]["ids"].push(invoiceitem.id);
        tree["invoices"][invoice.id]["item"][invoiceitem.id] = invoiceitem
      }
    });
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
          $("#customerid_id").removeAttr("disabled");
          filldata("#customerid_id", groupdata, "Select Customer", [
            "id",
            "name",
          ]);
          if (groupdata.length == 1) {
            $("#customerid_id").val(groupdata[0].id);
            $("#customerid_id").trigger("change");
            $("#id_orderid").removeAttr("disabled");
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
        $("#id_orderid").removeAttr("disabled");
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

$(document).on("click", ".paytrm", function () {
  if ($(this).is(':checked')) {
    $("#generate_" + $(this).data("id")).show();
  } else {
    $("#generate_" + $(this).data("id")).hide();
  }
  // $("#generate_" + oldgen).hide();
  // $("#generate_" + $(this).data("id")).show();
  // oldgen = $(this).data("id");
});

$(document).on("click", "#gene", function () {
  $(this).attr("disabled", true);
});

$(document).on("change", ".qty", function () {
  if ($("#id_uom" + $(this).data("index")).val() != 3) {
    val = $(this).val() * $(this).data("up")
  } else {
    val = parseInt($(this).val()) / 100 * parseFloat($(this).data("up"))
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
  // if (payterm_ordertype.includes(od_order.order_type, 0)) {
  //   if (od_payment_term.length > 0) {
  //     fillinvoices_body(od_payment_term, "payment_term");
  //   }
  // } else {
  //   if (od_items.length > 0) {
  //     fillinvoices_body(od_items, "items");
  //   }
  // }
  fillinvoice_body();
}

function fillinvoices_body(data, listname) {
  if (data) {
    var pt = [],
      it = [],
      iv = [];
    if (listname == "payment_term") {
      $.each(od_invoiceitems, function (i, value) {
        pt.push(value.order_payterm_id);
        iv.push(value.invoice_no);
      });
      var total = 0,
        lock = false;
      $("#id_invoiceblock_body").empty();
      var olditem = "";
      var i = 0;
      $.each(data, function (index, value) {
        if (value.order_item_id != olditem) {
          $("#id_invoiceblock_body").append(
            '<div class="col-sm-12 col-lg-12"><table class="table"><thead><tr><th></th><th>Item</th><th>Description</th><th>Qty./Unit</th><th>Unit Price</th><th>Total Value</th><th class="min110"></th></tr></thead><tbody id="invoicept' +
            value.order_item_id +
            '"></tbody></table></div>'
          );
          olditem = value.order_item_id;
          lock = false;
        }
        if (pt.includes(value.id)) {
          $("#invoicept" + value.order_item_id).append(
            "<tr><td></td><td>" +
            value.item +
            "</td><td>" +
            value.description +
            "</td><td>" +
            value.qty +
            " / " +
            setuom(value.uom_id) +
            "</td><td>" +
            humanamount(value.unit_price) +
            "</td><td>" +
            humanamount(value.total) +
            '</td><td class="py-0 align-center" style="vertical-align: middle;"><button class="btn btn-default btn-sm pdf" data-href="' +
            baseUrl +
            "pdf/invoice_" +
            iv[pt.indexOf(value.id)] +
            '.pdf" type="button">View Invoice</button></td></tr>'
          );
        } else {
          if (lock == false) {
            firstselector.push(index);
            $("#invoicept" + value.order_item_id).append(
              '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
              index +
              '" required class="paytrm" data-id="' +
              index +
              '" checked><label for="id_paytrm' +
              index +
              '"></label></div></td><td>' +
              value.item +
              "</td>      <td>" +
              value.description +
              "</td><td>" +
              value.qty +
              " / " +
              setuom(value.uom_id) +
              "</td><td>" +
              humanamount(value.unit_price) +
              "</td><td>" +
              humanamount(value.total) +
              '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
              index +
              '" data-id="' +
              index +
              '" data-list="' +
              listname +
              '" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
            lock = true;
          } else {
            $("#invoicept" + value.order_item_id).append(
              '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
              index +
              '" required class="paytrm" data-id="' +
              index +
              '" disabled><label for="id_paytrm' +
              index +
              '"></label></div></td><td>' +
              value.item +
              "</td>      <td>" +
              value.description +
              "</td><td>" +
              value.qty +
              " / " +
              setuom(value.uom_id) +
              "</td><td>" +
              humanamount(value.unit_price) +
              "</td><td>" +
              humanamount(value.total) +
              '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' +
              index +
              '" data-id="' +
              index +
              '" data-list="' +
              listname +
              '" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
          }
        }
        total += parseFloat(value.total);
      });
    } else if (listname == "items") {
      $.each(od_invoiceitems, function (index, value) {
        it.push(value.order_item_id);
        iv.push(value.id);
      });
      $("#id_invoiceblock_body")
        .empty()
        .append(
          '<table class="table"><thead><tr><th></th><th>Item</th><th>Item Description</th><th>' +
          setheader(od_order.order_type) +
          '</th><th>UOM</th><th>Unit Price</th><th>Total Value</th><th class="min110"></th></tr></thead><tbody id="id_invoicebody"></tbody></table>'
        );
      var total = 0,
        lock = false;
      $.each(data, function (index, value) {
        if (it.includes(value.id)) {
          subtotal = parseFloat(value.total);
          qty = parseFloat(value.qty);
          $.each(od_invoiceitems, function (i, val) {
            if (per_item.order_item_id == parseInt(value.id)) {
              $("#id_invoicebody").append(
                "<tr><td></td><td>" +
                per_item.item +
                "</td><td>" +
                per_item.description +
                "</td><td>" +
                per_item.qty +
                "</td><td>" +
                setuom(value.uom_id) +
                "</td><td>" +
                humanamount(per_item.unit_price) +
                "</td><td>" +
                humanamount(per_item.total) +
                '</td><td class="py-0 align-center" style="vertical-align: middle;"><button class="btn btn-default btn-sm pdf" data-href="' +
                baseUrl +
                "pdf/invoice_" +
                per_item.invoice_no +
                '.pdf" type="button">View Invoice</button>   </td></tr>'
              );
              subtotal -= parseFloat(per_item.sub_total);
              qty -= parseFloat(per_item.qty);
            }
          });
          if (subtotal > 0.0) {
            if (lock == false) {
              $("#id_invoicebody").append(
                '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
                index +
                '" required name="id_paytrm" class="paytrm" data-id="' +
                index +
                '" checked>    <label for="id_paytrm' +
                index +
                '"></label></div></td><td>' +
                value.item +
                "</td><td>" +
                value.description +
                "</td><td>" +
                qty +
                "</td><td>" +
                setuom(value.uom_id) +
                "</td><td>" +
                humanamount(value.unit_price) +
                "</td><td>" +
                humanamount(subtotal) +
                '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
                index +
                '" data-id="' +
                index +
                '" data-list="' +
                listname +
                '" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
              );
              lock = true;
            }
          }
        } else {
          if (lock == false) {
            $("#id_invoicebody").append(
              '<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" id="id_paytrm' +
              index +
              '" required name="id_paytrm" class="paytrm" data-id="' +
              index +
              '" checked>     <label for="id_paytrm' +
              index +
              '"></label></div></td> <td>' +
              value.item +
              "</td>      <td>" +
              value.description +
              "</td><td>" +
              value.qty +
              "</td><td>" +
              setuom(value.uom_id) +
              "</td> <td>" +
              humanamount(value.unit_price) +
              "</td><td>" +
              humanamount(value.total) +
              '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
              index +
              '" data-id="' +
              index +
              '" data-list="' +
              listname +
              '" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
            lock = true;
          } else {
            $("#id_invoicebody").append(
              '<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" id="id_paytrm' +
              index +
              '" required name="id_paytrm" class="paytrm" data-id="' +
              index +
              '" disabled><label for="id_paytrm' +
              index +
              '"></label></div></td>  <td>' +
              value.item +
              "</td>     <td>" +
              value.description +
              "</td><td>" +
              value.qty +
              "</td>        <td>" +
              setuom(value.uom_id) +
              "</td> <td>" +
              humanamount(value.unit_price) +
              "</td>           <td>" +
              humanamount(value.total) +
              '</td>                <td class="py-0 align-center" style="vertical-align: middle;">           <button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' +
              index +
              '" data-id="' +
              index +
              '" data-list="' +
              listname +
              '" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
          }
        }
        total += parseFloat(value.total);
      });
    }
    $("#id_invoiceblock_body").append(
      '<input type="hidden" name="order_total" value="' + total + '">'
    );
    $("#id_invoiceblock").show();
  }
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
    '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card"><div class="card-header">Invoice</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th><th>' +
    setheader(od_order.order_type) +
    '</th><th>UOM</th><th>Unit Price</th><th>Total</th></tr></thead><tbody id="preview_tbody"></tbody></table></div> <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label> <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label> <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div> <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label> <input type="number" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div> </div></div></div><div class="row" id="t2" data-state="hide"></div>'
  );
  if (items_for_invoicing.length > 0) {
    $.each(items_for_invoicing, function (i, t) {
      if ($("#id_paytrm" + t.id).is(':checked')) {
        $("#preview_tbody").append(
          '<tr><td><input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="0"><input type="hidden" name="order_details[' + c + '][order_item_id]" id="id_order_item_id' + c + '" value="' + t.id + '"><input type="hidden" name="order_details[' + c + '][item]" id="id_item' + c + '" value="' + t.item + '">' + t.item + '</td><td ><input type="text" class="form-control desp" required name="order_details[' + c + '][description]" id="id_descp' + c + '" value="' + t.description + '"></td><td class="minmax150"><input type="number" class="form-control qty" required name="order_details[' + c + '][qty]" id="id_qty' + c + '" min="1" value="' + t.qty + '" data-index="' + c + '" data-up="' + t.unit_price + '" data-uom="' + t.uom_id + '" max="' + t.qty + '"></td><td class="pt-3" >' + setuom(t.uom_id) + '<input type="hidden" required name="order_details[' + c + '][uom_id]" id="id_uom' + c + '" value="' + t.uom_id + '"></td><td class="pt-3">₹' + t.unit_price + '<input type="hidden" required name="order_details[' + c + '][unit_price]" id="id_unitprice' + c + '" value="' + t.unit_price + '"></td><td id="preview_row_total' + c + '" class="pt-3">₹' + t.total + '</td><input type="hidden" required name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + t.total + '"></tr>');
        c++;
      }
    });
  }
  if (payment_for_invoicing.length > 0) {
    $.each(payment_for_invoicing, function (j, p) {
      if ($("#id_paytrm" + p.order_item_id + "_" + p.id).is(':checked')) {
        if (p.ot == 1) {
          $("#preview_tbody").append(
            '<tr><td class="max100"><input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="' + p.id + '"><input type="hidden" name="order_details[' + c + '][order_item_id]" value="' + p.order_item_id + '">' + p.item + '<input type="hidden" name="order_details[' + c + '][item]" value="' + p.item + '"></td><td class="max150"><input type="text" required name="order_details[' + c + '][description]" id="id_description" class="form-control" value="' + p.description + '"></td><td>' + p.qty + ' <input type="hidden" name="order_details[' + c + '][qty]" value="' + p.qty + '"> / ' + setuom(p.uom_id) + '</td><td class="text-center">-</td><td><input type="number" style="width: 10rem;" name="order_details[' + c + '][unit_price]" class="form-control pup" data-id="' + c + '" value="' + p.unit_price + '"><input type="hidden" name="order_details[' + c + '][uom_id]" value="' + p.uom_id + '"></td><td><span id="id_total_span' + c + '">' + p.total + '</span><input type="hidden" name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + p.total + '"></td></tr>');
        } else {
          $("#preview_tbody").append(
            '<tr><td class="max100"><input type="hidden" name="order_details[' + c + '][order_payterm_id]" value="' + p.id + '"><input type="hidden" name="order_details[' + c + '][order_item_id]" value="' + p.order_item_id + '">' + p.item + '<input type="hidden" name="order_details[' + c + '][item]" value="' + p.item + '"></td><td class="max150"><input type="text" required name="order_details[' + c + '][description]" id="id_description" class="form-control" value="' + p.description + '"></td><td>' + p.qty + ' <input type="hidden" name="order_details[' + c + '][qty]" value="' + p.qty + '"> / ' + setuom(p.uom_id) + '<input type="hidden" name="order_details[' + c + '][unit_price]" value="' + p.unit_price + '"></td><td class="text-center">-</td><td>' + p.unit_price + '<input type="hidden" name="order_details[' + c + '][uom_id]" value="' + p.uom_id + '"></td><td>' + p.total + '<input type="hidden" name="order_details[' + c + '][total]" id="id_total' + c + '" value="' + p.total + '"></td></tr>');
        }
        c++;
      }
    });
  }
}

$(document).on("change", ".pup", function () {
  $("#id_total_span" + $(this).data('id')).text($(this).val());
  $("#id_total" + $(this).data('id')).val($(this).val());
});


function preview_modal_body(index, listname) {
  i = 0;
  if (listname == "items") {
    $("#preview_modal_body")
      .empty()
      .append(
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card">             <div class="card-header">' +
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
      '<tr><td><input type="hidden" name="order_details[0][order_payterm_id]" value="0"><input type="hidden" name="order_details[0][order_item_id]" id="id_order_item_id1" value="' +
      od_items[index].id +
      '">           <input type="hidden" name="order_details[0][item]" id="id_item1" value="' +
      od_items[index].item +
      '">' +
      od_items[index].item +
      '</td><td >              <input type="text" class="form-control desp" required name="order_details[0][description]" id="id_descp1" value="' +
      od_items[index].description +
      '"></td>                  <td class="minmax150"><input type="number" class="form-control qty" required name="order_details[0][qty]" id="id_qty1" min="1" value="' +
      remaining_qty +
      '" data-index="1" data-up="' +
      od_items[index].unit_price +
      '" data-uom="' +
      od_items[index].uom_id +
      '" max="' +
      remaining_qty +
      '">    </td><td class="pt-3" >' +
      setuom(od_items[index].uom_id) +
      '               <input type="hidden" required name="order_details[0][uom_id]" id="id_uom1" value="' +
      od_items[index].uom_id +
      '">     </td><td class="pt-3">₹' +
      od_items[index].unit_price +
      '<input type="hidden" required name="order_details[0][unit_price]" id="id_unitprice1" value="' +
      od_items[index].unit_price +
      '">       </td><td id="preview_row_total1" class="pt-3">₹0.00</td>   <input type="hidden" required name="order_details[0][total]" id="id_total1" value="0"></tr>'
    );
    // previewlist.push(1);
    preview_footer(index, listname);
    $(".qty").trigger("change");
    preview_total();
  } else {
    $("#preview_modal_body")
      .empty()
      .append(
        '<div class="row" id="t1" data-state="show"><div class="col-sm-12 col-lg-12"><div class="row"><div class="col-sm-12 col-lg-12"><div class="card">             <div class="card-header">' +
        getordertype() +
        '</div><div class="card-body"> <table class="table"><thead><tr><th>Item</th><th>Description</th>   <th>Qty./Unit</th>    <th>Unit Price</th><th>	Total Value</th> </tr></thead>          <tbody id="preview_tbody"></tbody></table></div>               <div class="card-footer" id="preview_footer"></div></div></div><div class="col-sm-12 col-lg-3"><label for="id_invoicedate">Invoice Date</label>                  <input type="date" class="form-control ftsm" name="invoice_date" required id="id_invoicedate"></div>  <div class="col-sm-12 col-lg-3"><label for="id_due_date">Due Date</label>      <input type="date" class="form-control ftsm" required name="due_date" id="id_due_date"></div>         <div class="col-sm-12 col-lg-3"><label for="id_invoice_no">Invoice No.</label>    <input type="number" class="form-control numberonly" pattern="[0-9]{7}" minlength="7"  maxlength="7" min="0000000" max="9999999" required name="invoice_no" id="id_invoice_no"></div></div></div></div><div class="row" id="t2" data-state="hide"></div>'
      );
    $("#preview_tbody").empty();

    $.each(firstselector, function (index, value) {
      $("#preview_tbody").append(
        '<tr><td class="max100"><input type="hidden" name="order_details[' +
        index +
        '][order_payterm_id]" value="' +
        od_payment_term[value].id +
        '"><input type="hidden" name="order_details[' +
        index +
        '][order_item_id]" value="' +
        od_payment_term[value].order_item_id +
        '">   ' +
        od_payment_term[value].item +
        '<input type="hidden" name="order_details[' +
        index +
        '][item]" value="' +
        od_payment_term[value].item +
        '"></td><td class="max150"><input type="text" required name="order_details[' +
        index +
        '][description]" id="id_description" class="form-control" value="' +
        od_payment_term[value].description +
        '">   </td><td>' +
        od_payment_term[value].qty +
        ' <input type="hidden" name="order_details[' +
        index +
        '][qty]" value="' +
        od_payment_term[value].qty +
        '"> / ' +
        setuom(od_payment_term[value].uom_id) +
        '                <input type="hidden" name="order_details[' +
        index +
        '][unit_price]" value="' +
        od_payment_term[value].unit_price +
        '">          </td><td>' +
        od_payment_term[value].unit_price +
        '<input type="hidden" name="order_details[' +
        index +
        '][uom_id]" value="' +
        od_payment_term[value].uom_id +
        '"></td><td>' +
        od_payment_term[value].total +
        '  <input type="hidden" name="order_details[' +
        index +
        '][total]" value="' +
        od_payment_term[value].total +
        '"></td></tr>'
      );
      i += 1;
    });
    preview_footer(index, listname);
  }
  $("#id_due_date").attr("min", tomorrow);
}

function resetongroup() {
  $("#customerid_id").empty().attr("disabled", true);
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
  $("#id_orderid").empty().attr("disabled", true);
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
  $("#id_invoiceblock_body").empty();
  $("#preview_modal_body").empty();
  $("#id_invoiceblock_body").empty();
}

function setheader(val) {
  if (val == 1) {
    return "Month";
  } else if (val == 2) {
    return "Payment Slab";
  } else {
    return "Qty.";
  }
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


function setuom(val) {
  if (val == 1) {
    return "Day(s)";
  }
  if (val == 2) {
    return "AU";
  }
  if (val == 3) {
    return "Percentage (%)";
  }
  if (val == 4) {
    return "PC";
  }
}

function fillorderbody(items) {
  $("#orderlist").empty();
  $.each(items, function (index, value) {
    $("#orderlist").append('<tr id="order' + index + '"></tr>');
    $("#order" + index)
      .append('<td id="item' + index + '">' + value.item + "</td>")
      .append(
        '<td id="description' + index + '">' + value.description + "</td>"
      )
      .append('<td id="qty' + index + '">' + value.qty + "</td>")
      .append('<td id="uom_id' + index + '">' + setuom(value.uom_id) + "</td>")
      .append('<td id="unit_price' + index + '">' + value.unit_price + "</td>")
      .append(
        '<td id="total' + index + '">' + humanamount(value.total) + "</td>"
      );
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
    ' %</span> ) : </b>         <span id="preview_igst_val" data-gst="' +
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
  // if (listname == "items") {
  //   $("#preview_subtotal_txt").text(humanamount(0));
  //   $("#previewsubtotal").val(0);
  //   $("#preview_sgst_val").text(humanamount(0));
  //   $("#preview_cgst_val").text(humanamount(0));
  //   $("#preview_igst_val").text(humanamount(0));
  //   $("#previewsgst").val(0);
  //   $("#previewcgst").val(0);
  //   $("#previewigst").val(0);
  //   $("#preview_total_val").text(humanamount(0));
  //   $("#previewinvoice_total").val(0);
  // }
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
  var old_ot = 0
  var table_id = 0
  var total = 0
  $.each(tree["items"]["ids"], function (b, item_Id) {
    var pt_list = []
    if (
      // New Order Type or
      (old_ot != tree["items"][item_Id].order_type) ||
      ( // Already Invoiced orders or 
        old_ot == tree["items"][item_Id].order_type &&
        (tree["items"][item_Id]["invoiced"]["ids"]).length > 0
      ) || ( // Payment term order type gets header
        tree["items"][item_Id].order_type < 4 &&
        (tree["items"][item_Id]["payment"]["ids"]).length > 0
      )) {
      table_id++
      // table header
      $("#id_invoiceblock_body").append(
        '<div class="col-sm-12 col-lg-12" id="col_' + table_id + '"><table class="table"><thead><tr><th></th><th>Performa</th><th>Item</th><th>Description</th><th>Qty./Unit</th><th>Unit Price</th><th>Total Value</th><th class="min110"></th></tr></thead><tbody id="invoicept' + table_id + '"></tbody></table></div>'
      );
    }
    // List invoiced items and payment terms
    if ((tree["items"][item_Id]["invoiced"]["ids"]).length > 0) {
      $.each(tree["items"][item_Id]["invoiced"]["ids"], function (c, invoiced_Id) {
        // Invoiced
        $("#invoicept" + table_id).append(
          '<tr><td style="width: 80px;"></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="invoice_id_performa' +
          item_Id +
          '" required class="" data-id="' +
          item_Id +
          '" ' + check_performa(tree["items"][item_Id]["invoiced"][invoiced_Id].item) + ' disabled>     <label for="invoice_id_performa' +
          item_Id +
          '"></label></div></td><td>' +
          tree["items"][item_Id]["invoiced"][invoiced_Id].item +
          "</td><td>" +
          tree["items"][item_Id]["invoiced"][invoiced_Id].description +
          "</td><td>" +
          tree["items"][item_Id]["invoiced"][invoiced_Id].qty +
          " / " +
          setuom(tree["items"][item_Id]["invoiced"][invoiced_Id].uom_id) +
          "</td><td>" +
          humanamount(tree["items"][item_Id]["invoiced"][invoiced_Id].unit_price) +
          "</td><td>" +
          humanamount(tree["items"][item_Id]["invoiced"][invoiced_Id].total) +
          '</td><td class="py-0 align-center" style="vertical-align: middle;"><button class="btn btn-default btn-sm pdf" data-href=" ' +
          baseUrl +
          "pdf/invoice_" +
          item_Id +
          '.pdf" type="button">View Invoice</button></td></tr>'
        );
        if (tree["items"][item_Id]["invoiced"][invoiced_Id].order_payterm_id != 0) {
          // Capturing invoiced Payment term Ids
          pt_list.push(tree["items"][item_Id]["invoiced"][invoiced_Id].order_payterm_id);
        }
      });
    };
    // List non-invoiced order items
    if (3 < tree["items"][item_Id].order_type && tree["items"][item_Id].order_type < 7 ||
      (tree["items"][item_Id].hasOwnProperty('payment') == true &&
        tree["items"][item_Id]["payment"]["ids"]).length == 0) {
      if (old_ot == tree["items"][item_Id].order_type) {
        // List disabled order items
        $("#invoicept" + table_id).append(
          '<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" id="id_paytrm' +
          item_Id +
          '" required class="paytrm" data-id="' +
          item_Id +
          '" disabled><label for="id_paytrm' +
          item_Id +
          '"></label></div></td><td></td><td>' +
          tree["items"][item_Id].item +
          "</td><td>" +
          tree["items"][item_Id].description +
          "</td><td>" +
          tree["items"][item_Id].qty +
          "</td><td>" +
          humanamount(tree["items"][item_Id].unit_price) +
          "</td>           <td>" +
          humanamount(tree["items"][item_Id].total) +
          '</td>                <td class="py-0 align-center" style="vertical-align: middle;">           <button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' +
          b +
          '" data-id="' +
          b +
          '" data-list="items" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
        );
      } else {
        // List enabled order items
        $("#invoicept" + table_id).append(
          '<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" id="id_paytrm' +
          item_Id +
          '" required class="paytrm" data-id="' +
          item_Id +
          '" checked><label for="id_paytrm' +
          item_Id +
          '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="id_performa' +
          item_Id +
          '" class="" data-id="' +
          item_Id +
          '"> <label for="id_performa' +
          item_Id +
          '"></label></div></td><td>' +
          tree["items"][item_Id].item +
          "</td><td>" +
          tree["items"][item_Id].description +
          "</td><td>" +
          tree["items"][item_Id].bal_qty +
          "</td><td>" +
          humanamount(tree["items"][item_Id].unit_price) +
          "</td><td>" +
          humanamount(tree["items"][item_Id].total) +
          '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
          item_Id +
          '" data-id="' +
          b +
          '" data-list="items" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
        );
        total += parseFloat(tree["items"][item_Id].total)
        items_for_invoicing.push(tree["items"][item_Id]);
      }
    }
    // List non-invoiced payment terms & cleared
    var unchecked_paymentterm = false
    if (tree["items"][item_Id].order_type < 4 && (tree["items"][item_Id]["payment"]["ids"]).length > 0) {
      $.each(tree["items"][item_Id]["payment"]["ids"], function (d, paymentterm_Id) {
        if (pt_list.includes(paymentterm_Id) == false) {
          if (unchecked_paymentterm) {
            // List disabled payment terms
            $("#invoicept" + table_id).append(
              '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" required class="paytrm" data-id="' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" disabled><label for="id_paytrm' +
              item_Id +
              '_' +
              paymentterm_Id +
              '"></label></div></td><td></td><td>' +
              tree["items"][item_Id]["payment"][paymentterm_Id].item +
              "</td>      <td>" +
              tree["items"][item_Id]["payment"][paymentterm_Id].description +
              "</td><td>" +
              tree["items"][item_Id]["payment"][paymentterm_Id].qty +
              " / " +
              setuom(tree["items"][item_Id]["payment"][paymentterm_Id].uom_id) +
              "</td><td>" +
              humanamount(tree["items"][item_Id]["payment"][paymentterm_Id].unit_price) +
              "</td><td>" +
              humanamount(tree["items"][item_Id]["payment"][paymentterm_Id].total) +
              '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' +
              b +
              '" data-id="' +
              b +
              '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
          } else {
            unchecked_paymentterm = true
            // List enabled payment terms
            $("#invoicept" + table_id).append(
              '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" required class="paytrm" data-id="' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" checked><label for="id_paytrm' +
              item_Id +
              '_' +
              paymentterm_Id +
              '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="id_performa' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" class="" data-id="' +
              item_Id +
              '_' +
              paymentterm_Id +
              '"> <label for="id_performa' +
              item_Id +
              '_' +
              paymentterm_Id +
              '"></label></div></td><td>' +
              tree["items"][item_Id]["payment"][paymentterm_Id].item +
              "</td>      <td>" +
              tree["items"][item_Id]["payment"][paymentterm_Id].description +
              "</td><td>" +
              tree["items"][item_Id]["payment"][paymentterm_Id].qty +
              " / " +
              setuom(tree["items"][item_Id]["payment"][paymentterm_Id].uom_id) +
              "</td><td>" +
              humanamount(tree["items"][item_Id]["payment"][paymentterm_Id].unit_price) +
              "</td><td>" +
              humanamount(tree["items"][item_Id]["payment"][paymentterm_Id].total) +
              '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
              item_Id +
              '_' +
              paymentterm_Id +
              '" data-id="' +
              b +
              '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
            );
            total += parseFloat(tree["items"][item_Id]["payment"][paymentterm_Id].total)
            payment_for_invoicing.push(tree["items"][item_Id]["payment"][paymentterm_Id]);
          }
        }
      });
    }
    // List non-invoiced Custom order items
    if (tree["items"][item_Id].order_type == 7) {
      // List enabled order items
      $("#invoicept" + table_id).append(
        '<tr><td> <div class="icheck-primary d-inline"> <input type="checkbox" id="id_paytrm' +
        item_Id +
        '" required class="paytrm" data-id="' +
        item_Id +
        '" checked>     <label for="id_paytrm' +
        item_Id +
        '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="id_performa' +
        item_Id +
        '" class="" data-id="' +
        item_Id +
        '"> <label for="id_performa' +
        item_Id +
        '"></label></div></td><td>' +
        tree["items"][item_Id].item +
        "</td>      <td>" +
        tree["items"][item_Id].description +
        "</td><td>" +
        tree["items"][item_Id].bal_qty +
        "</td><td>" +
        humanamount(tree["items"][item_Id].unit_price) +
        "</td><td>" +
        humanamount(tree["items"][item_Id].total) +
        '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
        item_Id +
        '" data-id="' +
        b +
        '" data-list="items" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
      );
      total += parseFloat(tree["items"][item_Id].total)
      items_for_invoicing.push(tree["items"][item_Id]);
      var unchecked_custom = false
      $.each(tree["items"][item_Id]["payment"]["ids"], function (d, paymentterm_ID) {
        if (unchecked_custom) {
          // List disabled payment terms
          $("#invoicept" + table_id).append(
            '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" required class="paytrm" data-id="' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" disabled><label for="id_paytrm' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="id_performa' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" class="" data-id="' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"> <label for="id_performa' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"></label></div></td><td>' +
            tree["items"][item_Id]["payment"][paymentterm_ID].item +
            "</td>      <td>" +
            tree["items"][item_Id]["payment"][paymentterm_ID].description +
            "</td><td>" +
            tree["items"][item_Id]["payment"][paymentterm_ID].qty +
            " / " +
            setuom(tree["items"][item_Id]["payment"][paymentterm_ID].uom_id) +
            "</td><td>" +
            humanamount(tree["items"][item_Id]["payment"][paymentterm_ID].unit_price) +
            "</td><td>" +
            humanamount(tree["items"][item_Id]["payment"][paymentterm_ID].total) +
            '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" style="display: none;" id="generate_' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" data-id="' +
            b +
            '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
          );

        } else {
          unchecked_custom = true
          // List enabled payment terms
          $("#invoicept" + table_id).append(
            '<tr><td><div class="icheck-primary d-inline"><input type="checkbox" id="id_paytrm' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" required class="paytrm" data-id="' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" checked><label for="id_paytrm' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"></label></div></td><td><div class="icheck-primary d-inline"> <input type="checkbox" id="id_performa' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" class="" data-id="' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"> <label for="id_performa' +
            item_Id +
            '_' +
            paymentterm_ID +
            '"></label></div></td><td>' +
            tree["items"][item_Id]["payment"][paymentterm_ID].item +
            "</td>      <td>" +
            tree["items"][item_Id]["payment"][paymentterm_ID].description +
            "</td><td>" +
            tree["items"][item_Id]["payment"][paymentterm_ID].qty +
            " / " +
            setuom(tree["items"][item_Id]["payment"][paymentterm_ID].uom_id) +
            "</td><td>" +
            humanamount(tree["items"][item_Id]["payment"][paymentterm_ID].unit_price) +
            "</td><td>" +
            humanamount(tree["items"][item_Id]["payment"][paymentterm_ID].total) +
            '</td><td class="py-0 align-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-primary generate" id="generate_' +
            item_Id +
            '_' +
            paymentterm_ID +
            '" data-id="' +
            b +
            '" data-list="payments" >Generate&nbsp;<i class="fas fa-chevron-right"></i></button></td></tr>'
          );
          total += parseFloat(tree["items"][item_Id]["payment"][paymentterm_ID].total)
          payment_for_invoicing.push(tree["items"][item_Id]["payment"][paymentterm_ID]);
        }
      });
    }
    // Update change in order type
    if (old_ot != tree["items"][item_Id].order_type) {
      old_ot = tree["items"][item_Id].order_type
    }
  });
  $("#id_invoiceblock_body").append(
    '<input type="hidden" name="order_total" value="' + total + '">'
  );
}

function check_performa(val) {
  if (val == 1 && val == true) {
    return 'checked'
  } else {
    return ''
  }
}