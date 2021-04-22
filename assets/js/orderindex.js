$(function () {
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "paging": true,
    "ordering": false,
    "searching": false,
  });
});

// var baseUrl = 'http://google.co.in'

$(".sublist").click(function () {
	var parent_id = $(this).parent("tr").attr("data-href");
	window.location = parent_id;
});

var period1, start1, end1, customer1;

$("#id_period1").on("change", function () {
  var period1 = $("#id_period1").val();
  if ($(this).val() == "2") {
    $("#id_startdate1").attr("disabled", "true");
    $("#id_enddate1").attr("disabled", "true");
  } else {
    $("#id_startdate1").removeAttr("disabled");
    start1 = "";
    $("#id_enddate1").removeAttr("disabled");
    end1 = "";
  }
});

$("#id_startdate1").on("change", function () {
  start1 = $("#id_startdate1").val();
});

$("#id_enddate1").on("change", function () {
  end1 = $("#id_enddate1").val();
});

$("#id_customer1").on("change", function () {
  customer1 = $("#id_customer1").val();
});

$(".update").on("click", function () {
  if ($(this).attr("id") == 1) {
    $("#w").DataTable().destroy();
    fill_datatable(period1, start1, end1, customer1);
  }
  
});

$(".edit").on("click", function () {
  var editlink = "/order/" + $(this).parent().parent("tr").attr("id");
  window.location = editlink;
});

$(".pdf").on("click", function () {
  var pdflink = "/order/pdf/" + $(this).parent().parent("tr").attr("id");
  window.location = pdflink;
});

$(".print").on("click", function () {
  var printlink = "/order/print/" + $(this).parent().parent("tr").attr("id");
  window.location = printlink;
});

var deletemodel;
$(".delete").on("click", function () {
  deletemodel = $(this).parent().parent("tr").attr("id");
  $("#modelactivate").click();
});

$("#modaldelete").on("click", function () {
  $.ajax({
    type: "POST",
    url: baseUrl + "incidents/app/",
    data: deletemodel,
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      $("#" + deletemodel).remove();
      $("#byemodal").click();
      toastr.success(data.message);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      toastr.warning("Delete Action Failed. Please try again.");
      $("#byemodal").click();
    });
});

$(".sublist").click(function () {
  var parent_id = $(this).parent("tr").attr("data-href");
  window.location = parent_id;
});

function fill_datatable(period = "", start = "", end = "", customer = "") {
  var dataTable = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: "mylink",
      type: "POST",
      data: {
        period: period,
        start: start,
        end: end,
        customer: customer,
      },
    },
  });
}

// mylink Response of table w
// response = {
//   draw: 1,
//   recordsTotal: 36,
//   recordsFiltered: 2,
//   data: [
//     [
//       "02/02/2020",
//       "200",
//       "1000",
//       "Balram",
//       "Prashant",
//       "20000",
//       "10001",
//       "<i class='fas fa-pen edit' id='1'></i>",
//       "<i class='far fa-file-pdf pdf' id='1'></i>",
//       "<i class='fas fa-print print' id='1'></i>",
//       "<i class='fas fa-minus-circle delete' id='1'></i>",
//     ],
//     [
//       "02/02/2020",
//       "200",
//       "1000",
//       "Balram",
//       "Prashant",
//       "20000",
//       "10001",
//       "<i class='fas fa-pen edit' id='2'></i>",
//       "<i class='far fa-file-pdf pdf' id='2'></i>",
//       "<i class='fas fa-print print' id='2'></i>",
//       "<i class='fas fa-minus-circle delete' id='2'></i>",
//     ],
//   ],
// };
