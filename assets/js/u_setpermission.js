$(document).on("change", ".chek", function () {
  var e = $(this).data("action");
  var c = $(this).data("controller");
  if (e == "edit" || e == "openpo" || e =="renew"){
    if($('#id_' + c + '_'+e).is(':checked')){
      $('#id_' + c + '_create').prop('checked', true);
      $('#id_' + c + '_view').prop('checked', true);
      $('#id_' + c + '_index').prop('checked', true);
    } else{
      $('#id_' + c + '_create').prop('checked', false);
      $('#id_' + c + '_view').prop('checked', false);
      $('#id_' + c + '_index').prop('checked', false);
    }
  } else if (e == "create") {
    if($('#id_' + c + '_'+e).is(':checked')){
      $('#id_' + c + '_view').prop('checked', true);
      $('#id_' + c + '_index').prop('checked', true);
    }else{
      $('#id_' + c + '_view').prop('checked', false);
      $('#id_' + c + '_index').prop('checked', false);
    }
  } else if (e == "view") {
    if($('#id_' + c + '_'+e).is(':checked')){
      $('#id_' + c + '_index').prop('checked', true);
    }else{
      $('#id_' + c + '_index').prop('checked', false);
    }
  }
});