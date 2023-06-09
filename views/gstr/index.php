<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid p-1">
          <div class="loader">
            <img style="    margin-left: 15vw;margin-top: 15vh;position: absolute;z-index: 1000000;"
              src="/assets/img/loader.gif" />
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-3">
                      <b>Past GSTR Report</b>
                      <select class="form-control" id="id_gstrset">
                        <option value="0">Pending</option>
                      </select>
                    </div>
                    <div class="col-1 mt-3 pt-2">
                      <button type="button" class="btn btn-info download">Download</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="example1" style="font-size: smaller;">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>GSTIN/UIN of Recipient</th>
                              <th>Receiver Name</th>
                              <th>Invoice Number</th>
                              <th>Invoice date</th>
                              <th>Invoice Value</th>
                              <th>Place Of Supply</th>
                              <th>Reverse Charge</th>
                              <th>Applicable % of Tax Rate</th>
                              <th>Invoice Type</th>
                              <th>E-Commerce GSTIN</th>
                              <th>Rate % <br>( A )</th>
                              <th>Taxable Value<br>( B )</th>
                              <th>Cess Amount</th>
                              <th>A * B</th>
                            </tr>
                          </thead>
                          <tbody class="tbody_gstr" id="id_showgstr">
                            <tr>
                              <td>
                                <input class="form-control form-control-sm" type="checkbox" name="gstr[]"
                                  id="id_invoice" checked>
                              </td>
                              <td>06AAACG5306N1ZM</td>
                              <td>G R INFRAPROJECTS LIMITED</td>
                              <td>2022142</td>
                              <td>02-09-2022</td>
                              <td>573480</td>
                              <td>06-HARAYANA</td>
                              <td>N</td>
                              <td></td>
                              <td>Regular B2B</td>
                              <td></td>
                              <td>18</td>
                              <td>486000</td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="15" style="text-align: right; font-size: large;">
                                <span class="text-info">Total : </span><span id="id_total">0</span>
                              </td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script>
      var gstrdata;

      function getRemote(remote_url, method = "GET", r_data = null, type = "json", convertapi = true) {
        var resp = $.ajax({ type: method, data: r_data, dataType: type, url: remote_url, async: false }).responseText;
        if (convertapi) { return JSON.parse(resp); }
        return resp;
      }

      $(document).on("click", ".download", function () {
        var date = new Date();
        var genid = date.getFullYear() + ("0" + (date.getMonth() + 1)).slice(-2) + ("0" + date.getDate()).slice(-2) + ("0" + date.getHours()).slice(-2) + ("0" + date.getMinutes()).slice(-2) + ("0" + date.getSeconds()).slice(-2);
        var rows = [
          ["GSTIN/UIN of Recipient",
            "Receiver Name",
            "Invoice Number",
            "Invoice date",
            "Invoice Value",
            "Place Of Supply",
            "Reverse Charge",
            "Applicable % of Tax Rate",
            "Invoice Type",
            "E-Commerce GSTIN",
            "Rate",
            "Taxable Value",
            "Cess Amount"]
        ];
        $('.checkme').each(function () {
          if ($(this).is(':checked')) {
            var c = $(this).data('inv_id');
            var resp = getRemote(baseUrl + '/gstr/create/' + c + '/' + genid);
            console.log(resp);
            var subset = [
              gstrdata[c].gstin,
              gstrdata[c].receiver,
              gstrdata[c].invoice_no,
              gstrdata[c].invoice_date,
              gstrdata[c].invoice_total,
              gstrdata[c].pos,
              gstrdata[c].rc,
              gstrdata[c].tr,
              gstrdata[c].it,
              gstrdata[c].egst,
              gstrdata[c].rate,
              gstrdata[c].invoice_value,
              gstrdata[c].cs
            ]
            rows.push(subset);
          } else {
            $('#id_tr' + $(this).data('inv_id')).remove()
          }
        });
        let csvContent = "data:text/csv;charset=utf-8,";
        rows.forEach(function (rowArray) {
          for (i = 0, i < rowArray.length; i++;) {
            if (typeof (rowArray[i]) == 'string') { rowArray[i] = rowArray[i].replace(/<(?:.|\n)*?>/gm, ''); }
            else { rowArray[i] = ''; }
          }

          let row = rowArray.join(",");
          csvContent += row + "\r\n"; // add carriage return
        });
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", genid + ".csv");
        document.body.appendChild(link);
        link.click();
        window.location.reload();
      });

      $(document).on("change", "#id_gstrset", function () {
        getgstr($(this).val());
      });

      function getgstr(val = "") {
        $(".loader").show()
        gstrdata = getRemote(baseUrl + 'gstr/getGstrReportList/' + val);
        gstrsetdata = getRemote(baseUrl + 'gstr/getsetid/' + val);
        $("#id_gstrset").empty().append(`<option value="0">Pending</option>`);
        $.each(gstrsetdata, function (index, brown) {
          if (val == brown){
            $("#id_gstrset").append('<option value="' + brown + '" selected>' + brown + '</option>');
          } else{
          $("#id_gstrset").append('<option value="' + brown + '">' + brown + '</option>');}
        });
        var total = 0;
        if (gstrdata) {
          $("#id_nonegstr").empty();
          $("#id_showgstr").empty();
          $.each(gstrdata, function (index, crow) {
            var subtotal = 0.18 * crow.invoice_value;
            var row = `<tr>
            <td>
              <input class="form-control form-control-sm checkme" type="checkbox" name="gstr[]"
                data-inv_id="`+ crow.id + `" checked>
            </td>
            <td>` + crow.gstin + `</td>
            <td>`+ crow.receiver + `</td>
            <td>`+ crow.invoice_no + `</td>
            <td>`+ crow.invoice_date + `</td>
            <td>`+ crow.invoice_total + `</td>
            <td>`+ crow.pos + `</td>
            <td>N</td>
            <td></td>
            <td>Regular B2B</td>
            <td></td>
            <td>18</td>
            <td>`+ crow.invoice_value + `</td>
            <td></td>
            <td>` + subtotal.toFixed(2) + `</td></tr>`;
            if(index){$("#id_showgstr").append(row);}
            total += subtotal;
          });
          $("#id_total").html(total)
        }
        $(".loader").hide()
      }

      getgstr()

    </script>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>