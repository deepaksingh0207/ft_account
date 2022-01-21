$(function () {
  $("#example").DataTable({
    initComplete: function () {
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
    "responsive": false, "lengthChange": false, "autoWidth": false, "ordering": false,
    "buttons": ["excel"]
  }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
});