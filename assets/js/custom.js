var DEBUG = true;

$('.select2').select2()

$('[data-toggle="tooltip"]').tooltip()

$(document).on("keyup", ".capitalize", function () {
  $(this).val($(this).val().replace(/\S*/g, function (word) { return word.charAt(0) + word.slice(1).toLowerCase(); }))
});

function humanamount(val) {
  return ra(val);
}

function ra(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}

function dlog() {
  if (DEBUG) {
    for (var i = 0; i < arguments.length; i++) {
      console.log(arguments[i]);
    }
  }
}

function plog() {
  for (var i = 0; i < arguments.length; i++) {
    console.log(arguments[i]);
  }
}

$(document).ready(function() {
  $("#copyright_year").text(new Date().getFullYear());
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
