<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form action="" method="POST" id="id_quickForm" novalidate="novalidate">
                <div class="card card-default">

                  <div class="card-header">
                    <h3 class="card-title" style="line-height: 2.2">
                      Add New Payments
                    </h3>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                        Submit
                      </button>
                      <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="row mx-1">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <div class="row">
                              <div class="col-sm-12 col-lg-2 pt-1">
                                <label for="id_invoice_no">
                                  Invoice Number :
                                </label>
                              </div>
                              <div class="col-sm-12 col-lg-3 form-group">
                                <select class="form-control select2" name="invoice_id" id="id_invoice_no">
                                  <option value="">&nbsp;</option>'
                                  <?php foreach ($invoices as $invoice) : ?>
                                  <option value="<?php echo $invoice['id'] ?>">
                                    <?php echo $invoice['id'] ?>
                                  </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="card-body" id="table_one" style="display: none;">
                            <table class="table mb-0">
                              <thead>
                                <th>Basic Value</th>
                                <th>GST Amount</th>
                                <th>Total Invoice Amount</th>
                                <th>TDS %</th>
                                <th>Less TDS</th>
                              </thead>
                              <tbody>
                                <input type="hidden" class="form-control" name="basic_value" id="id_basic_value"
                                  value="80000">
                                <td id="id_basicvalue" class="max150">
                                  80000
                                </td>
                                <input type="hidden" class="form-control" name="gst_amount" id="id_gst_amount">
                                <td id="id_gstamount" class="max150">
                                  4400
                                </td>
                                <input type="hidden" class="form-control" name="invoice_amount" id="id_invoice_amount">
                                <td id="id_invoiceamount" class="max150">
                                  94400
                                </td>
                                <td class="max150 py-1">
                                  <input type="number" class="form-control" name="tds_percent" min="0"
                                    id="id_tds_percent" style="width: 75px;">
                                </td>
                                <input type="hidden" class="form-control" name="tds_deducted" id="id_tds_deducted">
                                <td id="id_tdsdeducted" class="max150">
                                </td>
                              </tbody>
                            </table>
                          </div>
                          <div class="card-footer" id="receivable_amt_div" style="display: none;">
                            <div class="text-right">
                              <input type="hidden" class="form-control" name="receivable_amt" id="id_receivable_amt">
                              <b>Net Receivable Amount : </b>
                              <span id="id_receivableamt">₹2,55,000.00</span>
                            </div>
                          </div>
                        </div>
                        <div class="card" id="table_two" style="display: none;">
                          <div class="card-body">
                            <table class="table mb-0">
                              <thead>
                                <th>Payment Date </th>
                                <th>Cheque/UTR no.</th>
                                <th>Received Amt</th>
                                <th>Allocated Amt</th>
                              </thead>
                              <tbody>
                                <td class="form-group">
                                  <input type="date" class="form-control" name="payment_date" id="id_payment_date">
                                </td>
                                <td class="form-group">
                                  <input type="text" class="form-control" name="cheque" id="id_cheque">
                                </td>
                                <td class="form-group">
                                  <input type="number" class="form-control" name="received_amt" id="id_received_amt">
                                </td>
                                <td class="form-group">
                                  <input type="number" class="form-control" name="allocated_amt" id="id_allocated_amt">
                                </td>
                              </tbody>
                            </table>
                          </div>
                          <div class="card-footer">
                            <div class="text-right">
                              <input type="hidden" class="form-control" name="balance_amt" id="id_balance_amt">
                              <b>Balance Amount : </b>
                              <span id="id_balanceamount"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                      Submit
                    </button>
                    <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>

                <button type="button" id="responsemodal" class="btn btn-default" data-toggle="modal"
                  data-target="#modal-sm" style="display: none"></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add New Payment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to add new payment?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="form.submit()">
                          Add
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>