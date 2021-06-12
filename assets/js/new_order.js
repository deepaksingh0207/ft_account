var baseUrl = window.location.origin + "/ft_account/";
var groupdetails
var code
var prehigh = 0

$(function () {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();
  today = yyyy + "-" + mm + "-" + dd;
  $("#date_id").val(today);
  $(".select2").select2();
  // Form Validation
  $.validator.setDefaults({
    submitHandler: function () {
      form.submit();
    },
  });
  $("#quickForm").validate({
    rules: {
      customer_id: {
        required: true,
      },
      order_date: {
        required: true,
        date: true,
      },
      pay_days: {
        required: true,
      },
      terms: {
        required: true,
      },
      days: {
        required: true,
        tel: true,
      },
      po_no: {
        required: true,
      },
      sales_person: {
        required: true,
      },
      salesperson: {
        required: true,
      },
      bill_to: {
        required: true,
      },
      ship_to: {
        required: true,
      },
      bill: {
        required: true,
        textarea: true,
      },
      ship: {
        required: true,
        textarea: true,
      },
      remarks: {
        required: true,
        textarea: true,
      },
    },
    messages: {
      customer_id: {
        required: "Please select a customer.",
      },
      order_date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      pay_days: {
        required: "Please select day details.",
      },
      po_no: {
        required: "Please select a PO",
      },
      sales_person: {
        required: "Please provide you sales person.",
        tel: "Invalid Detail.",
      },
      bill_to: {
        required: "Please provide the bill address.",
      },
      ship_to: {
        required: "Please provide the ship address.",
      },
      remarks: {
        required: "Please state your remarks.",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });
  $("#add_item").click();
});

$(".numberonly").on("keypress", function (event) {
  var regex = new RegExp("^[0-9]$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$(".alphaonly").on("keypress", function (event) {
  var regex = new RegExp("^[A-Za-z ]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

// Dynamic Row Appending Function
// function addrow(charlie) {
//   $("#orderlist").append(
//     "<tr id='" +
//     charlie +
//     "'><td><input class='form-control ftsm' list='item" +
//     charlie +
//     "_list' name='item[]' id='id_item" +
//     charlie +
//     "' placeholder='Type or select...' /><datalist id='item" +
//     charlie +
//     "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input class='form-control ftsm' list='description" +
//     charlie +
//     "_list' name='description[]' id='id_description" +
//     charlie +
//     "' placeholder='Type or select...' /> <datalist id='description" +
//     charlie +
//     "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input type='number' class='form-control ftsm qty' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='qty[]' id='id_quantity" +
//     charlie +
//     "'/></td><td><input type='number' class='form-control ftsm unitprice' name='unit_price[]' id='id_unitprice" +
//     charlie +
//     "'/></td><td><input type='number' class='form-control ftsm tax' name='tax[]' id='id_tax" +
//     charlie +
//     "'></td><td>₹<input type='hidden' class='form-control ftsm rowtotal' name='total[]' id='total" +
//     charlie +
//     "'><span id='id_total" +
//     charlie +
//     "'>0.00</span></td><td><i class='fas fa-minus-circle trash' style='color: red' ></i></td></tr>"
//   );
// }

function addrow(charlie) {
  $("#orderlist").append(
    "<tr id='" +
    charlie +
    "'><td><input class='form-control ftsm itmy' name='item[]' id='id_item" +
    charlie +
    "' placeholder='Enter item name' /></td><td><input class='form-control ftsm desp' name='description[]' id='id_description" +
    charlie +
    "' placeholder='Enter Description...' /></td><td><input type='number' class='form-control ftsm qty' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='0' name='qty[]' id='id_quantity" +
    charlie +
    "'/></td><td><input type='number' class='form-control ftsm unitprice' value='0' name='unit_price[]' id='id_unitprice" +
    charlie +
    "'/></td><td>₹<input type='hidden' class='form-control ftsm rowtotal' value='0' name='total[]' id='total" +
    charlie +
    "'><span id='id_total" +
    charlie +
    "'>0.00</span></td><td><i class='fas fa-minus-circle trash' style='color: red' ></i></td></tr>"
  );
}

var deleteid;

// Delete Click Action
$(document).on("click", "i.trash", function () {
  deleteid = $(this).parent().parent().attr("id");
  $("#modelactivate").click();
});

// Delete & Return
$(".killrow").click(function () {
  $("#" + deleteid).remove();
  var arr = $("#id_tr").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b != deleteid;
  });
  $("#id_tr").val(res);
  ttotal();
  $("#byemodal").click();
});

// Cancel delete action
// $(".order").click(function () {
//   $("#order").show();
//   $("#trash").hide();
// });

// Add Order Item Click Action
$("#add_item").on("click", function () {
  var a = $("#id_tr").val().split(",");
  if (a.length < 2 && a[0] == "") {
    addrow(1);
    a[0] = 1;
  } else {
    var lastid = a[a.length - 1];
    lastid++;
    addrow(lastid);
    a.push("" + lastid + "");
  }
  $("#id_tr").val(a);
});


$(document).on("change", ".itmy", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  if (qtyid.val() != "") {
    $("#id_unitprice" + id[0]).attr("required");
    $("#id_quantity" + id[0]).attr("required");
  }
});

$(document).on("change", ".desp", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  if (qtyid.val() != "") {
    $("#id_unitprice" + id[0]).attr("required");
    $("#id_quantity" + id[0]).attr("required");
  }
});

// Monitoring Quantity Field
$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_unitprice" + id[0]).attr("required");
  $("#total" + id[0]).val(subtotal);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Monitoring Unit Price Field
$(document).on("change", ".unitprice", function () {
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_quantity" + id[0]).attr("required");
  $("#total" + id[0]).val(subtotal);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Monitoring Tax Field
$(document).on("change", ".tax", function () {
  var taxid = $(this).attr("id");
  id = taxid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#total" + id[0]).val(subtotal);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Calculation Sub Total & Total
function ttotal() {
  var idlist = $("#id_tr").val().split(",");
  total = 0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      total += parseFloat($("#id_total" + value).text());
    });
    $("#id_ordertotal").val(total);
    // $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  } else {
    total = 0.0;
    $("#id_ordertotal").val(total);
    // $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  }
}

// Row Data Calculator
function rowcollector(id) {
  rowqty = $("#id_quantity" + id).val();
  rowunitprice = $("#id_unitprice" + id).val();
  rowtax = $("#id_tax" + id).val();
  total = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    $("#id_item" + id).attr("required", "");
    $("#id_description" + id).attr("required", "");
    total = rowunitprice * rowqty;
    // if (rowtax[0] != "") {
    //   total += total * (rowtax / 100);
    // }
  }
  return total;
}

// Customer Ajax
$("#customerid_id").change(function () {
  var customerid = $(this).val();
  getcustomerdetails(customerid);
});

function getcustomerdetails(customerid) {
  if (customerid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/getdetails/" + customerid,
      data: customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#salesperson_id").val(data.contact_person);
        // $("#bill_id").val(data.address);
        // $("#ship_id").val(data.address);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
    $("#salesperson_id").val("");
    $("#bill_id").val("");
    $("#ship_id").val("");
  }
}

$("#id_customergroup").change(function () {
  var groupid = $(this).val();
  if (groupid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + groupid,
      data: groupid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        groupdetails = data
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
    groupdetails = ""
    $("#bill_id").val("");
    $("#ship_id").val("");
    $(".customer").text("");
    $("#customer_id").val("");
    $("#salesperson_id").val("");
    $("#comment_id").val("");
  }
});


$("#billaddbtn").on("click", function () {
  modelfill("billrow", "Bill To")
});

$("#shipaddbtn").on("click", function () {
  modelfill("shiprow", "Ship To")
});

function modelfill(checkboxclass, label) {
  customerid = $("#id_customergroup").val();
  $("#mylabel").text(label+' Address');
  if (customerid != '') {
    $("#addhead").empty();
    $("#addhead").append('<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Customer Code</th><th>Customer Name</th><th>'+label+' Address</th></thead><tbody id="addbody"></tbody></table>');
    $("#addbody").empty();
    $.each(groupdetails, function (index, row) {
      $("#addbody").append("<tr id='row" + row.id + "' ></tr>");
      $("#row" + row.id).append("<td id='tickcol" + row.id + "'></td>");
      $("#tickcol" + row.id).append("<div class='icheck-primary d-inline'><input type='radio' id='checkbox" + row.id + "' name='id_customer' class='" + checkboxclass + "'><label for='checkbox" + row.id + "'></label></div>");
      $("#row" + row.id).append("<td class='cody' id='code" + row.id + "'></td>");
      $("#code" + row.id).text(row.id);
      $("#row" + row.id).append("<td class='namy' id='name" + row.id + "'></td>");
      $("#name" + row.id).text(row.name);
      $("#row" + row.id).append("<td class='addy' id='address" + row.id + "'></td>");
      $("#address" + row.id).text(row.address);
    });
  } else {
    $("#addhead").empty();
    $("#addhead").append('No Records');
  }
}

$(document).on("click", ".billrow", function () {
  id = $(this).attr("id").match(/\d+/)[0];
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  code = $("#code" + id).text();
  customername = $("#name" + id).text();
  $("#bill_id").val(code);
  $("#id_customerid").text(customername);
  $("#row" + id).css('background-color', 'powderblue');
  $("#customerid_id").val(id);
  getcustomerdetails(id);
});

$(document).on("click", ".shiprow", function () {
  id = $(this).attr("id").match(/\d+/)[0];
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  code = $("#code" + id).text();
  $("#ship_id").val(code);
  $("#row" + id).css('background-color', 'powderblue');
});

$(document).on("click", ".cody", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

$(document).on("click", ".namy", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

$(document).on("click", ".addy", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

function highlight(id) {
  code = $("#code" + id).text();
  customername = $("#name" + id).text();
  modal = $("#checkbox" + id).attr('class')
  if (modal == "billrow") {
    $("#bill_id").val(code);
  }
  if (modal == "shiprow") {
    $("#ship_id").val(code);
  }
  $("#id_customerid").text(customername);
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  $("#checkbox" + id).prop('checked', true);
  $("#row" + id).css('background-color', 'powderblue');
  $("#customerid_id").val(id);
  getcustomerdetails(id);
}