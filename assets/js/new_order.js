$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert("Form successful submitted!");
    },
  });
  $("#quickForm").validate({
    rules: {
      customerid: {
        required: true,
        number: true,
      },
      date: {
        required: true,
        date: true,
      },
      quote_number: {
        required: true,
        number: true,
      },
      terms: {
        required: true,
      },
      days: {
        required: true,
        tel: true,
      },
      tracking: {
        required: true,
      },
      customer: {
        required: true,
      },
      salesperson: {
        required: true,
      },
      shipby: {
        required: true,
      },
      tax: {
        required: true,
      },
      bill: {
        required: true,
        textarea: true,
      },
      ship: {
        required: true,
        textarea: true,
      },
      comment: {
        required: true,
        textarea: true,
      },
      pvtcomment: {
        required: true,
        textarea: true,
      },
      pvtcomment: {
        required: true,
        textarea: true,
      },
    },
    messages: {
      customerid: {
        required: "Please enter this detail.",
        number: "Value must be a number.",
      },
      date: {
        required: "Please enter this detail.",
        date: "Value must be a date.",
      },
      quote_number: {
        required: "Please enter this detail.",
        number: "Value must be a number.",
      },
      terms: {
        required: "Please enter this detail.",
      },
      days: {
        required: "Please provide a password",
        tel: "Value must be a number.",
      },
      tracking: {
        required: "Please provide a password",
        tel: "Value must be a number.",
      },
      customer: {
        required: "Please provide a password",
      },
      salesperson: {
        required: "Please select the sales representative.",
      },
      shipby: {
        required: "Please enter this detail.",
      },
      tax: {
        required: "Please select this detail.",
      },
      ship: {
        required: "Please select the bill",
      },
      comment: {
        required: "Please ",
      },
      pvtcomment: {
        required: "Please provide a password",
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
