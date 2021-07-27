var customergroup_data, prehigh;

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
$("#id_search_billto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("billto", "Bill To Address")
});


// ShipTo Button Click
$("#id_search_shipto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("shipto", "Ship To Address")
});


// Updates Ship To and (Bill To data along with customer details)
$(document).on("click", ".fill_customer_details", function () {
  highlightrow($(this).data('index'));
  if ($(this).data('modal') == "billto") {
    $("#id_bill_to").val($(this).data('id')).removeClass("is-invalid");
    $("#id_bill_to-error").remove();
    $("#id_customer_id").val($(this).data('id'));
    $("#id_customertext").text($(this).data('name'));
    getcustomerdetails($(this).data('id'));
  } else {
    $("#id_ship_to").val($(this).data('id')).removeClass("is-invalid");
    $("#id_ship_to-error").remove();
  }
});


function resetongroup() {
  customergroup_data = "";
  $("#id_bill_to").val("");
  $("#id_ship_to").val("");
  resetonbillto()
  $("#id_customertext").text("");
  // $("#id_po_no").val("");
  // $("#comment_id").val("");
}

function resetonbillto(){
  $("#salesperson_id").val("");
}


// Address Model Creator Function
function modelfill(checkboxclass, label) {
  $("#modal_title").text(label);
  $("#addhead").empty();
  $("#addbody").empty();
  $(".addmodelfooter").hide();
  if (customergroup_data) {
    $("#addhead").append('<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>');
    $.each(customergroup_data, function (index, row) {
      $("#addbody").append("<tr id='row_" + index + "' ></tr>");
      $("#row_" + index)
        .append("<td id='col_1_" + index + "'><div class='icheck-primary d-inline'><input type='radio' id='checkbox" + index + "' name='id_customer' class='fill_customer_details' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' ><label for='checkbox" + row.id + "'></label></div></td>")
        .append("<td class='fill_customer_details' id='col_2_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.id + "</td>")
        .append("<td class='fill_customer_details' id='col_3_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.name + "</td>")
        .append("<td class='fill_customer_details' id='col_4_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' style='width: 455px'>" + row.address + "</td>");
    });
    $(".addmodelfooter").show();
  }
  else {
    $("#addhead").append('No Records');
  }
}

function highlightrow(id) {
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  $("#checkbox" + id).prop('checked', true);
  $("#row" + id).css('background-color', 'powderblue');
}

// Order Type Change
$(document).on("change", "#id_ordertype", function () {
  if ($(this).val()) {
    $(".order").show();
    if (old_orderid != $(this).val()) {
      $("#orderlist").empty();
      orderid_list = [];
      last_orderid = 0
      old_orderid = $(this).val();
      $("#add_item").trigger("click");
      if ($(this).val() == "2") {
        $("#add_item").hide();
        $("#order_item_header_qty").text("Payment Slab");
        $("#id_uom1").empty().append('<option value="3">Percentage (%)</option>').val("3");
      } else {
        $("#order_item_header_qty").text("Qty.");
      }
      $('select.uom').each(function () {
        $(this).val("")
      });
    }
  } else {
    $(".order").hide();
  }
});

// On quantity Change
$(document).on("change", ".qty", function () {
  qtycal($(this).attr("id"), $(this).data("id"))
});

// On Unit Price Change
$(document).on("change", ".unitprice", function () {
  unitpriceval = $(this).val();
  if ($(this).attr("id") == "id_ptunitprice" + $(this).data("id")) {
    paymentTermcollector($(this).data("id"));
  } else {
    $(this).val(parseFloat($(this).val()));
    ordercollector($(this).data("id"));
    $.each(ptlist, function (index, value) {
      $("#id_ptunitprice" + value).val(unitpriceval);
      paymentTermcollector(value);
    });
  }
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
  if (orderid_list.length < 1) {
    last_orderid = 1
  } else {
    last_orderid += 1
  }
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
    if ($("#id_ordertype").val() != 2) {
      ordercollector(id);
    }
  }
}

function lastfill() {
  paymentTermTotal = 0
  emptyPaymentTermIds = []
  $.each(ptlist, function (index, value) {
    if ($("#id_ptquantity" + value).val()) {
      if ((ptlist.length - 1) == index) {
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

  // if (paymentTermTotal > 100) {
  //   id = ptlist[ptlist.length - 1]
  //   extra = parseFloat($("#id_ptquantity" + ptlist.length).val()) - (paymentTermTotal - 100);
  //   $("#id_ptquantity" + id).val(parseInt(extra));
  //   paymentTermcollector(id);
  // }
}





// Amount Representation
function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
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
    if ($("#id_ordertype").val() == 2) { subtotal = rowunitprice; }
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