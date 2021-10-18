$(function () {
	$.validator.setDefaults({
	  submitHandler: function (form) {
		form.submit();
	  },
	});
	$("#quickForm").validate({
	  rules: {
		email: {
		  required: true,
		},
		password: {
		  required: true,
		},
	  },
	  messages: {
		email: {
		  required: "Email mandatory.",
		},
		password: {
		  required: "Password Mandatory.",
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
