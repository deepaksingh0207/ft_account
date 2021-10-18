$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            checker();
        },
    });
    $("#id_quickForm").validate({
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
        },
        messages: {
            group_id: {
                required: "Please select cutomer group.",
            },
            customer_id: {
                required: "Please select cutomer.",
            },
            order_id: {
                required: "Please select order.",
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
        }
    });
});