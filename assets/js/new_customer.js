$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      form.submit();
    },
  });
  $("#quickForm").validate({
    rules: {
      customername: {
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
      shipby: {
        required: true,
      },
      invoicethru: {
        required: true,
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
      addinfo: {
        required: true,
      },
      // active: {
      //   required: true,
      // },
      // shippingaddress: {
      //   required: true,
      // },
      // exlutax: {
      //   required: true,
      // },
      // paymentterms: {
      //   required: true,
      // },
      // salesperson: {
      //   required: true,
      // },
      // customernotes: {
      //   required: true,
      // },
      // customergroup: {
      //   required: true,
      // },
    },
    messages: {
      customername: {
        required: "Please enter customer name.",
      },
      contactperson: {
        required: "Please enter contact person.",
      },
      contactfirstname: {
        required: "Please enter contact firstname.",
      },
      address: {
        required: "Please enter the address.",
      },
      gst: {
        required: "Please enter VAT registration number.",
      },
      pphone: {
        required: "Please enter primary contact.",
      },
      sphone: {
        required: "Please enter secondary contact.",
      },
      shippingaddress: {
        required: "Please enter shipping address.",
      },
      fax: {
        required: "Please enter fax number.",
      },
      email: {
        required: "Please enter the email.",
      },
      addinfo: {
        required: "Please enter additional information.",
      },
      // active: {
      //   required: "Please select to activate user.",
      // },
      // invoicethru: {
      //   required: "Select sent invoice method.",
      // },
      // exlutax: {
      //   required: "Select to exclude tax.",
      // },
      // paymentterms: {
      //   required: "Select payment term.",
      // },
      // salesperson: {
      //   required: "Select sales person.",
      // },
      // customernotes: {
      //   required: "Enter customer note.",
      // },
      // customergroup: {
      //   required: "Select a group.",
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
  // window.stepper = new Stepper(document.querySelector(".bs-stepper"));
});

$(".fc").change(function () {
  var count = 0;
  $(".fc").each(function () {
    var value = $(this).val();
    // console.log($(this).attr('name'));
	// console.log(value);
    if (value.length == 0) {
      count += 1;
    }
  });
  // console.log(count);
  if (count < 1) {
    // $(".vip").show();
    $(".vip").removeAttr("disabled")
  } else {
    // $(".vip").hide();
    $(".vip").attr("disabled", true);
  }
});

$("#pphone_id").on("keypress", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$("#sphone_id").on("keypress", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$("#fax_id").on("keypress", function (event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});