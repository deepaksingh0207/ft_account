<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row pt-2">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title" style="line-height: 2.2">
                    Invoice Payments
                  </h3>
                  <div class="text-right">
                    <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body p-3">
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-4">
                      <b>Customer Group : </b>
                      <?php echo $customerPayment['cust_group']?>
                    </div>

                    <div class="col-sm-12 col-lg-4">
                      <b>Customer : </b>
                      <?php echo $customerPayment['customer_name']?>
                    </div>

                    <?php if( $customerPayment['remarks'] ): ?>
                    <div class="col-sm-12 col-lg-4">
                      <b>Remark</b>
                      <?php echo $customerPayment['remarks']?>
                    </div>
                    <?php endif; ?>

                    <div class="col-12 mt-3" id="colid_pending">
                      <div class="card">
                        <div class="card-header">
                          Payment Details
                        </div>
                        <div class="card-body p-0">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Payment Date</th>
                                <th>Cheque UTR No.</th>
                                <th>Received Amount</th>
                                <th>UTR File</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <?php echo $customerPayment['payment_date']?>
                                </td>
                                <td>
                                  <?php echo $customerPayment['cheque_utr_no']?>
                                </td>
                                <td>
                                  <?php echo $customerPayment['received_amt']?>
                                </td>
                                <td><i class="fas fa-paperclip sublist pointer"
                                    data-href="<?php echo $customerPayment['utr_file']?>"></i></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <?php if (is_array($customerPayment['remarks']) || is_object($customerPayment['remarks'])) : ?>
                        <div class="card-footer">
                          Remarks:
                          <?php echo $customerPayment['remarks']?>
                        </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-12 mt-3" id="colid_pending">
                      <div class="card">
                        <div class="card-header">
                          Payment Details
                        </div>
                        <div class="card-body p-0">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>PO no.</th>
                               <th>Invoice no.</th>
                                <th>TDS Percent</th>
                                <th>TDS Deducted</th>
                                <th>Receivable Amount</th>
                                <th>Balance Amount</th>
                                <th>Allocated Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (is_array($invoicePayment) || is_object($invoicePayment)) : ?>
                              <?php foreach($invoicePayment as $row) : ?>
                              <tr>
                              <td>
                                  <?php echo $row['po_no']?>
                                </td>
                               <td>
                                  <?php echo $row['invoice_no']?>
                                </td>
                                <td>
                                  <?php echo $row['tds_percent']?>
                                </td>
                                <td>
                                  <?php echo $row['tds_deducted']?>
                                </td>
                                <td>
                                  <?php echo $row['receivable_amt']?>
                                </td>
                                <td>
                                  <?php echo $row['balance_amt']?>
                                </td>
                                <td>
                                  <?php echo $row['allocated_amt']?>
                                </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                    Back
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <button type="button" id="modelutr" style="display: none;" data-toggle="modal" data-target="#utrmodal"></button>
    <div class="modal fade" id="utrmodal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header" id="utr_header">
            Payment Attchment
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="utr_body"></div>
        </div>
      </div>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>