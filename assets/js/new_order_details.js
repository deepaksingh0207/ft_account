var customergroup_data, prehigh;

// On Customer Group Change
$("#id_group_id").change(function () {
  var customergroupid = $(this).val();
  if (customergroupid) {
    $.ajax({
      type: "POST",
      url: baseUrl + "customers/groupcustomers/" + customergroupid,
      data: customergroupid,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
        resetongroup();
        customergroup_data = data
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        alert("Data not found for this customer group.");
      });
  } else {
    resetongroup();
  }
});


// BillTo Button Click
$("#id_search_billto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("billto", "Bill To Address")
});


// ShipTo Button Click
$("#id_search_shipto").on("click", function () {
  //Generates customer data modal and activates class="fill_customer_details" on customer select
  modelfill("shipto", "Ship To Address")
});


// Updates Ship To and (Bill To data along with customer details)
$(document).on("click", ".fill_customer_details", function () {
  highlightrow($(this).data('index'));
  if ($(this).data('modal') == "billto") {
    $("#id_bill_to").val($(this).data('id')).removeClass("is-invalid");
    $("#id_bill_to-error").remove();
    $("#id_customer_id").val($(this).data('id'));
    $("#id_customertext").text($(this).data('name'));
    getcustomerdetails($(this).data('id'));
  } else {
    $("#id_ship_to").val($(this).data('id')).removeClass("is-invalid");
    $("#id_ship_to-error").remove();
  }
});


function resetongroup() {
  customergroup_data = "";
  resetonbillto()
  $("#id_customertext").text("");
  // $("#id_po_no").val("");
  // $("#comment_id").val("");
}

function resetonbillto(){
  $("#salesperson_id").val("");
  $("#id_bill_to").val("");
  $("#id_ship_to").val("");
}


// Address Model Creator Function
function modelfill(checkboxclass, label) {
  $("#modal_title").text(label);
  $("#addhead").empty();
  $("#addbody").empty();
  $(".addmodelfooter").hide();
  if (customergroup_data) {
    $("#addhead").append('<table class="table table-hover" style="border: 1px solid lightgrey;"><thead><th></th><th>Code</th><th>Name</th><th>Address</th></thead><tbody id="addbody"></tbody></table>');
    $.each(customergroup_data, function (index, row) {
      $("#addbody").append("<tr id='row_" + index + "' ></tr>");
      $("#row_" + index)
        .append("<td id='col_1_" + index + "'><div class='icheck-primary d-inline'><input type='radio' id='checkbox" + index + "' name='id_customer' class='fill_customer_details' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' ><label for='checkbox" + row.id + "'></label></div></td>")
        .append("<td class='fill_customer_details' id='col_2_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.id + "</td>")
        .append("<td class='fill_customer_details' id='col_3_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' >" + row.name + "</td>")
        .append("<td class='fill_customer_details' id='col_4_" + index + "' data-index='" + index + "' data-id='" + row.id + "' data-name='" + row.name + "' data-address='" + row.address + "' data-modal='" + checkboxclass + "' style='width: 455px'>" + row.address + "</td>");
    });
    $(".addmodelfooter").show();
  }
  else {
    $("#addhead").append('No Records');
  }
}

function highlightrow(id) {
  $("#row" + prehigh).css('background-color', 'inherit');
  prehigh = id
  $("#checkbox" + id).prop('checked', true);
  $("#row" + id).css('background-color', 'powderblue');
}