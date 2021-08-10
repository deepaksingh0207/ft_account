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
      searching: true,
    });
  $("#example1_wrapper").children("div:first-child").attr("id", "yoyo");
  $("#yoyo")
    .children("div:first-child")
    .append(
      '<a href="'+currenturl+'/create" class="btn btn-default mb-2">Add New Customer</a>'
    );
});
$(".sublist").click(function () {
  var parent_id = $(this).parent("tr").attr("data-href");
  window.location = parent_id;
});
$(".statement").click(function () {
  var parent_id = $(this).parent("td").attr("data-href");
  window.location = parent_id;
});
$(".trash").click(function () {
  var a = $(this).attr("id");
  $("#trashid").val(a);
  $("#modelactivate").click();
  // $("#list").hide();
  // $("#trash").show();
});
$(".list").click(function () {
  // $("#trash").hide();
  // $("#list").show();
});
