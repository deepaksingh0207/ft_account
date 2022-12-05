<?php 
$orderAmount = 0.00;
$invliceTotal = 0.00;
$pendingAmount = 0.00;
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title" style="line-height: 2.2">Order Details</h3>
              <div class="text-right">
                <a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
                  Back
                </a>
                <a href="<?php echo ROOT; ?>orders/edit/<?php echo $order['id'] ?>/" class="btn btn-default btn-sm">
                  Edit
                </a>
                <?php if ($order['open_po']) : ?>
                <a href="<?php echo ROOT; ?>orders/renew/<?php echo $order['id'] ?>/" class="btn btn-default btn-sm">
                  Renew
                </a>
                <?php endif;  ?>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 col-lg-6">
                  <div class="row">
                    <div class="col-6">
                      <label for="id_customername">
                        <b>Customer :</b>
                      </label>
                    </div>
                    <div class="col-6 form-group">
                      <?php echo $customer['name'] ?>
                    </div>
                    <div class="col-6">
                      <label for="id_contactperson">
                        <b>Date :</b>
                      </label>
                    </div>
                    <div class="col-6 form-group">
                      <?php echo date('d, M Y', strtotime($order['order_date'])) ?>
                    </div>
                    <div class="col-6">
                      <label for="id_address"> <b>Customer PO No. :</b> </label>
                    </div>
                    <div class="col-6 form-group" style="text-align: justify">
                      <?php echo $order['po_no'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label for="id_address">
                        <b>Order PO Attachment :</b>
                      </label>
                    </div>
                    <div
                      class="col-6 form-group pointer attach"
                      id="attach"
                      style="text-align: justify"
                      data-href="<?php echo 'order_po/'.$order['po_file']?>"
                    >
                      <i class="fas fa-paperclip"></i>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="row">
                    <div class="col-6">
                      <label for="id_pincode"> <b>Contact Person :</b> </label>
                    </div>
                    <div class="col-6 form-group">
                      <?php echo $order['sales_person'] ?>
                    </div>
                    <div class="col-6"><b>Order Type :</b></div>
                    <div class="col-6 form-group">
                      <?php echo $ORDER_TYPE[$order['order_type']] ?>
                    </div>
                    <?php if ($order['po_from_date']) :  ?>
                    <div class="col-6">
                      <label for="id_amc_from">
                        <b>From Date:</b>
                      </label>
                    </div>
                    <div class="col-6 form-group">
                      <?php echo date('d, M Y', strtotime($order['po_from_date'])) ?>
                    </div>
                    <div class="col-6">
                      <label for="id_amc_till">
                        <b>Till Date :</b>
                      </label>
                    </div>
                    <div class="col-6 form-group">
                      <?php echo date('d, M Y', strtotime($order['po_to_date'])) ?>
                    </div>
                    <?php endif;  ?>
                  </div>
                </div>

                <?php if ($order['remarks']) :  ?>
                <div class="col-sm-12 col-lg-12">
                  <div class="row">
                    <div class="col-3"><b>Comments :</b></div>
                    <div class="col-9 form-group">
                      <?php echo $order['remarks'] ?>
                    </div>
                  </div>
                </div>
                <?php endif;  ?>

                <div class="col-sm-12 col-lg-12">
                  <div class="row">
                    <div class="col-3">
                      <label for="id_address"> <b>Bill To :</b> </label>
                    </div>
                    <div class="col-9 form-group">
                      <?php echo $customer['address'] ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <label for="id_gst">
                        <b>Ship To :</b>
                      </label>
                    </div>
                    <div class="col-9 form-group">
                      <?php echo $shipToAddress ?>
                    </div>
                  </div>
                </div>

								<div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row summarytoggle pointer">
                        <div class="col-10">
                          <b>Summary</b>
                        </div>
                        <div class="col-2 text-right">
                          <i
                            class="fas fa-chevron-down mt-1"
                            id="id_summary"
                          ></i>
                        </div>
                      </div>
                    </div>
                    <div
                      class="table-responsive card-body summary p-0"
                    >
                      <table class="table">
												<thead>
													<tr>
														<th>Order Total</th>
														<th>Invoice Total</th>
														<th>Payment Total</th>
														<th>Balance Total</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $summary['ordertotal']?></td>
														<td><?php echo $summary['invoice_total']?></td>
														<td><?php echo $summary['received_amt']?></td>
														<td><?php echo $summary['balance_amt']?></td>
													</tr>
												</tbody>
											</table>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row ordertoggle pointer">
                        <div class="col-10">
                          <b>Order Items</b>
                        </div>
                        <div class="col-2 text-right">
                          <i
                            class="fas fa-chevron-right mt-1"
                            id="id_order"
                          ></i>
                        </div>
                      </div>
                    </div>
                    <div
                      class="table-responsive card-body order p-0"
                      style="display: none"
                    >
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="min150">Item</th>
                            <th class="min150">Description</th>
                            <th class="minmax100">Qty</th>
                            <th class="min150">Unit of Measure</th>
                            <th class="min100">Unit Price</th>
                            <th class="min150">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (is_array($items) || is_object($items)) : ?>
                          <?php foreach($items as $item) : ?>
                          <tr>
                            <td>
                              <?php echo $item['item']?>
                            </td>
                            <td>
                              <?php echo $item['description']?>
                            </td>
                            <td>
                              <?php echo $item['qty']?>
                            </td>
                            <td>
                              <?php echo $UOM[$item['uom_id']] ?>
                            </td>
                            <td>
                              <?php echo $item['unit_price']?>
                            </td>
                            <td>
                              ₹
                              <?php echo $item['total'] ?>
                            </td>
                          </tr>
                          <?php $orderAmount += $item['total']; endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <?php if (in_array($order['order_type'], [1, 2, 3, 7, 99])) : ?>
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row paytermtoggle pointer">
                        <div class="col-10">
                          <b>Payment Terms</b>
                        </div>
                        <div class="col-2 text-right">
                          <i
                            id="id_payterm"
                            class="fas fa-chevron-right mt-1"
                          ></i>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive card-body payterm hide p-0">
                      <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="min150">Item</th>
                            <th class="min150">Item Description</th>
                            <th class="max150">Qty./Unit</th>
                            <th class="min100">Unit Price</th>
                            <th class="min150">Total Value</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (is_array($payterms) || is_object($payterms)) : ?>
                          <?php foreach($payterms as $payterm) : ?>
                          <tr>
                            <td>
                              <?php echo $payterm['item']?>
                            </td>
                            <td>
                              <?php echo $payterm['description']?>
                            </td>
                            <td>
                              <?php echo $payterm['qty']?>
                              /
                              <?php echo $UOM[$payterm['uom_id']] ?>
                            </td>
                            <td>
                              <?php echo $payterm['unit_price']?>
                            </td>
                            <td>
                              ₹
                              <?php echo $payterm['total'] ?>
                            </td>
                            <td id="pdf<?php echo $payterm['id'] ?>"></td>
                          </tr>
                          <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endif; ?>

                <?php if (empty($invoices) == 0) : ?>
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row invdtlstoggle pointer">
                        <div class="col-10">
                          <b>Invoice Details</b>
                        </div>
                        <div class="col-2 text-right">
                          <i
                            id="id_invdtls"
                            class="fas fa-chevron-right mt-1"
                          ></i>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive card-body invdetail hide p-0">
                      <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="min150">Invoice No.</th>
                            <th class="min150">Base Amt</th>
                            <th class="max150">GST</th>
                            <th class="min100">Invoice Amt</th>
                            <th class="min150">Due Date</th>
                            <th class="min150">Balance Amt.</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (is_array($invoices) || is_object($invoices)) : ?>
                          <?php foreach($invoices as $invoice) : ?>
                          <tr>
                            <td>
                              <?php echo $invoice['invoice_no']?>
                            </td>
                            <td>
                              <?php echo $invoice['sub_total']?>
                            </td>
                            <td>
                              <?php echo $invoice['igst'] + $invoice['sgst']+ $invoice['cgst']?>
                            </td>
                            <td>
                              <?php echo $invoice['invoice_total']?>
                            </td>
                            <td>
                              <?php echo date('d M Y', strtotime($invoice['due_date'])) ?>
                            </td>
                            <td>
                              <?php echo $invoice['balance_amt']?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                          <?php else: ?>
                          <tr>
                            <td colspan="5">No invoice raised</td>
                          </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endif; ?>

                <?php if (is_array($paymentDone) || is_object($paymentDone)) : ?>
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row paydtlstoggle pointer">
                        <div class="col-10">
                          <b>Payment Details</b>
                        </div>
                        <div class="col-2 text-right">
                          <i
                            id="id_paydtls"
                            class="fas fa-chevron-right mt-1"
                          ></i>
                        </div>
                      </div>
                    </div>
                    <div class="table-responsive card-body paydetail hide p-0">
                      <table class="table text-center">
                        <thead>
                          <tr>
                            <th class="min150">Invoice No.</th>
                            <th class="min150">Description</th>
                            <th class="max150">Payment Date</th>
                            <th class="min100">Allocated Amount</th>
                            <th class="min150">Cheque / UTR</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (is_array($paymentDone) || is_object($paymentDone)) : ?>
                          <?php foreach($paymentDone as $payment) : ?>
                          <tr>
                            <td>
                              <?php echo $payment['invoice_no']?>
                            </td>
                            <td>
                              <?php echo $payment['description']?>
                            </td>
                            <td>
                              <?php echo date('d M Y', strtotime($payment['payment_date']))?>
                            </td>
                            <td>
                              <?php echo $payment['allocated_amt']?>
                            </td>
                            <td>
                              <?php echo $payment['utr_file'] ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                          <?php else: ?>
                          <tr>
                            <td colspan="5">No Payment Received</td>
                          </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-footer text-right">
                <a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
                  Back
                </a>
                <a href="#" class="btn btn-default btn-sm">
                  Edit
                </a>
                <?php if ($order['open_po']) : ?>
                <a href="<?php echo ROOT; ?>orders/renew/<?php echo $order['id'] ?>" class="btn btn-default btn-sm">
                  Renew
                </a>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    </div>
    <button
      type="button"
      id="modelpdf"
      style="display: none"
      data-toggle="modal"
      data-target="#modal-xl"
    ></button>
    <div class="modal fade" id="modal-xl">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header" id="modal_header">
            Open PO
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0" id="modal_body"></div>
        </div>
      </div>
    </div>
    <script>
      var oti = <?php echo $order['order_type'] ?>;
      var id = <?php echo $order['id'] ?>;
    </script>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>
