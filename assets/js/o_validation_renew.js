var today = new Date();
today = today.getFullYear() +  "-" +  String(today.getMonth() + 1).padStart(2, "0") +  "-" +
String(today.getDate()).padStart(2, "0");

$(function () {
  $(".hide").hide();
  // $("#date_id").val(today);
  $.validator.setDefaults({
    submitHandler: function () {
      if (tree["otl"].length == 0) {
        alert("Please add orders");
      } else {
        form_maker();
        $("#responsemodal").trigger("click");
      }
    },
  });
  $("#quickForm").validate({
    rules: {
      group_id: {required: true},
      customer_id: {required: true},
      order_date: {required: true,date: true},
      po_no: {required: true},
      sales_person: {required: true},
      bill_to: {required: true},
      ship_to: {required: true},
      ordertype: {required: true},
      upload_po: {required: true,accept: "application/pdf"},
    },
    messages: {
      group_id: {required: "Please select a customer group."},
      customer_id: {required: "Please select a customer."},
      order_date: {required: "Please select a date.",date: "Value must be a date."},
      po_no: {required: "Please select a PO"},
      sales_person: {required: "Please provide you sales person.",
        tel: "Invalid Detail."},
      bill_to: {required: "Enter a bill address code."},
      ship_to: {required: "Enter a ship address code."},
      ordertype: {required: "Select a order type."},
      upload_po: {required: "Upload PO."},
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

function checker() {
  var check = true;
  $("input.paymentterm_description").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("input.item").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("input.desp").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("input.order_item_quantity").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("input.order_item_unitprice").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  if (oti != 7){
  $("input#from_date").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("input#to_date").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  } else {
    $("select.paymentterm_uom").each(function () {
      if ($(this).val().length < 1) {
        $(this).addClass("is-invalid");
        check = false;
      }
    });
  }
  $("input.paymentterm_quantity").each(function () {
    if ($(this).val().length < 1) {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("select.order_item_uom").each(function () {
    if ($(this).val() == "") {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  $("select#order_type").each(function () {
    if ($(this).val() == "") {
      $(this).addClass("is-invalid");
      check = false;
    }
  });
  return check
}

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
