var dtable

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
      $(row).addClass('pointer').attr('data-href', data[0]).children('td').addClass('sublist');
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
  var inv_id = $(this).parent("tr").data("href");
  var link = document.createElement("a");
  link.href = baseUrl + "invoices/geninv/" + inv_id;
  link.target = "_blank";
  link.click();
});

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
