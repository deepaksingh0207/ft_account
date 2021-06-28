<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form action="" method="post" id="id_quickForm" novalidate="novalidate">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Add New Payments</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary record" title="All fields are mandatory.">
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
                          <option value="1">JBM</option>
                          <option value="3">Aarti</option>
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
                        <select class="form-control" name="customer_id" id="customerid_id">
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 pt-1">
                        <div class="card" id="table_two" style="display: none;">
                          <div class="card-body table-responsive">
                            <table class="table mb-0">
                              <thead>
                                <th>Payment Date </th>
                                <th>Cheque/UTR no.</th>
                                <th>Received Amt</th>
                              </thead>
                              <tbody>
                                <td class="form-group">
                                  <input type="date" class="form-control www" name="payment_date" id="id_payment_date">
                                </td>
                                <td class="form-group">
                                  <input type="text" class="form-control www" name="cheque_utr_no" required
                                    id="id_cheque">
                                </td>
                                <td class="form-group">
                                  <input type="number" class="form-control www" name="received_amt" min="1"
                                    id="id_received_amt" min="0" value="0">
                                </td>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 pt-1">
                        <div class="table-responsive" id="table_one" style="display: none;">
                          <table class="table mb-0">
                            <thead class="text-center">
                              <th></th>
                              <th>Invoice Id</th>
                              <th>Basic Value</th>
                              <th>GST Amount</th>
                              <th>Total Invoice Amount</th>
                              <th>TDS %</th>
                              <th>Less TDS</th>
                              <th>Allocated Amt</th>
                            </thead>
                            <tbody id="id_invoicebody">
                            </tbody>
                            <tfoot style="background-color: #f7f7f7;">
                              <tr>
                                <td>
                                  <button type="button" id="add_row" class="btn btn-sm btn-info">Add Row</button>
                                </td>
                                <td colspan="7" class="text-right align-middle">
                                  <b id="id_balanceamt" style="display: none;">
                                    Balance Amount :
                                  </b>
                                  <span id="id_balance_amt"></span>
                                </td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary record" title="All fields are mandatory.">
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
                        <h5 class="modal-title">Generate New Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="preview_invoice">
                        <p>Are you confirm to add new payment.?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary generate" onclick="form.submit()">
                          Generate Invoice
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