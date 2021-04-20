<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">

    <div ftsolutions="menu.html"></div>

    <div class="content-wrapper">

      <!-- Menu -->
      <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-12">
              <form action="" method="post" id="quickForm" novalidate="novalidate">
              <input type="hidden" id="id_tr" name="trid" value="" />
                <div class="card">

                  <div class="card-header">
                    <div class="card-title">New Sales Order</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body" id="order" style="display: block">

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="customerid_id">Customer : </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm" name="customerid" id="customerid_id">
                          <option value=""></option>
                          <option value="1">User A</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="date_id">Date :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="date" class="form-control ftsm" name="date" id="date_id" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="quote_number_id">Quote Number :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm" name="quote_number" id="quote_number_id">
                          <option value=""></option>
                          <option value="1">10000</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="terms_id">Terms :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm" name="terms" id="terms_id">
                          <option value=""></option>
                          <option value="1">COD</option>
                          <option value="2">Pay in days</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="days_id">Days :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control ftsm" name="days" id="days_id" minlength="1" minlength="3" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="tracking_id">Tracking Ref No :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="tracking" id="tracking_id" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="customer_id">Customer PO No. :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="customer" id="customer_id" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="salesperson_id"></label>
                        Salesperson :
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm" name="salesperson" id="salesperson_id">
                          <option value=""></option>
                          <option value="">prashant</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="ship_id">Ship By:</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm" name="shipby" id="shipby_id">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="tax_id">Tax :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" name="tax" id="tax_id">
                          <option value=""></option>
                          <option value="0">Default</option>
                          <option value="1">Exempt</option>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="bill_id">Bill To :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="bill" id="bill_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="ship_id">Ship To :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="ship" id="ship_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="comment_id">Comments :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="comment" id="comment_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="pvtcomment_id">Private Comments :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="pvtcomment" id="pvtcomment_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">

                      <div class="col-12 table-responsive">
                        <table class="table text-center">
                          <thead>
                            <tr>
                              <th class="minmax150">Qty</th>
                              <th class="min100">Item</th>
                              <th class="min100">Description</th>
                              <th class="min100">Unit Price</th>
                              <th class="tax">Tax (%)</th>
                              <th class="min100">Total</th>
                              <th class="min100">Delete</th>
                            </tr>
                          </thead>
                          <tbody id="orderlist"></tbody>
                        </table>
                      </div>

                      <div class="col-12">
                        <div class="row">
                          <div class="col-sm-12 col-md-12 mb-2 align-center">
                            <button type="button" id="add_item" class="btn btn-primary btn-block btn-sm">
                              <i class="fas fa-plus"></i>
                            </button>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-12 text-right">
                        <b>Subtotal : </b>₹
                        <span id="subtotal_id">0.00</span>
                      </div>
                      <div class="col-12 text-right">
                        <b>Total : </b>₹
                        <span id="total">0.00</span>
                      </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm"> Back
                      </a>
                    </div>
                  </div>

                </div>

              </form>
            </div>
          </div>
          <br><br> <!-- Form Bottom Padding -->
        </div>

        <!-- Modal Start -->
        <button type="button" id="modelactivate" style="display: none" data-toggle="modal" data-target="#modal-default">
        </button>
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
                  <p>
                    Please confirm deleting action of this order?
                  </p>
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
        <!-- Modal End -->

        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </div>
    </div>
  </div>