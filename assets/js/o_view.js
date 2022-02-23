$(document).ready(function () {
	$(".hide").hide();
	$("#attach").prepend($("#attach").data("href").split("/")[1]);
});

$(document).on("click", ".attach", function () {
	url = baseUrl + $(this).data("href")
	error = '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>'
	$.get(url)
		.done(function (responseText) {
			a = responseText
			if (a.search("Customer List") < 0) {
				$("#modal_body").empty().append('<embed src="' + url + '" type="application/pdf" style="width: 100%; height: 513px;">');
			} else {
				$("#modal_body").empty().append(error);
			}
		}).fail(function () {
			$("#modal_body").empty().append(error);
		});
	// $("#modal_body").empty().append('<iframe src="'+url+'" width="100%" height="513px">');
	$("#modelpdf").click();
});

$(document).on("click", ".summarytoggle", function () {
	$(".summary").toggle();
	if ($("#id_summary").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_summary").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_summary").attr('class', 'fas fa-chevron-down mt-1');
	}
});

$(document).on("click", ".ordertoggle", function () {
	$(".order").toggle();
	if ($("#id_order").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_order").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_order").attr('class', 'fas fa-chevron-down mt-1');
	}
});

$(document).on("click", ".paytermtoggle", function () {
	$(".payterm").toggle();
	if ($("#id_payterm").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_payterm").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_payterm").attr('class', 'fas fa-chevron-down mt-1');
	}
});

$(document).on("click", ".invdtlstoggle", function () {
	$(".invdetail").toggle();
	if ($("#id_invdtls").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_invdtls").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_invdtls").attr('class', 'fas fa-chevron-down mt-1');
	}
});

$(document).on("click", ".paydtlstoggle", function () {
	$(".paydetail").toggle();
	if ($("#id_paydtls").attr('class') == "fas fa-chevron-down mt-1") {
		$("#id_paydtls").attr('class', 'fas fa-chevron-right mt-1');
	} else {
		$("#id_paydtls").attr('class', 'fas fa-chevron-down mt-1');
	}
});