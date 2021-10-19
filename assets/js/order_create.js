var sgst;
var cgst;
var igst;
var l_gst;
var del_ot;
var del_id;
var old_row = 0;
var oti = 0;
var groupId;
var r_groupId;
var group_id;
var r_groupId;
var checked_shipto;
var checked_billto;
var paymentterm_list = [];
var tree = { otl: [] };
var item_id;
var writemode = true;

$("#group_id").change(function () {
  group_id_reset();
  groupId = $(this).val();
  tree[oti][item_id]["utp"] = parseFloat(tree[oti][item_id]["utp"]).toFixed(2);
  tree[oti][item_id]["stl"] = parseFloat(tree[oti][item_id]["stl"]).toFixed(2);
  if (oti < 4) {
    tree[oti][item_id]["uom"] = uom("x");
    if (oti == 1 || oti == 3) {
      tree[oti][item_id]["from"] = $("#from_date").val();
      tree[oti][item_id]["till"] = $("#to_date").val();
    } else {
      tree[oti][item_id]["from"] = "";
      tree[oti][item_id]["till"] = "";
    }
    $.each(paymentterm_list, function (index, pid) {
      if (tree[oti][item_id].hasOwnProperty(pid) == false) {
        tree[oti][item_id][pid] = {};
      }
      if (tree[oti][item_id]["ptl"].includes(pid) == false) {
        tree[oti][item_id]["ptl"].push(pid);
      }
      tree[oti][item_id][pid]["itm"] = $(
        "#orderitem_" + item_id + "_val_1"
      ).val();
      tree[oti][item_id][pid]["dsp"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_3"
      ).val();
      tree[oti][item_id][pid]["qty"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_4"
      ).val();
      tree[oti][item_id][pid]["uom"] = uom("x");
      tree[oti][item_id][pid]["utp"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_5"
      ).val();
      tree[oti][item_id][pid]["stl"] = $(
        "#orderitem_" + item_id + "_paymentterm_" + pid + "_val_6"
      ).val();
    });
  } else {
    if (oti == 4) {
      tree[oti][item_id]["uom"] = "1";
    } else {
      tree[oti][item_id]["uom"] = $("#orderitem_" + item_id + "_val_4").val();
    }
  }
  treecleaner();
  treehouse();
  // ordertype_reset();
  // $("#order_type").val("");
}

function treecleaner() {
  if (tree["otl"].length > 0) {
    $.each(tree["otl"], function (index, val) {
      if (jQuery.isEmptyObject(tree[val])) {
        delete tree[val];
        tree["otl"] = jQuery.grep(tree["otl"], function (b) {
          return b != val;
        });
      } else {
        $.each(tree[val]["oil"], function (index, o_val) {
          if (jQuery.isEmptyObject(tree[val][o_val])) {
            delete tree[val][o_val];
            tree[val]["oil"] = jQuery.grep(tree[val]["oil"], function (b) {
              return b != o_val;
            });
          } else {
            if (tree[val][o_val].hasOwnProperty("ptl")) {
              if (tree[val][o_val]["ptl"].length == 0) {
                delete tree[val][o_val]["ptl"];
              } else {
                $.each(tree[val][o_val]["ptl"], function (index, p_val) {
                  if (jQuery.isEmptyObject(tree[val][o_val][p_val])) {
                    delete tree[val][o_val][p_val];
                    tree[val][o_val]["ptl"] = jQuery.grep(
                      tree[val][o_val]["ptl"],
                      function (b) {
                        return b != p_val;
                      }
                    );
                  }
                });
                if (tree[val][o_val]["ptl"].length == 0) {
                  delete tree[val][o_val]["ptl"];
                }
              }
            }
          }
          if (tree[val]["oil"].length == 0) {
            delete tree[val];
            tree["otl"] = jQuery.grep(tree["otl"], function (b) {
              return b != val;
            });
          }
        });
      }
    });
  }
}

function getot(val) {
  return [
    "",
    "On-Site Support Sale",
    "Project Sale",
    "AMC Support Sale",
    "Man-days-Support Sale",
    "SAP License Sale",
    "Hardware Sale",
  ][val];
}

function treehouse() {
  var subttl = 0.0;
  var sgstttl = 0.0;
  var cgstttl = 0.0;
  var igstttl = 0.0;
  $("#order_items").empty();
  $("#order_items_cardfooter").empty();
  $.each(tree["otl"], function (i, ot) {
    $.each(tree[ot]["oil"], function (j, oi) {
      subttl += parseFloat(tree[ot][oi]["stl"]);
      $("#order_items").append(
        '<tr data-widget="expandable-table" aria-expanded="false" id="parent_' +
          ot +
          "_" +
          oi +
          '"><td><i class="fas fa-caret-right fa-fw"></i>' +
          tree[ot][oi]["itm"] +
          "</td><td>" +
          tree[ot][oi]["dsp"] +
          "</td><td>" +
          getot(ot) +
          "</td><td>" +
          tree[ot][oi]["qty"] +
          "</td><td>" +
          tree[ot][oi]["uom"] +
          "</td><td>" +
          tree[ot][oi]["utp"] +
          "</td><td>" +
          tree[ot][oi]["stl"] +
          '</td><td style="min-width: 8vw;"><div class="card-tools"><button type="button" class="btn btn-sm btn-default myorder mr-1" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-pen text-primary"></i></button><button type="button" class="btn btn-sm btn-default remove_saved_item" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"><i class="fas fa-times text-danger" data-oti="' +
          ot +
          '" data-oii="' +
          oi +
          '"></i></button></div></td></tr>'
      );
      if (ot < 4) {
        $.each(tree[ot][oi]["ptl"], function (k, pt) {
          if (k == 0) {
            $("#order_items").append(
              '<tr class="expandable-body d-none text-center" id="child_' +
                ot +
                "_" +
                oi +
                '"><td colspan="8"><div class="p-0"><table class="table table-hover"><tbody id="' +
                ot +
                "_" +
                oi +
                '"><tr><td style="width: 8rem;">Sr No.</td><td style="width: 22rem;">Description</td><td style="width: 11rem;"> Qty./Unit </td><td>Unit Price</td><td style="width: 14rem;">Total</td></tr>'
            );
          }
          $("#" + ot + "_" + oi).append(
            "<tr><td>" +
              j +
              "." +
              k +
              "</td><td>" +
              tree[ot][oi][pt]["dsp"] +
              "</td><td>" +
              tree[ot][oi][pt]["qty"] +
              "</td><td>" +
              tree[ot][oi][pt]["utp"] +
              "</td><td>" +
              tree[ot][oi][pt]["stl"] +
              "</td></tr></tbody></table></div></td></tr>"
          );
        });
      }
    });
  });
  if (l_gst.state == "same") {
    cgstttl = (subttl * cgst) / 100;
    sgstttl = (subttl * sgst) / 100;
    ttl = subttl + sgstttl + cgstttl;
    $("#order_items_cardfooter").append(
      '<div class="row"><div class="col-3"><b>Sub Total : </b>₹ ' +
        subttl.toFixed(2) +
        '</div><div class="col-3"><b>SGST ' +
        sgst +
        "% : </b>" +
        sgstttl.toFixed(2) +
        '<br /></div><div class="col-3"><b>CGST ' +
        cgst +
        "% : </b>₹ " +
        cgstttl.toFixed(2) +
        '<br /></div><div class="col-3"><b>Total : </b>₹ ' +
        ttl.toFixed(2) +
        "</div></div>"
    );
  } else {
    igstttl = (subttl * igst) / 100;
    ttl = subttl + igstttl;
    $("#order_items_cardfooter").append(
      '<div class="row"><div class="col-4"><b>Sub Total : </b>₹ ' +
        subttl +
        ' </div><div class="col-4"><b>IGST ' +
        igst +
        "% : </b>₹ " +
        igstttl +
        '<br /></div><div class="col-4"><b>Total : </b>₹ ' +
        ttl +
        "</div></div>"
    );
  }
  $("#order_items_cardfooter").show();
}

$(document).on("click", ".myorder", function () {
  create();
  var ot = $(this).data("oti");
  var oi = $(this).data("oii");
  item_id = oi;
  oti = $(this).data("oti");
  writemode = false;
  $("#order_type").val($(this).data("oti")).trigger("change");
  if (oti == 1 || oti == 3) {
    $("#from_date").val(tree[ot][oi]["from"]);
    $("#to_date").val(tree[ot][oi]["till"]);
  }
  add_order(oi);
  $("#orderitem_" + oi + "_val_1").val(tree[ot][oi]["itm"]);
  $("#orderitem_" + oi + "_val_2").val(tree[ot][oi]["dsp"]);
  $("#orderitem_" + oi + "_val_4").val(tree[ot][oi]["uom"]);
  $("#orderitem_" + oi + "_val_5").val(tree[ot][oi]["utp"]);
  $("#orderitem_" + oi + "_val_3")
    .val(tree[ot][oi]["qty"])
    .trigger("change");
  if (tree[ot][oi].hasOwnProperty("ptl")) {
    $.each(tree[ot][oi]["ptl"], function (index, pt) {
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_1").text(index);
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_3").val(
        tree[ot][oi][pt]["dsp"]
      );
      $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_5").val(
        tree[ot][oi][pt]["utp"]
      );
      if (ot == 2) {
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val(
          tree[ot][oi][pt]["qty"]
        );
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_txt_6").text(
          tree[ot][oi][pt]["stl"]
        );
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_6").val(
          tree[ot][oi][pt]["stl"]
        );
      }
    });
  }
  writemode = true;
});

