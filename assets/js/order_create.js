var sgst;
var cgst;
var igst;
var l_gst;
var del_ot;
var del_id;
var old_row = 0;
var oti = 0;
var groupId;
var r_groupId;
var group_id;
var r_groupId;
var checked_shipto;
var checked_billto;
var paymentterm_list = [];
var tree = { otl: [] };
var item_id;
var writemode = true;

$("#group_id").change(function () {
  group_id_reset();
  groupId = $(this).val();
  if (groupId) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + groupId,
      dataType: "json",
      encode: true,
    })
      .done(function (r) {
        r_groupId = r;
        if (r.length == 1) {
          fill_billto_details(0, r[0].id, r[0].name);
          fill_shipto_details(0, r[0].id);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Data not found for this customer group.");
        console.log(jqXHR, textStatus, errorThrown);
      });
  }
});

function billto_reset() {
  $("#sales_person").val("");
}

function group_id_reset() {
  $("#bill_to").val("");
  $("#ship_to").val("");
  $("#customer_name").text("");
  group_id = "";
  r_groupId = "";
  checked_shipto = "";
  checked_billto = "";
  billto_reset();
  $("#itemcard").hide();
}

function getgst(id) {
  sgst = 0;
  cgst = 0;
  igst = 0;
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + id,
    dataType: "json",
    encode: true,
  })
    .done(function (r) {
      l_gst = r;
      if (r.state == "same") {
        sgst = r.sgst;
        cgst = r.cgst;
      } else {
        igst = r.igst;
      }
      update_tax();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("Data not found for this customer group.");
      console.log(jqXHR, textStatus, errorThrown);
    });
  $("#itemcard").show();
}

function get_sales_person(id) {
  billto_reset();
  $.ajax({
    type: "POST",
    url: baseUrl + "customers/getdetails/" + id,
    data: id,
    dataType: "json",
    encode: true,
  })
    .done(function (r) {
      $("#sales_person").val(r.contact_person).removeClass("is-invalid");
      getgst(id);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("No details found against this customer.");
      console.log(jqXHR, textStatus, errorThrown);
    });
}

function fill_billto_details(index, id, name) {
  checked_billto = index;
  $("#bill_to").val(id).removeClass("is-invalid");
  $("#bill_to-error").remove();
  $("#customer_id").val(id);
  $("#customer_name").text(name);
  get_sales_person(id);
}

function fill_shipto_details(index, id) {
  checked_shipto = index;
  $("#ship_to").val(id).removeClass("is-invalid");
  $("#ship_to-error").remove();
}

function update_tax(s = sgst, c = cgst, i = igst) {
  $("#add_order_item_sgstcut_txt").text(s);
  $("#add_order_item_cgstcut_txt").text(s);
  $("#add_order_item_igstcut_txt").text(i);
  if (l_gst.state == "same") {
    $("#col_sub_total").removeClass("col-4");
    $("#col_total").removeClass("col-4");
    $("#col_sub_total").addClass("col-3");
    $("#col_total").addClass("col-3");
    $("#col_sgst").show();
    $("#col_cgst").show();
    $("#col_igst").hide();
  } else {
    $("#col_sub_total").removeClass("col-3");
    $("#col_total").removeClass("col-3");
    $("#col_sub_total").addClass("col-4");
    $("#col_total").addClass("col-4");
    $("#col_sgst").hide();
    $("#col_cgst").hide();
    $("#col_igst").show();
  }
}

$("#billto_search_button").on("click", function () {
  $("#id_search_billto").trigger("click");
});

$("#billto_search_button").on("click", function () {
  modelfill("billto", "Bill To Address");
  $("#checkbox" + checked_billto).prop("checked", true);
  $("#row_" + checked_billto).css("background-color", "powderblue");
});

$("#ship_to").on("click", function () {
  $("#shipto_search_button").trigger("click");
});

$("#shipto_search_button").on("click", function () {
  modelfill("shipto", "Ship To Address");
  $("#checkbox" + checked_shipto).prop("checked", true);
  $("#row_" + checked_shipto).css("background-color", "powderblue");
});

function modelfill(checkboxclass, label) {
  $("#modal_title").text(label);
  $("#addhead").empty();
  $("#addbody").empty();
  if (r_groupId) {
    $("#addhead").append(
      '<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>'
    );
    $.each(r_groupId, function (index, row) {
      $("#addbody").append("<tr id='row_" + index + "' ></tr>");
      $("#row_" + index)
        .append(
          "<td id='col_1_" +
          index +
          "'><div class='icheck-primary d-inline'><input type='radio' id='checkbox" +
          index +
          "' name='id_customer' class='fill_customer_details' data-index='" +
          index +
          "' data-id='" +
          row.id +
          "' data-name='" +
          row.name +
          "' data-address='" +
          row.address +
          "' data-modal='" +
          checkboxclass +
          "' ><label for='checkbox" +
          index +
          "'></label></div></td>"
        )
        .append(
          "<td class='fill_customer_details' id='col_2_" +
          index +
          "' data-index='" +
          index +
          "' data-id='" +
          row.id +
          "' data-name='" +
          row.name +
          "' data-address='" +
          row.address +
          "' data-modal='" +
          checkboxclass +
          "' >" +
          row.id +
          "</td>"
        )
        .append(
          "<td class='fill_customer_details' id='col_3_" +
          index +
          "' data-index='" +
          index +
          "' data-id='" +
          row.id +
          "' data-name='" +
          row.name +
          "' data-address='" +
          row.address +
          "' data-modal='" +
          checkboxclass +
          "' >" +
          row.name +
          "</td>"
        )
        .append(
          "<td class='fill_customer_details' id='col_4_" +
          index +
          "' data-index='" +
          index +
          "' data-id='" +
          row.id +
          "' data-name='" +
          row.name +
          "' data-address='" +
          row.address +
          "' data-modal='" +
          checkboxclass +
          "' style='width: 455px'>" +
          row.address +
          "</td>"
        );
    });
  } else {
    $("#addhead").append("No Records");
  }
}

