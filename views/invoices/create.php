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
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body" id="order">
                    <div class="row">
                      <div class="col-sm-12 col-lg-3 form-group">
                        <label for="id_customergroup"> Customer Group : </label>
                        <select class="form-control" name="group_id" id="id_group_id">
                          <option>Select Group</option>
                          <?php foreach ($groups as $group) : ?>
                          <option value="<?php echo $group['id'] ?>">
                            <?php echo $group['name'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <label for="customerid_id">Customer : </label>
                        <select class="form-control" name="customer_id" id="customerid_id"></select>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <label for="id_orderid">Customer PO No.:</label>
                        <select name="order_id" id="id_orderid" class="form-control"></select>
                      </div>
                      <div class="col-sm-0 col-lg-0 form-group">
                        <label for="customer_id"></label>
                        <input type="hidden" class="form-control ftsm" name="po_no" id="id_pono" />
                      </div>
                      <div class="col-sm-0 col-lg-0 form-group">
                        <label for="id_salesperson"></label>
                        <input type="hidden" class="form-control ftsm" name="sales_person" id="id_salesperson" />
                      </div>
                      <div class="col-sm-0 col-lg-0 form-group">
                        <label for="bill_id"></label>
                        <input type="hidden" class="form-control ftsm" name="bill_to" id="bill_id" />
                      </div>
                      <div class="col-sm-0 col-lg-0 form-group">
                        <label for="ship_id"></label>
                        <input type="hidden" class="form-control ftsm" name="ship_to" id="ship_id" />
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group" id="id_ordertype" style="display: none"></div>
                      <div class="col-sm-12 col-lg-12 form-group">
                        <label for="comment_id"></label>
                        <textarea class="form-control capitalize" name="remarks" placeholder="Type your comments."
                          id="comment_id" cols="30" rows="1"></textarea>
                      </div>
                    </div>

                    <div class="row" style="display: none" id="id_orderblock">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <b>Order Details</b>
                          </div>
                          <div class="card-body table-responsive py-3">
                            <table class="table text-center">
                              <thead>
                                <tr>
                                  <th class="min100">Item</th>
                                  <th class="min100">Description</th>
                                  <th class="minmax150" id="setheader"></th>
                                  <th class="minmax150">Unit of Measure</th>
                                  <th class="min100">Unit Price</th>
                                  <th class="min100">Order Total</th>
                                </tr>
                              </thead>
                              <tbody id="orderlist"></tbody>
                            </table>
                          </div>
                          <div class="card-footer">
                            <div class="row">
                              <div class="col-3">
                                <b>Sub Total : </b>
                                <span id="ordertotal_txt">0.00</span>
                              </div>
                              <div class="col-3" id="sgst_details" style="display: none">
                                <b><span id="sgst_label"></span></b>
                                <span id="sgst_val"></span>
                              </div>
                              <div class="col-3 text-center" id="cgst_details" style="display: none">
                                <b><span id="cgst_label"></span></b>
                                <span id="cgst_val"></span>
                              </div>
                              <div class="col-3 text-center" id="igst_details" style="display: none">
                                <b><span id="igst_label"></span></b>
                                <span id="igst_val"></span>
                              </div>
                              <div class="col-3 text-right" id="total_details" style="color: mediumslateblue">
                                <b>Total</b>
                                <span id="total_val"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="display: none" id="id_invoiceblock">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">Payment Terms</div>
                          <div class="card-body" id="id_invoiceblock_body"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                </div>

                <button type="button" class="hide" id="preview_modal" data-toggle="modal"
                  data-target="#modal-xl"></button>

                <div class="modal fade" id="modal-xl">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header" id="preview_modal_header">
                        Generate Invoice
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="preview_modal_body"></div>
                      <div class="modal-footer justify-content-between" id="preview_modal_footer">
                        <div>
                          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            Close
                          </button>
                        </div>
                        <div>
                          <button type="submit" class="btn btn-light btn-sm" id="togglepdf">
                            Preview
                          </button>
                          <button type="submit" class="btn btn-primary btn-sm" id="gene" onclick="form.submit()" style="display: none;">
                            Generate
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <input type="hidden" name="paytype_body" id="id_paytype_val" value="1,2,3,4,5" />
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>