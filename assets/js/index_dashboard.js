$(function () {
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        diff = diffy(getMonth(duedate.split(" ")[1]) + "/" + duedate.split(" ")[0].split(",")[0] + "/" + duedate.split(" ")[2])
        console.log(diff);
        $("#age" + value).append('<span class="description-percentage text-' + diff[0] + '"><i class="fas fa-caret-up"></i>' + diff[1] + '</span>');
    });
});

function appendcode(val) {
    if (val < 0) {
        val *= -1
        val = ['danger', val + ' Days ago']
        return val
    } else if (val > 0) {
        if (val > 7) {
            val = ['success', val + ' Days']
            return val
        } else {
            val = ['warning', val + ' Days']
            return val
        }
    } else {
        val = ['warning', 'Today']
        return val
    }
}

function getMonth(mon) { return new Date(Date.parse(mon + " 1, 2012")).getMonth() + 1 }

function diffy(secondDate) {
    var today = new Date();
    var endDay = new Date(secondDate);
    var millisBetween = today.getTime() - endDay.getTime();
    var days = millisBetween / (1000 * 3600 * 24);
    return appendcode(Math.round(Math.abs(days)));
}