$(document).on("click", ".off", function () {
  $("#order_type").val("");
  ordertype_reset();
  $("#add_order_card").hide();
});

$(document).on("click", ".remove_saved_item", function () {
  del_ot = $(this).data("oti");
  del_id = $(this).data("oii");
  $("#modelactivate").click();
});

$(".killrow").click(function () {
  delete tree[del_ot][del_id];
  tree[del_ot]["oil"] = jQuery.grep(tree[del_ot]["oil"], function (b) {
    return b != del_id;
  });
  if (tree[del_ot]["oil"].length == 0) {
    delete tree[del_ot];
    tree["otl"] = jQuery.grep(tree["otl"], function (b) {
      return b != del_ot;
    });
  }
  if (tree["otl"].length == 0) {
    $("#order_items_cardfooter").hide();
  }
  treehouse();
  $("#byemodal").click();
});

function form_maker() {
  var subtotal = 0;
  var fakeoi = 0;
  var order_change_flag = 0,
    firstcheck = 0;
  $.each(tree["otl"], function (index, ot) {
    if (ot != order_change_flag && index == 0) {
      $("#hiddendata").append(
        '<input type="hidden" name="ordertype" id="id_order_type" value="' +
          ot +
          '" />'
      );
    } else if (ot != order_change_flag && index != 0) {
      $("#id_order_type").val("99");
    }

    $.each(tree[ot]["oil"], function (index, oi) {
      subtotal += parseFloat(tree[ot][oi]["stl"]);
      $("#hiddendata")
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][ordertype]" value="' +
            ot +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][item]" value="' +
            tree[ot][oi]["itm"] +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][description]" value="' +
            tree[ot][oi]["dsp"] +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][qty]" value="' +
            tree[ot][oi]["qty"] +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][uom_id]" value="' +
            tree[ot][oi]["uom"] +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][unit_price]" value="' +
            tree[ot][oi]["utp"] +
            '">'
        )
        .append(
          '<input type="hidden" name="order_details[' +
            fakeoi +
            '][total]" value="' +
            tree[ot][oi]["stl"] +
            '">'
        );
      if (ot == 1 || ot == 3) {
        $("#hiddendata")
          .append(
            '<input type="hidden" name="order_details[' +
              fakeoi +
              '][po_from_date]" value="' +
              tree[ot][oi]["from"] +
              '">'
          )
          .append(
            '<input type="hidden" name="order_details[' +
              fakeoi +
              '][po_to_date]" value="' +
              tree[ot][oi]["till"] +
              '">'
          );
      }
      if (tree[ot][oi].hasOwnProperty("ptl")) {
        $.each(tree[ot][oi]["ptl"], function (index, pt) {
          $("#hiddendata")
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][item]" value="' +
                tree[ot][oi][pt]["itm"] +
                '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][description]" value="' +
                tree[ot][oi][pt]["dsp"] +
                '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][qty]" value="' +
                tree[ot][oi][pt]["qty"] +
                '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][uom_id]" value="' +
                tree[ot][oi][pt]["uom"] +
                '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][unit_price]" value="' +
                tree[ot][oi][pt]["utp"] +
                '">'
            )
            .append(
              '<input type="hidden" name="order_details[' +
                fakeoi +
                "][payment_term][" +
                pt +
                '][total]" value="' +
                tree[ot][oi][pt]["stl"] +
                '">'
            );
        });
      }
      ++fakeoi;
    });
  });
  a = (sgst / 100) * subtotal;
  b = (cgst / 100) * subtotal;
  c = (igst / 100) * subtotal;
  var total = parseFloat(subtotal + a + b + c);
  if (l_gst.state == "same") {
    $("#hiddendata").append(
      '<input type="hidden" name="taxrate" value="' + l_gst.sgst + '">'
    );
  } else {
    $("#hiddendata").append(
      '<input type="hidden" name="taxrate" value="' + l_gst.igst + '">'
    );
  }
  $("#hiddendata")
    .append(
      '<input type="hidden" name="ordersubtotal" value="' +
        subtotal.toFixed(2) +
        '">'
    )
    .append('<input type="hidden" name="sgst" value="' + a.toFixed(2) + '">')
    .append('<input type="hidden" name="cgst" value="' + b.toFixed(2) + '">')
    .append('<input type="hidden" name="igst" value="' + c.toFixed(2) + '">')
    .append(
      '<input type="hidden" name="ordertotal" value="' + total.toFixed(2) + '">'
    );
}