$(document).on("click", ".fill_customer_details", function () {
  highlightrow($(this).data("index"));
  if ($(this).data("modal") == "billto") {
    fill_billto_details(
      $(this).data("index"),
      $(this).data("id"),
      $(this).data("name")
    );
  } else {
    fill_shipto_details($(this).data("index"), $(this).data("id"));
  }
});

function highlightrow(id) {
  $("#row_" + old_row).css("background-color", "inherit");
  $("#row_" + checked_billto).css("background-color", "inherit");
  $("#row_" + checked_shipto).css("background-color", "inherit");
  old_row = id;
  $("#checkbox" + id).prop("checked", true);
  $("#row_" + id).css("background-color", "powderblue");
}

$("#po_no").change(function () {
  mydata = { customer_id: $("#customer_id").val(), po_no: $(this).val() };
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
          po_validity = true;
          $(".say").remove();
          $("#po_no")
            .addClass("is-invalid")
            .parent()
            .append(
              '<span id="id_po_no-error" class="say error invalid-feedback">Order has been raised for this Customer PO.</span>'
            );
        } else {
          po_validity = false;
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Cannot validate PO No.");
      });
  }
});

function paymentterm_reset() {
  paymentterm_list = [];
  $("#payment_term_card").hide();
  $("#payment_term_cardbody").empty();
}

function create_from_date(create = true) {
  if (create) {
    $("#col_from_date")
      .append('<div class="col-4 mt-3 text-right"><label for="from_date">From Date :</label></div><div class="col-8 mt-2"><input type="date" class="form-control" id="from_date" required="" aria-invalid="false"></div>');
  } else {
    $("#col_from_date").empty();
  }
}

function create_to_date(create = true) {
  if (create) {
    $("#col_to_date")
      .append('<div class="col-4 mt-3 text-right"><label for="to_date">Till Date :</label></div><div class="col-8 mt-2"><input type="date" class="form-control" id="to_date" required=""></div>');
  } else {
    $("#col_to_date").empty();
  }
}

function ordertype_reset() {
  paymentterm_reset();
  $("#add_order_item_cardbody").hide();
  $("#add_order_item_cardfooter").hide();
  $("#order_item_list").empty();
  create_from_date(false);
  create_to_date(false);
  $("#add_order_subtotal_val").text(0.00);
  $("#add_order_sgst_val").text(0.00);
  $("#add_order_cgst_val").text(0.00);
  $("#add_order_igst_val").text(0.00);
  $("#add_order_total_val").text(0.00);
}

function create() {
  writemode = true;
  $("#order_type").val("");
  ordertype_reset();
  $("#add_order_card").show();
  // $("#add_order_cardbody").show();
  // $("#add_order_item_card").show();
}

function uom(tag = true, i = oti) {
  if (tag == true) {
    return ["", "AU", "Percentage (%)", "AU", "Day(s)", "", "", ""][i];
  } else if (tag == false) {
    return ["", "Day(s)", "AU", "Percentage (%)", "PC"][i];
  } else {
    return ["", "2", "3", "2", "1", "", "", ""][i];
  }
}

function nz(val) {
  // NaN to Zero
  if (val == "" || isNaN(val)) {
    return 0;
  } else {
    return parseFloat(val);
  }
}

$(document).on("change", "#order_type", function () {
  $(this).removeClass("is-invalid");
  ordertype_reset();
  oti = nz($(this).val());
  if (oti) {
    var otl = tree["otl"];
    if (otl.includes(oti) == false) {
      tree[oti] = { oil: [] };
    }
    if (writemode) {
      if (tree[oti]["oil"].length == 0) {
        item_id = 1;
      } else {
        item_id = tree[oti]["oil"][tree[oti]["oil"].length - 1] + 1;
      }
      add_order(item_id);
    }

    // On-Site Support Sale
    if (oti == 1) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Total Months");
      $("#unitprice_header").text("Total Price");
      create_from_date();
      create_to_date();
      $("#unitprice_header").text("Total Price");
    } //Project Sale
    else if (oti == 2) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Payment Slab");
      $("#price_header").text("Total Price");
      create_from_date(false);
      create_to_date(false);
    } // AMC Support Sale
    else if (oti == 3) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Qty.");
      $("#price_header").text("Total Price");
      create_from_date();
      create_to_date();
    } // Man-days-Support Sale
    else if (oti == 4) {
      $("#payment_term_card").hide();
      $("#quantity_header").text("Man days");
      $("#price_header").text("Unit Price");
      create_from_date(false);
      create_to_date(false);
    } // Custom Order
    else if (oti == 7) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Qty.");
      $("#price_header").text("Unit Price");
      create_from_date();
      create_to_date();
    } else {
      $("#payment_term_card").hide();
      $("#quantity_header").text("Qty.");
      $("#price_header").text("Total Price");
      create_from_date(false);
      create_to_date(false);
    }
    $("#add_order_item_cardbody").show();
    $("#add_order_item_cardfooter").show();
  }
});

