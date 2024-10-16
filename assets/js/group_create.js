$(function () {
	$("#customergroup_tab").addClass("active").attr('href', 'customergroup').attr('role', 'tab').attr('aria-controls', 'customergroup').attr('aria-selected', 'true').attr('data-toggle', 'pill');
	$("#customergroup_list").DataTable({
		responsive: false,
		lengthChange: false,
		autoWidth: true,
		paging: true,
		ordering: false,
		searching: true,
	});
	$("#customergroup_list_wrapper").children("div:first-child").attr("id", "yoyo");
	$("#yoyo")
		.children("div:first-child")
		.append(
			'<form method="post" id="customergroup" class="mb-0"> <div class="row"> <div class="col-sm-12 col-lg-8 form-group"><input type="text" class="form-control form-control-sm ftsm" required="" name="name" id="id_group_id" /> </div > <div class="col-sm-12 col-lg-2"> <div class="btn-group"> <button type="submit" id="add" class="btn btn-sm btn-default" > Add </button> <button type="submit" id="update" style="display: none" class="btn btn-sm btn-default" > Update </button> <a href="' + baseUrl + 'customergroups" id="cancel" class="btn btn-sm btn-default" > Cancel </a> </div> </div> </div > </form > '
		);
	$("#customergroup").validate({
		rules: {
			name: {
				required: true,
			},
		},
		messages: {
			name: {
				required: "Please enter a customer group.",
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
	$("#update").attr("formaction", baseUrl + "customergroups/edit/" + id);
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
			.done(function (resp) {
				data = resp.data;
				$("#customerbody").empty();
				if (data != false) {
					$.each(data, function (i, value) {
						$("#customerbody").append('<tr><td class="link" data-href="' + baseUrl + 'customers/view/' + value.id + '">' + value.name + '</td></tr>');
					});
				} else {
					$("#customerbody").append('<tr><td>No Customer.</td></tr>');
				}
			})
			.fail(function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR, textStatus, errorThrown);
				alert("No details found against this customer.");
			});
	}
	$("#modelactivate").trigger("click");
});

$(document).on("click", ".link", function () {
	window.location.href = $(this).data('href');
});

$("#cancel").on("click", function () {
	$("#add").show();
	$("#update").hide();
});