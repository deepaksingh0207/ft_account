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
                    <div class="card-title">Add New Invoice</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary">
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
                        <label for="customerid_id">Customer : </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control-sm select2" name="customer_id" id="customerid_id">
                          <option value=""></option>
                          <?php foreach ($customers as $customer) : ?>
                            <option value="<?php echo $customer['id'] ?>"><?php echo $customer['name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_orderid">Order Number:</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select name="order_id" id="id_orderid" class="form-control select2" disabled>
                          <option value=""></option>
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

                    <!-- <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_payindays">Pay in days :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control ftsm" name="pay_days" id="id_payindays" minlength="1" minlength="3" />
                      </div>
                    </div> -->

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

                      <div class="col-12 table-responsive">
                        <table class="table text-center mb-0">
                          <thead>
                            <tr>
                              <th class="min100">Item </th>
                              <th class="min100">Description</th>
                              <th class="minmax150">Qty </th>
                              <th class="min100">Unit Price</th>
                              <th class="min100">Order Total</th>
                            </tr>
                          </thead>
                          <tbody id="orderlist"></tbody>
                        </table>
                        <hr class="mt-0">
                      </div>
                      <!-- <div class="col-12">
                        <div class="row">
                          <div class="col-sm-12 col-md-12 mb-2">
                            <button type="button" id="add_item" class="btn btn-primary btn-sm" disabled>
                              ADD ITEM
                            </button>
                          </div>
                        </div>
                      </div> -->

                    </div>
                    <div class="row">
                      <!-- <div class="col-12 text-right">
                        <input type="hidden" name="invoicetotal" id="id_ordertotal" value="0.00">
                        <b>Subtotal : </b>₹
                        <span id="subtotal_id">0.00</span>
                      </div> -->
                      <div class="col-12 text-right">
                        <input type="hidden" name="invoicetotal" id="id_ordertotal" value="0.00">
                        <b>Sub Total : </b>₹
                        <span id="total">0.00</span>
                      </div>
                    </div>

                    <div class="row mt-5" id="paytype_div" style="display:none">
                      <div class="col-12 table-responsive">
                        <table class="table text-center mb-0">
                          <thead>
                            <tr>
                              <th class="min100">Sr No. </th>
                              <th class="min100 text-left">Line Items</th>
                              <th class="">% Slab </th>
                              <th class="min100"></th>
                              <th class="min100">Sub Total
                              </th>
                            </tr>
                          </thead>
                          <tbody id="id_paytype_body">
                            <tr id="row1">
                              <td>1
                              </td>
                              <td class="text-left">
                                <div class="form-group mb-0">
                                  <select class="form-control ftsm" style="width: 100%;" name="paytype" id="id_paytype">
                                    <option value="1"selected="selected">Advance</option>
                                    <option value="2">UAT Submit</option>
                                    <option value="3">GO Live </option>
                                    <option value="4">Support </option>
                                    <option value="5">Full Payment </option>
                                  </select>
                                </div>
                              </td>
                              <td>
                                <div class="input-group" style="justify-content: center;">
                                  <input type="tel" class="form-control ftwm subtotal minmax100" name="subtotal" id="id_subtotal">
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <i class="fas fa-percentage"></i>
                                    </div>
                                  </div>
                                </div>
                              </td>
                              <td>
                              <button type="button" class="calcy btn btn-sm btn-primary">Apply</button>
                              </td>
                              <td id="id_paytotal_div">
                                <div></div>
                                <input type="hidden" name="paytotal" id="id_paytotal">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <hr class="mt-0">
                      </div>
                      
                      <div class="col-12 text-right">
                        <input type="hidden" name="sgst" id="id_sgst" value="">
                        <b>IGST : </b>₹
                        <span id="sgstvalue">0.00</span>
                        ( <span id="sgstpercent">0</span> % )
                      </div>

                      <div class="col-12 text-right">
                        <input type="hidden" name="cgst" id="id_cgst" value="">
                        <b>CGST : </b>₹
                        <span id="cgstvalue">0.00</span>
                        ( <span id="cgstpercent">0</span> % )
                      </div>
                      
                      <div class="col-12 text-right">
                        <input type="hidden" name="cgst" id="id_igst" value="">
                        <b>SGST : </b>₹
                        <span id="igstvalue">0.00</span>
                        ( <span id="igstpercent">0</span> % )
                      </div>
                      <div class="col-12 text-right" style="color: crimson;">
                        <input type="hidden" name="gsttotal" id="id_gsttotal" value="">
                        <b>Total : </b>₹
                        <span id="gstvalue">0.00</span>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <!-- <button type="submit" class="btn btn-sm btn-default" name="submit" value="save">
                        Save
                      </button>
                      <button type="submit" class="btn btn-sm btn-default" name="submit" value="save_recurring">
                        Save & Recurring
                      </button>
                      <button type="submit" class="btn btn-sm btn-primary" name="submit" value="submit_print">
                        Record & Print
                      </button>
                      <button type="submit" class="btn btn-sm btn-primary" name="submit" value="submit_email">
                        Record & Email
                      </button> -->
                      <button type="submit" class="btn btn-sm btn-primary">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm"> Back
                      </a>
                    </div>
                  </div>

                </div>

              </form>
              <input type="hidden" name="paytype_body" id="id_paytype_val" value="1,2,3,4,5">
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