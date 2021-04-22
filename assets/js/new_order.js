var baseUrl   = window.location.origin + '/ft_account/';

$(function () {
  $(".select2").select2();
  // Form Validation
  $.validator.setDefaults({
    submitHandler: function () {
      form.submit();
    },
  });
  $("#quickForm").validate({
    rules: {
      customerid: {
        required: true,
      },
      date: {
        required: true,
        date: true,
      },
      quote_number: {
        required: true,
      },
      terms: {
        required: true,
      },
      days: {
        required: true,
        tel: true,
      },
      tracking: {
        required: true,
      },
      customer: {
        required: true,
      },
      salesperson: {
        required: true,
      },
      shipby: {
        required: true,
      },
      tax: {
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
      comment: {
        required: true,
        textarea: true,
      },
      pvtcomment: {
        required: true,
        textarea: true,
      },
    },
    messages: {
      customerid: {
        required: "Please select this customer.",
      },
      date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      quote_number: {
        required: "Please select quote details.",
      },
      terms: {
        required: "Please select a term.",
      },
      days: {
        required: "Please provide number of days.",
        tel: "Invalid Detail.",
      },
      tracking: {
        required: "Please provide a Tracking Ref Id.",
      },
      customer: {
        required: "Please provide a Customer PO Id",
      },
      salesperson: {
        required: "Please select the sales representative.",
      },
      shipby: {
        required: "Select Shipping Method.",
      },
      tax: {
        required: "Please select on from the list.",
      },
      bill: {
        required: "Enter this detail.",
      },
      ship: {
        required: "Enter this detail.",
      },
      comment: {
        required: "Enter your comment.",
      },
      pvtcomment: {
        required: "Enter your private comment.",
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
function addrow(charlie) {
  $("#orderlist").append(
    "<tr id='" +
      charlie +
      "'><td><input type='number' class='form-control ftsm qty' min='1' step='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='qty[]' id='id_quantity" +
      charlie +
      "'/></td><td><input class='form-control ftsm' list='item" +
      charlie +
      "_list' name='item[]' id='id_item" +
      charlie +
      "' placeholder='Type or select...' /><datalist id='item" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input class='form-control ftsm' list='description" +
      charlie +
      "_list' name='description[]' id='id_description" +
      charlie +
      "' placeholder='Type or select...' /> <datalist id='description" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input type='number' class='form-control ftsm unitprice' name='unit_price[]' id='id_unitprice" +
      charlie +
      "'/></td><td><input type='number' class='form-control ftsm tax' name='tax[]' id='id_tax" +
      charlie +
      "'></td><td>₹<input type='hidden' class='form-control ftsm rowtotal' name='total[]' id='total" +
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
    return b !== deleteid;
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
  console.log(a);
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
  console.log($("#id_tr").val());
});

// Monitoring Tax Field
// $(".tax").change(function () {
//   ttotal();
// });

// Monitoring Quantity Field
$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal();
});

// Monitoring Unit Price Field
$(document).on("change", ".unitprice", function () {
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  subtotal = rowcollector(id[0]);
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
    $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  }
  else{
    total = 0.00
    $("#id_ordertotal").val(total);
    $("#subtotal_id").text(parseFloat(total).toFixed(2));
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
    total = rowunitprice * rowqty;
    if (rowtax[0] != "") {
      total += total * (rowtax / 100);
    }
  }
  return total;
}

// Customer Ajax
$("#customerid_id").change(function () {
  var customerid = $(this).val()
  if(customerid) {
    console.log(customerid);
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/getdetails/" + customerid,
      data: customerid,
      dataType: "json",
      encode: true,
    })
    .done(function( data ) {
      $("#salesperson_id").val(data.contact_person)
      $("#bill_id").val(data.address)
      $("#ship_id").val(data.address)
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
      alert("No details found against this customer.")
    });
  } else {
    $("#salesperson_id").val("")
    $("#bill_id").val("")
    $("#ship_id").val("")
  }
});
