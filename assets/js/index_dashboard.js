$(function () {
    $("#example1")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      ordering: false,
      searching: false,
    });
    $(".odd").css("background-color","transparent");
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        diff = diffy(getMonth(duedate.split(" ")[2]) + "/" + duedate.split(" ")[1] + "/" + duedate.split(" ")[3])
        console.log(duedate);
        if (diff[2] == ''){
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '">' + diff[1] + '</span>');
        } else {
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '"><i class="fas fa-caret-' + diff[2] + '"></i> ' + diff[1] + '</span>');
        }
    });
    $('.odd').hover(function () {
        $(this).css('background-color', 'lightblue');
      }, function () {
        $(this).css('background-color', 'transparent');
      });
      $('.even').hover(function () {
        $(this).css('background-color', 'lightblue');
      }, function () {
        $(this).css('background-color', 'transparent');
      });
});

$(".sublist").click(function () {
    var parent_id = $(this).parent("tr").attr("data-href");
    window.location = parent_id;
  });

function appendcode(val) {
    if (val < 0) {
        val *= -1
        val = ['danger', val + ' Days ago', 'down']
        return val
    } else if (val > 0) {
        if (val > 7) {
            val = ['success', val + ' Days', 'up']
            return val
        } else {
            val = ['warning', val + ' Days', 'up']
            return val
        }
    } else {
        val = ['warning', 'Today', '']
        return val
    }
}

function getMonth(mon) { return new Date(Date.parse(mon + " 1, 2012")).getMonth() + 1 }

function diffy(secondDate) {
    var today = new Date();
    var endDay = new Date(secondDate);
    var millisBetween = endDay.getTime() - today.getTime();
    var days = millisBetween / (1000 * 3600 * 24);
    console.log(days);
    return appendcode(Math.round(days));
}