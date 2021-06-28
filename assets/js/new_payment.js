var baseUrl = window.location.origin + "/ft_account/";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0");
var yyyy = today.getFullYear();
var ptlist = []
tomorrow = yyyy + "-" + mm + "-" + (parseInt(dd) + 1);
var receiveableamt = 0, receivedamt = 0, allocateamt = 0, balanceamt = 0
var customerlist = [], grouplist = [], rowlist = [], allocateamtlist = [];


$(function () {
  $('.select2').select2();
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click();
    },
  });
  $("#id_quickForm").validate({
    rules: {
      group_id: {
        required: true,
      },
      customer_id: {
        required: true,
      },
      payment_date: {
        required: true,
      },
      cheque_utr_no: {
        required: true,
      },
      received_amt: {
        required: true,
      },
      invoice_no: {
        required: true,
      },
      basic_value: {
        required: true,
      },
      gst_amount: {
        required: true,
      },
      invoice_amount: {
        required: true,
      },
      allocated_amt: {
        required: true,
      },
    },
    messages: {
      group_id: {
        required: "Please select cutomer group.",
      },
      customer_id: {
        required: "Please select cutomer.",
      },
      payment_date: {
        required: "Enter the payment date.",
        date: "Value must be a date.",
      },
      cheque_utr_no: {
        required: "Enter Cheque/UTR No.",
      },
      received_amt: {
        required: "Enter Received amount.",
      },
      invoice_no: {
        required: "Enter Invoice amount.",
      },
      basic_value: {
        required: "Enter Basic amount.",
      },
      gst_amount: {
        required: "Enter GST amount.",
      },
      invoice_amount: {
        required: "Enter Total Invoice amount.",
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
  $("#id_payment_date").attr("min", tomorrow)
});

function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

$(document).on("click", "i.trash", function () {
  deleteid = $(this).parent().parent().attr("id");
  $("#modelactivate").click();
});

$(".killrow").click(function () {
  $("#" + deleteid).remove();
  id = deleteid.match(/\d+/);
  rowlist = jQuery.grep(rowlist, function (b) {
    return b != id;
  });
  updateAllocateAmount();
  $("#byemodal").click();
  $("#add_row").show();
});

function resetform() {
  $("#table_one").hide();
  $("#table_two").hide();
  $("#receivable_amt_div").hide();
  $("#id_invoicebody").empty();
}

function getid(val) {
  id = val.match(/\d+/);
  return id[0];
}

$(document).on("change", ".inv", function () {
  invoice_id = $(this).val();
  id = getid($(this).attr("id"));
  if (invoice_id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/getdetails/" + invoice_id,
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        $("#table_two").show();
        $("#receivable_amt_div").show();
        $("#table_one").show();
        basicvalue(data.sub_total, parseInt(id[0]));
        gstamount(parseFloat(data.igst) + parseFloat(data.sgst) + parseFloat(data.cgst), parseInt(id[0]));
        invoiceamount(data.invoice_total, parseInt(id[0]));
        allocatedamt(data.invoice_total, parseInt(id[0]));
        
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this invoice number.");
      });
  }
});

