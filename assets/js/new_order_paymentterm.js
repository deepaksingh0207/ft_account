var ptlist = [];


// On hovering Address column
$(document).on("click", "#add_pt", function () {
  if (ptlist.length == 0) {
    projecttablebody(lastid);
  } else {
    var lastid = ptlist[ptlist.length - 1];
    lastid++;
    projecttablebody(lastid);
  }
});
