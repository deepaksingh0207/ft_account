var baseUrl = window.location.origin + "/ft_account/";
var groupdetails
var code
var deleteid;
var prehigh = 0
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
today = yyyy + "-" + mm + "-" + dd;

// Validation Classses
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

// Order Row creating function with row id as arguement
function addrow(charlie) {
  $("#orderlist").append("<tr id='" + charlie + "'></tr>");

  $("#" + charlie).append("<td class='form-group'><input class='form-control ftsm itmy' name='item[]' id='id_item" + charlie + "' placeholder='Enter item name' /></td>");

  $("#" + charlie).append("<td class='form-group'><input class='form-control ftsm desp' name='description[]' id='id_description" + charlie + "' placeholder='Enter Description...' /></td>");

  $("#" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm qty' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='' name='qty[]' id='id_quantity" + charlie + "' /></td>");

  $("#" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm unitprice' value='' name='unit_price[]' id='id_unitprice" + charlie + "' /></td>");

  $("#" + charlie).append("<td class='form-group'>₹<input type='hidden' class='form-control ftsm rowtotal' value='' name='total[]' id='total" + charlie +
    "' ><span id='id_total" + charlie + "' >0.00</span></td>");

  $("#" + charlie).append("<td><i class='fas fa-minus-circle trash' style='color: red' ></i></td>");
}

function checker() {
  var check = true;
  $('input.itmy').each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass('is-invalid');
      check = false;
    }
  });
  $('input.desp').each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass('is-invalid');
      check = false;
    }
  });
  $('input.qty').each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass('is-invalid');
      check = false;
    }
  });
  $('input.unitprice').each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass('is-invalid');
      check = false;
    }
  });
  if (check == true) {
    $("#responsemodal").click();
  }
}

$(function () {
  $("#date_id").val(today);

  // $(".select2").select2();

  $.validator.setDefaults({
    submitHandler: function () {
      checker()
    },
  });

  $("#quickForm").validate({
    rules: {
      group_id: {
        required: true,
      },
      customer_id: {
        required: true,
      },
      order_date: {
        required: true,
        date: true,
      },
      po_no: {
        required: true,
      },
      sales_person: {
        required: true,
      },
      bill_to: {
        required: true,
      },
      ship_to: {
        required: true,
      },
      remarks: {
        required: true,
      },
    },
    messages: {
      group_id: {
        required: "Please select a customer group.",
      },
      customer_id: {
        required: "Please select a customer.",
      },
      order_date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      po_no: {
        required: "Please select a PO",
      },
      sales_person: {
        required: "Please provide you sales person.",
        tel: "Invalid Detail.",
      },
      bill_to: {
        required: "Enter a bill address code.",
      },
      ship_to: {
        required: "Enter a ship address code.",
      },
      remarks: {
        required: "Please state your comments.",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
      checker()
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });

  $("#add_item").click();

});


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
    $("#id_customertext").val("");
    $("#salesperson_id").val("");
    $("#comment_id").val("");
  }
});

// Delete order item modal activator
$(document).on("click", "i.trash", function () {
  deleteid = $(this).parent().parent().attr("id");
  $("#modelactivate").click();
});

// Delete order item on item modal submit
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

// Add new order button function
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

// On quantity Change
$(document).on("change", ".qty", function () {
  $(this).val($(this).val() * 1.0);
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  rowcollector(id[0]);
});

// On Unit Price Change
$(document).on("change", ".unitprice", function () {
  $(this).val($(this).val() * 1.0);
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  rowcollector(id[0]);
});

// Bill Button Click
$("#billaddbtn").on("click", function () {
  modelfill("billrow", "Bill To")
});

// Ship Button Click
$("#shipaddbtn").on("click", function () {
  modelfill("shiprow", "Ship To")
});

