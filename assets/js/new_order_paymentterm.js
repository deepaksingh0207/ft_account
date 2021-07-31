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

// Each Payment Term calculator
function paymentTermcollector(id) {
  if ($("#id_ptquantity" + id).val()) {
    $("#id_ptquantity" + id).data('val', $("#id_ptquantity" + id).val());
  } else {
    $("#id_ptquantity" + id).data('val', 0);
  }
  if ($("#id_ptunitprice" + id).val()) {
    $("#id_ptunitprice" + id).data('val', $("#id_ptunitprice" + id).val());
  } else {
    $("#id_ptunitprice" + id).data('val', 0);
  }
  rowqty = $("#id_ptquantity" + id).data('val');
  rowunitprice = $("#id_ptunitprice" + id).data('val');
  subtotal = 0;
  if (rowqty && rowunitprice) {
    if (oti == 1) {
      subtotal = rowunitprice * rowqty;
    } else {
      subtotal = rowunitprice * (rowqty / 100);
    }
    $("#pttotal" + id).val(subtotal);
    $("#id_pttotal" + id).text(parseFloat(subtotal).toFixed(2));
    pttotal();
  }
}

// All Payment Term Total calculator
function pttotal() {
  var days = 0, total = 0.0;
  if (ptlist != "") {
    $.each(ptlist, function (index, value) {
      qty = parseInt($("#id_ptquantity" + value).data('val'));
      subtotal = parseInt($("#pttotal" + value).data('val'));
      days += qty;
      total += subtotal;
    });
    $("#id_pttotaldays").val(days);
    $("#id_pttotal").val(total);
    $("#totalday").text(days);
    $("#pttotalvalue").text(humanamount(total));
  }
}


$(document).on("input propertychange paste", '#id_quantity1', function () {
  if (oti < 3) {
    ptlist = []
    $("#id_project").empty();
    projectdiv()
    $("#id_projectsummary").empty();
    $("#add_pt").hide();
    for (i = 0; i < $(this).val(); i++) {
      if (oti == 1) {
        projecttablebody((i + 1), 1, uom = 'AU', true);
      } else {
        projecttablebody(i + 1);
      }
    }
  }
});

function resetPaymentTermForm() {
  $("#id_project").empty();
  $("#id_projectsummary").empty();
}

function projectdiv() {
  $("#id_project").append('<table class="table text-center mt-5" id="projectable"></table>');
  $("#projectable").append('<thead><tr id="projecttableheader"></tr></thead>')
    .append('<tbody id="projecttablebody"></tbody>');
  $("#projecttableheader").append('<th class="min100">Item</th>')
    .append('<th class="min100">Payment Term</th>')
    .append('<th class="minmax150">Payment Percent</th>')
    .append('<th class="minmax150">UOM</th>')
    .append('<th class="min100">Unit Price</th>')
    .append('<th class="min100">Total</th>');
  // $("#projecttableheader").append('<th class="min100">Delete</th>');
  $("#id_projectsummary").append('<hr class="mt-0"> <div class="row" id="ptsummary"> <div class="col-10 mb-2">    <button type="button" id="add_pt" class="btn btn-primary btn-sm">Add Payment Terms</button></div> <div class="col-2 mb-2">      <div class="row"> <div class="col-12 text-left"> <input type="hidden" name="pttotaldays" id="id_pttotaldays"  value="0"><b>Qty. : &nbsp; &nbsp; &nbsp; &nbsp;</b><span id="totalday">0</span></div> <div class="col-12 text-left" id="pttotaldiv"> <input type="hidden" name="ptsubtotal" id="id_pttotal" value="0.0" /><b>Total : &nbsp; &nbsp; &nbsp;</b><span id="pttotalvalue">0.00</span></div> </div> </div> </div>');
}

function projecttablebody(id, val = "", uom = "Percentage (%)", check = false) {
  $("#projecttablebody").append("<tr id='pt" + id + "'></tr>");
  $("#pt" + id).append("<td class='form-group'><input type='text' class='form-control item capitalize' name='ptitem[]' data-id='" + id + "' id='id_ptitem" + id + "' placeholder='*Enter Item' /></td>")
    .append("<td class='form-group'><input type='text' class='form-control desp capitalize' data-id='" + id + "' name='paymentterm[]' id='id_paymentterm" + id + "' placeholder='*Enter Description' /></td>")
    .append("<td class='form-group max150'><input type='number' class='form-control qty'  value='" + val + "' data-id='" + id + "' name='ptqty[]' id='id_ptquantity" + id + "' max='100' min='5' step='5' onkeypress='return event.charCode >= 48 && event.charCode <= 57' /></td>")
    .append('<td class="pt-3">' + uom + '</td>')
    .append("<td class='form-group max150'><input type='number' class='form-control unitprice' name='ptunit_price[]' value='' data-id='" + id + "' id='id_ptunitprice" + id + "' /></td>")
    .append("<td class='form-group'><input type='hidden' class='form-control rowtotal' value='' name='pttotal[]' data-id='" + id + "' data-val='0' id='pttotal" + id + "' ><span id='id_pttotal" + id + "' >₹0.00</span></td>");
  // .append('<td><i class="fas fa-minus-circle trash" style="color: red" ></i></td>');
  ptlist.push(id);
  if (check) { $("#id_ptquantity" + id).attr("readonly", true); }
  $("#id_ptunitprice" + id).val($("#id_unitprice1").val()).attr("readonly", true);
}
