$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click();
    },
  });
  $("#id_quickForm").validate({
    rules: {
      name: {
        required: true,
      },
      contact_person: {
        required: true,
      },
      contact: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      fax: {
        required: true,
        minlength: 9,
        maxlength: 15,
      },
      email: {
        required: true,
        email: true,
      },
      pan: {
        required: true,
      },
      sac: {
        required: true,
      },
      gstin: {
        required: true,
        minlength: 15,
        maxlength: 15,
      },
      pincode: {
        required: true,
        minlength: 6,
        maxlength: 6,
      },
      address: {
        required: true,
      },
      state: {
        required: true,
      },
      bank_name: {
        required: true,
      },
      account_no: {
        required: true,
      },
      isfc_code: {
        required: true,
      },
    },
    messages: {
      name: {
        required: "Please enter company name.",
      },
      contact_person: {
        required: "Please enter the contact person's name.",
      },
      contact: {
        required: "Please enter primary contact.",
      },
      mobile: {
        required: "Please enter secondary contact.",
      },
      fax: {
        required: "Please enter fax number.",
      },
      email: {
        required: "Please enter the email.",
      },
      pan: {
        required: "Please enter the PAN details.",
      },
      sac: {
        required: "Please enter the SAC details.",
      },
      gstin: {
        required: "Please enter the GST details.",
      },
      pincode: {
        required: "Please enter correct pincode.",
      },
      address: {
        required: "Please enter the address.",
      },
      state: {
        required: "Please enter a state from the list.",
      },
      bank_name: {
        required: "Please enter bank name.",
      },
      account_no: {
        required: "Please enter account number.",
      },
      isfc_code: {
        required: "Please enter the ISFC code.",
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
  var id_companyname = $("#id_companyname").val();
  var id_contactperson = $("#id_contactperson").val();
  var id_contact = $("#id_contact").val();
  var id_mobile = $("#id_mobile").val();
  var id_fax = $("#id_fax").val();
  var id_email = $("#id_email").val();
  var id_pan = $("#id_pan").val();
  var id_sac = $("#id_sac").val();
  var id_gst = $("#id_gst").val();
  var id_pincode = $("#id_pincode").val();
  var id_address = $("#id_address").val();
  var id_state = $("#id_state").val();
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

$("#id_companyname").change(function () {
  if ($("#id_companyname").val() != id_companyname) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_contactperson").change(function () {
  if ($("#id_contactperson").val() != id_contactperson) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_contact").change(function () {
  if ($("#id_contact").val() != id_contact) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_mobile").change(function () {
  if ($("#id_mobile").val() != id_mobile) {
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

$("#id_pan").change(function () {
  if ($("#id_pan").val() != id_pan) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_sac").change(function () {
  if ($("#id_sac").val() != id_sac) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_gst").change(function () {
  if ($("#id_gst").val() != id_gst) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_pincode").change(function () {
  if ($("#id_pincode").val() != id_pincode) {
    $(".vip").removeAttr("disabled");
  }
});

$("#id_address").change(function () {
  if ($("#id_address").val() != id_address) {
    $(".vip").removeAttr("disabled");
  }
});

$("#state_id").change(function () {
  if ($("#state_id").val() != state_id) {
    $(".vip").removeAttr("disabled");
  }
});
