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
                      <?php echo $invoice['id'] ?>
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
                      <?php echo $invoice['po_no'] ?>
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
                      <?php echo $invoice['remarks'] ?>
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
                              <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <b>Past Invoice Details</b>
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
                              <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <b>Payment Terms</b>
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
                              <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

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