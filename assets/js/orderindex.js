$(function () {
  $(".select2").select2();
  $("#example1").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    paging: true,
    ordering: false,
    searching: false,
  });
});

$(document).on("click", ".sublist", function () {
  var parent_id = $(this).parent("tr").attr("data-href");
  window.location = parent_id;
});

var period1, start1, end1, customer1;

$("#id_period").on("change", function () {
  if ($(this).val() == "2") {
    $("#id_startdate").removeAttr("disabled");
    $("#id_enddate").removeAttr("disabled");
  } else {
    $("#id_startdate").attr("disabled", "true");
    $("#id_enddate").attr("disabled", "true");
  }
  $("#id_startdate").val("");
  $("#id_enddate").val("");
  start1 = "";
  end1 = "";
});

$("#id_startdate").on("change", function () {
  start1 = $("#id_startdate").val();
});

$("#id_enddate").on("change", function () {
  end1 = $("#id_enddate").val();
});

$("#id_customer").on("change", function () {
  customer1 = $("#id_customer").val();
});

var dat = {
  1: {
    date: "sublist",
    order: "dump",
    customer: "sublist",
    sales: "dump",
    amount: "dump",
  },
  2: {
    date: "sublist",
    order: "dump",
    customer: "sublist",
    sales: "dump",
    amount: "dump",
  },
};

var det = [{
    date: "sublist",
    order: "dump",
    customer: "sublist",
    sales: "dump",
    amount: "dump",
  },{
    date: "sublist",
    order: "dump",
    customer: "sublist",
    sales: "dump",
    amount: "dump",
  }]

  columns = ['date','order','customer','sales','amount']

$(".update").on("click", function (det) {
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
