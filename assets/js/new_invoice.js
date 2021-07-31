var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
var groupdata, customerid, customerdata, orderdata, orderdata_order, gstlist;

function resetongroup() { }

function filldata(id, data, msg, field) {
  $(id).append("<option>" + msg + "</option>");
  $.each(data, function (index, value) {
    val = []
    for (var key in value) { if (field.includes(key, 0)) val.push(value[key]); }
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
        groupdata = data
        filldata("#customerid_id", groupdata, "Select Customer", ['id', 'name']);
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
    $("#order_list_layout").show();
  }
}

function orderdetails() {
  $("#id_pono").val(orderdata_order.po_no);
  $("#id_salesperson").val(orderdata_order.sales_person);
  $("#bill_id").val(orderdata_order.bill_to);
  $("#ship_id").val(orderdata_order.ship_to);
  setordertype(orderdata_order.order_type);
  fillorder(orderdata.items);
  fillinvoices(orderdata.invoices);
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