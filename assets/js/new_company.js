var baseUrl = window.location.origin + "/ft_account/";

$(function () {
  $(".select2").select2();
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click();
    },
  });
  $("#id_quickForm").validate({
    rules: {
      companyname: {
        required: true,
      },
      contactperson: {
        required: true,
      },
      address: {
        required: true,
      },
      pincode: {
        required: true,
        minlength: 6,
        maxlength: 6,
      },
      state: {
        required: true,
      },
      gst: {
        required: true,
        minlength: 15,
        maxlength: 15,
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
    },
    messages: {
      companyname: {
        required: "Please enter company name.",
      },
      contactperson: {
        required: "Please enter the contact person's name.",
      },
      address: {
        required: "Please enter the address.",
      },
      pincode: {
        required: "Please enter correct pincode.",
      },
      state: {
        required: "Please enter a state from the list.",
      },
      gst: {
        required: "Please enter gstin.",
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
