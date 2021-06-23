var baseUrl = window.location.origin + '/ft_account/';

$(function () {
	$.validator.setDefaults({
		submitHandler: function () {
			$("#responsemodal").click();
		},
	});
	$("#id_quickForm").validate({
		rules: {
			group_id: {
				required: true,
			},
		},
		messages: {
			group_id: {
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
	$("#add").attr("formaction", baseUrl + "add/");
});

$(".groupy").hover(
	function () {
		$(this).css('background-color', 'powderblue');
	}, function () {
		$(this).css('background-color', 'white');
	}
);

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