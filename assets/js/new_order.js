var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
var groupdetails = ""
var code;
var empty_ptlistids = []
var deleteid;
var var_ordertypeid;
var lastfillcheck = false
var sgst = 0;
var cgst = 0;
var igst = 0;
var prehigh = 0
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var ptlist = []
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

  $("#" + charlie).append("<td class='form-group'><input type='text' class='form-control ftsm itmy' name='item[]' id='id_item" + charlie + "' placeholder='Enter item name' /></td>");

  $("#" + charlie).append("<td class='form-group'><input type='text' class='form-control ftsm desp' name='description[]' id='id_description" + charlie + "' placeholder='Enter Description...' /></td>");

  $("#" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm qty' name='qty[]' id='id_quantity" + charlie + "' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /></td>");

  $("#" + charlie).append('<td class="form-group"><select class="form-control uom" name="uom[]" id="id_uom' + charlie + '"><option value=""></option><option value="1">Day(s)</option><option value="2">Nos</option><option value="3">Percentage (%)</option><option value="4">PC</option></select></td>');

  $("#" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm unitprice' name='unit_price[]' id='id_unitprice" + charlie + "' /></td>");

  $("#" + charlie).append("<td class='form-group'>₹<input type='hidden' class='form-control ftsm rowtotal' value='' name='total[]' id='total" + charlie +
    "' ><span id='id_total" + charlie + "' >0.00</span></td>");

  $("#" + charlie).append("<td><i class='fas fa-minus-circle trash' style='color: red' ></i></td>");
}

function projectdiv() {
  $("#id_project").append('<table class="table text-center mb-0" id="projectable"></table>');
  $("#projectable").append('<thead><tr id="projecttableheader"></tr></thead>');
  $("#projecttableheader").append('<th class="min100">Item</th>');
  $("#projecttableheader").append('<th class="min100">Payment Term</th>');
  $("#projecttableheader").append('<th class="minmax150">Payment Percent</th>');
  $("#projecttableheader").append('<th class="minmax150">UOM</th>');
  $("#projecttableheader").append('<th class="min100">Unit Price</th>');
  $("#projecttableheader").append('<th class="min100">Total</th>');
  // $("#projecttableheader").append('<th class="min100">Delete</th>');
  $("#projectable").append('<tbody id="projecttablebody"></tbody>');
  $("#id_projectsummary").append('<hr class="mt-0"> <div class="row" id="ptsummary"> <div class="col-10 mb-2">    <button type="button" id="add_pt" class="btn btn-primary btn-sm">Add Payment Terms</button></div> <div class="col-2 mb-2">      <div class="row"> <div class="col-12 text-left"> <input type="hidden" name="pttotaldays" id="id_pttotaldays"  value="0"><b>Qty. : &nbsp; &nbsp; &nbsp; &nbsp;</b><span id="totalday">0</span></div> <div class="col-12 text-left" id="pttotaldiv"> <input type="hidden" name="ptsubtotal" id="id_pttotal" value="0.0" /><b>Total : &nbsp; &nbsp; &nbsp;</b><span id="pttotalvalue">0.00</span></div> </div> </div> </div>');
}

function projecttablebody(charlie) {
  $("#projecttablebody").append("<tr id='pt" + charlie + "'></tr>");
  $("#pt" + charlie).append("<td class='form-group'><input type='text' class='form-control ftsm itmy' name='ptitem[]' id='id_ptitem" + charlie + "' placeholder='Enter item name' /></td>");

  $("#pt" + charlie).append("<td class='form-group'><input type='text' class='form-control ftsm desp' name='paymentterm[]' id='id_paymentterm" + charlie + "' placeholder='Enter Description...' /></td>");

  $("#pt" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm qty'  value='' name='ptqty[]' id='id_ptquantity" + charlie + "' max='100' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /></td>");

  $("#pt" + charlie).append('<td class="pt-3">Percentage (%)</td>');

  $("#pt" + charlie).append("<td class='form-group'><input type='number' class='form-control ftsm unitprice' name='ptunit_price[]' value='' id='id_ptunitprice" + charlie + "' /></td>");

  $("#pt" + charlie).append("<td class='form-group'>₹<input type='hidden' class='form-control ftsm rowtotal' value='' name='pttotal[]' id='pttotal" + charlie +
    "' ><span id='id_pttotal" + charlie + "' >0.00</span></td>");
  // $("#pt" + charlie).append('<td><i class="fas fa-minus-circle trash" style="color: red" ></i></td>');
  ptlist.push(charlie);
  $("#id_ptunitprice" + charlie).val($("#id_unitprice1").val()).attr("readonly", true);
  console.log(ptlist);
}

function checker() {
  var check = true;
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
  $('select.uom').each(function () {
    if ($(this).val() == "") {
      $(this).addClass('is-invalid');
      check = false;
    }
  });
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
  if ($("#id_ordertype").val() == 2) {
    paytm = 0
    $.each(ptlist, function (index, value) {
      if ($("#id_ptquantity" + value).val() != "") {
        paytm += parseFloat($("#id_ptquantity" + value).val())
      } else {
        check = false;
        alert('All Payment Percent Mandatory.');
      }
    });
    if (paytm > 100) {
      check = false;
      alert('Sum of all Payment Percent exceeds 100%.');
    }
  }
  if (check == true) {
    $("#responsemodal").click();
  }
}

$(function () {
  $("#date_id").val(today);
  $.validator.setDefaults({
    submitHandler: function () {
      checker();
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
      ordertype: {
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
      ordertype: {
        required: "Select a order type.",
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
    }
  });
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
        $("#bill_id").val("");
        $("#ship_id").val("");
        $("#id_customertext").text("");
        $("#salesperson_id").val("");
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  } else {
    groupdetails = ""
    $("#bill_id").val("");
    $("#ship_id").val("");
    $("#id_customertext").text("");
    $("#salesperson_id").val("");
    // $("#id_po_no").val("");
    // $("#comment_id").val("");
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
  id = deleteid.match(/\d+/);
  if (deleteid == "pt" + id) {
    ptlist = jQuery.grep(ptlist, function (b) {
      return b != id;
    });
    console.log(ptlist);
    pttotal();
    $("#byemodal").click();
  } else {
    var arr = $("#id_tr").val().split(",");
    res = jQuery.grep(arr, function (b) {
      return b != deleteid;
    });
    $("#id_tr").val(res);
    ttotal();
    $("#byemodal").click();
  }
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

// On hovering Address column
$(document).on("click", "#add_pt", function () {
  if (ptlist.length == 0) {
    projecttablebody(lastid);
  } else {
    var lastid = ptlist[ptlist.length - 1];
    lastid++;
    projecttablebody(lastid);
  }
});

// On quantity Change
$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  qtycal(qtyid, id[0])
});

$(document).on("keyup", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  qtycal(qtyid, id[0])
});

function qtycal(qtyid, id) {
  if (qtyid == "id_ptquantity" + id) {
    lastfill();
    ptcollector(id);
  } else {
    if ($("#id_ordertype").val() != 2) {
      rowcollector(id);
    }
  }
}

function lastfill() {
  ptlist_total = 0
  empty_ptlistids = []
  $.each(ptlist, function (index, value) {
    if ($("#id_ptquantity" + value).val() == "") {
      empty_ptlistids.push(value);
    } else {
      if ((ptlist.length - 1) == index){
        $("#id_ptquantity" + value).val(100-ptlist_total);
      }
      ptlist_total += parseFloat($("#id_ptquantity" + value).val())
    }
  });
  if (lastfillcheck == false) {
    if (empty_ptlistids.length == 1) {
      balanc = 100 - ptlist_total
      if (balanc < 0) {
        balanc = ""
      }
      $("#id_ptquantity" + empty_ptlistids[0]).val(balanc);
      ptcollector(empty_ptlistids[0]);
      lastfillcheck = true
      ptlist_total = 100
    }
  }
  // if (ptlist_total > 100) {
  //   id = ptlist[ptlist.length - 1]
  //   extra = parseFloat($("#id_ptquantity" + ptlist.length).val()) - (ptlist_total - 100);
  //   $("#id_ptquantity" + id).val(parseInt(extra));
  //   ptcollector(id);
  // }
}

// On Unit Price Change
$(document).on("change", ".unitprice", function () {
  $(this).val($(this).val() * 1.0);
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  if (unitpriceid == "id_ptunitprice" + id[0]) {
    ptcollector(id[0]);
  } else {
    rowcollector(id[0]);
  }
  unitprc = $(this).val();
  $.each(ptlist, function (index, value) {
    $("#id_ptunitprice" + value).val(unitprc);
    ptcollector(value);
  });
});

$(document).on("change", ".uom", function () {
  rowcollector(id[0]);
});

// Order Type Change
$(document).on("change", "#id_ordertype", function () {
  if ($(this).val() == "") {
    $(".field").hide();
  } else {
    $(".field").show();
    $("#orderlist").empty();
    if (var_ordertypeid != $(this).val()) {
      $("#id_tr").val("");
    }
    $("#add_item").trigger("click");
    if ($(this).val() == "2") {
      $("#add_item").hide();
      $("#order_item_header_qty").text("Payment Slab");
      addprojecttable();
    } else {
      $("#add_item").show();
      $("#order_item_header_qty").text("Qty.");
      $("#id_project").empty();
      $("#id_projectsummary").empty();
    }
  }
  $('select.uom').each(function () {
    $(this).val("")
  });
  if ($("#id_ordertype").val() == 2) {
    $("#id_uom1").empty().append('<option value="3">Percentage (%)</option>').val("3");
    // $("#id_uom1").attr("disabled", true);
    // $("#id_uom1").val("3");
  }
  var_ordertypeid = $(this).val()
});

// Amount Representation
function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

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
    $("#bill_id").removeClass("is-invalid");
    $("#id_customer_id").val(id);
    $("#id_customertext").text(customername);
    getcustomerdetails(id);
  }
  if (modal == "shiprow") {
    $("#ship_id").val(code);
    $("#ship_id").removeClass("is-invalid");
  }

}

// Each Order Item calculator
function rowcollector(id) {
  rowqty = $("#id_quantity" + id).val();
  rowunitprice = $("#id_unitprice" + id).val();
  rowtax = $("#id_tax" + id).val();
  rowuom = $("#id_uom" + id).val();
  subtotal = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    subtotal = rowunitprice * rowqty;
    if ($("#id_ordertype").val() == 2 && rowuom == 3) {
      // subtotal = rowunitprice * (rowqty / 100);
      subtotal = rowunitprice
    }
  }
  $("#total" + id).val(subtotal);
  $("#id_total" + id).text(parseFloat(subtotal).toFixed(2));
  ttotal()
}

