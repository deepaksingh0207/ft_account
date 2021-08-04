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
	valy = $(this).data("name");
	id = $(this).data("id");
	$("#id_group_id").val(valy);
	$("#update").attr("formaction", baseUrl + "customergroups/update/" + id);
	$("#add").hide();
	$("#update").show();
});

$(".customer").on("click", function () {
	if ($(this).data("id")) {
		$.ajax({
			type: "POST",
			url: baseUrl + "customers/groupcustomers/" + $(this).data("id"),
			data: $(this).data("id"),
			dataType: "json",
			encode: true,
		})
			.done(function (data) {
				$("#customerbody").empty();
				if (data != false){
					$.each(data, function (i, value) {
						$("#customerbody").append('<tr><td><a href="' + baseUrl + 'customers/view/' + value.id + '">' + value.name + '</a></td></tr>');
					});
				} else {
					$("#customerbody").append('<tr><td>No Customer.</td></tr>');
				}				
			})
			.fail(function (jqXHR, textStatus, errorThrown) {
				alert("No details found against this customer.");
			});
	}
	$("#modelactivate").trigger("click");
});

$("#cancel").on("click", function () {
	$("#add").show();
	$("#update").hide();
});