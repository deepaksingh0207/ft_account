$(document).on("keyup", ".capitalize", function () {
  $(this).val($(this).val().replace(/\S*/g, function (word) {return word.charAt(0) + word.slice(1).toLowerCase();}))
});

function humanamount(val) {
  var val = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(val);
  return val
}