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
                    Invoice Details
                  </h3>
                  <div class="text-right">
                    <!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
										</a> -->
                    <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customername"> <b>Invoice No :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['invoice_no'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customername"> <b>Customer :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['name'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_contactperson"> <b>Order Number:</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <a href="<?php echo ROOT; ?>orders/view/<?php echo $invoice['order_id'] ?>">
                        <?php echo $invoice['po_no'] ?>
                      </a>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> <b>Date :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group" style="text-align: justify">
                      <?php echo $invoice['invoice_date'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> <b>Contact Person:</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $invoice['sales_person'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> <b>Bill To :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['address'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> <b>Ship To :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $shipToAddress ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pphone"> <b>Comments :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $invoice['remarks'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pphone"> <b>Order Type :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $invoice['order_type'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pphone"> <b>Due Date :</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $invoice['due_date'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <b>Order Details</b>
                        </div>
                        <div class="table-responsive card-body p-3">
                          <table class="table">
                            <thead>
                              <tr>
                                <th class="min100">Item</th>
                                <th class="min100">Description</th>
                                <th class="min100">Qty</th>
                                <th class="min100">Unit of Measure</th>
                                <th class="min100">Unit Price</th>
                                <th class="min100">Order Total</th>
                              </tr>
                            </thead>
                            <tbody id="invoicelist">
                              <?php if($invoiceItems && count($invoiceItems)) :
                            foreach ($invoiceItems as $invoiceItem) :
                            ?>
                              <tr>
                                <td>
                                  <?php echo $invoiceItem['item']?>
                                </td>
                                <td>
                                  <?php echo $invoiceItem['description']?>
                                </td>
                                <td>
                                  <?php echo $invoiceItem['qty']?>
                                </td>
                                <td>
                                  <?php echo $invoiceItem['uom_id']?>
                                </td>
                                <td>
                                  <?php echo $invoiceItem['unit_price']?>
                                </td>
                                <td>
                                  <?php echo $invoiceItem['total']?>
                                </td>
                              </tr>
                              <?php endforeach; 
                              endif; ?>
                              <?php if( $invoice['order_type'] == 'Project Sale' ): ?>
                              <tr>
                              <td><?php echo $invoice['id'] ?></td>
                              <td><?php echo $invoice['payment_description'] ?></td>
                              <td><?php echo $invoice['pay_percent'] ?></td>
                              <td>Percentage (%)</td>
                              <td><?php echo $invoice['order_total'] ?></td>
                              <td><?php echo $invoice['sub_total'] ?></td>
                              </tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="card-footer">
                          <div class="row justify-content-center">
                            <?php if ($invoice['sgst'] != 0 ) : ?>
                            <div class="col-sm-12 col-lg-3 text-center">
                              <b>SGST : </b>
                              <?php echo $invoice['sgst']?>
                            </div>
                            <?php endif; ?>
                            <?php if ($invoice['cgst'] != 0 ) : ?>
                            <div class="col-sm-12 col-lg-3 text-center">
                              <b>CGST : </b>
                              <?php echo $invoice['cgst']?>
                            </div>
                            <?php endif; ?>
                            <?php if ($invoice['igst'] != 0 ) : ?>
                            <div class="col-sm-12 col-lg-3 text-center">
                              <b>IGST : </b>
                              <?php echo $invoice['igst']?>
                            </div>
                            <?php endif; ?>
                            <div class="col-sm-12 col-lg-3 text-center" style="color: mediumslateblue;">
                              <b>TOTAL : </b>
                              <?php echo $invoice['invoice_total']?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if (count($payments)) : ?>
                  <div class="row mx-1">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <b>Payment Details</b>
                        </div>
                        <div class="table-responsive card-body p-3">
                          <table class="table">
                            <thead>
                              <tr>
                                <th class="min100">Payment Date</th>
                                <th class="min100">TDS %</th>
                                <th class="min100">Less TDS</th>
                                <th class="min100">Net Receivable Amt</th>
                                <th class="min100">Cheque/UTR no.</th>
                                <th class="min100">Allocated Amt</th>
                                <th class="min100">Balance Amount</th>

                              </tr>
                            </thead>
                            <tbody id="invoicelist">
                              <?php if(count($payments)) :
                            foreach ($payments as $payment) :
                            ?>
                              <tr>
                                <td>
                                  <?php echo date('d, M Y', strtotime($payment['payment_date']))?>
                                </td>
                                <td>
                                  <?php echo $payment['tds_percent']?>
                                </td>
                                <td>
                                  <?php echo $payment['tds_deducted']?>
                                </td>
                                <td>
                                  <?php echo $payment['receivable_amt']?>
                                </td>
                                <td>
                                  <?php echo $payment['cheque_utr_no']?>
                                </td>
                                <td>
                                  <?php echo $payment['allocated_amt']?>
                                </td>
                                <td>
                                  <?php echo $payment['balance_amt']?>
                                </td>
                              </tr>
                              <?php endforeach; 
                              endif; ?>
                            </tbody>
                          </table>
                        </div>

                        <div class="card-footer">
                          <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-3">
                              <div class="row">
                                <div class="col-12">
                                  <b>Allocated Amount : </b>
                                  ₹0.00
                                </div>
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="row">
                                <div class="col-12 text-right">
                                  <b>Balance Amount : </b>
                                  ₹0.00
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="card-footer text-right">
                  <!-- <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>" class="btn btn-primary btn-sm"> Edit
									</a> -->
                  <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                    Back
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>