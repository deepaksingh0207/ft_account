var DEBUG = true;

$('.select2').select2()

$('[data-toggle="tooltip"]').tooltip()

$(document).on("keyup", ".capitalize", function () {
  $(this).val($(this).val().replace(/\S*/g, function (word) { return word.charAt(0) + word.slice(1).toLowerCase(); }))
});

function humanamount(val) {
  return ra(val);
}

function ra(val, foreign = false) {
  if (foreign) {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD'
    }).format(val);
  } else {
    return new Intl.NumberFormat('en-IN', {
      style: 'currency',
      currency: 'INR'
    }).format(val);
  }
}

$(document).ready(function () {
  $("#copyright_year").text(new Date().getFullYear());
  $(window).keydown(function (event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

function firstcap(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