function add_order(id) {
  if (oti < 5) {
    $("#order_item_list").append(
      '<tr id="order_item_' +
      id +
      '"> <td class="form-group" id="orderitem_' +
      id +
      '_col_1"> <input type="text" data-id="' +
      id +
      '" class="form-control item capitalize" id="orderitem_' +
      id +
      '_val_1" placeholder="*Enter Item" /> </td> <td class="form-group" id="orderitem_' +
      id +
      '_col_2"> <input type="text" data-id="' +
      id +
      '" class="form-control min150 desp capitalize" id="orderitem_' +
      id +
      '_val_2" placeholder="*Enter Description" /> </td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_3"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_quantity numberonly" id="orderitem_' +
      id +
      '_val_3" min="1" step="1" aria-invalid="false" /> </td> <td class="form-group min150" id="orderitem_' +
      id +
      '_col_4"> <span id="orderitem_' +
      id +
      '_txt_4">' +
      uom() +
      '</span> </td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_35"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_unitprice" id="orderitem_' +
      id +
      '_val_5" /> <input type="hidden" data-id="' +
      id +
      '" class="form-control rowtotal" id="orderitem_' +
      id +
      '_val_6" /> </td> </tr>'
    );
  } else {
    $("#order_item_list").append(
      '<tr id="order_item_' +
      id +
      '"> <td class="form-group" id="orderitem_' +
      id +
      '_col_1"> <input type="text" data-id="' +
      id +
      '" class="form-control item capitalize" id="orderitem_' +
      id +
      '_val_1" placeholder="*Enter Item" /> </td> <td class="form-group" id="orderitem_' +
      id +
      '_col_2"> <input type="text" data-id="' +
      id +
      '" class="form-control min150 desp capitalize" id="orderitem_' +
      id +
      '_val_2" placeholder="*Enter Description" /> </td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_3"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_quantity numberonly" id="orderitem_' +
      id +
      '_val_3" min="1" step="1" aria-invalid="false" /> </td> <td class="form-group min150" id="orderitem_' +
      id +
      '_col_4"> <span id="orderitem_' +
      id +
      '_txt_4">' +
      uom() +
      '</span><select data-id="' +
      id +
      '" class="form-control order_item_uom" id="orderitem_' +
      id +
      '_val_4"><option value=""></option><option value="1">Day(s)</option><option value="2">AU</option><option value="3">Percentage (%)</option><option value="4">PC</option></select></td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_5"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_unitprice" id="orderitem_' +
      id +
      '_val_5" /> <input type="hidden" data-id="' +
      id +
      '" class="form-control rowtotal" id="orderitem_' +
      id +
      '_val_6" /> </td></tr>'
    );
  }
  if (oti < 4 || oti == 7) {
    payment_term_cardbody(id);
  }
}

function payment_term_cardbody(id) {
  if (oti == 1 || oti == 3) {
    $("#payment_term_cardbody").append(
      '<table class="table" id="table_' +
      id +
      '"><thead><tr><th class="max100">Sr. No.</th><th class="min100">Item Description</th><th class="minmax150">Qty./Unit</th><th class="min100">Unit Price</th><th class="min100">Total Value</th></tr></thead><tbody id="paymentterm_list_' +
      id +
      '"></tbody></table>'
    );
  }
  else if (oti == 2) {
    $("#payment_term_cardbody").append(
      '<table class="table" id="table_' +
      id +
      '"><thead><tr><th class="max100">Sr. No.</th><th class="max100">Item</th><th class="min100">Item Description</th><th class="minmax150">Qty./Unit</th><th class="min100">Unit Price</th><th class="min100">Total Value</th></tr></thead><tbody id="paymentterm_list_' +
      id +
      '"></tbody></table>'
    );
  }
  else if (oti == 7) {
    $("#payment_term_cardbody").append(
      '<table class="table" id="table_' +
      id +
      '"><thead><tr><th class="max150">Sr. No.</th><th class="max150">Item Description</th><th class="max100">Qty.</th><th class="min150">UOM</th><th class="min150">Unit Price</th><th class="min150">Total Value</th></tr></thead><tbody id="paymentterm_list_' +
      id +
      '"></tbody></table>'
    );
    $("#payment_term_cardbody").append('<div class="text-left"><button type="button" class="btn btn-primary btn-sm mr-2" id="add_new_paymentterm" onclick="add_pt()" >Add</button><button type="button" class="btn btn-danger btn-sm" id="del_paymentterm" onclick="del_pt()">Delete Last Term</button></div>');
  }
  add_paymentterm(id, 1);
  paymentterm_list = [1];
}

