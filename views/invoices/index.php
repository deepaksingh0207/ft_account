<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 col-lg-3">
                  <label for="id_startdate"> Start Date :</label>
                  <input type="date" class="form-control ftsm" name="startdate" id="id_startdate">
                </div>
                <div class="col-sm-12 col-lg-3">
                  <label for="id_enddate"> End Date :</label>
                  <input type="date" class="form-control ftsm" name="enddate" id="id_enddate">
                </div>
                <div class="col-sm-12 col-lg-3">
                  <label for="id_customer"> Customer : </label>
                  <select class="form-control fc ftsm select2 mt-0" name="customer_id"
                    id="id_customer">
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer) : ?>
                      <option value="<?php echo $customer['id'] ?>">
                        <?php echo $customer['customer_name'] . ' (' . $customer['state_name'] . ')' ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-12 col-lg-3 mt-4">
                  <div class="btn-group mt-2">
                    <button type="button" class="btn btn-default update">
                      <i class="fas fa-search my-1"></i>
                    </button>
                    <a href="<?php echo ROOT; ?>invoices" type="button" class="btn btn-default">
                      Clear
                    </a>
                    <a href="<?php echo ROOT; ?>invoices/create" type="button"
                      class="btn btn-default">
                      New Invoice
                    </a>
                  </div>
                </div>
                <div class="col-sm-12 col-lg-12 text-right">

                </div>
                <div class="col-12 mt-3">
                  <table id="example1" class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th style="max-width:150px;">Invoice No</th>
                        <th style="max-width:150px;">Order/PO</th>
                        <th style="max-width:250px;">Customer</th>
                        <th>Salesperson</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- --------17/10/2024-----modal----------- -->

    <!-- <button type="button" class="hide" id="preview_modal" data-toggle="modal" data-target="#modal-xl"></button>
    <button type="button" id="modelpdf" style="display: block" data-toggle="modal" data-target="#pdfmodal"></button> -->

    <form action="" method="post" id="creditNoteForm">
      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header" id="preview_modal_header">
              Generate Credit Note
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="preview_modal_body" style="max-height: 70vh; overflow-y: auto;">

              <div id="t1">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="modal-header" id="preview_modal_header">
                      Credit Note
                      <span>
                        <span>Invoice No :</span> <span id="invoiceNo" style="font-size: medium; font-weight: bold;"></span>
                      </span>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="select-all"></th>
                          <th>Item</th>
                          <th>Description</th>
                          <th id="setheader_creditnote"></th>
                          <th>UOM</th>
                          <th>Unit Price</th>
                          <th>HSN Code</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody id="preview_tbody">
                        <!-- Table rows will be inserted here -->
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-4 text-left">
                        <b>Sub Total : </b>
                        <span id="preview_subtotal_txt"></span>
                        <!-- <input type="hidden" name="invoice_total" id= "invoice_total" class="previewsubtotal" value="">  -->
                      </div>
                      <div class="col-sm-4 text-center Igst" style ="display:block">
                        <b>IGST ( 18% ) : </b>
                        <span id="preview_igst_val"></span>
                      </div>
                      <div class="col-sm-4 text-center SCgst" style ="display:block">
                        <b>SGST(9%) : </b> <span id="preview_sgst_val"></span>&nbsp;&nbsp;&nbsp;&nbsp;<b>CGST(9%) : </b> <span id="preview_cgst_val"></span>
                      </div>
                      <div class="col-sm-4 text-right" style="color:mediumslateblue">
                        <b>Total : </b>
                        <span id="preview_total_val"></span>
                        <input type="hidden" name="credit_note_total" id="preview_credit_total" value="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-2">
                    <label for="id_creditnotedate">Credit Note Date</label>
                    <input type="date" class="form-control ftsm" name="credit_note_date" required id="id_creditnote_date" value="">
                  </div>
                  <div class="col-sm-12 col-lg-2">
                    <label for="id_credit_no">Credit Note No.</label>
                    <input type="number" value="" class="form-control numberonly" pattern="[0-9]{7}" min="0000000" max="9999999" required name="credit_no" id="id_credit_no">
                    <span id="credit_no_error" style=" display: none;" class="say error invalid-feedback"></span>
                  </div>
                </div>
              </div>

              <div id="t2" style="display: none;">


              </div>
            </div>
            <div class="modal-footer justify-content-between" id="preview_modal_footer">
              <div>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                  Close
                </button>
              </div>
              <div>
                <button type="button" class="btn btn-default btn-sm" id="togglepdf">
                  Preview
                </button>
                <button type="button" class="btn btn-default btn-sm" id="backToEditing" style="display: none;">Back to Editing</button>
                <button type="submit" class="btn btn-primary btn-sm" id="generate_credit" name="gen_button" onclick="form.submit()" style="display: none;">
                  Generate
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>



    <!----------------------end----------------- -->

    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <span id="id_modelcustomer" style="font-size: x-large;font-weight: bold;"></span>&nbsp; &nbsp;
            &nbsp;
            <span id="id_modeldate" style="font-style: italic; color: slategrey; padding-top: 8px"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-6">
                <div class="row">
                  <div class="col-6">
                    <label>Invoice No</label>
                  </div>
                  <div class="col-6">
                    <p id="id_modelinvoice_no"></p>
                  </div>
                  <div class="col-6">
                    <label>PO Order</label>
                  </div>
                  <div class="col-6">
                    <p id="id_modelpo_order"></p>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <input type="text" class="form-control mb-2 act" id="id_invoice" pattern="[0-9]{7}"
                  minlength="7" maxlength="7" placeholder="New Invoice No" min="0000000"
                  max="9999999">
                <input type="text" class="form-control mb-2 act" id="id_creditnote"
                  placeholder="New Credit No">
                <div class="row">
                  <div class="col-6 mb-2 act col_invcpy">
                    <a class="btn btn-info btn-block btn-flat py-3 invcpy" target="_blank"><i
                        class="far fa-file-pdf fa-lg"></i><br><br>Print Invoice</a>
                  </div>
                  <!-- <div class="col-6 mb-2 act col_cbncpy">
                    <a class="btn btn-info btn-block btn-flat py-3 cbncpy" target="_blank"><i
                        class="far fa-file-pdf fa-lg"></i><br><br>Print Credit Note</a>
                  </div> -->

                  <div class="col-6 mb-2 act col_genirn">
                    <button class="btn btn-info btn-block btn-flat py-3 genirn">
                      <i class="fas fa-file-invoice fa-lg"></i><br><br>Generate E-Invoice
                    </button>
                  </div>

                  <div class="col-6 mb-2 act col_ecanirn">
                    <button class="btn btn-info btn-block btn-flat py-3 initecanirn">
                      <i class="fas fa-edit fa-lg"></i><br><br>Cancel E-Invoice</button>
                    <button class="ecanirn hide">ecanirn</button>
                  </div>

                  <div class="col-6 mb-2 act col_gencbn">
                    <button class="btn btn-info btn-block btn-flat py-3 initgencbn" data-toggle="modal" data-target="#modal-xl">
                      <i class="fas fa-file-invoice fa-lg"></i><br><br>Generate Credit Note
                    </button>
                    <!-- <button class="gencbn hide ">gencbn</button> -->
                  </div>

                  <div class="col-6 mb-2 act col_rgenirn">
                    <button class="btn btn-info btn-block btn-flat py-3 initrgenirn">
                      <i class="far fa-clone fa-lg"></i><br><br>Regenerate E-Invoice</button>
                    <button class="rgenirn hide"></button>
                  </div>

                  <div class="col-6 mb-2 act reject">
                    <button class="btn btn-danger btn-block btn-flat py-3" id="id_reject">
                      <i class="fab fa-mixer"></i><br><br>Cancel</button>
                  </div>

                  <div class="col-6 mb-2 act accept">
                    <button class="btn btn-success btn-block btn-flat py-3" id="id_accept">
                      <i class="fas fa-check"></i><br><br>Continue</button>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between feeter" style="color:red"></div>
        </div>
      </div>
    </div>
  </div>
  <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>