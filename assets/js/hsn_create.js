$(function () {
	$("#hsn_tab").addClass("active").attr('href','hsn').attr('role','tab').attr('aria-controls','hsn').attr('aria-selected','true').attr('data-toggle','pill');
	$("#hsn_list").DataTable({
		responsive: false,
		lengthChange: false,
		autoWidth: true,
		paging: true,
		ordering: false,
		searching: true,
	});
	$("#hsn_list_wrapper").children("div:first-child").attr("id", "yoyo");
	$("#yoyo")
		.children("div:first-child")
		.append(
			'<form method="post" id="hsn" class="mb-0"> <div class="row"> <div class="col-sm-12 col-lg-3 form-group"><input type="text" class="form-control form-control-sm ftsm" required="" name="code" placeholder="HSN Code" id="id_hsn_code" /> </div > <div class="col-sm-12 col-lg-5 form-group"><input type="text" placeholder="HSN Description" class="form-control form-control-sm ftsm" required="" name="description" id="id_group_id" /> </div > <div class="col-sm-12 col-lg-2"> <div class="btn-group"> <button type="submit" id="add" class="btn btn-sm btn-default" > Add </button> <button type="submit" id="update" style="display: none" class="btn btn-sm btn-default" > Update </button> <a href="' + baseUrl + 'hsn" id="cancel" class="btn btn-sm btn-default" > Cancel </a> </div> </div> </div > </form > '
		);
	$("#hsn").validate({
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
	valz = $(this).data("code");
	id = $(this).data("id");
	$("#id_group_id").val(valy);
	$("#id_hsn_code").val(valz);
	$("#update").attr("formaction", baseUrl + "hsn/edit/" + id);
	$("#add").hide();
	$("#update").show();
});

$(document).on("click", ".link", function () {
	window.location.href = $(this).data('href');
});

$("#cancel").on("click", function () {
	$("#add").show();
	$("#update").hide();
});