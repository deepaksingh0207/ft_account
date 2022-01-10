var dtable

function fill_datatable(appliedfilter = {}) {
  $('#example1 thead th').each(function () {
    var col_list = ["Date", "Salesperson","Amount"]
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
      $(row).addClass('pointer').attr('data-href', data[2]).children('td').addClass('sublist');
    },
    "ajax": {
      url: baseUrl + "invoices/search/",
      type: "POST",
      data: appliedfilter
    }
  });
  $('#example1_filter').hide();
}

$(document).on("click", ".sublist", function () {
  url = baseUrl + 'pdf/invoice_' + $(this).parent("tr").data("href") + '.pdf'
  error = '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>'
  $.get(url)
    .done(function (responseText) {
      a = responseText
      if (a.search("Customer List") < 0) {
        $("#modal_body").empty().append('<embed src="' + url + '" type="application/pdf" style="width: 100%; height: 513px;">');
      } else {
        $("#modal_body").empty().append(error);
      }
    }).fail(function () {
      $("#modal_body").empty().append(error);
    });
  // $("#modal_body").empty().append('<iframe src="'+url+'" width="100%" height="513px">');
  $("#modelpdf").click();
});

// $("#id_period").on("change", function () {
//   if ($(this).val() == "2") {
//     $("#id_startdate").removeAttr("disabled");
//     $("#id_enddate").removeAttr("disabled");
//   } else {
//     $("#id_startdate").attr("disabled", "true");
//     $("#id_enddate").attr("disabled", "true");
//   }
//   $("#id_startdate").val("");
//   $("#id_enddate").val("");
// });

$("#id_startdate").on("change", function () {
  $("#id_enddate").attr('min', $(this).val());
});

$(".update").on("click", function () {
  var f = {};
  if ($("#id_startdate").val()) {
    f.startdate = $("#id_startdate").val()
  }
  if ($("#id_enddate").val()) {
    f.enddate = $("#id_enddate").val()
  }
  if ($("#id_customer").val()) {
    f.customer_id = $("#id_customer").val()
  }
  dtable.destroy();
  fill_datatable(f);
});

$(function () {
  $(".select2").select2();
  fill_datatable();
});

// https://www.youtube.com/watch?v=M0cEiFAzwf0