$(document).on("change", "#id_group_id", function () {
  resetform();
  $("#customerid_id").val("").empty().attr("disabled", true);
  groupid = $(this).val();
  if (groupid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + $(this).val(),
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        grouplist = data
        $("#customerid_id").append("<option></option>");
        $.each(grouplist, function (index, value) {
          $("#customerid_id").append("<option value='" + value.id + "'>" + value.name + "</option>");
        });
        $("#customerid_id").removeAttr('disabled');
        
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

$("#customerid_id").change(function () {
  resetform();
  customerid = $(this).val();
  if (customerid) {
    $("#table_two").show();
    $("#table_one").show();
    $("#add_row").click();
  }
});

$(document).on("click", "#add_row", function () {
  if (rowlist.length < 1) {
    addrow(1);
    rowlist[0] = 1;
  } else {
    var lastid = rowlist[rowlist.length - 1];
    lastid++;
    if (addrow(lastid) == true) {
      rowlist.push(lastid);
    }
  }
  if (rowlist.length >= invoicelist) {
    $("#add_row").hide();
  } else {
    $("#add_row").show();
  }
  
});

function addrow(val) {
  $("#id_invoicebody").append('<tr id="id_row' + val + '" class="text-center"></tr>');
  $("#id_row" + val).append('<td class="text-center align-middle" ><i class="fas fa-minus-circle trash" style="color: red"></i></td>');
  $("#id_row" + val).append('<td id="id_invoiceno' + val + '"></td>');
  $("#id_invoiceno" + val).append('<select class="form-control inv" name="invoice_no[]" id="id_invoice_no' + val + '"></select>');
  $("#id_invoice_no" + val).append('<option>&nbsp;</option>');
  $.each(newinvoicelist, function (index, value) {
    $("#id_invoice_no" + val).append('<option val="' + value + '" class="pt-3">' + value + '</option>');
  });
  $("#id_row" + val).append('<input type="hidden" name="basic_value[]" id="id_basic_value' + val + '">');
  $("#id_row" + val).append('<td id="id_basicvalue' + val + '" class="pt-3"></td>');
  $("#id_row" + val).append('<input type="hidden" name="gst_amount[]" id="id_gst_amount' + val + '">');
  $("#id_row" + val).append('<td id="id_gstamount' + val + '" class="pt-3"></td>');
  $("#id_row" + val).append('<input type="hidden" name="invoice_amount[]" id="id_invoice_amount' + val + '">');
  $("#id_row" + val).append('<td id="id_invoiceamount' + val + '" class="pt-3"></td>');
  $("#id_row" + val).append('<td id="id_tdspercent' + val + '"></td>');
  $("#id_tdspercent" + val).append('<input type="number" class="form-control max100 up" name="tds_percent[]" min="0" id="id_tds_percent' + val + '">');
  $("#id_row" + val).append('<input type="hidden" class="form-control max150" name="tds_deducted[]" id="id_tds_deducted' + val + '">');
  $("#id_row" + val).append('<td id="id_tdsdeducted' + val + '" class="pt-3"></td>');
  $("#id_row" + val).append('<td id="id_allocatedamt' + val + '" class="pt-3"></td>');
  $("#id_row" + val).append('<input type="hidden" class="form-control" name="allocated_amt[]" id="id_allocated_amt' + val + '">');
  return true
}


function updateAllocateAmount() {
  allocateamt = 0;
  $.each(rowlist, function (index, value) {
    allocateamt += parseFloat($("#id_allocated_amt" + value).val());
  });
  func_balanceamount();
  
}

$(document).on("change", "#id_received_amt", function () {
  func_balanceamount();
});

function func_balanceamount() {
  receivedamt = parseFloat($("#id_received_amt").val());
  if (allocateamt > 0.0) {
    if (receivedamt > 0.0) {
      balanceamt = allocateamt - receivedamt;
      balanceamount(balanceamt);
      $("#id_balanceamt").show();
    } else {
      balanceamount(allocateamt);
      $("#id_balanceamt").show();
    }
  } else {
    balanceamount(0);
    $("#id_balanceamt").hide();
  }
  
}

function basicvalue(newval = 0, id) {
  $("#id_basic_value" + id).val(parseFloat(newval));
  $("#id_basicvalue" + id).text(humanamount(newval));
}

function gstamount(newval = 0, id) {
  $("#id_gst_amount" + id).val(parseFloat(newval));
  $("#id_gstamount" + id).text(humanamount(newval));
}

function invoiceamount(newval = 0, id) {
  $("#id_invoice_amount" + id).val(parseFloat(newval));
  $("#id_invoiceamount" + id).text(humanamount(newval));
}

function tdspercent(newval = 0) {
  $("#id_tds_percent").val(parseFloat(newval));
}

function tdsdeduction(newval = 0, id) {
  $("#id_tds_deducted" + id).val(parseFloat(newval));
  $("#id_tdsdeducted" + id).text(humanamount(newval));
}

function paymentdate(newval = tomorrow) {
  $("#id_payment_date").val(parseFloat(newval));
  $("#id_paymentdate").text(humanamount(newval));
}

function cheque(newval = "") {
  $("#id_cheque").val(newval);
}

function receivedamt(newval = 0) {
  receivedamt = newval
  $("#id_received_amt").val(parseFloat(newval));
}

function allocatedamt(newval = 0, id) {
  $("#id_allocated_amt" + id).attr("max", newval);
  $("#id_allocated_amt" + id).val(newval);
  $("#id_allocatedamt" + id).text(humanamount(newval));
  updateAllocateAmount();
}

function balanceamount(newval = 0) {
  $("#id_balance_amt").val(parseFloat(newval));
  $("#id_balanceamount").text();
  $("#id_balance_amt").text(humanamount(newval));
}

$(document).on("change", ".up", function () {
  id = getid($(this).attr("id"));
  val = parseFloat($(this).val());
  baseval = parseFloat($("#id_basic_value" + id).val());
  lesstds = baseval * (val / 100);
  tdsdeduction(lesstds, id);
  inval = parseFloat($("#id_invoice_amount" + id).val());
  allocatedamt(inval - lesstds, id);
  
});