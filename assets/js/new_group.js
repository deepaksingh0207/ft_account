var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';

$(function () {
	$("#example1").DataTable({
		responsive: false,
		lengthChange: false,
		autoWidth: true,
		paging: true,
		ordering: false,
		searching: false,
	  });
	$("#id_quickForm").validate({
		rules: {
			name: {
				required: true,
			},
		},
		messages: {
			name: {
				required: "Select a customer group.",
			},
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		},
	});
});

$(".groupy").on("click", function () {
	valy = $(this).children("td.name").text();
	id = $(this).children("td.id").text();
	$("#id_group_id").val(valy);
	$("#update").attr("formaction", baseUrl + "customergroups/update/" + id);
	$("#add").hide();
	$("#update").show();
});

$("#cancel").on("click", function () {
	$("#add").show();
	$("#update").hide();
});