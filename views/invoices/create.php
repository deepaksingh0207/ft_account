<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form action="" method="post" id="quickForm" novalidate="novalidate">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Add New Invoice</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary" title="All fields are mandatory.">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body" id="order" style="display: block">

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_customergroup">
                          Customer Group :
                        </label>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" name="group_id" id="id_group_id">
                          <option value=""></option>
                          <?php foreach ($groups as $group) : ?>
                          <option value="<?php echo $group['id'] ?>">
                            <?php echo $group['name'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="customerid_id">Customer : </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" name="customer_id" id="customerid_id" disabled>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_orderid">Order Number:</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select name="order_id" id="id_orderid" class="form-control" disabled>
                          <option value="">&nbsp;</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_invoicedate">Date :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="date" class="form-control ftsm" name="invoice_date" id="id_invoicedate" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="customer_id">Customer PO No. :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="po_no" id="id_pono" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_salesperson">Salesperson:</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="sales_person" id="id_salesperson" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="bill_id">Bill To :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="bill_to" id="bill_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="ship_id">Ship To :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="ship_to" id="ship_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="comment_id">Comments :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="remarks" id="comment_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_ordertype">Order Type :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group" id="id_ordertype">

                      </div>
                    </div>

                    <div class="row" id="order_list_layout" style="display: none; justify-content: flex-end;">
                      <div class="col-12 card px-0">
                        <div class="card-header">
                          <b>Order Details</b>
                        </div>
                        <div class="card-body table-responsive py-3">
                          <table class="table text-center">
                            <thead>
                              <tr>
                                <th class="min100">Item</th>
                                <th class="min100">Description</th>
                                <th class="minmax150">Qty</th>
                                <th class="minmax150">Unit of Measure</th>
                                <th class="min100">Unit Price</th>
                                <th class="min100">Order Total</th>
                              </tr>
                            </thead>
                            <tbody id="orderlist"></tbody>
                          </table>

                        </div>
                        <div class="card-footer">
                          <div class="text-right">
                            <b>Sub Total : </b>
                            <span id="ordertotal">0.00</span>
                            <input type="hidden" name="order_total" id="id_order_total" />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-lg-3 text-right" id="ordersgstdiv" style="display: none;">
                        <input type="hidden" name="sgst" id="id_sgst" value="">
                        <p class="mb-0" id="sgst"></p>
                        <p id="sgstval"></p>
                      </div>
                      <div class="col-sm-12 col-lg-3 text-right" id="ordercgstdiv" style="display: none;">
                        <input type="hidden" name="cgst" id="id_cgst" value="">
                        <p class="mb-0" id="cgst"></p>
                        <p id="cgstval"></p>
                      </div>
                      <div class="col-sm-12 col-lg-3 text-right" id="orderigstdiv" style="display: none;">
                        <input type="hidden" name="igst" id="id_igst" value="">
                        <p class="mb-0" id="igst"></p>
                        <p id="igstval"></p>
                      </div>
                      <div class="col-sm-12 col-lg-3 text-right" id="totaldiv" style="color: mediumslateblue;">
                        <input type="hidden" name="ordertotal" id="id_ordertotal" value="">
                        <p class="mb-0"><b>Total</b></p>
                        <p id="totalval"></p>
                      </div>
                    </div>

                    <div class="row" id="invoice_list_layout" style="display: none">
                      <div class="col-12 card px-0">
                        <div class="card-header">
                          <b>Past Invoice Details</b>
                        </div>
                        <div class="card-body table-responsive">
                          <table class="table text-center mb-0">
                            <thead id="invoiceheader">
                              <tr>
                                <td colspan="9">No Past Invoice</td>
                              </tr>
                            </thead>
                            <tbody id="invoicelist"></tbody>
                          </table>

                        </div>
                        <div class="card-footer">
                          <div class="text-right">
                            <b>Balance Amount : </b>
                            <span id="pendingbalance">0.00</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" id="id_paymenttermdiv" style="display: none">
                      <div class="col-12 card px-0">
                        <div class="card-header">
                          <b>Payment Terms</b>
                        </div>
                        <div class="card-body table-responsive">
                          <table class="table text-center mb-0">
                            <thead>
                              <tr>
                                <th style="min-width: 40px;"></th>
                                <th class="min100">Item</th>
                                <th class="min100">Description</th>
                                <th class="minmax150">Qty</th>
                                <th class="minmax150">Unit of Measure</th>
                                <th class="min100">Unit Price</th>
                                <th class="min100">Total</th>
                              </tr>
                            </thead>
                            <tbody id="id_paymentterm_list" class="text-left"></tbody>
                          </table>
                          <hr class="mt-0">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary" title="All fields are mandatory.">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                </div>

                <button type="button" id="responsemodal" class="btn btn-default" data-toggle="modal"
                  data-target="#modal-sm" style="display: none"></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Generate Invoice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to generate invoice?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="form.submit()">
                          Generate
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <input type="hidden" name="paytype_body" id="id_paytype_val" value="1,2,3,4,5" />
            </div>
          </div>
        </div>

        <button type="button" id="modelactivate" style="display: none" data-toggle="modal"
          data-target="#modal-default"></button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="" method="post" class="text-center mb-0">
                <div class="modal-header">
                  <div class="modal-title">ORDER DELETE</div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Please confirm deleting action of this order?</p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger btn-sm killrow">
                    Delete
                  </button>
                  <button type="button" id="byemodal" class="btn btn-light btn-sm" data-dismiss="modal">
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>