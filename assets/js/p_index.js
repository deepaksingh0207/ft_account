var currentdomain = window.location.origin;
var currenturl    = window.location.href;
var currentpath   = window.location.pathname;

$(function () {
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
    "bLengthChange": false,
    "pageLength": 10,
    "order": [],
    "searching": true
  });
  $('#example1_filter').hide();
});
$(".sublist").click(function () {
  var parent_id = $(this).parent("tr").attr("data-href");
  window.location = parent_id;
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
//   start1 = "";
//   end1 = "";
// });

$(".update").on("click", function () {
  period = $("#id_period").val()
  start = $("#id_startdate").val()
  end = $("#id_enddate").val()
  customer = $("#id_customer").val()
  fill_datatable(period, start, end, customer);
});

// https://www.youtube.com/watch?v=M0cEiFAzwf0

function fill_datatable(period="", start="", end="", customer="") {
  var dtable = $("#example1").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "searching": false,
    "ajax": {
      url: "",
      type: "",
      data: {
        period: period, start:start, end:end, customer:customer
      }
    }
  });
}