// On hovering Code column
$(document).on("click", ".cody", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

// On hovering Name column
$(document).on("click", ".namy", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

// On hovering Address column
$(document).on("click", ".addy", function () {
  id = $(this).attr('id').match(/\d+/)[0];
  highlight(id)
});

// Highlight Function
function highlight(id) {
  code = $("#code" + id).text();
  customername = $("#name" + id).text();
  modal = $("#checkbox" + id).attr('class')
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  $("#checkbox" + id).prop('checked', true);
  $("#row" + id).css('background-color', 'powderblue');
  $("#customerid_id").val(id);
  if (modal == "billrow") {
    $("#bill_id").val(code);
    $("#id_customer_id").val(id);
    $("#id_customertext").text(customername);
    getcustomerdetails(id);
  }
  if (modal == "shiprow") {
    $("#ship_id").val(code);
  }
}

// Each Order Item calculator
function rowcollector(id) {
  rowqty = $("#id_quantity" + id).val();
  rowunitprice = $("#id_unitprice" + id).val();
  rowtax = $("#id_tax" + id).val();
  subtotal = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    $("#id_item" + id).attr("required", "");
    $("#id_description" + id).attr("required", "");
    subtotal = rowunitprice * rowqty;
  }
  $("#total" + id).val(subtotal);
  $("#id_total" + id).text(parseFloat(subtotal).toFixed(2));
  ttotal()
}

// All Order Items calculator
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

// Fill modal customer details function
function modelfill(checkboxclass, label) {
  // customerid = $("#id_group_id").val();
  $("#mylabel").text(label + ' Address');
  if (groupdetails == '') {
    $("#addhead").empty();
    $("#addhead").append('No Records');
  }
  else {
    $("#addhead").empty();
    $("#addhead").append('<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>');
    $("#addbody").empty();
    $.each(groupdetails, function (index, row) {
      $("#addbody").append("<tr id='row" + row.id + "' ></tr>");
      $("#row" + row.id).append("<td id='tickcol" + row.id + "'></td>");
      $("#tickcol" + row.id).append("<div class='icheck-primary d-inline'><input type='radio' id='checkbox" + row.id + "' name='id_customer' class='" + checkboxclass + "'><label for='checkbox" + row.id + "'></label></div>");
      $("#row" + row.id).append("<td class='cody' id='code" + row.id + "'></td>");
      $("#code" + row.id).text(row.id);
      $("#row" + row.id).append("<td class='namy' id='name" + row.id + "'></td>");
      $("#name" + row.id).text(row.name);
      $("#row" + row.id).append("<td class='addy' id='address" + row.id + "' style='width: 455px'></td>");
      $("#address" + row.id).text(row.address);
    });
  }
}

// Customer Details Colletctor
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

// $("#id_group_id").change(function () {
//   var customerid = $(this).val();
//   getcustomerdetails(customerid);
// });


// $(document).on("change", ".tax", function () {
//   var taxid = $(this).attr("id");
//   id = taxid.match(/\d+/);
//   subtotal = rowcollector(id[0]);
//   $("#total" + id[0]).val(subtotal);
//   $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
//   ttotal();
// });


// $(document).on("click", ".billrow", function () {
//   id = $(this).attr("id").match(/\d+/)[0];
//   $("#row" + prehigh).css('background-color', 'inherit');
//   prehigh = id
//   code = $("#code" + id).text();
//   customername = $("#name" + id).text();
//   $("#bill_id").val(code);
//   $("#id_customertext").text(customername);
//   $("#row" + id).css('background-color', 'powderblue');
//   $("#customerid_id").val(id);
//   getcustomerdetails(id);
// });

// $(document).on("click", ".shiprow", function () {
//   id = $(this).attr("id").match(/\d+/)[0];
//   $("#row" + prehigh).css('background-color', 'inherit');
//   prehigh = id
//   code = $("#code" + id).text();
//   $("#ship_id").val(code);
//   $("#row" + id).css('background-color', 'powderblue');
// });