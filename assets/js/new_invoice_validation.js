$(function () {
  $("#id_invoicedate").val(today);
  $(".select2").select2();
  $.validator.setDefaults({
    submitHandler: function () {
      $("#responsemodal").click(); //Activating Modal

    },
  });
  $("#quickForm").validate({
    rules: {
      group_id: {
        required: true,
      },
      customer_id: {
        required: true,
      },
      order_id: {
        required: true,
      },
      invoice_date: {
        required: true,
        date: true,
      },
      due_date: {
        required: true,
        date: true,
      },
      po_no: {
        required: true,
      },
      sales_person: {
        required: true,
      },
      bill_to: {
        required: true,
      },
      ship_to: {
        required: true,
      },
    },
    messages: {
      group_id: {
        required: "Please select customer group.",
      },
      customer_id: {
        required: "Please select this customer.",
      },
      order_id: {
        required: "Please select the order number.",
      },
      invoice_date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      due_date: {
        required: "Please select a date.",
        date: "Value must be a date.",
      },
      pay_days: {
        required: "Please enter days count.",
      },
      po_no: {
        required: "Please enter Customer PO.",
      },
      sales_person: {
        required: "Please provide a salesperson.",
        tel: "Invalid Detail.",
      },
      bill_to: {
        required: "Please provide a bill to address.",
        tel: "Invalid Detail.",
      },
      ship_to: {
        required: "Please provide ship to address.",
        tel: "Invalid Detail.",
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