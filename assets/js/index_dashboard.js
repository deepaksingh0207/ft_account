$(function () {
    $.each(invoicelist, function (index, value) {
        duedate = $("#due" + value).text();
        diff = diffy(getMonth(duedate.split(" ")[1])+"/"+duedate.split(" ")[0].split(",")[0]+"/"+duedate.split(" ")[2])

        console.log(diff);
        // $("#age"+value).text();
    });
});

function appendcode(val){
    if (val < 0){
        
    } else if (val > 0) {

    } else {

    }
}

function getMonth(mon){return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1}

function diffy(secondDate){  
    var today = new Date();
    var endDay = new Date(secondDate);
    var millisBetween = today.getTime() - endDay.getTime();
    var days = millisBetween / (1000 * 3600 * 24);
    return Math.round(Math.abs(days));  
}  