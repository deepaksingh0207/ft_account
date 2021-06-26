var baseUrl = window.location.origin + "/ft_account/";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
var ptlist = []
tomorrow = yyyy + "-" + mm + "-" + (parseInt(dd) + 1);
var receiveableamt = allocateamt = 0;

$(function () {
  $('.select2').select2();
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click();
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
  $("#id_payment_date").val(tomorrow);
  $("#id_payment_date").attr("min", tomorrow);
});

$(document).on("change", "#id_invoice_no", function () {
  resetform();
  invoice_id = $(this).val();
  if (invoice_id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/getdetails/" + $(this).val(),
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#table_two").show();
        $("#receivable_amt_div").show();
        $("#table_one").show();
        basicvalue(data.sub_total);
        gstamount(parseFloat(data.igst) + parseFloat(data.sgst) + parseFloat(data.cgst));
        invoiceamount(data.order_total);
        receivableamt(data.order_total);
        func_balanceamount();
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

function resetform() {
  $("#table_two").hide();
  $("#receivable_amt_div").hide();
  $("#table_one").hide();
  basicvalue();
  gstamount();
  invoiceamount();
  tdspercent();
  tdsdeduction();
  receivableamt();
  cheque();
  receivedamt();
  allocatedamt();
  balanceamount();
}

$(document).on("change", "#id_tds_percent", function () {
  tds_percent = parseFloat($(this).val()) / 100;
  base_val = parseFloat($("#id_basic_value").val());
  invoiceamt = parseFloat($("#id_invoice_amount").val());
  less_TDS = tds_percent * base_val
  tdsdeduction(less_TDS);
  receivableamt(invoiceamt + less_TDS);
  func_balanceamount();
});

$(document).on("change", "#id_allocated_amt", function () {
  allocateamt = parseFloat($("#id_allocated_amt").val());
  func_balanceamount();
});

function func_balanceamount() {
  balanceamount(receiveableamt - allocateamt);
}

function basicvalue(newval = 0) {
  $("#id_basic_value").val(parseFloat(newval));
  $("#id_basicvalue").text(humanamount(newval));
}

function gstamount(newval = 0) {
  $("#id_gst_amount").val(parseFloat(newval));
  $("#id_gstamount").text(humanamount(newval));
}

function invoiceamount(newval = 0) {
  $("#id_invoice_amount").val(parseFloat(newval));
  $("#id_invoiceamount").text(humanamount(newval));
}

function tdspercent(newval = 0) {
  $("#id_tds_percent").val(parseFloat(newval));
}

function tdsdeduction(newval = 0) {
  $("#id_tds_deducted").val(parseFloat(newval));
  $("#id_tdsdeducted").text(humanamount(newval));
}

function receivableamt(newval = 0) {
  $("#id_allocated_amt").attr("max", newval);
  receiveableamt = parseFloat(newval);
  $("#id_receivable_amt").val(parseFloat(newval));
  $("#id_receivableamt").text(humanamount(newval));
}

function paymentdate(newval = tomorrow) {
  $("#id_payment_date").val(parseFloat(newval));
  $("#id_paymentdate").text(humanamount(newval));
}

function cheque(newval = "") {
  $("#id_cheque").val(newval);
}

function receivedamt(newval = 0) {
  $("#id_received_amt").val(parseFloat(newval));
}

function allocatedamt(newval = 0) {
  $("#id_allocated_amt").val(parseFloat(newval));
}

function balanceamount(newval = 0) {
  $("#id_balance_amt").val(parseFloat(newval));
  $("#id_balanceamount").text(humanamount(newval));
}