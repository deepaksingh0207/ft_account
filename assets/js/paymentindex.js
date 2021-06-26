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