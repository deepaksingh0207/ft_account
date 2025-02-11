
let symbol = '';
$(document).ready(function () {
    $('#select-all').on('change', function () {
        const checked = $(this).is(':checked');
        $('#preview_tbody .item-checkbox').prop('checked', checked);
        updateCalculations()
    });

    $(document).on('change', '.item-checkbox', function () {
        const allChecked = $('#preview_tbody .item-checkbox:checked').length === $('#preview_tbody .item-checkbox').length;
        $('#select-all').prop('checked', allChecked);
        updateCalculations();

    });

    function setheader(index) {
        list = ["", "Month", "Payment Slab", "Qty.", "Qty.", "Qty", "Qty"]
        list[99] = "Qty."
        return list[index]
    }

    $(document).on("click", ".sublist", function () {
        invoice_id = $(this).closest("tr").data("href");

        $.ajax({
            url: baseUrl + "creditnotes/getInvoiceItems/" + invoice_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {

                if (response.status) {
                    const items = response.data;
                    let hasValidQty = items.some(item => parseInt(item.qty) > 0);
                    // console.log("Quantities:", hasValidQty);
                    if (!hasValidQty) {
                        $('.initgencbn').hide();
                    } else {
                        $('.initgencbn').show();
                    }
                }

            }
        });
    });


    // Initiate Credit Note generation
    $('.initgencbn').on('click', function () {
        $('#t1').show();
        $('#t2').hide();
        $('#generate_credit').hide();
        $('#backToEditing').hide();
        $('#togglepdf').show();
        $('#preview_tbody').empty();
        $('#modal-lg').modal('hide');

        $.ajax({
            url: baseUrl + "creditnotes/getInvoiceItems/" + invoice_id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                $('#preview_tbody').empty();
                if (response.status) {
                    const items = response.data;
                    order_type = items[0].order_type;
                    $("#setheader_creditnote").text(setheader(order_type));
                    customerid = items[0].customer_id;
                    symbol = items[0].symbol || '';
                    let rows = '';
                    items.forEach(function (item, index) {
                        //  console.log(item);
                        const row = `
                            <tr data-existing-qty="${item.qty}" data-uom-id="${item.uom_id}" data-uom-title="${item.uom_title}" data-order-id="${item.order_id}" data-order-item-id="${item.order_item_id}" data-id="${item.id}"  data-order-payterm-id="${item.order_payterm_id}" data-order-type-id="${item.order_type}">
                            
                                <td><input type="checkbox" class="item-checkbox" data-index="${index}"></td>
                                <td>${item.item}
                                </td>
                                <td><input type="text" class="form-control desp" value="${item.description}" name="invoice_details[${index}][description]" readonly></td>
                                <td class="minmax150"><input type="number" class="form-control qty" data-max="${item.qty}" value="${item.qty}" name="invoice_details[${index}][qty]" required></td>
                                <td class="pt-3">${item.uom_title}</td>
                                <td><input type="number" class="form-control pup unit-price" style="width: 10rem;" value="${item.unit_price}" name="invoice_details[${index}][unit_price]" required readonly></td>
                                <td>
                                    <select class="form-control" style="width:15vw;" name="invoice_details[${index}][hsn_code]" readonly>
                                        <option value="${item.hsn_id}" selected>${item.hsn_code} - ${item.hsn_description}</option>
                                    </select>
                                </td>
                                <td class="item-total">${symbol}${item.total}
                                
                                </td>   
                            </tr>`;
                        rows += row;
                    });

                    $('#preview_tbody').html(rows);
                    $('#preview_tbody').on('input', '.qty, .unit-price', function () {
                        validateQty();
                        updateCalculations();
                    });

                    items.forEach(function (item) {
                        $('#invoiceNo').text(item.invoice_no);
                    });
                    updateTotals(customerid);
                }
            },

        });

        $('#modal-xl').modal('show');

        // Reset checkboxes when modal is closed
        $('#modal-xl').on('hidden.bs.modal', function () {
            $('#preview_tbody .item-checkbox').prop('checked', false);
            $('#select-all').prop('checked', false);
        });
    });

    function updateCalculations() {
        let subtotal = 0;
        $('#preview_tbody tr').each(function () {
            const checkbox = $(this).find('.item-checkbox');
            if (checkbox.is(':checked')) {
                const qty = parseFloat($(this).find('.qty').val()) || 0;
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const uom_id = $(this).data('uom-id');
                let total = 0;

                if (uom_id == 1 || uom_id == 2 || uom_id == 4) { // Day, Nos, PC
                    total = qty * unitPrice;
                } else if (uom_id == 3) { // Percentage
                    total = (qty * unitPrice) / 100;
                }

                $(this).find('.item-total').text(symbol + total.toFixed(2));
                subtotal += total;
            }
            updateTotals(customerid);
        });
    }


    function updateTotals(customerid, igstRate, cgstRate, sgstRate) {
        // AJAX request to fetch tax rates
        $.ajax({
            type: "POST",
            url: baseUrl + "creditnotes/getTaxesRate/" + customerid,
            dataType: "json",
            encode: true,
        })
            .done(function (resp) {
                var data = resp.data;
                // console.log(data);
                const state = data.state;
                const gstStatus = data.gst;

                igstRate = data.igst;
                cgstRate = data.cgst;
                sgstRate = data.sgst;
                let subtotal = 0;

                // Calculate subtotal for checked items only
                $('#preview_tbody tr').each(function () {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        subtotal += parseFloat($(this).find('.item-total').text().replace(symbol, '')) || 0;
                    }
                });

                const igst = subtotal * (igstRate / 100);
                const cgst = subtotal * (cgstRate / 100);
                const sgst = subtotal * (sgstRate / 100);
                let total;
                if (gstStatus == 'foreign_country') {
                    total = subtotal;
                    $('.Igst').hide();
                    $('.SCgst').hide();
                    // Only show subtotal and total
                    $('#preview_subtotal_txt').text(symbol + subtotal.toFixed(2));
                    $('#preview_total_val').text(symbol + total.toFixed(2));
                    $('#previewinvoice_total').val(total.toFixed(2));
                    $('#preview_credit_total').val(total.toFixed(2));
                } else {
                    if (state == 'same') {
                        total = subtotal + cgst + sgst;
                        $('.SCgst').show();
                        $('.Igst').hide();
                        $('#preview_cgst_val').text(symbol + cgst.toFixed(2));
                        $('#preview_sgst_val').text(symbol + sgst.toFixed(2));
                        $('#preview_subtotal_txt').text(symbol + subtotal.toFixed(2));
                        $('#preview_total_val').text(symbol + total.toFixed(2));
                        $('#previewinvoice_total').val(total.toFixed(2));
                        $('#preview_credit_total').val(total.toFixed(2));
                    } else {
                        total = subtotal + igst;
                        $('.Igst').show();
                        $('.SCgst').hide();
                        $('#preview_igst_val').text(symbol + igst.toFixed(2));

                        $('#preview_subtotal_txt').text(symbol + subtotal.toFixed(2));
                        $('#preview_total_val').text(symbol + total.toFixed(0));
                        $('#previewinvoice_total').val(total.toFixed(0));
                        $('#preview_credit_total').val(total.toFixed(0));
                    }

                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("No tax details found.");
                console.log(jqXHR, textStatus, errorThrown);
            });
    }

    $(document).on('change', '.item-checkbox', function () {
        updateCalculations();
    });

    function validateQty() {
        $('#preview_tbody .qty').each(function () {
            const maxQty = parseFloat($(this).data('max'));
            const currentQty = parseFloat($(this).val());

            if (currentQty > maxQty) {
                $(this).val(maxQty);
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    }

    $('#togglepdf').on('click', function () {
        let isValid = validateForm();
        if (isValid) {
            let credit_no = $('#id_credit_no').val();
            $.ajax({
                type: "POST",
                url: baseUrl + "creditnotes/credit_note_validty/",
                data: { credit_no: credit_no },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $("#id_credit_no-error").remove();
                        $("#id_credit_no").addClass("is-invalid");
                        $("#credit_no_error").text("Credit No exists").show();
                    } else {
                        // Collect form data and generate credit note
                        let formData = collectFormData();

                        $.ajax({
                            url: baseUrl + "creditnotes/gencbn/",
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                $('#t1').hide();
                                $('#t2').show();
                                $('#togglepdf').hide();
                                $('#generate_credit').show();
                                $('#backToEditing').show();
                                $('#t2').html(response);
                            }
                        });
                    }
                }
            });
        }
    });

    $('#backToEditing').on('click', function () {
        $('#t1').show();
        $('#t2').hide();
        $('#togglepdf').show();
        $('#generate_credit').hide();
        $('#backToEditing').hide();
    });


    $('#generate_credit').off('click').on('click', function () {
        let formData = collectFormData();

        $.ajax({
            url: baseUrl + "creditnotes/saveCreditNote/",
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {

                    alert('Credit note generated successfully!');

                    // window.location.href = baseUrl + 'creditnotes/index';

                } else {
                    alert('Failed to generate credit note: ' + response.message);

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occurred: ' + textStatus);
            }
        });
    });
 
    function collectFormData() {
        const formData = {
            invoice_details: [],
            credit_note_total: $('#preview_credit_total').val(),
            credit_no: $('#id_credit_no').val(),
            credit_note_date: $('#id_creditnote_date').val(),
            igst: $('#preview_igst_val').text().replace(symbol, '').trim(),
            cgst: $('#preview_cgst_val').text().replace(symbol, '').trim(),
            sgst: $('#preview_sgst_val').text().replace(symbol, '').trim(),
        };

        $('#preview_tbody tr').each(function () {
            const checkbox = $(this).find('.item-checkbox');
            if (checkbox.is(':checked')) {
                // const orderTypeId = $(this).data('order-type-id'); 
                const orderPaytermId = $(this).data('order-payterm-id');
                const data = {
                    invoice_id: invoice_id,
                    order_id: $(this).data('order-id'),
                    order_item_id: $(this).data('order-item-id'),
                    id: $(this).data('id'),
                    item: $(this).find('td:nth-child(2)').text().trim(),
                    description: $(this).find('input[name$="[description]"]').val(),
                    qty: $(this).find('input[name$="[qty]"]').val(),
                    unit_price: $(this).find('input[name$="[unit_price]"]').val(),
                    hsn_code: $(this).find('select[name$="[hsn_code]"]').val(),
                    total: $(this).find('.item-total').text().replace(symbol, '').trim(),
                    // sgst: $('#preview_sgst_val').text().replace('₹', '').trim(),
                    credit_note_total: $('#preview_credit_total').val(),
                    order_type: $(this).data('order-type-id'),
                    uom_id: $(this).data('uom-id'),

                };

                
                formData.invoice_details.push(data);
            }
        });
        return formData;
    }

    // Validate the form before submission
    function validateForm() {
        let isValid = true;
        let credit_no = $('#id_credit_no').val();
        let creditNoteDate = $("#id_creditnote_date").val();
        let checkboxChecked = $('#preview_tbody .item-checkbox:checked').length > 0;
        if (!creditNoteDate) {
            $("#id_creditnote_date").addClass("is-invalid");
            isValid = false;
        } else {
            $("#id_creditnote_date").removeClass("is-invalid");
        }

        if (!credit_no) {
            $("#id_credit_no").addClass("is-invalid");
            // $("#credit_no_error").text("Please enter credit no").show();
            isValid = false;
        } else if (!/^\d{7}$/.test(credit_no)) {
            $("#id_credit_no").addClass("is-invalid");
            $("#credit_no_error").text("Only 7 digits are allowed").show();
            isValid = false;
        } else {
            $("#id_credit_no").removeClass("is-invalid");
            $("#credit_no_error").hide();
        }

        if (!checkboxChecked) {

            alert("Please select at least one item.");
            isValid = false;
        }

        return isValid;
    }
});



