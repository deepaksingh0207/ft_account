$(function () {
	$('.select2').select2();
	$('#state_id').val("1");
	$('#select2-state_id-container').text("Andaman and Nicobar Islands");
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
			currency: { 
				required: true,

			  },
			  state: {
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
			currency: { 
				required: "Please select a currency.",
			  },
			  state: {
				required: "Please select a state.", 
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
});

$(".fc").change(function () {
	var count = 0;
	$(".fc").each(function () {
		var value = $(this).val();
		if (value.length == 0) {
			count += 1;
		}
	});
	if (count < 1) {
		$(".vip").removeAttr("disabled");
	} else {
		$(".vip").attr("disabled", true);
	}
});

$(".pan").on("keyup", function (event) {
	$(this).val($(this).val().toUpperCase());
});

$(".gst").on("keyup", function (event) {
	$(this).val($(this).val().toUpperCase());
});

$(".numberonly").on("keypress", function (event) {
	var regex = new RegExp("^[0-9]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

$("#id_email").on("change", function () {
	$(this).val($(this).val().toLowerCase());
});

$(".alphaonly").on("keypress", function (event) {
	var regex = new RegExp("^[A-Za-z ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

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


  

