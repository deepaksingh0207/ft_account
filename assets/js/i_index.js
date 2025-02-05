var dtable, loopme;

function fill_datatable(appliedfilter = {}) {
  $('#example1 thead th').each(function () {
    var col_list = ["Date", "Salesperson", "Amount"]
    var title = $(this).text();
    if (col_list.indexOf(title) < 0) {
      $(this).html('<input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
    }
  });
  dtable = $("#example1").DataTable({
    initComplete: function () {
      // Apply the search
      this.api().columns().every(function () {
        var that = this;

        $('input', this.header()).on('keyup change clear', function () {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    },
    "processing": true,
    "ordering": false,
    "pageLength": 10,
    "bLengthChange": false,
    "order": [],
    "searching": true,
    "columns": [
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4 },
      { data: 5 },
      { data: 6 }
    ],
    createdRow: function (row, data, dataIndex) {
      $(row).addClass('pointer').attr('data-toggle', 'modal').attr('data-target', '#modal-lg').attr('data-href', data[0]).attr('data-date', data[1]).attr('data-invoice', data[2]).attr('data-po_no', data[3]).attr('data-customer', data[4]).children('td').addClass('sublist');
    },
    "ajax": {
      url: baseUrl + "invoices/search/",
      type: "POST",
      data: appliedfilter
    }
  });
  $('#example1_filter').hide();
}

function diff_hours(dt2, dt1) {
  var diff = (dt2.getTime() - dt1.getTime()) / 1000;
  diff /= (60 * 60);
  return Math.abs(Math.round(diff));
}

$(document).on("click", ".sublist", function () {
  $("#id_creditnote").val('');
  var inv_id = $(this).parent("tr").data("href");
  var customer = $(this).parent("tr").data("customer");
  var po_no = $(this).parent("tr").data("po_no");
  var invoice = $(this).parent("tr").data("invoice");
  var o_date = $(this).parent("tr").data("date");

  $('.act').hide();
  $("#id_modelcustomer").text(customer);
  $("#id_modelinvoice_no").text(invoice);
  $("#id_modelpo_order").text(po_no);
  $("#id_modeldate").text(o_date);
  $('.invcpy').attr('href', baseUrl + "invoices/geninv/" + inv_id)
  $('.cbncpy').attr('href', baseUrl + "invoices/gencbn/" + inv_id)
  $('.col_invcpy').show();

  // Get IRN List
  $('.genirn, .rgenirn').data('href', baseUrl + "invoices/postEinvoiceRequest/" + inv_id).data('inv_id', inv_id);
  $('.ecanirn').data('href', baseUrl + "invoiceirn/cancelIrnByInvoice/" + inv_id);
  $('.gencbn').data('href', baseUrl + "invoices/postCreditNoteRequest/" + inv_id);
  var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnByInvoice/" + inv_id);
  // console.log(getInvIrn);
  if (!getInvIrn) {
    $("#id_invoice").data('invoice_no', invoice);
    $('.col_genirn').show();
  } else {
    if (getInvIrn[0]['credit_note'] != null) { 
      $('.col_cbncpy, .col_rgenirn, #id_invoice').show();
     }
    else {
      var ack_date = new Date(getInvIrn[0]['ack_date']);
      var today = new Date();
      if (getInvIrn[0]['status'] == "0") {
        $("#id_invoice").data('invoice_no', getInvIrn[0]['invoice_no']);
        $('#id_invoice, .col_rgenirn, .col_invid').show();
      } else if (diff_hours(today, ack_date) > 24) { 
        //  $('#id_creditnote, .col_gencbn').show(); 
         $('.col_cbncpy, .col_gencbn').show(); 
      }
      else { 
        $('.col_ecanirn').show(); }
    }
  }
  $('.feeter').html('');
});

$(document).on("click", ".initrgenirn", function () {
  var new_invoiceno = $("#id_invoice").val();
  if (new_invoiceno.length > 6 && new_invoiceno != $("#id_invoice").data('invoice_no')) {
    geturl = baseUrl + "invoices/check_invoice_validty/" + new_invoiceno;
    getIrnId = getRemote(geturl);
    if (getIrnId == 0) { $('.feeter').show().html('<span class="text-danger">Invoice No Exist</span>'); return; }
    $('.act').hide();
    $('.accept, .reject').show()
    $("#id_accept").attr('data-class', '.rgenirn');
    $("#id_reject").attr('data-class', '#id_invoice, .col_rgenirn');
  } else if (new_invoiceno.length != 7) { $('.feeter').show().html('<span class="text-danger">Invalid Invoice No<span>'); return; }
});

$(document).on("click", ".exitrgenirn", function () {
  $('.col_rgenirn').show();
  $('.col_conrgenirn').hide();
});

$(document).on("click", ".initecanirn", function () {
  $('.act').hide();
  $('.accept, .reject').show()
  $("#id_accept").attr('data-class', '.ecanirn');
  $("#id_reject").attr('data-class', '.col_ecanirn');
});

$(document).on("click", ".initgencbn", function () {
  var new_creditnote = $("#id_creditnote").val();
  if (new_creditnote.length == 5) {
    $('.act').hide();
    $('.accept, .reject').show();
    $("#id_accept").attr('data-class', '.gencbn');
    $("#id_reject").attr('data-class', '#id_creditnote, .col_gencbn');
  } else { $('.feeter').show().html('<span class="text-danger">Invalid Credit Note No.<span>'); return; }
});

$(document).on("click", ".gencbn", function () {
  $('.act').hide();
  $('.feeter, .col_gencbn, .col_invcpy').show();
  $('.gencbn').html('<img src="' + baseUrl + 'assets/img/load.gif" alt="Loading" width="30px" class="mb-2"><br>Generate E-Invoice');
  var new_creditnote = $("#id_creditnote").val();
  var getIrnId = getRemote($(this).data('href') + "/" + new_creditnote);  
  if (getIrnId['Status'] == "0") {
    $('.feeter').show().text(getIrnId['ErrorDetails'][0]['ErrorMessage']);
    $('.gencbn').html('<i class="fas fa-file-invoice fa-lg"></i><br><br>Generate Credit Note');
  } else { $('.col_gencbn').hide(); $('.col_cbncpy').show(); }
});

$(document).on("click", "#id_accept", function () {
  $(".act").hide()
  $($(this).attr('data-class')).trigger('click');
  $('.col_invcpy').show();
});

$(document).on("click", "#id_reject", function () {
  $(".act").hide()
  $($(this).attr('data-class')).show();
  $('.col_invcpy').show();
});

$(document).on("click", ".exitecanirn", function () {
  $('.col_ecanirn').show();
  $('.col_conecanirn').hide();
});

$(document).on("click", ".rgenirn", function () {
  var new_invoiceno = $("#id_invoice").val();

  if (new_invoiceno.length != 7) { $('.feeter').show().html('<span class="text-danger">Invoice No Mandatory<span>'); return; }

  $('.act').hide();
  var getIrnId, geturl = $(this).data('href') + "/" + new_invoiceno;
  checkinvoice = getRemote(baseUrl + "invoices/check_invoice_validty/" + new_invoiceno);
  if (checkinvoice == 0) { $('.feeter').show().html('<span class="text-danger">Invoice No Invalid<span>'); return; }
  getIrnId = getRemote(geturl);
  if (getIrnId['Status'] == "0") {
    $('.feeter').show().text(getIrnId['ErrorDetails'][0]['ErrorMessage']);
    $('.col_invcpy, .col_rgenirn').show();
  } else {
    var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnById/" + getIrnId);
    if (getInvIrn) { $('#id_invoice, .col_genirn, .col_invid, .col_crednote').hide(); $('.col_invcpy, .col_ecanirn').show(); }
    else { $('.col_invcpy, .col_genirn').show(); }
    $('.feeter').show().text('');
  }
});

$(document).on("click", ".genirn", function () {
  $('.act').hide();
  $('.feeter, .col_gencbn, .col_invcpy').show();
  $('.genirn').html('<img src="' + baseUrl + 'assets/img/load.gif" alt="Loading" width="30px" class="mb-2"><br>Generate E-Invoice');
  var geturl = $(this).data('href');
  var getIrnId = getRemote(geturl);
  if (getIrnId['Status'] == "0") {
    $('.feeter').show().text(getIrnId['ErrorDetails'][0]['ErrorMessage']);
    $('.genirn').html('<i class="fas fa-file-invoice fa-lg"></i><br><br>Generate E-Invoice');
    $('.initgencbn').hide(); 
  } else {
    var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnById/" + getIrnId);
    if (getInvIrn) { $('.act').hide(); $('.col_ecanirn').show(); }
  }
});

$(document).on("click", ".ecanirn", function () {
  $('.act').hide();
  $('.ecanirn').html('<img src="' + baseUrl + 'assets/img/load.gif" alt="Loading" width="30px"><br><br>Generate E-Invoice');
  var geturl = $(this).data('href');
  var getIrnId = getRemote(geturl)
  if (getIrnId['status'] == "0") {
    $('.feeter, .col_rgenirn, .col_invid').show();
    $('.feeter').html('');
    $('.col_conrgenirn, .col_conecanirn').hide();
    var currentdate = new Date();
    if (getIrnId['added_date'] > currentdate) { $('.col_crednote').show(); }
  } else {
    $('.feeter').show().html(getIrnId);
    $('.col_conecanirn').hide();
    $('.col_rgenirn, .col_invid, .col_invcpy, #id_invoice').show();
  }
});

$("#id_startdate").on("change", function () { $("#id_enddate").attr('min', $(this).val()); });

$(".update").on("click", function () {
  var f = {};
  if ($("#id_startdate").val()) { f.startdate = $("#id_startdate").val() }
  if ($("#id_enddate").val()) { f.enddate = $("#id_enddate").val() }
  if ($("#id_customer").val()) { f.customer_id = $("#id_customer").val() }
  dtable.destroy();
  fill_datatable(f);
});

$(function () { $(".select2").select2(); fill_datatable(); });

// https://www.youtube.com/watch?v=M0cEiFAzwf0
