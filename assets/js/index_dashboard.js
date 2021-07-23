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
    $(".odd").css("background-color", "transparent");
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        diff = appendcode(datediff(getMonth(duedate.split(" ")[2]) + "/" + duedate.split(" ")[1] + "/" + duedate.split(" ")[3]));
        console.log(duedate);
        $("#due" + value).empty();
        if (diff[2] == '') {
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '">' + diff[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + diff[0] + '">' + duedate + '</span>');
        } else {
            $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '"><i class="fas fa-caret-' + diff[2] + '"></i> ' + diff[1] + '</span>');
            $("#due" + value).append('<span class="description-percentage text-' + diff[0] + '">' + duedate + '</span>');
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
    val = parseInt(val)
    if (val > 24) {
        if (val > 168) {
            val = ['success', parseInt(val / 24) + ' Days', 'up']
            return val
        } else {
            val = ['warning', parseInt(val / 24) + ' Days', 'up']
            return val
        }
    }
    else if (val < -48) {
        val = ['danger', parseInt((val * -1) / 24) + ' Days ago', 'down']
        return val
    }
    else if (0 < val) {
        val = ['warning', 'Tomorrow', 'down']
        return val
    }
    else if (val < -24) {
        val = ['danger', 'Yesterday', 'down']
        return val
    }
    else {
        val = ['warning', 'Today', '']
        return val
    }
}

function getMonth(mon) { return new Date(Date.parse(mon + " 1, 2012")).getMonth() + 1 }

function datediff(fromdate) {
    // Return value in Hrs.
    return (new Date(fromdate).getTime() - new Date().getTime()) / 3600000;
}