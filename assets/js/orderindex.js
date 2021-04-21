$(function () {
  $("#example1").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    paging: true,
    ordering: false,
    searching: false,
  });
});

$(document).ready(function(){
	function fill_datatable (period='', start='', end='', customer=''){
		var dataTable = $('#example1').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
				url : "fetch.php",
				type : "POST",
				data : {
					period : '',
					start : '',
					end : '',
					customer : ''
				}
			}
		})
	}
});