$(function () {
	$('.select2').select2()
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
			name: {
				required: true,
			},
			// contact_person: {
			// 	required: true,
			// },
			// address: {
			// 	required: true,
			// },
			// pincode: {
			// 	required: true,
			// 	minlength: 6,
			// 	maxlength: 6,
			// },
			// state: {
			// 	required: true,
			// },
			// pan: {
			// 	required: true,
			// },
			// gstin: {
			// 	required: true,
			// },
			// pphone: {
			// 	required: true,
			// 	minlength: 8,
			// 	maxlength: 10,
			// },
			// aphone: {
			// 	required: false,
			// 	minlength: 8,
			// 	maxlength: 10,
			// },
			// fax: {
			// 	required: false,
			// 	minlength: 9,
			// 	maxlength: 15,
			// },
			// email: {
			// 	required: true,
			// },
			// remark: {
			// 	required: true,
			// },
			// managername: {
			// 	required: true,
			// },
			// manageremail: {
			// 	required: true,
			// },
			// managerphone: {
			// 	required: true,
			// },
		},
		messages: {
			group_id: {
				required: "Select a customer group.",
			},
			name: {
				required: "Please enter customer name.",
			},
			// contact_person: {
			// 	required: "Please enter contact person.",
			// },
			// address: {
			// 	required: "Please enter address.",
			// },
			// pincode: {
			// 	required: "Please enter pincode.",
			// },
			// state: {
			// 	required: "Select a State.",
			// },
			// pan: {
			// 	required: "Invalid format.",
			// },
			// gstin: {
			// 	required: "Invalid format.",
			// },
			// pphone: {
			// 	required: "Please enter primary contact.",
			// },
			// aphone: {
			// 	required: "Please enter secondary contact",
			// },
			// fax: {
			// 	required: "Invalid format.",
			// },
			// email: {
			// 	required: "Please enter an email.",
			// },
			// remark: {
			// 	required: "Please enter additonal info.",
			// },
			// managername: {
			// 	required: "Please enter IT Manager name.",
			// },
			// manageremail: {
			// 	required: "Please enter IT Manager email.",
			// },
			// managerphone: {
			// 	required: "Please enter IT Manager contact.",
			// },
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
	var id_customername = $("#id_customername").val();
	var id_customergroup = $("#id_customergroup").val();
	var id_contactperson = $("#id_contactperson").val();
	var id_address = $("#id_address").val();
	var pincode_id = $("#pincode_id").val();
	var state_id = $("#state_id").val();
	var id_gst = $("#id_gst").val();
	var id_pphone = $("#id_pphone").val();
	var id_sphone = $("#id_sphone").val();
	var id_fax = $("#id_fax").val();
	var id_email = $("#id_email").val();
	var id_addinfo = $("#id_addinfo").val();
	var id_pan = $("#id_pan").val();
	var id_managername = $("#id_managername").val();
	var id_manageremail = $("#id_manageremail").val();
	var id_managerphone = $("#id_managerphone").val();

});

$(".pan").on("keypress", function (event) {
	$(this).val($(this).val().toUpperCase());
	var regex = new RegExp("^[A-Z]{5}[0-9]{4}[A-Z]{1}+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

$("#id_managername").change(function () {
	if ($("#id_managername").val() != id_managername) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_manageremail").change(function () {
	if ($("#id_manageremail").val() != id_manageremail) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_managerphone").change(function () {
	if ($("#id_managerphone").val() != id_managerphone) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_customergroup").change(function () {
	if ($("#id_customergroup").val() != id_customergroup) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_customername").change(function () {
	if ($("#id_customername").val() != id_customername) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_contactperson").change(function () {
	if ($("#id_contactperson").val() != id_contactperson) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_address").change(function () {
	if ($("#id_address").val() != id_address) {
		$(".vip").removeAttr("disabled");
	}
});

$("#pincode_id").change(function () {
	if ($("#pincode_id").val() != pincode_id) {
		$(".vip").removeAttr("disabled");
	}
});

$("#state_id").change(function () {
	if ($("#state_id").val() != state_id) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_gst").change(function () {
	if ($("#id_gst").val() != id_gst) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_pphone").change(function () {
	if ($("#id_pphone").val() != id_pphone) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_sphone").change(function () {
	if ($("#id_sphone").val() != id_sphone) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_fax").change(function () {
	if ($("#id_fax").val() != id_fax) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_email").change(function () {
	if ($("#id_email").val() != id_email) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_addinfo").change(function () {
	if ($("#id_addinfo").val() != id_addinfo) {
		$(".vip").removeAttr("disabled");
	}
});

$("#id_pan").change(function () {
	if ($("#id_pan").val() != id_pan) {
		$(".vip").removeAttr("disabled");
	}
});

// --------country-----------

$(document).ready(function () {
	$('#country_id').change(function () {
		var countryId = $(this).val();
		var countryCode = $(this).find('option:selected').data('code');
		$('#cnt_code').val(countryCode);
		if (countryId) {
			$.ajax({
				url: baseUrl + "customers/getStatesByCountry",
				type: 'POST',
				data: { country_id: countryId },
				success: function (data) {
					var states = JSON.parse(data);
					$('#state_id').empty();
					$('#state_id').append('<option value="">Select State</option>');

					$.each(states, function (index, state) {
						$('#state_id').append('<option value="' + state.id + '">' + state.name + '</option>');
					});

					if (states.length == 0) {
						$('#state_id').append('<option value="">No states available</option>');
					}
				}
			});
		} else {
			$('#state_id').empty();
			$('#state_id').append('<option value="">Select State</option>');
		}
	});

	$('#country_id').trigger('change');
});
