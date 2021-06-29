var baseUrl = window.location.origin + "/ft_account/";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0");
var yyyy = today.getFullYear();
var ptlist = [], invoicelist = []
tomorrow = yyyy + "-" + mm + "-" + (parseInt(dd) + 1);
today = yyyy + "-" + mm + "-" + dd;
var rowlist = [1], invoicelist = [], selectedinvoice = [];

function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

function checker() {
  check = true
  amount = 0
  $.each(rowlist, function (index, value) {
    amount += parseFloat($("#id_allocated_amt" + value).val());
    if ($("#id_invoice_no" + value).val() == "" || $("#id_invoice_no" + value).val() == null) {
      $("#id_invoice_no" + value).addClass("is-invalid");
      check = false
    }
  });
  
  if (invoicelist.length == 0) {
    alert("No Invoice found on this customer ID.");
    check = false
  } else if (amount != parseFloat($("#id_received_amt").val())) {
    alert("Sum of Allocated Amount is not equal to Received Amount.");
    check = false
  } else if (check == true) {
    $("#responsemodal").click();
  }
}

$(function () {
  $('.select2').select2();
  $.validator.setDefaults({
    submitHandler: function () {
      checker();
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
  $("#id_payment_date").val("");
  $("#id_payment_date").attr("max", today)
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
        $("#customerid_id").append("<option></option>");
        $.each(data, function (index, value) {
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
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/getInvoiceIdsByCustomer/" + customerid,
      data: customerid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        invoicelist = []
        $.each(data, function (index, value) {
          invoicelist.push(value.id);
        });
        $("#table_one").show();
        $("#allocated_amt_div1").show();
        $(".add_row").click();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this customer.");
      });
  }
});

$(document).on("change", ".invoice_no", function () {
  syn();
  invoice_id = $(this).val();
  id = $(this).attr("data-row");
  basicvalue(0, id);
  gstamount(0, id);
  invoiceamount(0, id);
  receivableamt(0, id);
  balanceamt(0, id);
  if (invoice_id) {
    $.ajax({
      type: "POST",
      url: baseUrl + "invoices/getdetails/" + invoice_id,
      data: $(this).val(),
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        if (data != false) {
          $("#table_two").show();
          $("#receivable_amt_div").show();
          $("#table_one").show();
          basicvalue(data.sub_total, id);
          gstamount(parseFloat(data.igst) + parseFloat(data.sgst) + parseFloat(data.cgst), id);
          invoiceamount(data.invoice_total, id);
          receivableamt(data.invoice_total, id);
          balanceamt(data.invoice_total, id);
        }
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("No details found against this invoice number.");
      });
  }
});

function resetform() {
  $("#table_one").hide();
  $(".addy").parent().hide();
  receivedamt();
  cheque();
  $.each(rowlist, function (index, rowval) {
    rowlist = jQuery.grep(rowlist, function (b) {
      return b != rowval;
    });
    $("#"+rowval).remove();
  });
  $("#1").hide();
}

$(document).on("change", ".tds_percent", function () {
  tds_percent_val = parseFloat($(this).val()) / 100;
  id = $(this).attr("data-row");
  base_val = parseFloat($("#id_basic_value" + id).val());
  invoiceamt = parseFloat($("#id_invoice_amount" + id).val());
  allocatedamt = parseFloat($("#id_allocated_amt" + id).val());
  less_TDS = tds_percent_val * base_val
  tdsdeduction(less_TDS, id);
  receivableamt(invoiceamt - less_TDS, id);
  balanceamt(invoiceamt - less_TDS - allocatedamt, id);
});

$(document).on("change", ".allocated_amt", function () {
  id = $(this).attr("data-row");
  rec_val = parseFloat($("#id_receivable_amt" + id).val());
  altamt = parseFloat($("#id_allocated_amt" + id).val());
  balanceamt(rec_val - altamt, id);
});

$(document).on("click", ".trash", function () {
  id = $(this).attr("data-row");
  $("#" + id).remove();
  rowlist = jQuery.grep(rowlist, function (b) {
    return b != id;
  });
  if (rowlist.length < 1) {
    $(".add_row").click();
  }
  $(".addy").parent().show();
  console.log(rowlist);
});

$(document).on("click", ".add_row", function () {
  if (rowlist.length >= invoicelist.length) {
    $(".addy").parent().hide();
  } else {
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
    if (invoicelist.length > 1 ){
      $(".addy").parent().show();
    }
  }
  syn();
  console.log(rowlist);
});

function addrow(val) {
  $("#new").append('<div class="card" id="' + val + '"> <div class="card-header px-1"> <div class="row"> <div class="col-sm-12 col-lg-2 pt-1 text-center"> <label for="id_invoice_no"> Invoice Number : </label> </div> <div class="col-sm-12 col-lg-3 form-group mb-0"> <select class="form-control invoice_no" name="invoice_id[]" id="id_invoice_no' + val + '" data-row="' + val + '"> <option value=""></option> </select> </div> <div class="col-sm-12 col-lg-7 text-right pt-1"><button type="button" class="btn btn-default mr-3 trash" data-row="' + val + '"><i class="fas fa-times" style="color: crimson;"></i></button> </div> </div> </div> <div class="card-body" id="table' + val + '" style="display: block;"> <table class="table mb-0"> <thead> <th>Basic Value</th> <th>GST Amount</th> <th>Total Invoice Amount</th> <th>TDS %</th> <th>Less TDS</th> <th>Net Receivable Amount </th> </thead> <tbody> <tr> <input type="hidden" data-row="' + val + '" name="basic_value[]" id="id_basic_value' + val + '"> <td id="id_basicvalue' + val + '" class="max150">₹0.00</td> <input type="hidden" data-row="' + val + '" name="gst_amount[]" id="id_gst_amount' + val + '"> <td id="id_gstamount' + val + '" class="max150">₹0.00</td> <input type="hidden" data-row="' + val + '" name="invoice_amount[]" id="id_invoice_amount' + val + '"> <td id="id_invoiceamount' + val + '" class="max150">₹0.00</td> <td class="max150 py-1"> <input type="number" data-row="' + val + '" class="form-control tds_percent" name="tds_percent[]" value="0" min="0" id="id_tds_percent' + val + '"></td> <input type="hidden" data-row="' + val + '" name="tds_deducted[]" value="0" id="id_tds_deducted' + val + '"> <td id="id_tdsdeducted' + val + '" class="max150"></td> <input type="hidden" data-row="' + val + '" name="receivable_amt[]" id="id_receivable_amt' + val + '" value="0.0"> <td id="id_receivableamt' + val + '">₹0.00</td> </tr> </tbody> </table> </div> <div class="card-footer" id="allocated_amt_div' + val + '" style="display: block;"> <div class="row"> <div class="col-2 pt-2 text-center"> <b>Allocated Amount : </b> </div> <div class="col-3"> <input type="number" data-row="' + val + '" class="form-control allocated_amt" min="1" name="allocated_amt[]" id="id_allocated_amt' + val + '" value="0"> </div> <div class="col-7"> <div class="text-right pt-2"> <input type="hidden" data-row="' + val + '" name="balance_amt[]" id="id_balance_amt' + val + '"> <b>Balance Amount : </b><span id="id_balanceamt' + val + '">₹0.00</span> </div> </div> </div> </div></div>');
  return true
}

function balanceamt(newval = 0, id) {
  $("#id_balance_amt" + id).val(parseFloat(newval));
  $("#id_balanceamt" + id).text(humanamount(newval));
}

function receivableamt(newval = 0, id) {
  $("#id_receivable_amt" + id).val(parseFloat(newval));
  $("#id_receivableamt" + id).text(humanamount(newval));
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

function paymentdate(newval = today) {
  $("#id_payment_date").val(parseFloat(newval));
  $("#id_paymentdate").text(humanamount(newval));
}

function cheque(newval = "") {
  $("#id_cheque").val(newval);
}

function receivedamt(newval = 0) {
  $("#id_received_amt").val(parseFloat(newval));
}

function allocatedamt(newval = 0, id) {
  $("#id_allocated_amt" + id).attr("max", newval);
  $("#id_allocated_amt" + id).val(newval);
  $("#id_allocatedamt" + id).text(humanamount(newval));
}

function syn() {
  selectedinvoice = []
  $.each(rowlist, function (index, rowval) {
    id = $("#id_invoice_no" + rowval).val();
    if (id != "" && id != null) {
      selectedinvoice.push(id);
      console.log(selectedinvoice);
    }
  });
  $.each(rowlist, function (index, rowval) {
    id = $("#id_invoice_no" + rowval).val();
    $("#id_invoice_no" + rowval).empty();
    $("#id_invoice_no" + rowval).append('<option></option>');
    if (id == "" || id == null) {
      $.each(invoicelist, function (index, valu) {
        a = selectedinvoice.indexOf(valu)
        if (a < 0) {
          $("#id_invoice_no" + rowval).append('<option value="' + valu + '">' + valu + '</option>');
        }
      });
    } else {
      $.each(invoicelist, function (index, valu) {
        a = selectedinvoice.indexOf(valu)
        if (a < 0) {
          $("#id_invoice_no" + rowval).append('<option value="' + valu + '">' + valu + '</option>');
        } else {
          if (id == valu) {
            $("#id_invoice_no" + rowval).append('<option value="' + valu + '">' + valu + '</option>');
            $("#id_invoice_no" + rowval).val(id);
          }
        }
      });
    }
  });
}