function del_pt() {
  if (paymentterm_list.length > 0) {
    var last_pti = paymentterm_list[paymentterm_list.length - 1];
    $("#orderitem_" + item_id + "_paymentterm_" + last_pti).remove();
    paymentterm_list = jQuery.grep(paymentterm_list, function (b) {
      return b != last_pti;
    });
    if (paymentterm_list.length == 0) {
      $("#paymentterm_list_" + item_id).append('<tr><td colspan="6" class="text-center">No Payment Terms</td></tr>');
    }
  }
}

function add_pt() {
  if (paymentterm_list.length > 0) {
    var new_pti = paymentterm_list[paymentterm_list.length - 1] + 1;
  } else {
    var new_pti = 1
    $("#paymentterm_list_" + item_id).empty();
  }
  add_paymentterm(item_id, new_pti);
  paymentterm_list.push(new_pti);
}

function add_paymentterm(oid, pid) {
  if (oti == 2) {
    $("#paymentterm_list_" + oid).append(
      '<tr id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '"><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_1">' + pid + '</td><td class="form-group paymentterm_item" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_2"></td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_3"><input type="text" class="form-control paymentterm_description capitalize" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_3" placeholder="*Enter Description" /></td><td class="input-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_4"><input type="number" class="form-control paymentterm_quantity" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_4" max="100" min="5" step="5" data-oid="' +
      oid +
      '" data-pid="' +
      pid +
      '" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/><div class="input-group-append"><span class="input-group-text"> % </span></div></td><td class="form-group max100" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_5"><input type="number" class="form-control paymentterm_unitprice" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_5" readonly="readonly"/></td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_6"><input type="hidden" class="form-control paymentterm_rowtotal" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_6" /><span id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_txt_6">₹0.00</span></td></tr>;'
    );
  } else if (oti == 1 || oti == 3) {
    $("#paymentterm_list_" + oid).append(
      '<tr id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '"><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_1">' + pid + '</td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_3"><input type="text" class="form-control paymentterm_description capitalize" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_3" placeholder="*Enter Description" /></td><td class="input-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_4"><input type="hidden" value="1" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_4">1 / AU </td><td class="form-group max100" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_5"><input type="number" class="form-control paymentterm_unitprice" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_5" readonly="readonly"/></td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_6"><input type="hidden" class="form-control paymentterm_rowtotal" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_6" /><span id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_txt_6">₹0.00</span></td></tr>;'
    );
  } else if (oti == 7) {
    $("#paymentterm_list_" + oid).append(
      '<tr id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '"><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_1">' + pid + '</td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_3"><input type="text" class="form-control paymentterm_description capitalize" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_3" placeholder="*Enter Description" /></td><td class="input-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_4"><input type="number" data-oid="' +
      oid +
      '" data-pid="' +
      pid +
      '" class="form-control paymentterm_quantity" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_4"></td><td class="form-group max100" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_7"><select class="form-control paymentterm_uom" data-oid="' +
      oid +
      '" data-pid="' +
      pid +
      '" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_7"><option value=""></option><option value="1">Day(s)</option><option value="2">AU</option><option value="3">Percentage (%)</option><option value="4">PC</option></select></td><td class="form-group max100" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_5"><input type="number" data-oid="' +
      oid +
      '" data-pid="' +
      pid +
      '" class="form-control paymentterm_unitprice" value="' + $("#orderitem_" + oid + "_val_5").val() + '" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_5" readonly="readonly"/></td><td class="form-group" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_col_6"><input type="hidden" class="form-control paymentterm_rowtotal" id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_val_6" /><span id="orderitem_' +
      oid +
      "_paymentterm_" +
      pid +
      '_txt_6">₹0.00</span></td></tr>;'
    );
  }
}

$(document).on("change", ".order_item_quantity", function () {
  if (oti < 4) {
    gen_paymentterm($(this).data("id"), $(this).val());
    order_item_calculator($(this).data("id"));
    $(".item").trigger("change");
  } else {
    order_item_calculator($(this).data("id"));
  }
});

function gen_paymentterm(id, value) {
  if (oti < 4) {
    var bal = value - paymentterm_list.length;
    if (bal > 0) {
      for (i = 1; i <= bal; i++) {
        var new_pti = paymentterm_list[paymentterm_list.length - 1] + 1;
        add_paymentterm(id, new_pti);
        paymentterm_list.push(new_pti);
      }
    }
    if (bal < 0) {
      bal *= -1;
      for (i = 1; i <= bal; i++) {
        var last_pti = paymentterm_list[paymentterm_list.length - 1];
        $("#orderitem_" + id + "_paymentterm_" + last_pti).remove();
        paymentterm_list = jQuery.grep(paymentterm_list, function (b) {
          return b != last_pti;
        });
      }
    }
  }
}

