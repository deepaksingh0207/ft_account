var currentdomain = window.location.origin;
var currenturl    = window.location.href;
var currentpath   = window.location.pathname;

$(function () {
  $("#example1")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      ordering: false,
      searching: false,
    });
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