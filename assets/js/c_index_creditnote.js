$(document).ready(function () {
  var table = $('#example3').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "createdRow": function (row, data, dataIndex) {
      $(row).addClass('pointer')
        .attr('data-toggle', 'modal')
        .attr('data-target', '#creditNoteModal')
        .attr('data-item', data[3])
        .children('tr').addClass('list');
    }
  });

  $('#example3 tbody').on('click', '.list', function () {

    $('.feeterr').text('');
    creditNoteItemId = $(this).find('.hidden-item-id').data('id');
    creditNoteId = $(this).find('.hidden-item-id').data('credit_note_id');

    $('.generatecbn').data('href', baseUrl + "invoices/postCreditNoteRequest/" + creditNoteId);
    var getCreditIrnDetails = getRemote(baseUrl + "invoiceirn/getIrnByCreditNote/" + creditNoteId);


    if (!getCreditIrnDetails || getCreditIrnDetails.length == 0) {
      $('.generatecbn').show();
      // $('.col_cbncopy').html('');
      creditNoteLink = '<a class="btn btn-info btn-block btn-flat py-3 " target="_blank" href="' + baseUrl + 'invoices/gencbn/' + creditNoteId + '" >Print Credit Notes</a>';
      $('.col_cbncopy').html(creditNoteLink);
    } else if (getCreditIrnDetails[0].status == 1 && getCreditIrnDetails[0].irn_no !== "") {
      // $('.generatecbn').hide();
      $('.generatecbn').prop('disabled', true);
      creditNoteLink = '<a class="btn btn-info btn-block btn-flat py-3" target="_blank" href="' + baseUrl + 'invoices/gencbn/' + creditNoteId + '" >' +
        '<i class="far fa-file-pdf fa-lg"></i> <br><br> Print Credit Note' +
        '</a>';

      $('.col_cbncopy').html(creditNoteLink);

    } else {
      $('.generatecbn').show();

    }


    $('#creditNoteModal').modal('show');

  });

  $('.generatecbn').on('click', function () {
    var getUrl = $(this).data('href');

    $('#loader').show();

    setTimeout(function () {
      var getirnId = getRemote(getUrl);
      $('#loader').hide();

      if (getirnId['Status'] == "0") {
        $('.feeterr').show().text(getirnId['ErrorDetails'][0]['ErrorMessage']);
      } else {
        alert('Credit IRN generated successfully!');
        $('.generatecbn').prop('disabled', true);
        creditNoteLink = '<a class="btn btn-info btn-block btn-flat py-3" target="_blank" href="' + baseUrl + 'invoices/gencbn/' + creditNoteId + '" >' +
          '<i class="far fa-file-pdf fa-lg"></i> <br><br> Print Credit Note' +
          '</a>';

        $('.col_cbncopy').html(creditNoteLink);
      }
    }, 1000);
  });


});