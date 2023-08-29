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

async function dot(loopme) { if (loopme > 0) { setTimeout(function () { loopme--; $('.dot').append('.'); dot(loopme); }, 1000); } }

function pleasewait(val) {
  loopme = val;
  if (val) { $('.dot').empty(); $('.feeter').show(); dot(loopme); }
  else { $('.feeter').hide(); }
}

function diff_hours(dt2, dt1) {
  var diff = (dt2.getTime() - dt1.getTime()) / 1000;
  diff /= (60 * 60);
  return Math.abs(Math.round(diff));
}

$(document).on("click", ".initrgenirn", function () {
  var new_invoiceno = $("#id_invoice").val();
  if (new_invoiceno != $("#id_invoice").data('invoice_no')) {
    geturl = baseUrl + "invoices/check_invoice_validty/" + new_invoiceno;
    getIrnId = getRemote(geturl);
    if (getIrnId == 0) { $('.feeter').show().html('<span class="text-danger">Invoice No Exist</span>'); return; }
  }
  $('.col_rgenirn').hide();
  $('.col_conrgenirn').show();
});

$(document).on("click", ".exitrgenirn", function () {
  $('.col_rgenirn').show();
  $('.col_conrgenirn').hide();
});

$(document).on("click", ".initecanirn", function () {
  $('.col_ecanirn').hide();
  $('.col_conecanirn').show();
});

$(document).on("click", ".exitecanirn", function () {
  $('.col_ecanirn').show();
  $('.col_conecanirn').hide();
});

$(document).on("click", ".sublist", function () {
  $('.feeter, .col_invid, .col_crednote, .col_invcpy, .col_genirn, .col_rgenirn, .col_ecanirn, .col_conrgenirn, .col_conecanirn').hide();
  var inv_id = $(this).parent("tr").data("href");
  var customer = $(this).parent("tr").data("customer");
  var po_no = $(this).parent("tr").data("po_no");
  var invoice = $(this).parent("tr").data("invoice");
  var o_date = $(this).parent("tr").data("date");
  $("#id_modelcustomer").text(customer);
  $("#id_modelinvoice_no").text(invoice);
  $("#id_modelpo_order").text(po_no);
  $("#id_modeldate").text(o_date);
  $('.invcpy').attr('href', baseUrl + "invoices/geninv/" + inv_id)
  $('.col_invcpy').show();

  // Get IRN List
  var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnByInvoice/" + inv_id);
  $('.genirn, .rgenirn').data('href', baseUrl + "invoices/postEinvoiceRequest/" + inv_id).data('inv_id', inv_id);
  $('.ecanirn').data('href', baseUrl + "invoiceirn/cancelIrnByInvoice/" + inv_id);
  if (!getInvIrn) {
    $("#id_invoice").val(invoice).attr('placeholder', invoice).data('invoice_no', invoice);
    $('.col_genirn').show();
  } else {
    if (getInvIrn[0]['status'] == "0") {
      $("#id_invoice").val('').attr('placeholder', getInvIrn[0]['invoice_no']).data('invoice_no', getInvIrn[0]['invoice_no']);
      var ack_date = new Date(getInvIrn[0]['ack_date']);
      var today = new Date();
      $('.col_rgenirn, .col_invid').show();
      if (diff_hours(today, ack_date) > 24) { $('.col_crednote').show(); }
    } else { $('.col_ecanirn').show(); }
  }
});

$(document).on("click", ".rgenirn", function () {
  var new_invoiceno = $("#id_invoice").val();
  var new_creditnote = $("#id_crednote").val();
  if (new_invoiceno == "") { $('.feeter').show().html('<span class="text-danger">Invoice No Mandatory<span>'); return; }
  $('.col_rgenirn, .col_invid, .col_crednote, .col_conrgenirn').hide();
  $('.feeter').show().html('<b>Please wait <span class="text-primary dot"></span></b>');
  pleasewait(10);
  var getIrnId, geturl = $(this).data('href') + "/" + new_invoiceno;
  getIrnId = getRemote(geturl);
  if (getIrnId['Status'] == "0") {
    $('.feeter').show().text(getIrnId['ErrorDetails'][0]['ErrorMessage']);
    $('.col_rgenirn').show();
  } else {
    if (new_creditnote) { updatecredit = getRemote(baseUrl + "invoices/check_invoice_validty/" + inv_id + "/" + new_creditnote); }
    var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnById/" + getIrnId);
    if (getInvIrn) { $('.col_genirn, .col_invid, .col_crednote').hide(); $('.col_ecanirn').show(); }
    else { $('.col_genirn').show(); }
    $('.feeter').show().text('');
  }
});

$(document).on("click", ".genirn", function () {
  var getIrnId;
  $('.col_genirn, .col_invid, .col_crednote').hide();
  $('.feeter').show().html('<b>Please wait <span class="text-primary dot"></span></b>');
  pleasewait(10);
  var geturl = $(this).data('href');
  getIrnId = getRemote(geturl);
  if (getIrnId['Status'] == "0") {
    $('.feeter').show().text(getIrnId['ErrorDetails'][0]['ErrorMessage']);
    $('.col_genirn').show();
  } else {
    var getInvIrn = getRemote(baseUrl + "invoiceirn/getIrnById/" + getIrnId);
    if (getInvIrn) { $('.col_genirn, .col_invid, .col_crednote').hide(); $('.col_ecanirn').show(); }
    else { $('.col_genirn').show(); }
    $('.feeter').hide().text('');
  }
});

$(document).on("click", ".ecanirn", function () {
  $('.col_ecanirn, .col_invid, .col_crednote').hide();
  $('.feeter').show().html('<b>Please wait <span class="text-primary dot"></span></b>');
  pleasewait(10);
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
    $('.col_ecanirn').show();
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
