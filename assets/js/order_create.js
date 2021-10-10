var group_id,
  group_id_data,
  checked_billto,
  checked_shipto,
  old_row,
  oti, gst,
  new_oii,
  sgst,
  cgst,
  igst,
  del_id,
  ordertype_list,
  orderitem_list,
  paymentterm_list;
var editmode = true;
var instance_list = [];
var tree = { otl: [] };
var fill_last_one = false;

$("#group_id").change(function () {
  group_id_reset();
  group_id = $(this).val();
  if (group_id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + group_id,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        group_id_data = data;
        if (data.length == 1) {
          fill_billto_details(0, data[0].id, data[0].name);
          fill_shipto_details(0, data[0].id);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Data not found for this customer group.");
      });
  }
});

function billto_reset() {
  $("#sales_person").val("");
}

function group_id_reset() {
  group_id = "";
  group_id_data = "";
  checked_shipto = "";
  checked_billto = "";
  $("#bill_to").val("");
  $("#ship_to").val("");
  billto_reset();
  $("#customer_name").text("");
}

function fill_billto_details(index, id, name) {
  checked_billto = index;
  $("#bill_to").val(id).removeClass("is-invalid");
  $("#bill_to-error").remove();
  $("#customer_id").val(id);
  $("#customer_name").text(name);
  getcustomerdetails(id);
}

function fill_shipto_details(index, id) {
  checked_shipto = index;
  $("#ship_to").val(id).removeClass("is-invalid");
  $("#ship_to-error").remove();
}

