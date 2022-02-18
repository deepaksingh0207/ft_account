$(function () {
    $('#example3').DataTable({
        "buttons": ["excel"],
        rowsGroup: [0,1,2],
        "responsive": true, "lengthChange": false, "autoWidth": true, "ordering": false,
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
});

$(document).on("click", ".ordlist", function () {
    var parent_id = $(this).parent("tr").data('href');
    window.location = baseUrl + 'orders/view/' + parent_id;
});
