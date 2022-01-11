$(function () {
    $('.get_uom_display').each(function(i, obj) {
        $(this).text(uom(parseInt($(this).text())));
    });
});

function uom(i) {
    return ["", "AU", "Percentage (%)", "AU", "Day(s)", "", "", ""][i];
}

$(document).on("click", ".ordertoggle", function () {
	$(".order").toggle();
	if ($("#id_order").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_order").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_order").attr('class', 'fas fa-chevron-down mt-1');
	}
});