function order_item_calculator(id) {
  var a = $("#orderitem_" + id + "_val_3").val();
  var b = $("#orderitem_" + id + "_val_5").val();
  var c = 0;
  if (a && b) {
    if (oti < 4 || oti == 7) {
      // Fill payterm unitprice
      $.each(paymentterm_list, function (index, pid) {
        if ([1, 3].includes(oti)) {
          res = nz(b / a).toFixed(2);
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_5").val(res);
          $("#orderitem_" + id + "_paymentterm_" + pid + "_txt_6").text(
            humanamount(res)
          );
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_6").val(res);
          update_pt_total(id, pid);
        } else if (oti == 2 || oti == 7) {
          res = nz(b).toFixed(2);
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_5").val(res);
          update_pt_total(id, pid);
          // $("#orderitem_" + id + "_paymentterm_" + pid + "_txt_6").text(
          //   humanamount(res)
          // );
          // $("#orderitem_" + id + "_paymentterm_" + pid + "_val_6").val(res);
        }
      });
    }
    // Calculation
    if ([4].includes(oti)) {
      c = a * b;
    } else if ([1, 2, 3].includes(oti)) {
      c = b;
    } else {
      var uom_val = $("#orderitem_" + id + "_val_4").val();
      if (uom_val == 3) {
        c = (a / 100) * b;
      } else {
        c = a * b;
      }
    }
  }
  $("#orderitem_" + id + "_val_6").val(c);
  // $("#orderitem_" + id + "_txt_6").text(humanamount(c));
  order_calculator(id);
}

function order_calculator(id) {
  var sub_total = 0;
  sub_total += parseFloat($("#orderitem_" + id + "_val_6").val());
  $("#add_order_subtotal_val").text(nz(sub_total.toFixed(2)));
  a = parseFloat((sgst / 100) * sub_total);
  b = parseFloat((cgst / 100) * sub_total);
  c = parseFloat((igst / 100) * sub_total);
  $("#add_order_sgst_val").text(nz(a.toFixed(2)));
  $("#add_order_cgst_val").text(nz(b.toFixed(2)));
  $("#add_order_igst_val").text(nz(c.toFixed(2)));
  $("#add_order_total_val").text(nz(a + b + c + sub_total).toFixed(2));
}

$(document).on("change", ".order_item_unitprice", function () {
  order_item_calculator($(this).data("id"));
});

$(document).on("click", ".showmain_card", function () {
  if ($(this).val() == 1) {
    if (checker()) {
      treeleaves();
      $("#add_order_card").hide();
    }
  }
});

function treeleaves() {
  if (tree["otl"].includes(oti) == false) {
    tree["otl"].push(oti);
    tree[oti] = { oil: [] };
  }
  if (tree[oti]["oil"].includes(item_id) == false) {
    tree[oti]["oil"].push(item_id);
    if (tree[oti].hasOwnProperty(item_id) == false) {
      if (oti < 4 || oti == 7) {
        tree[oti][item_id] = { ptl: [] };
      } else {
        tree[oti][item_id] = {};
      }
    }
  }
  tree[oti][item_id]["itm"] = $("#orderitem_" + item_id + "_val_1").val();
  tree[oti][item_id]["dsp"] = $("#orderitem_" + item_id + "_val_2").val();
  tree[oti][item_id]["qty"] = $("#orderitem_" + item_id + "_val_3").val();
  tree[oti][item_id]["utp"] = $("#orderitem_" + item_id + "_val_5").val();
  tree[oti][item_id]["stl"] = $("#orderitem_" + item_id + "_val_6").val();
  tree[oti][item_id]["utp"] = parseFloat(tree[oti][item_id]["utp"]).toFixed(2);
  tree[oti][item_id]["stl"] = parseFloat(tree[oti][item_id]["stl"]).toFixed(2);
  if (oti < 4 || oti == 7) {
    if (oti == 7) {
      tree[oti][item_id]["uom"] = $("#orderitem_" + item_id + "_val_4").val();
    } else {
      tree[oti][item_id]["uom"] = uom("x");
    }
    if (oti == 1 || oti == 3 || oti == 7) {
      tree[oti][item_id]["from"] = $("#from_date").val();
      tree[oti][item_id]["till"] = $("#to_date").val();
    } else {
      tree[oti][item_id]["from"] = "";
      tree[oti][item_id]["till"] = "";
    }
    $.each(paymentterm_list, function (index, pid) {
      if (tree[oti][item_id].hasOwnProperty(pid) == false) {
        tree[oti][item_id][pid] = {};
      }
      if (tree[oti][item_id]["ptl"].includes(pid) == false) {
        tree[oti][item_id]["ptl"].push(pid);
      }
      tree[oti][item_id][pid]["itm"] = $(
        "#orderitem_" + item_id + "_val_1"
      ).val();
      tree[oti][item_id][pid]["dsp"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_3"
      ).val();
      tree[oti][item_id][pid]["qty"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_4"
      ).val();
      if (oti == 7) {
        tree[oti][item_id][pid]["uom"] = $(
          "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_7"
        ).val();
      } else {
        tree[oti][item_id][pid]["uom"] = uom("x");
      }
      tree[oti][item_id][pid]["utp"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_5"
      ).val();
      tree[oti][item_id][pid]["stl"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_6"
      ).val();
    });
  } else {
    if (oti == 4) {
      tree[oti][item_id]["uom"] = "1";
    } else {
      tree[oti][item_id]["uom"] = $("#orderitem_" + item_id + "_val_4").val();
    }
  }
  treecleaner();
  treehouse();
  // ordertype_reset();
  // $("#order_type").val("");
}

