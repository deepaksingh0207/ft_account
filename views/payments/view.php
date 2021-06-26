<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title" style="line-height: 2.2">
                    View Payment Details
                  </h3>
                  <div class="text-right">
                    <!-- <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                        Edit
                      </button> -->
                    <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body p-3">
                  <div class="row mx-1">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body" id="table_one">
                          <table class="table mb-0">
                            <thead>
                              <th>Invoice Number</th>
                              <th>Basic Value</th>
                              <th>GST Amount</th>
                              <th>Total Invoice Amount</th>
                              <th>TDS %</th>
                              <th>Less TDS</th>
                            </thead>
                            <tbody>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="card-footer" id="receivable_amt_div">
                          <div class="text-right">
                            <b>Net Receivable Amount : </b>
                            <span id="id_receivableamt">₹2,55,000.00</span>
                          </div>
                        </div>
                      </div>
                      <div class="card" id="table_two">
                        <div class="card-body">
                          <table class="table mb-0">
                            <thead>
                              <th>Payment Date </th>
                              <th>Cheque/UTR no.</th>
                              <th>Received Amt</th>
                              <th>Allocated Amt</th>
                            </thead>
                            <tbody>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
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
                  <!-- <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                    Edit
                  </button> -->
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
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>