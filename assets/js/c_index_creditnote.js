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

    creditNoteItemId = $(this).find('.hidden-item-id').data('id');
    creditNoteId = $(this).find('.hidden-item-id').data('credit_note_id');

    $('.generatecbn').data('href', baseUrl + "invoices/postCreditNoteRequest/" + creditNoteId);
    var getCrnIrn = getRemote(baseUrl + "invoiceirn/getIrnByInvoice/" + creditNoteId);
    // console.log('Credit Note ID:', creditNoteId);
    // console.log('Credit Note Item ID:', creditNoteItemId);
    $('#creditNoteModal').modal('show');
    $('.cbncpy').hide();
  });
  // Reset modal content when it is closed
  $('#creditNoteModal').on('hidden.bs.modal', function () {
    $('.generatecbn').html('<i class="fas fa-file-invoice fa-lg"></i><br><br>Generate IRN');
    $('.feeterr').hide().text('');
  });

  $('.generatecbn').on('click', function () {
    var $btn = $(this);
    $btn.html('<img src="' + baseUrl + 'assets/img/load.gif" alt="Loading" width="30px" class="mb-2"><br>Generate E-Invoice');
    var getUrl = $btn.data('href');
    var getirnId = getRemote(getUrl);

    if (getirnId['Status'] == "0") { 
       $('.feeterr').show().text(getirnId['ErrorDetails'][0]['ErrorMessage']);
    } else {
      alert('Credit IRN generated successfully!');
      $('.generatecbn').html('<i class="fas fa-file-invoice fa-lg"></i><br><br>Generate IRN');
      // $('.cbncpy').show();
    }


  });
});