function treecleaner() {
  if (tree["otl"].length > 0) {
    $.each(tree["otl"], function (index, val) {
      if (jQuery.isEmptyObject(tree[val])) {
        delete tree[val];
        tree["otl"] = jQuery.grep(tree["otl"], function (b) {
          return b != val;
        });
      } else {
        $.each(tree[val]["oil"], function (index, o_val) {
          if (jQuery.isEmptyObject(tree[val][o_val])) {
            delete tree[val][o_val];
            tree[val]["oil"] = jQuery.grep(tree[val]["oil"], function (b) {
              return b != o_val;
            });
          } else {
            if (tree[val][o_val].hasOwnProperty("ptl")) {
              if (tree[val][o_val]["ptl"].length == 0) {
                delete tree[val][o_val]["ptl"];
              } else {
                $.each(tree[val][o_val]["ptl"], function (index, p_val) {
                  if (jQuery.isEmptyObject(tree[val][o_val][p_val])) {
                    delete tree[val][o_val][p_val];
                    tree[val][o_val]["ptl"] = jQuery.grep(
                      tree[val][o_val]["ptl"],
                      function (b) {
                        return b != p_val;
                      }
                    );
                  }
                });
                if (tree[val][o_val]["ptl"].length == 0) {
                  delete tree[val][o_val]["ptl"];
                }
              }
            }
          }
          if (tree[val]["oil"].length == 0) {
            delete tree[val];
            tree["otl"] = jQuery.grep(tree["otl"], function (b) {
              return b != val;
            });
          }
        });
      }
    });
  }
}

function getot(val) {
  return [
    "",
    "On-Site Support Sale",
    "Project Sale",
    "AMC Support Sale",
    "Man-days-Support Sale",
    "SAP License Sale",
    "Hardware Sale",
    "Custom Order",
    "",
  ][val];
}

function treehouse() {
  var subttl = 0.0;
  var sgstttl = 0.0;
  var cgstttl = 0.0;
  var igstttl = 0.0;
  $("#order_items").empty();
  $("#order_items_cardfooter").empty();
  $.each(tree["otl"], function (i, ot) {
    $.each(tree[ot]["oil"], function (j, oi) {
      subttl += parseFloat(tree[ot][oi]["stl"]);
      if (ot < 4) {
        $("#order_items").append(
          '<tr data-widget="expandable-table" aria-expanded="false" id="parent_' +
          ot +
          "_" +
          oi +
          '"><td><i class="fas fa-caret-right fa-fw"></i>' +
          tree[ot][oi]["itm"] +
          "</td><td>" +
          tree[ot][oi]["dsp"] +
          "</td><td>" +
          getot(ot) +
          "</td><td>" +
          tree[ot][oi]["qty"] +
          "</td><td>" +
          tree[ot][oi]["uom"] +
          "</td><td>" +
          tree[ot][oi]["utp"] +
          "</td><td>" +
          tree[ot][oi]["stl"] +
          '</td><td style="min-width: 8vw;"><div class="card-tools"><button type="button" class="btn btn-sm btn-default myorder mr-1" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-pen text-primary"></i></button><button type="button" class="btn btn-sm btn-default remove_saved_item" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-times text-danger" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"></i></button></div></td></tr>'
        );
      } else {
        $("#order_items").append(
          '<tr id="parent_' +
          ot +
          "_" +
          oi +
          '"><td>' +
          tree[ot][oi]["itm"] +
          "</td><td>" +
          tree[ot][oi]["dsp"] +
          "</td><td>" +
          getot(ot) +
          "</td><td>" +
          tree[ot][oi]["qty"] +
          "</td><td>" +
          tree[ot][oi]["uom"] +
          "</td><td>" +
          tree[ot][oi]["utp"] +
          "</td><td>" +
          tree[ot][oi]["stl"] +
          '</td><td style="min-width: 8vw;"><div class="card-tools"><button type="button" class="btn btn-sm btn-default myorder mr-1" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-pen text-primary"></i></button><button type="button" class="btn btn-sm btn-default remove_saved_item" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-times text-danger" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"></i></button></div></td></tr>'
        );
      }
      if (ot < 4) {
        $.each(tree[ot][oi]["ptl"], function (k, pt) {
          if (k == 0) {
            $("#order_items").append(
              '<tr class="expandable-body d-none text-center" id="child_' +
              ot +
              "_" +
              oi +
              '"><td colspan="8"><div class="p-0"><table class="table table-hover"><tbody id="' +
              ot +
              "_" +
              oi +
              '"><tr><td style="width: 8rem;">Sr No.</td><td style="width: 22rem;">Description</td><td style="width: 11rem;"> Qty./Unit </td><td>Unit Price</td><td style="width: 14rem;">Total</td></tr>'
            );
          }
          $("#" + ot + "_" + oi).append(
            "<tr><td>" +
            j +
            "." +
            k +
            "</td><td>" +
            tree[ot][oi][pt]["dsp"] +
            "</td><td>" +
            tree[ot][oi][pt]["qty"] +
            "</td><td>" +
            tree[ot][oi][pt]["utp"] +
            "</td><td>" +
            tree[ot][oi][pt]["stl"] +
            "</td></tr></tbody></table></div></td></tr>"
          );
        });
      }
    });
  });
  if (l_gst.state == "same") {
    cgstttl = (subttl * cgst) / 100;
    sgstttl = (subttl * sgst) / 100;
    ttl = subttl + sgstttl + cgstttl;
    $("#order_items_cardfooter").append(
      '<div class="row"><div class="col-3"><b>Sub Total : </b>₹ ' +
      subttl.toFixed(2) +
      '</div><div class="col-3"><b>SGST ' +
      sgst +
      "% : </b>" +
      sgstttl.toFixed(2) +
      '<br /></div><div class="col-3"><b>CGST ' +
      cgst +
      "% : </b>₹ " +
      cgstttl.toFixed(2) +
      '<br /></div><div class="col-3"><b>Total : </b>₹ ' +
      ttl.toFixed(2) +
      "</div></div>"
    );
  } else {
    igstttl = (subttl * igst) / 100;
    ttl = subttl + igstttl;
    $("#order_items_cardfooter").append(
      '<div class="row"><div class="col-4"><b>Sub Total : </b>₹ ' +
      subttl +
      ' </div><div class="col-4"><b>IGST ' +
      igst +
      "% : </b>₹ " +
      igstttl +
      '<br /></div><div class="col-4"><b>Total : </b>₹ ' +
      ttl +
      "</div></div>"
    );
  }
  $("#order_items_cardfooter").show();
}

