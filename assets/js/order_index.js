var dtable

function fill_datatable(appliedfilter = {}) {
  dtable = $("#example1").DataTable({
    "processing": true,
    "ordering": false,
    "bLengthChange": false,
    "pageLength": 10,
    "order": [],
    "searching": false,
    "columns": [
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4 },
      { data: 5 }
    ],
    createdRow: function (row, data, dataIndex) {
      $(row).addClass('pointer').attr('data-href', data[0]).children('td').addClass('sublist');
    },
    // "columnDefs": [
    //   { className: 'sublist', targets: "_all" }
    // ],
    "ajax": {
      url: baseUrl + "orders/search/",
      type: "POST",
      data: appliedfilter
    }
  });
}

$("#id_startdate").on("change", function () {
  $("#id_enddate").attr('min', $(this).val());
});

$(document).on("click", ".sublist", function () {
  var parent_id = $(this).parent("tr").data('href');
  window.location = baseUrl + 'orders/view/' + parent_id;
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
