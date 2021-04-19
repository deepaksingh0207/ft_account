$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert("Form successful submitted!");
    },
  });
  $("#quickForm").validate({
    rules: {
      customerid: {
        required: true,
        number: true,
      },
      date: {
        required: true,
        date: true,
      },
      quote_number: {
        required: true,
        number: true,
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
      pvtcomment: {
        required: true,
        textarea: true,
      },
    },
    messages: {
      customerid: {
        required: "Please enter this detail.",
        number: "Value must be a number.",
      },
      date: {
        required: "Please enter this detail.",
        date: "Value must be a date.",
      },
      quote_number: {
        required: "Please enter this detail.",
        number: "Value must be a number.",
      },
      terms: {
        required: "Please enter this detail.",
      },
      days: {
        required: "Please provide a password",
        tel: "Value must be a number.",
      },
      tracking: {
        required: "Please provide a password",
        tel: "Value must be a number.",
      },
      customer: {
        required: "Please provide a password",
      },
      salesperson: {
        required: "Please select the sales representative.",
      },
      shipby: {
        required: "Please enter this detail.",
      },
      tax: {
        required: "Please select this detail.",
      },
      ship: {
        required: "Please select the bill",
      },
      comment: {
        required: "Please ",
      },
      pvtcomment: {
        required: "Please provide a password",
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
      "'><td><input type='number' class='form-control ftsm' name='quantity" +
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
      "_list'><option value='a'></option><option value='b'></option></datalist></td><td><input type='number' class='form-control ftsm' name='unitprice" +
      charlie +
      "' id='id_unitprice" +
      charlie +
      "'/></td><td><select class='form-control ftsm' name='tax" +
      charlie +
      "' id='id_tax" +
      charlie +
      "'><option value=''></option><option value='0'>None</option></select></td><td>₹<span id='id_total" +
      charlie +
      "'>0.00</span></td><td><i class='fas fa-minus-circle trash' style='color: red' value='" +
      charlie +
      "'></i></td></tr>"
  );
}

// delete confirmation
$(document).on("click", "i.trash", function () {
  $(".killrow").attr("id", $(this).attr("value"));
  $("#order").hide();
  $("#trash").show();
});

// delete and show main
$(".killrow").click(function () {
  var a = $(this).attr("id");
  $("#" + a).remove();
  var arr = $("#id_tr").val().split(",");
  res = jQuery.grep(arr, function (b) {
    return b !== a ;
  });
  $("#id_tr").val(res);
  $("#order").show();
  $("#trash").hide();
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