$(document).on("click", ".myorder", function () {
  create();
  var ot = $(this).data("oti");
  var oi = $(this).data("oii");
  item_id = oi;
  oti = $(this).data("oti");
  writemode = false;
  $("#order_type").val($(this).data("oti")).trigger("change");
  if (oti == 1 || oti == 3 || oti == 7) {
    $("#from_date").val(tree[ot][oi]["from"]);
    $("#to_date").val(tree[ot][oi]["till"]);
  }
  add_order(oi);
  $("#orderitem_" + oi + "_val_1").val(tree[ot][oi]["itm"]);
  $("#orderitem_" + oi + "_val_2").val(tree[ot][oi]["dsp"]);
  $("#orderitem_" + oi + "_val_4").val(tree[ot][oi]["uom"]);
  $("#orderitem_" + oi + "_val_5").val(tree[ot][oi]["utp"]);
  $("#orderitem_" + oi + "_val_3")
    .val(tree[ot][oi]["qty"])
    .trigger("change");
  if (tree[ot][oi].hasOwnProperty("ptl")) {
    $.each(tree[ot][oi]["ptl"], function (index, pt) {
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_1").text(index);
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_3").val(
        tree[ot][oi][pt]["dsp"]
      );
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_5").val(
        tree[ot][oi][pt]["utp"]
      );
      if (ot == 2 || ot == 7) {
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val(
          tree[ot][oi][pt]["qty"]
        );
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_txt_6").text(
          tree[ot][oi][pt]["stl"]
        );
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_6").val(
          tree[ot][oi][pt]["stl"]
        );
        if (ot == 7) {
          $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_7").val(
            tree[ot][oi][pt]["uom"]
          );
        }
      }
    });
  }
  writemode = true;
});

$(document).on("click", ".off", function () {
  $("#order_type").val("");
  ordertype_reset();
  $("#add_order_card").hide();
});

$(document).on("click", ".remove_saved_item", function () {
  del_ot = $(this).data("oti");
  del_id = $(this).data("oii");
  $("#modelactivate").click();
});

$(".killrow").click(function () {
  delete tree[del_ot][del_id];
  tree[del_ot]["oil"] = jQuery.grep(tree[del_ot]["oil"], function (b) {
    return b != del_id;
  });
  if (tree[del_ot]["oil"].length == 0) {
    delete tree[del_ot];
    tree["otl"] = jQuery.grep(tree["otl"], function (b) {
      return b != del_ot;
    });
  }
  if (tree["otl"].length == 0) {
    $("#order_items_cardfooter").hide();
  }
  treehouse();
  $("#byemodal").click();
});

