$(function () {
  $("#example").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": true, "ordering": false,
    "buttons": ["excel"],
    initComplete: function () {
      this.api().columns().every(function () {
        var that = this;
        $('input', this.header()).on('keyup change clear', function () {
          if (that.search() !== this.value) {that.search(this.value).draw();}
        });
      });
    }
  }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
});