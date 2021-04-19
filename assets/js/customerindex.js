includeHTML();
$("#example1")
  .DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    paging: true,
    ordering: false,
    searching: true,
  })
  .buttons()
  .container()
  .appendTo("#example1_wrapper .col-md-6:eq(0)");
$("#example1_wrapper").children("div:first-child").attr("id", "yoyo");
$("#yoyo")
  .children("div:first-child")
  .append(
    '<a href="<?php echo ROOT ?>/customers" class="btn btn-primary vip">Add New Customer</a>'
  );
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
  $("#list").hide();
  $("#trash").show();
});
$(".list").click(function () {
  $("#trash").hide();
  $("#list").show();
});
