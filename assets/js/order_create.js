var customergroup_data, prehigh, billto_address, shipto_address, po_validity, oti;
//OrderTypeID
var ptlist = [];

// On Customer Group Change
$("#id_group_id").change(function () {
  var customergroupid = $(this).val();
  if (customergroupid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + customergroupid,
      data: customergroupid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        resetongroup();
        if (data.length == 1) {
          fill_billto_details(0, data[0].id, data[0].name)
          fill_shipto_details(0, data[0].id)
        }
        customergroup_data = data
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Data not found for this customer group.");
      });
  } else {
    resetongroup();
  }
});


// BillTo Button Click
$("#id_bill_to").on("click", function () {
  $("#id_search_billto").trigger('click');
});
$("#id_search_billto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("billto", "Bill To Address");
  $("#checkbox" + billto_address).prop('checked', true);
  $("#row_" + billto_address).css('background-color', 'powderblue');
});


// ShipTo Button Click
$("#id_ship_to").on("click", function () {
  $("#id_search_shipto").trigger('click');
});
$("#id_search_shipto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("shipto", "Ship To Address");
  $("#checkbox" + shipto_address).prop('checked', true);
  $("#row_" + shipto_address).css('background-color', 'powderblue');
});


// Updates Ship To and (Bill To data along with customer details)
$(document).on("click", ".fill_customer_details", function () {
  highlightrow($(this).data('index'));
  if ($(this).data('modal') == "billto") {
    fill_billto_details($(this).data('index'), $(this).data('id'), $(this).data('name'))
  } else {
    fill_shipto_details($(this).data('index'), $(this).data('id'))
  }
});

function fill_billto_details(index, id, name) {
  billto_address = index
  $("#id_bill_to").val(id).removeClass("is-invalid");
  $("#id_bill_to-error").remove();
  $("#id_customer_id").val(id);
  $("#id_customertext").text(name);
  getcustomerdetails(id);
}

function fill_shipto_details(index, id) {
  shipto_address = index
  $("#id_ship_to").val(id).removeClass("is-invalid");
  $("#id_ship_to-error").remove();
}

function resetongroup() {
  customergroup_data = "";
  shipto_address = "";
  billto_address = "";
  $("#id_bill_to").val("");
  $("#id_ship_to").val("");
  resetonbillto()
  $("#id_customertext").text("");
}

function resetonbillto() {
  $("#salesperson_id").val("");
}