function getcustomerdetails(id) {
  billto_reset();
  if (id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/getdetails/" + id,
      data: id,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#sales_person").val(data.contact_person).removeClass("is-invalid");
        getgst(id);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
}

function getgst(id) {
  $.ajax({
    type: "POST",
    url: baseUrl + "invoices/gettaxesrate/" + id,
    dataType: "json",
    encode: true,
  }).done(function (data) {
    gst = data
    if (data.state == "same") {
      sgst = data.sgst;
      cgst = data.cgst;
      igst = 0;
      $("#add_order_item_sgstcut_txt").text(sgst);
      $("#add_order_item_cgstcut_txt").text(cgst);
      $("#add_order_item_igstcut_txt").text("0");
      $("#sgstdiv").show();
      $("#cgstdiv").show();
      $("#igstdiv").hide();
    } else {
      sgst = 0;
      cgst = 0;
      igst = data.igst;
      $("#add_order_item_sgstcut_txt").text("0");
      $("#add_order_item_cgstcut_txt").text("0");
      $("#add_order_item_igstcut_txt").text(igst);
      $("#sgstdiv").hide();
      $("#cgstdiv").hide();
      $("#igstdiv").show();
    }
    $("#order_items_card").show();
  });
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
  if (group_id_data) {
    $("#addhead").append(
      '<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>'
    );
    $.each(group_id_data, function (index, row) {
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

$("#addy").change(function () {
  $(this).attr("disabled", "");
});

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
  $("#payment_term_cardbody").empty();
}

function ordertype_reset() {
  paymentterm_reset();
  instance_list = [];
  $("#from_date").attr("readonly", "");
  $("#to_date").attr("readonly", "");
  $("#order_item_list").empty();
  $("#add_order_cardbody").hide();
  $("#from_date").val("");
  $("#to_date").val("");
  oti = 0;
  del_id = 0;
  last_order_item = 0;
  orderid_list = [];
  ordertype_list = [];
  orderitem_list = [];
  fill_last_one = false;
  paymentterm_list = [];
  $("#add_item").trigger("click");
}

function nz(val) {
  // NaN to Zero
  if (val == "" || val == NaN) {
    return 0;
  } else {
    return parseInt(val);
  }
}

$(document).on("change", "#order_type", function () {
  $(this).removeClass("is-invalid");
  ordertype_reset();
  // treecleaner();
  oti = nz($(this).val());
  if (oti) {
    ordertype_list = tree["otl"];
    if (ordertype_list.includes(oti) == false) {
      ordertype_list.push(oti);
      tree[oti] = { oil: [] };
    }
    orderitem_list = tree[oti]["oil"];
    $("#add_order_item_button").trigger("click");
    // On-Site Support Sale
    if (oti == 1) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Total Months");
      $("#unitprice_header").text("Total Price");
      $("#from_date").removeAttr("readonly");
      $("#to_date").removeAttr("readonly");
    } //Project Sale
    else if (oti == 2) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Payment Slab");
      $("#price_header").text("Total Price");
      $("#from_date").attr("readonly", "");
      $("#to_date").attr("readonly", "");
    } // AMC Support Sale
    else if (oti == 3) {
      $("#payment_term_card").show();
      $("#quantity_header").text("Qty.");
      $("#price_header").text("Total Price");
      $("#from_date").removeAttr("readonly");
      $("#to_date").removeAttr("readonly");
    } // Man-days-Support Sale
    else if (oti == 4) {
      $("#payment_term_card").hide();
      $("#quantity_header").text("Man days");
      $("#price_header").text("Unit Price");
      $("#from_date").attr("readonly", "");
      $("#to_date").attr("readonly", "");
    } else {
      $("#payment_term_card").hide();
      $("#quantity_header").text("Qty.");
      $("#price_header").text("Total Price");
      $("#from_date").attr("readonly", "");
      $("#to_date").attr("readonly", "");
    }
    $("#add_order_cardbody").show();
  }

});

$(document).on("click", "#add_order_item_button", function () {
  if (editmode) {
    new_oii = orderitem_list.length + 1;
    orderitem_list.push(new_oii);
    instance_list.push(new_oii);
    if (oti < 4) {
      tree[oti][new_oii] = { ptl: [] };
    } else {
      tree[oti][new_oii] = {};
    }
    add_order(new_oii);
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
      otiuom() +
      '</span> </td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_35"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_unitprice" min="1" id="orderitem_' +
      id +
      '_val_5" /> </td> <td class="form-group pt-4" id="orderitem_' +
      id +
      '_col_6"> <input type="hidden" data-id="' +
      id +
      '" class="form-control rowtotal" id="orderitem_' +
      id +
      '_val_6" /> <span id="orderitem_' +
      id +
      '_txt_6">₹0.00</span> </td><td id="orderitem_' +
      id +
      '_col_7" class="pt-4"></td> </tr>'
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
      otiuom() +
      '</span><select data-id="' +
      id +
      '" class="form-control order_item_uom" id="orderitem_' +
      id +
      '_val_4"><option value=""></option><option value="1">Day(s)</option><option value="2">AU</option><option value="3">Percentage (%)</option><option value="4">PC</option></select></td> <td class="form-group max150" id="orderitem_' +
      id +
      '_col_5"> <input type="number" data-id="' +
      id +
      '" class="form-control order_item_unitprice" min="1" id="orderitem_' +
      id +
      '_val_5" /> </td> <td class="form-group pt-4" id="orderitem_' +
      id +
      '_col_6"> <input type="hidden" data-id="' +
      id +
      '" class="form-control rowtotal" id="orderitem_' +
      id +
      '_val_6" /> <span id="orderitem_' +
      id +
      '_txt_6">₹0.00</span> </td> <td id="orderitem_' +
      id +
      '_col_7" class="pt-4"></td></tr>'
    );
  }
  if (id != instance_list[0]) {
    $("#orderitem_" + id + "_col_7").append(
      '<i class="fas fa-minus-circle trash" data-id=' +
      id +
      ' style="color: red" ></i>'
    );
  }
  if (oti < 4) {
    paymentterm_list = tree[oti][id]["ptl"];
    paymentterm_list.push(1);
    payment_term_cardbody(id);
  }
}

function otiuom(id = false, ot = oti) {
  oti_uomid_list = ["", "2", "3", "2", "1", "", ""];
  if (id) {
    return oti_uomid_list[ot];
  }
  oti_uom_list = ["", "AU", "Percentage (%)", "AU", "Day(s)", "", ""];
  return oti_uom_list[ot];
}

function getuom(val) {
  uom_list = ["", "Day(s)", "AU", "Percentage (%)", "PC"];
  return uom_list[val];
}

function getot(val) {
  ot_list = [
    "",
    "On-Site Support Sale",
    "Project Sale",
    "AMC Support Sale",
    "Man-days-Support Sale",
    "SAP License Sale",
    "Hardware Sale",
  ];
  return ot_list[val];
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
  if (oti == 2) {
    $("#payment_term_cardbody").append(
      '<table class="table" id="table_' +
      id +
      '"><thead><tr><th class="max100">Sr. No.</th><th class="max100">Item</th><th class="min100">Item Description</th><th class="minmax150">Qty./Unit</th><th class="min100">Unit Price</th><th class="min100">Total Value</th></tr></thead><tbody id="paymentterm_list_' +
      id +
      '"></tbody></table>'
    );
  }
  if (editmode) {
    tree[oti][id][1] = {};
  }
  add_paymentterm(id, 1);
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
      '_col_1">1</td><td class="form-group paymentterm_item" id="orderitem_' +
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
      '_col_1">1</td><td class="form-group" id="orderitem_' +
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
  }
}

$(document).on("change", ".paymentterm_quantity", function () {
  var oid = $(this).data("oid");
  var pid = $(this).data("pid");
  if (oti == 2) {
    var qty = $("#orderitem_" + oid + "_paymentterm_" + pid + "_val_4").val();
    var utp = $("#orderitem_" + oid + "_paymentterm_" + pid + "_val_5").val();
    var ttl = (qty / 100) * utp;
    $("#orderitem_" + oid + "_paymentterm_" + pid + "_txt_6").text(
      nz(ttl).toFixed(2)
    );
    $("#orderitem_" + oid + "_paymentterm_" + pid + "_val_6").val(
      nz(ttl).toFixed(2)
    );
  }
  lastfill(oid);
});

$(document).on("click", "i.trash", function () {
  del_id = $(this).data("id");
  $("#modelactivate").click();
});

$(".killrow").click(function () {
  $("#order_item_" + del_id).remove();
  orderitem_list = jQuery.grep(orderitem_list, function (b) {
    return b != del_id;
  });
  instance_list = jQuery.grep(instance_list, function (b) {
    return b != del_id;
  });
  if (oti < 4) {
    $("#table_" + del_id).remove();
    delete tree[oti][del_id];
  }
  $("#byemodal").click();
});

function gen_paymentterm(id, value) {
  if (oti < 4 && editmode) {
    paymentterm_list = tree[oti][id]["ptl"];
    var bal = value - paymentterm_list.length;
    if (bal > 0) {
      for (i = 1; i <= bal; i++) {
        var new_pti = paymentterm_list[paymentterm_list.length - 1] + 1;
        add_paymentterm(id, new_pti);
        paymentterm_list.push(new_pti);
        tree[oti][id][new_pti] = {};
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
        delete tree[oti][id][last_pti];
      }
      tree[oti][id]["ptl"] = paymentterm_list;
    }
  }
}

$(document).on("change", ".order_item_quantity", function () {
  if (oti < 4) {
    gen_paymentterm($(this).data("id"), $(this).val());
    order_item_calculator($(this).data("id"));
    $(".item").trigger("change");
  }
});

$(document).on("change", ".order_item_unitprice", function () {
  order_item_calculator($(this).data("id"));
});

$(document).on("change", ".order_item_uom", function () {
  order_item_calculator($(this).data("id"));
});

function order_item_calculator(id) {
  var a = $("#orderitem_" + id + "_val_3").val();
  var b = $("#orderitem_" + id + "_val_5").val();
  var c = 0;
  if (a && b) {
    if (oti < 4) {
      paymentterm_list = tree[oti][id]["ptl"];
      // Fill payterm unitprice
      $.each(paymentterm_list, function (index, pid) {
        if ([1, 3].includes(oti)) {
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_5").val(
            (b / a).toFixed(2)
          );
          $("#orderitem_" + id + "_paymentterm_" + pid + "_txt_6").text(
            humanamount(b / a)
          );
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_6").val(
            (b / a).toFixed(2)
          );
        } else if (oti == 2) {
          $("#orderitem_" + id + "_paymentterm_" + pid + "_val_5").val(
            nz(b).toFixed(2)
          );
        }
      });
    }
    // Calculation
    if (oti in [4]) {
      c = a * b;
    } else if (oti in [1, 2, 3]) {
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
  $("#orderitem_" + id + "_txt_6").text(humanamount(c));
  order_calculator();
}

function order_calculator() {
  var sub_total = 0;
  $.each(instance_list, function (index, oid) {
    sub_total += nz($("#orderitem_" + oid + "_val_6").val());
  });
  $("#add_order_item_subtotal_txt").text(humanamount(sub_total));
  $("#add_order_item_subtotal").val(sub_total);
  a = (sgst / 100) * sub_total;
  b = (cgst / 100) * sub_total;
  c = (igst / 100) * sub_total;
  $("#add_order_item_sgstcut").val(a);
  $("#add_order_item_cgstcut").val(b);
  $("#add_order_item_igstcut").val(c);
  $("#add_order_item_total").val(a + b + c + sub_total);
  $("#add_order_item_sgst_txt").text(humanamount(a));
  $("#add_order_item_cgst_txt").text(humanamount(b));
  $("#add_order_item_igst_txt").text(humanamount(c));
  $("#add_order_item_total_txt").text(humanamount(a + b + c + sub_total));
}

$(document).on("click", "#add_order_button", function () {
  $("#main_card").hide();
  $("#add_order_card").show();
});

$(document).on("click", ".showmain_card", function () {
  if ($(this).val() == 1) {
    checker();
    treeleaves();
    showmain();
  } else {
    showmain();
    ordertype_reset();
    $("#order_type").val("");
  }
});

function showmain() {
  $("#main_card").show();
  $("#add_order_card").hide();
}

$(document).on("change", "#id_po_from_date", function () {
  $("#id_po_to_date").attr("min", $(this).val());
});

function treeleaves() {
  $.each(instance_list, function (index, oid) {
    tree[oti][oid]["itm"] = $("#orderitem_" + oid + "_val_1").val();
    tree[oti][oid]["dsp"] = $("#orderitem_" + oid + "_val_2").val();
    tree[oti][oid]["qty"] = $("#orderitem_" + oid + "_val_3").val();
    tree[oti][oid]["utp"] = $("#orderitem_" + oid + "_val_5").val();
    tree[oti][oid]["stl"] = $("#orderitem_" + oid + "_val_6").val();
    if (oti < 4) {
      tree[oti][oid]["uom"] = otiuom(true);
      if (oti == 1 || oti == 3) {
        tree[oti][oid]["from"] = $("#from_date").val();
        tree[oti][oid]["till"] = $("#to_date").val();
      }
      $.each(tree[oti][oid]["ptl"], function (index, pid) {
        tree[oti][oid][pid]["itm"] = $("#orderitem_" + oid + "_val_1").val();
        tree[oti][oid][pid]["dsp"] = $(
          "#orderitem_" + oid + "_paymentterm_" + pid + "_val_3"
        ).val();
        tree[oti][oid][pid]["qty"] = $(
          "#orderitem_" + oid + "_paymentterm_" + pid + "_val_4"
        ).val();
        tree[oti][oid][pid]["uom"] = otiuom(true);
        tree[oti][oid][pid]["utp"] = $(
          "#orderitem_" + oid + "_paymentterm_" + pid + "_val_5"
        ).val();
        tree[oti][oid][pid]["stl"] = $(
          "#orderitem_" + oid + "_paymentterm_" + pid + "_val_6"
        ).val();
      });
    } else {
      if (oti == 4) {
        tree[oti][oid]["uom"] = "1";
      } else {
        tree[oti][oid]["uom"] = $("#orderitem_" + oid + "_val_4").val();
      }
    }
  });
  treecleaner();
  treehouse();
  ordertype_reset();
  $("#order_type").val("");
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
                delete tree[val][o_val];
                tree[val]["oil"] = jQuery.grep(tree[val]["oil"], function (b) {
                  return b != o_val;
                });
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

function treehouse() {
  $("#order_items").empty();
  $.each(tree["otl"], function (index, val) {
    $.each(tree[val]["oil"], function (index, o_val) {
      $("#order_items").append(
        "<tr><td>" +
        tree[val][o_val]["itm"] +
        "</td><td>" +
        tree[val][o_val]["dsp"] +
        "</td><td>" +
        getot(val) +
        "</td><td>₹ " +
        tree[val][o_val]["stl"] +
        '</td><td style="width: 2vw;"><div class="card-tools mt-2"><a class="btn btn-tool myorder" data-oti="' +
        val +
        '" data-oii="' +
        o_val +
        '"><i class="fas fa-pen"></i></a></div></td></tr>'
      );
    });
  });
}

$(document).on("click", ".myorder", function () {
  $("#add_order_button").trigger("click");
  editmode = false;
  $("#order_type").val($(this).data("oti")).trigger("change");
  $.each(tree[oti]["oil"], function (index, o_val) {
    if (oti < 4) {
      if (oti == 1 || oti == 3) {
        $("#from_date").val(tree[oti][o_val]["from"]);
        $("#to_date").val(tree[oti][o_val]["till"]);
      }
      add_order(o_val);
      instance_list.push(o_val);
      $("#orderitem_" + o_val + "_val_1").val(tree[oti][o_val]["itm"]);
      $("#orderitem_" + o_val + "_val_2").val(tree[oti][o_val]["dsp"]);
      $("#orderitem_" + o_val + "_val_3").val(tree[oti][o_val]["qty"]);
      for (i = 2; i <= tree[oti][o_val]["qty"]; i++) {
        add_paymentterm(o_val, i);
      }
      $("#orderitem_" + o_val + "_val_4").val(tree[oti][o_val]["utp"]);
      $("#orderitem_" + o_val + "_val_5").val(tree[oti][o_val]["stl"]);
      order_item_calculator(o_val);
      $.each(tree[oti][o_val]["ptl"], function (index, p_val) {
        $("#orderitem_" + o_val + "_paymentterm_" + p_val + "_val_1").text(
          index
        );
        $("#orderitem_" + o_val + "_paymentterm_" + p_val + "_val_3").val(
          tree[oti][o_val][p_val]["dsp"]
        );
        $("#orderitem_" + o_val + "_paymentterm_" + p_val + "_val_5").val(
          tree[oti][o_val][p_val]["utp"]
        );
        if (oti == 2) {
          $("#orderitem_" + o_val + "_paymentterm_" + p_val + "_val_4")
            .val(tree[oti][o_val][p_val]["qty"])
            .trigger("change");
        }
      });
    } else {
      add_order(o_val);
      instance_list.push(o_val);
      $("#orderitem_" + o_val + "_val_1").val(tree[oti][o_val]["itm"]);
      $("#orderitem_" + o_val + "_val_2").val(tree[oti][o_val]["dsp"]);
      $("#orderitem_" + o_val + "_val_3").val(tree[oti][o_val]["qty"]);
      $("#orderitem_" + o_val + "_val_4").val(tree[oti][o_val]["uom"]);
      $("#orderitem_" + o_val + "_val_5").val(tree[oti][o_val]["utp"]);
      $("#orderitem_" + o_val + "_val_6").val(tree[oti][o_val]["stl"]);
      order_item_calculator(o_val);
    }
  });
  editmode = true;
});

function form_maker() {
  var subtotal = 0
  $.each(tree["otl"], function (index, ot) {
    $.each(tree[ot]["oil"], function (index, oi) {
      subtotal += parseFloat(tree[ot][oi]["stl"])
      $("#hiddendata")
        .append('<input type="hidden" name="order_details[' + oi + '][ordertype]" value="' + ot + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][item]" value="' + tree[ot][oi]["itm"] + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][description]" value="' + tree[ot][oi]["dsp"] + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][qty]" value="' + tree[ot][oi]["qty"] + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][uom_id]" value="' + tree[ot][oi]["uom"] + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][unit_price]" value="' + tree[ot][oi]["utp"] + '">')
        .append('<input type="hidden" name="order_details[' + oi + '][total]" value="' + tree[ot][oi]["stl"] + '">');
      if (ot == 1 || ot == 3) {
        $("#order_items")
          .append('<input type="hidden" name="po_from_date" value="' + tree[ot][oi]["from"] + '">')
          .append('<input type="hidden" name="po_to_date" value="' + tree[ot][oi]["till"] + '">');
      }
      if (tree[ot][oi].hasOwnProperty("ptl")) {
        $.each(tree[ot][oi]["ptl"], function (index, pt) {
          $("#order_items")
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][item]" value="' + tree[ot][oi][pt]["itm"] + '">')
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][description]" value="' + tree[ot][oi][pt]["dsp"] + '">')
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][qty]" value="' + tree[ot][oi][pt]["qty"] + '">')
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][uom_id]" value="' + tree[ot][oi][pt]["uom"] + '">')
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][unit_price]" value="' + tree[ot][oi][pt]["utp"] + '">')
            .append('<input type="hidden" name="order_details[' + oi + "][payment_term][" + pt + '][total]" value="' + tree[ot][oi][pt]["stl"] + '">');
        });
      }
    });
  });
  a = (sgst / 100) * subtotal;
  b = (cgst / 100) * subtotal;
  c = (igst / 100) * subtotal;
  var total = subtotal + a + b + c;
  if (gst.state == "same") {
    $("#hiddendata")
      .append('<input type="hidden" name="taxrate" value="' + gst.sgst + '">')
  } else {
    $("#hiddendata")
      .append('<input type="hidden" name="taxrate" value="' + gst.igst + '">')
  }
  $("#hiddendata")
    .append('<input type="hidden" name="ordersubtotal" value="' + subtotal + '">')
    .append('<input type="hidden" name="sgst" value="' + a + '">')
    .append('<input type="hidden" name="cgst" value="' + b + '">')
    .append('<input type="hidden" name="igst" value="' + c + '">')
    .append('<input type="hidden" name="ordertotal" value="' + total + '">');
}

