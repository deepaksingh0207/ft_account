$(function () {
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
});

function addrow(charlie) {
  $("#orderlist").append(
    "<tr id='" +
      charlie +
      "'><td><input type='number' class='form-control ftsm qty' name='quantity" +
      charlie +
      "' id='id_quantity" +
      charlie +
      "'/></td><td><input class='form-control ftsm' list='item" +
      charlie +
      "_list' name='item" +
      charlie +
      "' id='id_item" +
      charlie +
      "' placeholder='Type or select...' /><datalist id='item" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input class='form-control ftsm' list='description" +
      charlie +
      "_list' name='description" +
      charlie +
      "' id='id_description" +
      charlie +
      "' placeholder='Type or select...' /> <datalist id='description" +
      charlie +
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input type='number' class='form-control ftsm unitprice' name='unitprice" +
      charlie +
      "' id='id_unitprice" +
      charlie +
      "'/></td><td><input type='number' class='form-control ftsm tax' name='tax' id='id_tax" + charlie + "'></td><td>₹<span id='id_total" +
      charlie +
      "'>0.00</span></td><td><i class='fas fa-minus-circle trash' style='color: red' value='" +
      charlie +
      "'></i></td></tr>"
  );
}

// delete confirmation
$(document).on("click", "i.trash", function () {
  $(".killrow").attr("id", $(this).attr("value"));
  $("#modelactivate").click();
});

// delete and show main
$(".killrow").click(function () {
  var a = $(this).attr("id");
  $("#" + a).remove();
  var arr = $("#id_tr").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b !== a;
  });
  $("#id_tr").val(res);
  ttotal()
  $("#byemodal").click();
});

// Cancel delete action
$(".order").click(function () {
  $("#order").show();
  $("#trash").hide();
});

// Add Item click
$("#add_item").on("click", function () {
  // var a = $("input[id='trid']")
  //   .map(function () {
  //     return $(this).val();
  //   })
  //   .get();
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

$(".tax").change(function () {
  ttotal();
});

$(document).on("change", ".qty", function () {
  var qtyid = $(this).attr("id");
  id = qtyid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal()
});

$(document).on("change", ".unitprice", function () {
  var unitpriceid = $(this).attr("id");
  id = unitpriceid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal()
});

$(document).on("change", ".tax", function () {
  var taxid = $(this).attr("id");
  id = taxid.match(/\d+/);
  subtotal = rowcollector(id[0]);
  $("#id_total" + id[0]).text(parseFloat(subtotal).toFixed(2));
  ttotal()
});

function ttotal() {
  var idlist = $("#id_tr").val().split(",");
  total = 0;
  if (idlist != "") {
    $.each(idlist, function (index, value) {
      total += parseFloat($("#id_total" + value).text());
    });
    $("#subtotal_id").text(parseFloat(total).toFixed(2));
    $("#total").text(parseFloat(total).toFixed(2));
  }
}

function rowcollector(id) {
  rowqty = $("#id_quantity" + id).val();
  rowunitprice = $("#id_unitprice" + id).val();
  rowtax = $("#id_tax" + id).val();
  total = 0;
  if (rowqty[0] != "" && rowunitprice[0] != "") {
    total = rowunitprice * rowqty;
    if (rowtax[0] != "") {
      total += (total*(rowtax/100))
    }
  }
  return total;
}
