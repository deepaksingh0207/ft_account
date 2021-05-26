$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      form.submit();
    },
  });
  $("#id_quickForm").validate({
    rules: {
      companyname: {
        required: true,
      },
      contact_person: {
        required: true,
      },
      pphone: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      sphone: {
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
        minlength: 10,
        maxlength: 10,
      },
	  sac: {
        required: true,
        minlength: 6,
        maxlength: 6,
      },
	  gst: {
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
    },
    messages: {
      companyname: {
        required: "Please enter customer name.",
      },
      contact_person: {
        required: "Please enter contact person.",
      },
      pphone: {
        required: "Please enter primary contact.",
      },
      sphone: {
        required: "Please enter secondary contact.",
      },
      fax: {
        required: "Please enter fax number.",
      },
	  email: {
        required: "Please enter the email.",
      },
	  pan: {
        required: "Please enter the correct PAN number.",
      },
	  sac: {
        required: "Please enter the correct SAC number.",
      }, 
	  gst: {
        required: "Please enter the correct GSTIN number.",
      },
	  pincode: {
        required: "Please enter the correct Pincode area.",
      },
      address: {
        required: "Please enter the address.",
      },
	  state: {
        required: "Please select a state.",
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
  var id_customername = $("#id_customername").val();
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