// Each Payment Term calculator
function ptcollector(id) {
  rowqty = $("#id_ptquantity" + id).val();
  rowunitprice = $("#id_ptunitprice" + id).val();
  subtotal = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    //subtotal = rowunitprice * rowqty;
    subtotal = rowunitprice * (rowqty / 100);
  }
  $("#pttotal" + id).val(subtotal);
  $("#id_pttotal" + id).text(parseFloat(subtotal).toFixed(2));
  pttotal();
}

// All Payment Term Total calculator
function pttotal() {
  var days = 0;
  var total = 0.00;
  if (ptlist != "") {
    $.each(ptlist, function (index, value) {
      if ($("#id_ptquantity" + value).val() == "") {
        qty = 0
      }
      else {
        qty = parseInt($("#id_ptquantity" + value).val());
      }
      if ($("#pttotal" + value).val() == "") {
        subtotal = 0.00
      }
      else {
        subtotal = parseFloat($("#pttotal" + value).val());
      }
      days += qty;
      total += subtotal;
    });
  }
  $("#id_pttotaldays").val(days);
  $("#id_pttotal").val(total);
  $("#totalday").text(days);
  $("#pttotalvalue").text(humanamount(total));
}

// All Order Items calculator
function ttotal() {
  var idlist = $("#id_tr").val().split(",");
  total = 0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      total += parseFloat($("#id_total" + value).text());
    });
  } else {
    total = 0.0;
  }
  $("#id_ordersubtotal").val(total);
  $("#subtotal").text(humanamount(parseFloat(total).toFixed(2)));
  igstval = igst / 100 * total
  cgstval = cgst / 100 * total
  sgstval = sgst / 100 * total
  $("#id_igst").val(igstval);
  $("#id_cgst").val(cgstval);
  $("#id_sgst").val(sgstval);
  $("#sgstvalue").text(humanamount(parseFloat(sgstval).toFixed(2)));
  $("#cgstvalue").text(humanamount(parseFloat(cgstval).toFixed(2)));
  $("#igstvalue").text(humanamount(parseFloat(igstval).toFixed(2)));
  gst = igstval + cgstval + sgstval
  withgst = gst + total
  $("#id_ordertotal").val(withgst);
  $("#total").text(humanamount(parseFloat(withgst).toFixed(2)));
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
      console.log(row);
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
        $("#salesperson_id").removeClass("is-invalid");
        getgst(customerid);
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

function addprojecttable() {
  //projectdiv()
  //projecttablebody(1)
}


$(document).on("input propertychange paste", '#id_quantity1', function () {
  if ($("#id_ordertype").val() == 2) {
    console.log("qty change ::" + $(this).val());
    $("#id_project").empty();
    projectdiv()
    $("#add_pt").hide();
    $("#id_projectsummary").empty();
    ptlist = []
    for (i = 0; i < $(this).val(); i++) {
      projecttablebody((i + 1));
    }
  }
});

