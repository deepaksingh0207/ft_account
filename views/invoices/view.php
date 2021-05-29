<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">
    <div class="content-wrapper">
      <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card card-default mt-3">
                <div class="card-header">
                  <h3 class="card-title" style="line-height: 2.2">
                    View Invoice
                  </h3>
                  <div class="text-right">
                    <!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
										</a> -->
                    <a
                      href="<?php echo ROOT; ?>customers"
                      class="btn btn-default btn-sm"
                    >
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customername"> Invoice No : </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['id'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customername"> Customer : </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['name'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_contactperson"> Order Number: </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['po_no'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> Date : </label>
                    </div>
                    <div
                      class="col-sm-12 col-lg-3 form-group"
                      style="text-align: justify"
                    >
                      <?php echo $invoice['invoice_date'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> Contact Person: </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['sales_person'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> Bill To : </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['bill_to'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> Ship To : </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['ship_to'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pphone"> Comments : </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $invoice['remarks'] ?>
                    </div>
                  </div>
                  <div class="table-responsive card">
                    <div class="card-body p-3">
                      <table class="table text-center mb-0">
                        <thead>
                          <tr>
                            <th class="min100">Order Amount</th>
                            <th class="min100">Pay Term</th>
                            <th class="min100">Pay Percent</th>
                            <th class="min100">Sub Total</th>
                            <th class="min100">IGST</th>
                            <th class="min100">CGST</th>
                            <th class="min100">SGST</th>
                            <th class="min100">Total</th>
                            <th class="min100">Date</th>
                          </tr>
                        </thead>
                        <tbody id="invoicelist">
                          <tr>
                            <td><?php echo $invoice['order_total']?></td>
                            <td><?php echo $invoice['payment_term']?></td>
                            <td><?php echo $invoice['pay_percent']?></td>
                            <td><?php echo $invoice['sub_total']?></td>
                            <td><?php echo $invoice['igst']?></td>
                            <td><?php echo $invoice['cgst']?></td>
                            <td><?php echo $invoice['sgst']?></td>
                            <td><?php echo $invoice['invoice_total']?>0</td>
                            <td>
                              <?php echo date('d, M Y', strtotime($invoice['invoice_date']))?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
									</a> -->
                  <a
                    href="<?php echo ROOT; ?>customers"
                    class="btn btn-default btn-sm"
                  >
                    Back
                  </a>
                </div>
              </div>
            </div>
          </div>
          <br /><br />
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div>
