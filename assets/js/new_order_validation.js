var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
var emptyPaymentTermIds = [], deleteid, old_orderid, oneTimeLastFill = false;
var sgst = 0, cgst = 0, igst = 0;
var orderid_list = [], last_orderid = 0;
var today = new Date();
today = today.getFullYear() + "-" + String(today.getMonth() + 1).padStart(2, "0") + "-" + String(today.getDate()).padStart(2, "0");

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
      upload_po: {
        required: true,
        accept: "application/pdf"
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
      upload_po: {
        required: "Upload PO.",
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
  $('input.item').each(function () {
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
  checklessthanone = false;
  checkmandatory = false;
  if ($("#id_ordertype").val() == 2) {
    paytm = 0
    $.each(ptlist, function (index, value) {
      if ($("#id_ptquantity" + value).val() < 1) {
        checklessthanone = true;
      }
      if ($("#id_ptquantity" + value).val() != "") {
        paytm += parseFloat($("#id_ptquantity" + value).val())
      } else {
        checkmandatory = true;
      }
    });
    if (checklessthanone == true) {
      alert('Payment Percent cannot be less than 5.');
    }
    if (checkmandatory == true) {
      alert('All Payment Percent Mandatory.');
    }
    if (paytm > 100) {
      check = false;
      alert('Sum of all Payment Percent exceeds 100%.');
    }
    // if (paytm < 100) {
    //   check = false;
    //   alert('Sum of all Payment Percent cannot be less than 1.');
    // }
  }
  if (check == true) {
    $("#responsemodal").click();
  }
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
