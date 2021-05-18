(function () {
  const elem = document.querySelector("#parallax");
  var width = $('#parallax').width();
  var height = $('#parallax').height();
  $("#parallax").css("background-image", "url(https://source.unsplash.com/random/"+ width + "x" + height + "/?content_filter=high&count=1&orientation=landscape" );
})();

(function () {
  document.addEventListener("mousemove", parallax);
  const elem = document.querySelector("#parallax");
  image = getimage()
  elem.css('background-image', image)
  function parallax(e) {
    let _w = window.innerWidth / 2;
    let _h = window.innerHeight / 2;
    let _mouseX = e.clientX;
    let _mouseY = e.clientY;
    let _depth1 = `${50 - (_mouseX - _w) * 0.01}% ${
      50 - (_mouseY - _h) * 0.01
    }%`;
    let _depth2 = `${50 - (_mouseX - _w) * 0.02}% ${
      50 - (_mouseY - _h) * 0.02
    }%`;
    let _depth3 = `${50 - (_mouseX - _w) * 0.06}% ${
      50 - (_mouseY - _h) * 0.06
    }%`;
    let x = `${_depth3}, ${_depth2}, ${_depth1}`;
    console.log(x);
    elem.style.backgroundPosition = x;
  }
})();
