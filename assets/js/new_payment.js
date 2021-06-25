var baseUrl = window.location.origin + "/ft_account/";
var receiveableamt;

$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
    },
  });
  $("#id_quickForm").validate({
    rules: {
      invoice_no: {
        required: true,
      },
      payment_date: {
        required: true,
      },
      cheque: {
        required: true,
        date: true,
      },
      received_amt: {
        required: true,
      },
      allocated_amt: {
        required: true,
      },
    },
    messages: {
      invoice_no: {
        required: "Please select a invoice number.",
      },
      payment_date: {
        required: "Enter Payment date.",
        date: "Value must be a date.",
      },
      cheque: {
        required: "Enter cheque number.",
      },
      received_amt: {
        required: "Enter a received amount",
      },
      allocated_amt: {
        required: "Enter Allocated amount.",
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

$(document).on("change", "#id_invoice", function () {
  resetform();
  invoice_id = $(this).val();
  if (invoice_id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "payment/invoice/" + $(this).val(),
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#id_basicvalue").text(data);
        $("#id_gstamount").text(data);
        $("#id_invoiceamount").text(data);
        $("#id_receivableamt").text(humanamount(data));
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this invoice number.");
      });
  }
});

// Amount Representation
function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

function resetform(){

}

$(document).on("change", "#id_tds_percent", function () {
  tds_percent = parseFloat($(this).val()) / 100;
  base_val = parseFloat($("#id_basic_value").val());
  less_TDS = tds_percent * base_val
  tdsdeduction(less_TDS);
  invoiceamt = parseFloat($("#id_invoice_amount").val());
  receiveableamt = invoiceamt + less_TDS;
  receivableamt(humanamount(receiveableamt));
});

$(document).on("change", "#id_tds_percent", function () {
  allocateamt = parseFloat($("#id_allocated_amt").val());
  balanceamount(humanamount(allocateamt + receiveableamt));
});

function basicvalue(newval) {
  $("#id_basic_value").val(newval);
  $("#id_basicvalue").text(newval);
}

function gstamount(newval) {
  $("#id_gst_amount").val(newval);
  $("#id_gstamount").text(newval);
}

function invoiceamount(newval) {
  $("#id_invoice_amount").val(newval);
  $("#id_invoiceamount").text(newval);
}

function tdspercent(newval) {
  $("#id_tds_percent").val(newval);
  $("#id_tdspercent").text(newval);
}

function tdsdeduction(newval) {
  $("#id_tds_deducted").val(newval);
  $("#id_tdsdeducted").text(newval);
}

function receivableamt(newval) {
  $("#id_receivable_amt").val(newval);
  $("#id_receivableamt").text(newval);
}

function paymentdate(newval) {
  $("#id_payment_date").val(newval);
  $("#id_paymentdate").text(newval);
}

function cheque(newval) {
  $("#id_cheque").val(newval);
  $("#id_chequeno").text(newval);
}

function receivedamt(newval) {
  $("#id_cheque").val(newval);
  $("#id_chequeno").text(newval);
}

function allocatedamt(newval) {
  $("#id_allocatedamt").val(newval);
  $("#id_allocated_amt").text(newval);
}

function balanceamount(newval) {
  $("#id_balance_amt").val(newval);
  $("#id_balanceamount").text(newval);
}