function lastfill(oid) {
  var pt_total_qty = 0;
  var empty_qty_ids = [];
  var pt_list = tree[oti][oid]["ptl"];
  $.each(pt_list, function (index, pid) {
    if ($("#orderitem_" + oid + "_paymentterm_" + pid + "_val_4").val()) {
      if (pt_list.length - 1 == index && fill_last_one == true) {
        // Always sets last payment slab to balance
        $("#orderitem_" + oid + "_paymentterm_" + pid + "_val_4").val(
          100 - pt_total_qty
        );
      }
      pt_total_qty += parseInt(
        $("#orderitem_" + oid + "_paymentterm_" + pid + "_val_4").val()
      );
    } else {
      empty_qty_ids.push(pid);
    }
  });
  if (fill_last_one == false) {
    if (empty_qty_ids.length == 1) {
      balanc = 100 - pt_total_qty;
      if (balanc < 0) {
        balanc = "";
      }
      $(
        "#orderitem_" + oid + "_paymentterm_" + empty_qty_ids[0] + "_val_4"
      ).val(balanc);
      // paymentTermcollector(empty_qty_ids[0]);
      fill_last_one = true;
      pt_total_qty = 100;
    }
  }
}

$(document).on("change", "#from_date", function () {
  $("#to_date").attr("min", $(this).val());
});

$(document).on("change", ".item", function () {
  if (oti == 2) {
    $(".paymentterm_item").text($(this).val());
  }
});
