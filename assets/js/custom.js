$(document).ready(function () {
  $('.odd').hover(function () {
    $(this).css('background-color', 'lightblue');
  }, function () {
    $(this).css('background-color', '#f2f2f2');
  });
  $('.even').hover(function () {
    $(this).css('background-color', 'lightblue');
  }, function () {
    $(this).css('background-color', 'transparent');
  });
});

// respmsg("Update Successfully") #Success message
// respmsg("Update Failed", false) #false for error flag and true for success(by default value true)
// respmsg("Update Successfully", true, false)  #false for hiding the message (by default value true))

function respmsg(body = "", status = true, show = true) {
  if (status == true) {
    if (show == true) {
      $("#respsuccess").show();
    } else {
      $("#respsuccess").hide();
    }
    $("#respsuccess").append(body);
  } else {
    if (show == true) {
      $("#resperror").show();
    } else {
      $("#resperror").hide();
    }
    $("#resperror").append(body);
  }
}