function form_maker() {
  var subtotal = 0;
  var fakeoi = 0;
  var order_change_flag = 0,
    firstcheck = 0;
  $.each(tree["otl"], function (index, ot) {
    if (ot != order_change_flag && index == 0) {
      $("#hiddendata").append(
        '<input type="hidden" name="ordertype" id="id_order_type" value="' +
        ot +
        '" />'
      );
    } else if (ot != order_change_flag && index != 0) {
      $("#id_order_type").val("99");
    }

    $.each(tree[ot]["oil"], function (index, oi) {
      subtotal += parseFloat(tree[ot][oi]["stl"]);
      $("#hiddendata")
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][ordertype]" value="' +
          ot +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][item]" value="' +
          tree[ot][oi]["itm"] +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][description]" value="' +
          tree[ot][oi]["dsp"] +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][qty]" value="' +
          tree[ot][oi]["qty"] +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][uom_id]" value="' +
          tree[ot][oi]["uom"] +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][unit_price]" value="' +
          tree[ot][oi]["utp"] +
          '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
          fakeoi +
          '][total]" value="' +
          tree[ot][oi]["stl"] +
          '">'
        );
      if (ot == 1 || ot == 3) {
        $("#hiddendata")
          .append(
            '<input type="hidden" name="order_details[' +
            fakeoi +
            '][po_from_date]" value="' +
            tree[ot][oi]["from"] +
            '">'
          )
          .append(
            '<input type="hidden" name="order_details[' +
            fakeoi +
            '][po_to_date]" value="' +
            tree[ot][oi]["till"] +
            '">'
          );
      }
      if (tree[ot][oi].hasOwnProperty("ptl")) {
        $.each(tree[ot][oi]["ptl"], function (index, pt) {
          $("#hiddendata")
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][item]" value="' +
              tree[ot][oi][pt]["itm"] +
              '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][description]" value="' +
              tree[ot][oi][pt]["dsp"] +
              '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][qty]" value="' +
              tree[ot][oi][pt]["qty"] +
              '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][uom_id]" value="' +
              tree[ot][oi][pt]["uom"] +
              '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][unit_price]" value="' +
              tree[ot][oi][pt]["utp"] +
              '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
              fakeoi +
              "][payment_term][" +
              pt +
              '][total]" value="' +
              tree[ot][oi][pt]["stl"] +
              '">'
            );
        });
      }
      ++fakeoi;
    });
  });
  a = (sgst / 100) * subtotal;
  b = (cgst / 100) * subtotal;
  c = (igst / 100) * subtotal;
  var total = parseFloat(subtotal + a + b + c);
  if (l_gst.state == "same") {
    $("#hiddendata").append(
      '<input type="hidden" name="taxrate" value="' + l_gst.sgst + '">'
    );
  } else {
    $("#hiddendata").append(
      '<input type="hidden" name="taxrate" value="' + l_gst.igst + '">'
    );
  }
  $("#hiddendata")
    .append(
      '<input type="hidden" name="ordersubtotal" value="' +
      subtotal.toFixed(2) +
      '">'
    )
    .append('<input type="hidden" name="sgst" value="' + a.toFixed(2) + '">')
    .append('<input type="hidden" name="cgst" value="' + b.toFixed(2) + '">')
    .append('<input type="hidden" name="igst" value="' + c.toFixed(2) + '">')
    .append(
      '<input type="hidden" name="ordertotal" value="' + total.toFixed(2) + '">'
    );
}

$(document).on("change", ".item", function () {
  if (oti == 2) {
    $(".paymentterm_item").text($(this).val());
  }
});

function update_pt_total(o, p) {
  var a = $("#orderitem_" + o + "_paymentterm_" + p + "_val_4").val();
  var b = $("#orderitem_" + o + "_paymentterm_" + p + "_val_5").val();
  var c = $("#orderitem_" + o + "_paymentterm_" + p + "_val_7").val();
  if (oti == 7 && c != 3) {
    var res = nz(b * a);
  } else if (oti == 2 || (oti == 7 && c == 3)) {
    var res = nz((b * a) / 100);
  } else {
    var res = nz(b * a);
  }
  $("#orderitem_" + o + "_paymentterm_" + p + "_val_6").val(res.toFixed(2));
  $("#orderitem_" + o + "_paymentterm_" + p + "_txt_6").text(
    humanamount(res.toFixed(2))
  );
}

$(document).on("change", ".paymentterm_uom", function () {
  update_pt_total($(this).data("oid"), $(this).data("pid"));
});

$(document).on("change", ".paymentterm_quantity", function () {
  var oi = $(this).data("oid");
  update_pt_total(oi, $(this).data("pid"));
  var qtyttl = 0;
  var empty_qty_ids = [];
  if (oti == 2) {
    $.each(paymentterm_list, function (index, pt) {
      if ($("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val()) {
        if (
          paymentterm_list[paymentterm_list.length - 1] == pt &&
          empty_qty_ids.length < 1
        ) {
          $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val(
            100 - qtyttl
          );
          update_pt_total(oi, pt);
        }
        qtyttl += parseInt(
          $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val()
        );
      } else {
        empty_qty_ids.push(pt);
      }
    });
    if (empty_qty_ids.length == 1) {
      balanc = 100 - qtyttl;
      if (balanc < 0) {
        balanc = "";
      }
      $("#orderitem_" + oi + "_paymentterm_" + empty_qty_ids[0] + "_val_4").val(
        balanc
      );
      update_pt_total(oi, empty_qty_ids[0]);
    }
  }
});

$(document).on("change", ".order_item_uom", function () {
  order_item_calculator($(this).data("id"));
});

$(document).on("change", "#from_date", function () {
  $("#to_date").attr("min", $("#from_date").val());
});

$(document).on("change", "#to_date", function () {
  $("#from_date").attr("max", $("#to_date").val());
});
