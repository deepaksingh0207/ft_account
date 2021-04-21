$(function () {
  var a = [w, x, y, z];
  $.each(a, function (index, value) {
    $(value).DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      ordering: false,
      searching: false,
    });
  });
});

$(document).ready(function () {
  fill_datatable();
});

var period1, period2, period3, period4;
var start1, start2, start3, start4;
var end1, end2, end3, end4;
var customer1, customer2, customer3, customer4;
var mylink1
var mylink2
var mylink3
var mylink4

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

$("#id_period2").on("change", function () {
  var period2 = $("#id_period2").val();
  if ($(this).val() == "2") {
    $("#id_startdate2").attr("disabled", "true");
    $("#id_enddate2").attr("disabled", "true");
  } else {
    $("#id_startdate2").removeAttr("disabled");
    start2 = "";
    $("#id_enddate2").removeAttr("disabled");
    end2 = "";
  }
});

$("#id_startdate2").on("change", function () {
  start2 = $("#id_startdate2").val();
});

$("#id_enddate2").on("change", function () {
  end2 = $("#id_enddate2").val();
});

$("#id_customer2").on("change", function () {
  customer2 = $("#id_customer2").val();
});

$("#id_period3").on("change", function () {
  var period3 = $("#id_period3").val();
  if ($(this).val() == "2") {
    $("#id_startdate3").attr("disabled", "true");
    $("#id_enddate3").attr("disabled", "true");
  } else {
    $("#id_startdate3").removeAttr("disabled");
    start3 = "";
    $("#id_enddate3").removeAttr("disabled");
    end3 = "";
  }
});

$("#id_startdate3").on("change", function () {
  start3 = $("#id_startdate3").val();
});

$("#id_enddate3").on("change", function () {
  end3 = $("#id_enddate3").val();
});

$("#id_customer3").on("change", function () {
  customer3 = $("#id_customer3").val();
});

$("#id_period4").on("change", function () {
  var period4 = $("#id_period4").val();
  if ($(this).val() == "2") {
    $("#id_startdate4").attr("disabled", "true");
    $("#id_enddate4").attr("disabled", "true");
  } else {
    $("#id_startdate4").removeAttr("disabled");
    start4 = "";
    $("#id_enddate4").removeAttr("disabled");
    end4 = "";
  }
});

$("#id_startdate4").on("change", function () {
  start4 = $("#id_startdate4").val();
});

$("#id_enddate4").on("change", function () {
  end4 = $("#id_enddate4").val();
});

$("#id_customer4").on("change", function () {
  customer4 = $("#id_customer4").val();
});

$(".update").on("click", function () {
  if ($(this).attr("id") == 1) {
    $("#w").DataTable().destroy();
    fill_datatable( "w",mylink1, period1, start1, end1, customer1);
  } else if ($(this).attr("id") == 2) {
    $("#x").DataTable().destroy();
    fill_datatable( "x",mylink2, period2, start2, end2, customer2);
  } else if ($(this).attr("id") == 3) {
    $("#y").DataTable().destroy();
    fill_datatable( "y",mylink3, period3, start3, end3, customer3);
  } else {
    $("#z").DataTable().destroy();
    fill_datatable( "z",mylink4, period4, start4, end4, customer4);
  }
});

function fill_datatable(updatetable, mylink ,period = "", start = "", end = "", customer = "") {
  var dataTable = $("#"+updatetable).DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: mylink,
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

// Link Response of table w, x, y 
// {"draw":1,"recordsTotal":36,"recordsFiltered":2,"data":[["Sean Wong","Male","Rua Vito Bovino, 240","Sao Paulo-SP","04677-002","Brazil"],["Pedro Afonso","Male","Av. dos Lusiadas, 23","Sao Paulo","05432-043","Brazil"]]}