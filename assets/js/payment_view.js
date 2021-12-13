$(document).on("click", ".sublist", function () {
    url = baseUrl + 'utr_file/' + $(this).data("href")
    error = '<div class="error-page"><h2 class="headline text-warning"> 404</h2> <div class="error-content pt-4"> <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Invoice not found.</h3><p>We could not find the invoice you were looking for.</p> </div></div>'
    $.get(url)
        .done(function (responseText) {
            a = responseText
            if (a.search("Customer List") < 0) {
                $("#utr_body").empty().append('<embed src="' + url + '" type="application/pdf" style="width: 100%; height: 513px;">');
            } else {
                $("#utr_body").empty().append(error);
            }
        }).fail(function () {
            $("#utr_body").empty().append(error);
        });
    $("#modelutr").click();
});
