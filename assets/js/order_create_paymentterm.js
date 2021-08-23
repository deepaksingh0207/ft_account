var ptlist = [];

function setuom(val) {
  if (val == 1) {
    return 'Day(s)';
  }
  if (val == 2) {
    return 'AU';
  }
  if (val == 3) {
    return 'Percentage (%)';
  }
  if (val == 4) {
    return 'PC';
  }
}

function paymentgenerator() {
  $.each(orderid_list, function (index, id) {
    for (i = 1; i <= $("#id_quantity" + id).val(); i++) {
      paymentTermcollector(id, i)
    }
  });
}


// Each Payment Term calculator
function paymentTermcollector(xid, yid) {
  if ($("#colt" + xid + "id_ptquantity" + yid).val()) {
    $("#colt" + xid + "id_ptquantity" + yid).data('val', $("#colt" + xid + "id_ptquantity" + yid).val());
  } else {
    $("#colt" + xid + "id_ptquantity" + yid).data('val', 0);
  }
  if ($("#colt" + xid + "id_ptunitprice" + yid).val()) {
    $("#colt" + xid + "id_ptunitprice" + yid).data('val', $("#colt" + xid + "id_ptunitprice" + yid).val());
  } else {
    $("#colt" + xid + "id_ptunitprice" + yid).data('val', 0);
  }
  rowqty = $("#id_quantity" + xid).data('val');
  rowunitprice = $("#colt" + xid + "id_ptunitprice" + yid).data('val');
  subtotal = 0;
  if (rowqty && rowunitprice) {
    if (oti == 1) {
      subtotal = rowunitprice / rowqty;
    } else {
      subtotal = rowunitprice;
    }
    $("#colt" + xid + "id_ptunitprice" + yid).val(subtotal);
    $("#colt" + xid + "pttotal" + yid).val(subtotal);
    $("#colt" + xid + "id_pttotal" + yid).text(parseFloat(subtotal).toFixed(2));
  }
}

function resetPaymentTermForm() {
  $(".orderdtl").hide();
  $("#row_paytm").empty();
}


function projecttablebody(body, id, val = "", uom = 3) {
  $("#" + body).append("<tr id='" + body + "pt" + id + "'></tr>");
  // Sr No
  $("#" + body + "pt" + id).append("<td class='form-group'><input type='hidden' class='" + body + "_item' name='ptitem[]' data-id='" + id + "' id='" + body + "id_ptitem" + id + "' />" + id + "</td>");
  // ITEM Field
  if (oti == 2) {
    $("#" + body + "pt" + id).append("<td class='form-group " + body + "_item' ></td>");
  }
  // Description Field
  $("#" + body + "pt" + id).append("<td class='form-group'><input type='text' class='form-control desp capitalize' data-id='" + id + "' name='paymentterm[]' id='" + body + "id_paymentterm" + id + "' placeholder='*Enter Description' /></td>");
  // QTY Field
  if (oti == 1) {
    $("#" + body + "pt" + id).append("<td class='form-group max150'><input type='hidden' class='form-control'  value='" + val + "' data-id='" + id + "' name='ptqty[]' id='" + body + "id_ptquantity" + id + "'><input type='hidden' name='ptuom[]' id'id_ptuom' value='" + uom + "'>1 / AU </td>");
  } else {
    $("#" + body + "pt" + id).append("<div class='input-group mt-2 pt-1'><input type='number' class='form-control ptqty'  value='" + val + "' data-id='" + id + "' name='ptqty[]' id='" + body + "id_ptquantity" + id + "' max='100' min='5' step='5' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /><input type='hidden' name='ptuom[]' id'id_ptuom' value='" + uom + "'><div class='input-group-append'><span class='input-group-text'> % </span></div></div>");
  }
  // UOM, Unit Price & Total Field
  $("#" + body + "pt" + id)
    .append("<td class='form-group max100'><input type='number' class='form-control " + body + "_unitprice' name='ptunit_price[]' value='' data-id='" + id + "' id='" + body + "id_ptunitprice" + id + "' /></td>")
    .append("<td class='form-group'><input type='hidden' class='form-control rowtotal' value='' name='pttotal[]' data-id='" + id + "' data-val='0' id='" + body + "pttotal" + id + "' ><span id='" + body + "id_pttotal" + id + "' >₹0.00</span></td>");
  // .append('<td><i class="fas fa-minus-circle trash" style="color: red" ></i></td>');
  ptlist.push(id);
  $("#" + body + "id_ptunitprice" + id).val($("#id_unitprice" + body.match(/(\d+)/)).val()).attr("readonly", true);
}

$(document).on("change", ".item", function () {
  if (oti < 3) {
    $(".colt" + $(this).data('id') + "_item").text($(this).val())
    $(".colt" + $(this).data('id') + "_item").val($(this).val())
  }
});

$(document).on("change", ".ptqty", function () {
  paymentgenerator()
});