// Address Model Creator Function
function modelfill(checkboxclass, label) {
  $("#modal_title").text(label);
  $("#addhead").empty();
  $("#addbody").empty();
  if (customergroup_data) {
    $("#addhead").append('<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>');
    $.each(customergroup_data, function (index, row) {
      $("#addbody").append("<tr id='row_" + index + "' ></tr>");
      $("#row_" + index)
        .append("<td id='col_1_" + index + "'><div class='icheck-primary d-inline'><input type='radio' id='checkbox" + index + "' name='id_customer' class='fill_customer_details' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' ><label for='checkbox" + index + "'></label></div></td>")
        .append("<td class='fill_customer_details' id='col_2_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.id + "</td>")
        .append("<td class='fill_customer_details' id='col_3_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.name + "</td>")
        .append("<td class='fill_customer_details' id='col_4_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' style='width: 455px'>" + row.address + "</td>");
    });
  }
  else {
    $("#addhead").append('No Records');
  }
}

function highlightrow(id) {
  $("#row_" + prehigh).css('background-color', 'inherit');
  $("#row_" + billto_address).css('background-color', 'inherit');
  $("#row_" + shipto_address).css('background-color', 'inherit');
  prehigh = id
  $("#checkbox" + id).prop('checked', true);
  $("#row_" + id).css('background-color', 'powderblue');
}

// On Customer PO Change
$("#id_po_no").change(function () {
  mydata = { 'customer_id': $("#id_customer_id").val(), 'po_no': $(this).val() }
  if ($(this).val()) {
    $.ajax({
      type: "POST",
      url: baseUrl + "orders/po_validty/",
      data: mydata,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        if (data == false) {
          po_validity = true
          $(".say").remove();
          $("#id_po_no").addClass('is-invalid').parent().append('<span id="id_po_no-error" class="say error invalid-feedback">Order has been raised for this Customer PO.</span>');
        } else { po_validity = false }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Cannot validate PO No.");
      });
  }
});

// Reset on Order Type
function resetonorder() {
  resetPaymentTermForm();
  $(".hide").hide();
  $("#id_po_from_date_col").empty();
  $("#id_po_to_date_col").empty();
  $("#orderlist").empty();
  orderid_list = [];
  last_orderid = -1
  $("#add_item").trigger("click");
}

// Order Type Change
$(document).on("change", "#id_ordertype", function () {
  if ($(this).val()) {
    oti = nz($(this).val());
    // Show/Hide Order Item Card
    $(".order").show();
    if (old_orderid != oti) {
      resetonorder()
      old_orderid = oti;
      // On-Site Support Sale
      if (oti == 1) {
        // $("#add_item").hide();
        $("#order_item_header_qty").text("Total Months");
        $("#order_item_header_up").text("Total Price");
        $(".hide").show();
        $("#id_po_from_date_col").append('<input type="date" required class="form-control" name="po_from_date" id="id_po_from_date">');
        $("#id_po_to_date_col").append('<input type="date" required class="form-control" name="po_to_date" id="id_po_to_date">');
      } //Project Sale
      else if (oti == 2) {
        $("#order_item_header_qty").text("Payment Slab");
        $("#order_item_header_up").text("Total Price");
      } // AMC Support Sale
      else if (oti == 3) {
        $(".hide").show();
        $("#order_item_header_qty").text("Qty.");
        $("#order_item_header_up").text("Total Price");
        $("#id_po_from_date_col").append('<input type="date" required class="form-control" name="po_from_date" id="id_po_from_date">');
        $("#id_po_to_date_col").append('<input type="date" required class="form-control" name="po_to_date" id="id_po_to_date">');
      } // Man-days-Support Sale
      else if (oti == 4) {
        $("#order_item_header_qty").text("Man days");
        $("#order_item_header_up").text("Unit Price");
      }
      else {
        $("#order_item_header_qty").text("Qty.");
        $("#order_item_header_up").text("Total Price");
      }
      ttotal();
    }
  } else {
    oti = 0
    $(".order").hide();
  }
});

$(document).on("change", "#id_po_from_date", function () {
  $("#id_po_to_date").attr("min", $(this).val());
});

// On quantity Change
$(document).on("change", ".qty", function () {
  qtycal($(this).attr("id"), $(this).data("id"))
  if (oti < 4) {
    $("#colt" + $(this).data('id')).empty();
    for (i = 0; i < $(this).val(); i++) {
      if (oti == 2) {
        projecttablebody("colt" + $(this).data('id'), i);
      } else {
        projecttablebody("colt" + $(this).data('id'), i, 1, uom = 2, true);
      }
    }
    $("#col_" + $(this).data('id')).show();
    $(".orderdtl").show();
    paymentgenerator();
  }
});

// On Unit Price Change
$(document).on("change", ".unitprice", function () {
  unitpriceval = $(this).val();
  $(this).data('val', $(this).val())
  if (oti < 4) {
    if (oti == 2) {
      $(".colt" + $(this).data('id') + "_unitprice").val($(this).val());
    } else {
      subtotal = ($(this).val() / $("#id_quantity" + $(this).data('id')).val()).toFixed(2);
      $(".colt" + $(this).data('id') + "_unitprice").val(subtotal)
    }
  }
  paymentgenerator()
  ordercollector($(this).data("id"));
});


$(document).on("change", ".uom", function () {
  ordercollector($(this).data('id'));
});


// Delete order item modal activator
$(document).on("click", "i.trash", function () {
  deleteid = $(this).data("id");
  $("#modelactivate").click();
});


// Delete order item on item modal submit
$(".killrow").click(function () {
  $("#" + deleteid).remove();
  $("#col_" + deleteid).remove();
  if (deleteid == "pt" + deleteid) {
    ptlist = jQuery.grep(ptlist, function (b) {
      return b != id;
    });
    pttotal();
    $("#byemodal").click();
  } else {
    orderid_list = jQuery.grep(orderid_list, function (b) {
      return b != deleteid;
    });
    if (orderid_list.length < 1) {
      $("#add_item").trigger("click");
    }
    ttotal();
    $("#byemodal").click();
  }
});


// Add new order button click
$("#add_item").on("click", function () {
  last_orderid += 1
  addrow(last_orderid);
});


function qtycal(qtyid, id) {
  if (qtyid == "id_ptquantity" + id) {
    val = $("#" + qtyid).val();
    if ((val % 5) > 0) {
      $("#" + qtyid).val(parseInt(val) + (5 - (val % 5)));
    }
    if (val > 100) {
      $("#" + qtyid).val(100);
    }
    lastfill();
    paymentTermcollector(id);
  } else {
    ordercollector(id);
    // if (oti != 2) {
    //   ordercollector(id);
    // }
  }
}

function lastfill() {
  paymentTermTotal = 0
  emptyPaymentTermIds = []
  $.each(ptlist, function (index, value) {
    if ($("#id_ptquantity" + value).val()) {
      if ((ptlist.length - 1) == index && oneTimeLastFill == true) {
        // Always sets last payment slab to balance
        $("#id_ptquantity" + value).val(100 - paymentTermTotal);
      }
      paymentTermTotal += parseInt($("#id_ptquantity" + value).val())
    } else {
      emptyPaymentTermIds.push(value);
    }
  });

  if (oneTimeLastFill == false) {
    if (emptyPaymentTermIds.length == 1) {
      balanc = 100 - paymentTermTotal
      if (balanc < 0) {
        balanc = ""
      }
      $("#id_ptquantity" + emptyPaymentTermIds[0]).val(balanc);
      paymentTermcollector(emptyPaymentTermIds[0]);
      oneTimeLastFill = true
      paymentTermTotal = 100
    }
  }
}


// Each Order Item calculator
function ordercollector(id) {
  if ($("#id_quantity" + id).val()) {
    $("#id_quantity" + id).data('val', $("#id_quantity" + id).val());
  } else {
    $("#id_quantity" + id).data('val', 0);
  }
  if ($("#id_unitprice" + id).val()) {
    $("#id_unitprice" + id).data('val', $("#id_unitprice" + id).val());
  } else {
    $("#id_unitprice" + id).data('val', 0);
  }
  rowqty = $("#id_quantity" + id).data('val');
  rowunitprice = $("#id_unitprice" + id).data('val');
  rowuom = $("#id_uom" + id).val();
  subtotal = 0;
  if (rowqty && rowunitprice) {
    if (oti < 4) { subtotal = rowunitprice; }
    else if (rowuom == 3) { subtotal = rowunitprice * (rowqty / 100); }
    else { subtotal = rowunitprice * rowqty; }
    $("#total" + id).val(subtotal);
    $("#total" + id).data('val', subtotal);
    $("#id_total" + id).text(humanamount(parseFloat(subtotal).toFixed(2)));
    ttotal()
  }
}

// All Order Items calculator
function ttotal() {
  subtotal = 0;
  if (orderid_list != "") {
    $.each(orderid_list, function (index, value) {
      subtotal += parseFloat($("#total" + value).data('val'));
    });
    $("#id_ordersubtotal").val(subtotal);
    $("#subtotal").text(humanamount(parseFloat(subtotal).toFixed(2)));
    igstval = igst / 100 * subtotal
    cgstval = cgst / 100 * subtotal
    sgstval = sgst / 100 * subtotal
    updateigst(igstval)
    updatecgst(cgstval)
    updatesgst(sgstval)
    gst = igstval + cgstval + sgstval
    total = gst + subtotal
    $("#id_ordertotal").val(total);
    $("#total").text(humanamount(parseFloat(total).toFixed(2)));
  }
}

// Customer Details Colletctor
function getcustomerdetails(customerid) {
  resetonbillto();
  if (customerid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/getdetails/" + customerid,
      data: customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#salesperson_id").val(data.contact_person).removeClass("is-invalid");
        getgst(customerid);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
}

function getgst(customerid) {
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + customerid,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      if (data.state == "same") {
        $("#sgstpercent").text(data.sgst);
        $("#sgstdiv").show();
        sgst = data.sgst;

        $("#cgstpercent").text(data.cgst);
        $("#cgstdiv").show();
        cgst = data.cgst;

        $("#igstdiv").hide();
        igst = 0;
        $("#id_taxrate").val(data.cgst);
      } else {
        $("#sgstdiv").hide();
        $("#cgstdiv").hide();
        $("#id_taxrate").val(data.igst);
        $("#igstpercent").text(data.igst);
        $("#igstdiv").show();
        cgst = 0;
        sgst = 0;
        igst = data.igst;
      }
      ttotal();
    });
}


function updateigst(val) {
  $("#id_igst").val(val);
  $("#igstvalue").text(humanamount(parseFloat(igstval).toFixed(2)));
}

function updatecgst(val) {
  $("#id_cgst").val(cgstval);
  $("#cgstvalue").text(humanamount(parseFloat(cgstval).toFixed(2)));
}

function updatesgst(val) {
  $("#id_sgst").val(sgstval);
  $("#sgstvalue").text(humanamount(parseFloat(sgstval).toFixed(2)));
}

// Order Row creating function with row id as arguement
function addrow(id) {
  $("#orderlist").append("<tr id='" + id + "'></tr>");
  $("#" + id).append("<td class='form-group'><input type='text' class='form-control item capitalize' name='order_details[" + id + "][item]' data-id='" + id + "' id='id_item" + id + "' placeholder='*Enter Item' /></td>")
    .append("<td class='form-group'><input type='text' class='form-control min150 desp capitalize' name='order_details[" + id + "][description]' data-id='" + id + "' id='id_description" + id + "' placeholder='*Enter Description' /></td>")
    .append("<td class='form-group max150'><input type='number' class='form-control qty' data-qty='0' name='order_details[" + id + "][qty]' data-val='0' data-id='" + id + "' id='id_quantity" + id + "' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /></td>")
    .append('<td class="form-group min150" id="td_uom' + id + '"><select class="form-control uom" name="order_details[' + id + '][uom_id]" data-id="' + id + '" id="id_uom' + id + '"><option value=""></option><option value="1">Day(s)</option><option value="2">AU</option><option value="3">Percentage (%)</option><option value="4">PC</option></select></td>')
    .append("<td class='form-group max150'><input type='number' class='form-control unitprice' data-up='0' name='order_details[" + id + "][unit_price]' data-val='0' data-id='" + id + "' min='1' id='id_unitprice" + id + "' /></td>")
    .append("<td class='form-group pt-4'><input type='hidden' class='form-control rowtotal' data-total='0' value='' name='order_details[" + id + "][total]' data-val='0' data-id='" + id + "' id='total" + id +
      "' ><span id='id_total" + id + "' >₹0.00</span></td>");
  if (id != 0) {
    $("#" + id).append("<td class='pt-4'><i class='fas fa-minus-circle trash' data-id='" + id + "' style='color: red' ></i></td>");
  }
  if (oti == 2) {
    $("#td_uom" + id)
      .empty()
      .append("<div class='pt-1'>Percentage (%)</div>")
      .append('<select class="form-control uom" name="order_details[' + id + '][uom_id]" data-id="' + id + '" id="id_uom' + id + '" style="display: none;"></select>');
    $("#id_uom" + id)
      .append('<option value="3" selected="">Percentage (%)</option>')
      .hide();
    $("#row_paytm").append('<div class="col-sm-12 col-lg-12" id="col_' + id + '" style="display: none;"></div>')
    colt_maker('col_' + id)
  } else if (oti == 1 || oti == 3) {
    $("#td_uom" + id)
      .empty()
      .append("<div class='pt-1'>AU<div>")
      .append('<select class="form-control uom" name="order_details[' + id + '][uom_id]" data-id="' + id + '" id="id_uom' + id + '" style="display: none;"></select>');
    $("#id_uom" + id)
      .append('<option value="2">AU</option>')
      .hide();
    $("#row_paytm").append('<div class="col-sm-12 col-lg-12" id="col_' + id + '" style="display: none;"></div>')
    colt_maker('col_' + id)
  } else if (oti == 4) {
    $("#td_uom" + id)
      .empty()
      .append('<select class="form-control uom" name="order_details[' + id + '][uom_id]" data-id="' + id + '" id="id_uom' + id + '"></select>');
    $("#id_uom" + id).append('<option value="1">Day(s)</option>');
  }
  orderid_list.push(id);
}

function colt_maker(id) {
  if (oti == 2) {
    $("#" + id).append('<table class="table"><thead><tr><th class="max100">Sr. No.</th><th class="max100">Item</th><th class="min100">Item Description</th><th class="minmax150">Qty./Unit</th><th class="min100">Unit Price</th><th class="min100">Total Value</th></tr></thead><tbody id="colt' + id.match(/(\d+)/)[0] + '"></tbody></table>')
  } else {
    $("#" + id).append('<table class="table"><thead><tr><th class="max100">Sr. No.</th><th class="min100">Item Description</th><th class="minmax150">Qty./Unit</th><th class="min100">Unit Price</th><th class="min100">Total Value</th></tr></thead><tbody id="colt' + id.match(/(\d+)/)[0] + '"></tbody></table>')
  }
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

function nz(val) {
  // NaN to Zero
  if (val == "" || val == NaN) {
    return 0
  } else {
    return parseInt(val)
  }
}


function paymentgenerator() {
  $.each(orderid_list, function (index, id) {
    qty_control = 0
    check = true
    empty_payment_term_list = []
    j = nz($("#id_quantity" + id).val()) - 1
    for (i = 0; i <= j; i++) {
      if (i == j && oti == 2 && check == true && qty_control != 0) {
        $("#colt" + id + "id_ptquantity" + i).val(100 - qty_control)
      }
      else if (nz($("#colt" + id + "id_ptquantity" + i).val()) == 0) {
        check = false
        empty_payment_term_list.push("colt" + id + "id_ptquantity" + i)
      }
      else {
        qty_control += nz($("#colt" + id + "id_ptquantity" + i).val())
        // If not last row grab qty val
        // if (nz($("#colt" + id + "id_ptquantity" + i).val()) == 0) {
        //   check = false
        // }
      }
      paymentTermcollector(id, i)
    }
    if (empty_payment_term_list.length == 1) {
      $("#" + empty_payment_term_list[0]).val(100 - qty_control)
    }
  });
}


// Each Payment Term calculator
function paymentTermcollector(xid, yid) {
  if ($("#colt" + xid + "id_ptquantity" + yid).val()) {
    $("#colt" + xid + "id_ptquantity" + yid).data('val', $("#colt" + xid + "id_ptquantity" + yid).val());
  } else {
    $("#colt" + xid + "id_ptquantity" + yid).data('val', 0);
  }
  if ($("#colt" + xid + "id_ptunitprice" + yid).val()) {
    $("#colt" + xid + "id_ptunitprice" + yid).data('val', $("#colt" + xid + "id_ptunitprice" + yid).val());
  } else {
    $("#colt" + xid + "id_ptunitprice" + yid).data('val', 0);
  }
  rowqty = $("#id_quantity" + xid).val();
  rowptqty = $("#colt" + xid + "id_ptquantity" + yid).val();
  rowunitprice = $("#id_unitprice" + xid).val();
  rowptunitprice = $("#colt" + xid + "id_ptunitprice" + yid).val();
  subtotal = 0;
  if (rowptqty && rowptunitprice) {
    if (oti == 1 || oti == 3) {
      subtotal = (rowunitprice / rowqty).toFixed(2);
      $("#colt" + xid + "id_ptunitprice" + yid).val(subtotal)
    } else {
      subtotal = rowptunitprice * (rowptqty / 100);
      $("#colt" + xid + "id_ptunitprice" + yid).val(rowptunitprice);
    }
    $("#colt" + xid + "pttotal" + yid).val(subtotal);
    $("#colt" + xid + "id_pttotal" + yid).text(humanamount(parseFloat(subtotal).toFixed(2)));
  }
}

function resetPaymentTermForm() {
  $(".orderdtl").hide();
  $("#row_paytm").empty();
}


function projecttablebody(body, id, val = "", uom = 3) {
  $("#" + body).append("<tr id='" + body + "pt" + id + "'></tr>");
  // Sr No
  $("#" + body + "pt" + id).append("<td class='form-group'><input type='hidden' class='" + body + "_item' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][item]' data-id='" + id + "' value='" + $("#id_item" + body.match(/(\d+)/)).val() + "' id='" + body + "id_ptitem" + id + "' />" + (id + 1) + "</td>");
  // ITEM Field
  if (oti == 2) {
    $("#" + body + "pt" + id).append("<td class='form-group " + body + "_item' >" + $("#id_item" + body.match(/(\d+)/)).val() + "</td>");
  }
  // Description Field
  $("#" + body + "pt" + id).append("<td class='form-group'><input type='text' class='form-control desp capitalize' data-id='" + id + "' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][description]' id='" + body + "id_paymentterm" + id + "' placeholder='*Enter Description' /></td>");
  // QTY Field
  if (oti == 2) {
    $("#" + body + "pt" + id).append("<td class='input-group'><input type='number' class='form-control ptqty'  value='" + val + "' data-id='" + id + "' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][qty]' id='" + body + "id_ptquantity" + id + "' max='100' min='5' step='5' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /><input type='hidden' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][uom_id]' id'id_ptuom' value='" + uom + "'><div class='input-group-append'><span class='input-group-text'> % </span></div></td>");
  } else {
    $("#" + body + "pt" + id).append("<td class='form-group max150'><input type='hidden' class='form-control'  value='" + val + "' data-id='" + id + "' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][qty]' id='" + body + "id_ptquantity" + id + "'><input type='hidden' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][uom_id]' id'id_ptuom' value='" + uom + "'>1 / AU </td>");
  }
  // UOM, Unit Price & Total Field
  $("#" + body + "pt" + id)
    .append("<td class='form-group max100'><input type='number' class='form-control " + body + "_unitprice' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][unit_price]' value='' data-id='" + id + "' id='" + body + "id_ptunitprice" + id + "' /></td>")
    .append("<td class='form-group'><input type='hidden' class='form-control rowtotal' value='' name='order_details[" + body.match(/(\d+)/)[0] + "][payment_term]" + "[" + id + "][total]' data-id='" + id + "' data-val='0' id='" + body + "pttotal" + id + "' ><span id='" + body + "id_pttotal" + id + "' >₹0.00</span></td>");
  // .append('<td><i class="fas fa-minus-circle trash" style="color: red" ></i></td>');
  ptlist.push(id);
  $("#" + body + "id_ptunitprice" + id).val($("#id_unitprice" + body.match(/(\d+)/)).val()).attr("readonly", true);
}

$(document).on("change", ".item", function () {
  if (oti < 3) {
    $(".colt" + $(this).data('id') + "_item").text($(this).val())
    $(".colt" + $(this).data('id') + "_item").val($(this).val())
  }
});

$(document).on("change", ".ptqty", function () {
  paymentgenerator()
});