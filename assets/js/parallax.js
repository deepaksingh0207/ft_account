var width = $(document).width();
var height = $(document).height();
image =
  "url(https://source.unsplash.com/random/" +
  width +
  "x" +
  height +
  "/?content_filter=high&count=1&orientation=landscape)";
$(document).ready(function () {
  $("#parallax").css("background-image", image);
});
