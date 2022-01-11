<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row mt-3">
            <div class="col-12 col-sm-12">
              <div class="card card-primary card-tabs" style="min-height: 75vh;">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="pt-2 px-3">
                      <h3 class="card-title">DASHBOARD</h3>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" id="ip_tab" data-toggle="pill" href="#ip" role="tab" aria-controls="ip"
                        aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pc_tab" data-toggle="pill" href="#pc" role="tab" aria-controls="pc"
                        aria-selected="false">Completed</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show active" id="ip" role="tabpanel" aria-labelledby="ip-tab">
                      <div class="row">
                        <div class="col-sm-12 col-lg-3">
                          <label for="id_startdate"> Start Date :</label>
                          <input type="date" class="form-control ftsm" name="startdate" id="id_startdate">
                        </div>
                        <div class="col-sm-12 col-lg-3">
                          <label for="id_enddate"> End Date :</label>
                          <input type="date" class="form-control ftsm" name="enddate" id="id_enddate">
                        </div>
                        <div class="col-sm-12 col-lg-3">
                          <label for="id_customer"> Customer : </label>
                          <select class="form-control fc ftsm select2 mt-0" name="customer" id="id_customer">
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $customer) : ?>
                            <option value="<?php echo $customer['id'] ?>">
                              <?php echo $customer['name'] ?>
                            </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 mt-4">
                          <div class="btn-group mt-2">
                            <button type="button" class="btn btn-default update">
                              <i class="fas fa-search my-1"></i>
                            </button>
                            <a href="<?php echo ROOT; ?>dashboard" type="button" class="btn btn-default">
                              Clear
                            </a>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-12 mt-3">
                          <table id="example2" class="table table-striped table-hover table-bordered">
                            <thead>
                              <tr>
                                <th rowspan="2">Customer</th>
                                <th colspan="3" class="text-center" style="border-bottom: 0px;">
                                  Invoice
                                </th>
                                <th rowspan="2">TDS</th>
                                <th rowspan="2">Received Amount</th>
                                <th rowspan="2">Balance Amount</th>
                                <th rowspan="2">Due Date</th>
                                <th rowspan="2">Ageing</th>
                              </tr>
                              <tr>
                                <th>No.</th>
                                <th class="text-center">Date</th>
                                <th>Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (is_array($invoices) || is_object($invoices)) : ?>
                              <?php foreach ($invoices as $invoice) : ?>
                              <tr data-href="<?php echo $invoice['invoice_id'] ?>">
                                <?php if ($invoice['balance_amount'] - $invoice['tds_deducted'] != 0) : ?>
                                <td class="align-middle text-center">
                                  <?php echo $invoice['customer_name'] ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php echo $invoice['invoice_no'] ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php echo date('d, M Y', strtotime($invoice['invoice_date'])) ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php echo $invoice['invoice_amount'] ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php if ($invoice['tds_deducted']) : ?>
                                  <?php echo $invoice['tds_deducted'] ?>
                                  <?php else :  ?>
                                  0
                                  <?php endif; ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php echo $invoice['recieved_amount'] ?>
                                </td>
                                <td class="sublist pointer align-middle text-center">
                                  <?php echo $invoice['balance_amount'] - $invoice['tds_deducted'] ?>
                                </td>
                                <td class="sublist pointer align-middle text-center"
                                  id="due<?php echo $invoice['invoice_id'] ?>">
                                  <?php echo date('D, d M Y', strtotime($invoice['due_date'])) ?>
                                </td>
                                <td id="age<?php echo $invoice['invoice_id'] ?>"></td>
                                <?php endif; ?>
                              </tr>
                              <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pc" role="tabpanel" aria-labelledby="pc-tab">
                      <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead>
                          <tr>
                            <th rowspan="2">Customer</th>
                            <th colspan="3" class="text-center" style="border-bottom: 0px;">
                              Invoice
                            </th>
                            <th rowspan="2">TDS</th>
                            <th rowspan="2">Received Amount</th>
                            <th rowspan="2">Balance Amount</th>
                            <th rowspan="2">Due Date</th>
                          </tr>
                          <tr>
                            <th>No.</th>
                            <th class="text-center">Date</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (is_array($invoices) || is_object($invoices)) : ?>
                          <?php foreach ($invoices as $invoice) : ?>
                          <?php if ($invoice['balance_amount'] -$invoice['tds_deducted'] == 0) : ?>
                          <tr data-href="<?php echo $invoice['invoice_id'] ?>">
                            <td class="align-middle text-center text-success">
                              <?php echo $invoice['customer_name'] ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo $invoice['invoice_no'] ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo date('d, M Y', strtotime($invoice['invoice_date'])) ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo $invoice['invoice_amount'] ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php if ($invoice['tds_deducted']) : ?>
                              <?php echo $invoice['tds_deducted'] ?>
                              <?php else :  ?>
                              0
                              <?php endif; ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo $invoice['recieved_amount'] ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo $invoice['balance_amount'] - $invoice['tds_deducted'] ?>
                            </td>
                            <td class="sublist pointer align-middle text-center text-success">
                              <?php echo date('D, d M Y', strtotime($invoice['due_date'])) ?>
                            </td>
                          </tr>
                          <?php endif; ?>
                          <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
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
    <script>
      var invoicelist = [], tabledates = []
      <?php if (is_array($invoices) || is_object($invoices)) : ?>
      <?php foreach($invoices as $invoice) : ?>
        invoicelist.push(<?php echo $invoice['invoice_id'] ?>);
      tabledates.push('<?php echo date('m / d / Y', strtotime($invoice['due_date'])) ?>');
      <?php endforeach; ?>
      <?php endif; ?>
    </script>