$(document).on("change", ".item", function () {
  if (oti == 2) {
    $(".paymentterm_item").text($(this).val());
  }
});

function update_pt_total(o, p) {
  var a = $("#orderitem_" + o + "_paymentterm_" + p + "_val_4").val();
  var b = $("#orderitem_" + o + "_paymentterm_" + p + "_val_5").val();
  var res = nz((b * a) / 100);
  $("#orderitem_" + o + "_paymentterm_" + p + "_val_6").val(res.toFixed(2));
  $("#orderitem_" + o + "_paymentterm_" + p + "_txt_6").text(
    humanamount(res.toFixed(2))
  );
}

$(document).on("change", ".paymentterm_quantity", function () {
  var oi = $(this).data("oid");
  update_pt_total(oi, $(this).data("pid"));
  var qtyttl = 0;
  var empty_qty_ids = [];
  $.each(paymentterm_list, function (index, pt) {
    if ($("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val()) {
      if (
        paymentterm_list[paymentterm_list.length - 1] == pt &&
        empty_qty_ids.length < 1
      ) {
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val(
          100 - qtyttl
        );
        update_pt_total(oi, pt);
      }
      qtyttl += parseInt(
        $("#orderitem_" + oi + "_paymentterm_" + pt + "_val_4").val()
      );
    } else {
      empty_qty_ids.push(pt);
    }
  });
  if (empty_qty_ids.length == 1) {
    balanc = 100 - qtyttl;
    if (balanc < 0) {
      balanc = "";
    }
    $("#orderitem_" + oi + "_paymentterm_" + empty_qty_ids[0] + "_val_4").val(
      balanc
    );
    update_pt_total(oi, empty_qty_ids[0]);
  }
});

$(document).on("change", ".order_item_uom", function () {
  order_item_calculator($(this).data("id"));
});

$(document).on("change", "#from_date", function () {
  $("#to_date").attr("min", $("#from_date").val());
});

$(document).on("change", "#to_date", function () {
  $("#from_date").attr("max", $("#to_date").val());
});
