<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-12 mt-3 mb-5">
              <div class="card card-primary card-tabs" style="min-height: 75vh">
                <div class="card-header p-0 pt-1">
                  <ul
                    class="nav nav-tabs"
                    id="custom-tabs-two-tab"
                    role="tablist">
                    <li class="nav-item">
                      <a
                        class="nav-link active"
                        id="sy_tab"
                        data-toggle="pill"
                        href="#sy"
                        role="tab"
                        aria-controls="sy"
                        aria-selected="true">Summary</a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="opo_tab"
                        data-toggle="pill"
                        href="#opo"
                        role="tab"
                        aria-controls="opo"
                        aria-selected="false">
                        Open PO
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="ip_tab"
                        data-toggle="pill"
                        href="#ip"
                        role="tab"
                        aria-controls="ip"
                        aria-selected="true">
                        Receivable
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="pc_tab"
                        data-toggle="pill"
                        href="#pc"
                        role="tab"
                        aria-controls="pc"
                        aria-selected="false">Completed</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="sy"
                      role="tabpanel"
                      aria-labelledby="sy_tab">
                      <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                              <?php echo $orderSumary['no'] ?>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Order</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($orderSumary['ORD_AMT']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                              <?php echo $invoiceSumary['no'] ?>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Invoice</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($invoiceSumary['INV_AMT']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                              <i class="fas fa-rupee-sign"></i>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">TDS</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($paymentSumary['TDS']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                              <?php echo $paymentSumary['no'] ?>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Payments</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($paymentSumary['AMT']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                              <i class="fas fa-rupee-sign"></i>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Total</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($paymentSumary['AMT'] + $paymentSumary['TDS']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                              <i class="fas fa-rupee-sign"></i>
                            </span>
                            <div class="info-box-content">
                              <span class="info-box-text">Balance</span>
                              <span class="info-box-number">
                                <small><i class="fas fa-rupee-sign"></i></small>
                                <?php echo number_format($invoiceSumary['INV_AMT'] - ($paymentSumary['AMT'] + $paymentSumary['TDS'])) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="ip"
                      role="tabpanel"
                      aria-labelledby="ip-tab">
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_startdate"> Start Date :</label>
                          <input
                            type="date"
                            class="form-control ftsm"
                            name="startdate"
                            id="id_startdate" />
                        </div>
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_enddate"> End Date :</label>
                          <input
                            type="date"
                            class="form-control ftsm"
                            name="enddate"
                            id="id_enddate" />
                        </div>
                        <!-- ------po filter---- -->
                        <div class="col-sm-12 col-lg-2">
                          <label for="po_no">Search PO</label>
                          <input type="text" id="po_no" name = "po_no" class="form-control" placeholder="Search PO Number">

                        </div>
                        <!-- ----end---- -->
                        <div class="col-sm-12 col-lg-3">
                          <label for="id_customer"> Customer : </label>
                          <select
                            class="form-control fc ftsm select2 mt-0"
                            name="customer"
                            id="id_customer">
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $customer) : ?>
                              <option value="<?php echo $customer['id'] ?>">
                                <?php echo $customer['customer_name'] . ' - ' . $customer['state_name'] ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 mt-4">
                          <div class="btn-group mt-2">
                            <button
                              type="button"
                              class="btn btn-default update">
                              <i class="fas fa-search my-1"></i>
                            </button>
                            <a
                              href="<?php echo ROOT; ?>dashboard"
                              type="button"
                              class="btn btn-default">
                              Clear
                            </a>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-12 mt-3">
                          <table
                            id="example1"
                            class="table table-striped table-hover table-bordered"
                            style="width: 100%">
                            <thead>
                              <tr>
                                <th rowspan="2">Customer</th>
                                <th
                                  colspan="4"
                                  class="text-center"
                                  style="border-bottom: 0px">
                                  Invoice
                                </th>
                                <th rowspan="2">TDS</th>
                                <th rowspan="2">Received Amount</th>
                                <th rowspan="2">Balance Amount</th>
                                <th rowspan="2">Due Date</th>
                                <th rowspan="2">Ageing</th>
                              </tr>
                              <tr>
                           
                                <th>PO</th>
                                <th>No.</th>
                                <th class="text-center">Date</th>
                                <th>Amount</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="pc"
                      role="tabpanel"
                      aria-labelledby="pc-tab">
                      <table
                        id="example2"
                        class="table table-striped table-hover table-bordered"
                        style="width: 100%">
                        <thead>
                          <tr>
                            <th rowspan="2">Customer</th>
                            <th
                              colspan="3"
                              class="text-center"
                              style="border-bottom: 0px">
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
                              <?php if ($invoice['balance_amount'] - $invoice['tds_deducted'] == 0) : ?>
                                <tr data-href="<?php echo $invoice['invoice_id'] ?>">
                                  <td class="align-middle text-center text-success">
                                    <?php echo $invoice['customer_name'] ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo $invoice['invoice_no'] ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo date('d, M Y', strtotime($invoice['invoice_date'])) ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo $invoice['invoice_amount'] ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php if ($invoice['tds_deducted']) : ?>
                                      <?php echo $invoice['tds_deducted'] ?>
                                    <?php else :  ?>
                                      0
                                    <?php endif; ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo $invoice['recieved_amount'] ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo $invoice['balance_amount'] - $invoice['tds_deducted'] ?>
                                  </td>
                                  <td
                                    class="sublist pointer align-middle text-center text-success">
                                    <?php echo date('D, d M Y', strtotime($invoice['due_date'])) ?>
                                  </td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="opo"
                      role="tabpanel"
                      aria-labelledby="opo-tab">
                      <table id="ordersummary" class="table table-striped table-hover table-bordered" style="width: 100%;">
                        <thead>
                          <tr>
                            <th>Customer</th>
                            <th>PO No</th>
                            <th>PO Amount</th>
                            <th>Invoice Amount</th>
                            <th>
                              Received Amount<br />
                              <span style="font-size:12px;">(TDS + Allocated)</span>
                            </th>
                            <th>Balance Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($reports as $row) : ?>
                            <tr data-href="<?php echo $row['id'] ?>">
                              <td class="ordersummary pointer"><?php echo $row['name'] ?></td>
                              <td class="ordersummary pointer"><?php echo $row['po_no'] ?></td>
                              <td class="ordersummary pointer"><?php echo $row['ordertotal'] ?></td>
                              <td class="ordersummary pointer"><?php echo $row['invoice_total'] ?></td>
                              <td class="ordersummary pointer"><?php echo $row['received'] ?></td>
                              <td class="ordersummary pointer"><?php echo $row['balance'] ?></td>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button
          type="button"
          class="btn btn-default hide"
          id="popup"
          data-toggle="modal"
          data-target="#modal-xl"></button>
        <div class="modal fade" id="modal-xl">
          <div class="modal-dialog modal-xl" style="max-width: 1200px">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">Monthly PO Monitoring</div>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table
                  class="table table-bordered mb-0"
                  id="example3"
                  style="width: 100%">
                  <thead>
                    <tr>
                      <th>Hide</th>
                      <th style="width: 115px">Company</th>
                      <th>Customer PO</th>
                      <th>Order Amount</th>
                      <th>Item</th>
                      <th>Description</th>
                      <th>Item Amount</th>
                      <th style="width: 55px">Order Date</th>
                      <th style="width: 55px">Due Date</th>
                      <th>Ageing</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (is_array($popuprows) || is_object($popuprows)) : ?>
                      <?php foreach ($popuprows as $key => $row) : ?>
                        <tr data-href="<?php echo $row['id'] ?>">
                          <td class="pointer align-middle">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input hidemon" name="<?php echo $row['id'] ?>" id="hide<?php echo $row['id'] ?>">
                              <label class="custom-control-label" for="hide<?php echo $row['id'] ?>"></label>
                            </div>
                          </td>
                          <td class="ordlist pointer align-middle">
                            <?php echo $row['name'] ?>
                          </td>
                          <td class="ordlist pointer align-middle">
                            <?php echo $row['po_no'] ?>
                          </td>
                          <td class="ordlist pointer align-middle">
                            <?php echo $row['ordertotal'] ?>
                          </td>
                          <?php if ($row['ageing'] < 11): ?>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['item'] ?>
                            </td>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['description'] ?>
                            </td>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['total'] ?>
                            </td>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['po_from_date'] ?>
                            </td>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['po_to_date'] ?>
                            </td>
                            <td
                              style="background-color: #f67161; color: #fff"
                              class="ordlist pointer">
                              <?php echo $row['ageing'] ?>
                            </td>
                          <?php elseif ($row['ageing'] < 21): ?>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['item'] ?>
                            </td>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['description'] ?>
                            </td>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['total'] ?>
                            </td>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['po_from_date'] ?>
                            </td>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['po_to_date'] ?>
                            </td>
                            <td
                              style="background-color: #ffe77aff; color: #2c5f2dff"
                              class="ordlist pointer">
                              <?php echo $row['ageing'] ?>
                            </td>
                          <?php else: ?>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['item'] ?>
                            </td>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['description'] ?>
                            </td>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['total'] ?>
                            </td>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['po_from_date'] ?>
                            </td>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['po_to_date'] ?>
                            </td>
                            <td
                              style="background-color: #2c5f2dff; color: #ffe77aff"
                              class="ordlist pointer">
                              <?php echo $row['ageing'] ?>
                            </td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    <script>
      var invoicelist = [],
        tabledates = [];
      <?php if (is_array($invoices) || is_object($invoices)) : ?>
        <?php foreach ($invoices as $invoice) : ?>
          invoicelist.push(<?php echo $invoice['invoice_id'] ?>);
          tabledates.push('<?php echo date('m / d / Y', strtotime($invoice['due_date'])) ?>');
        <?php endforeach; ?>
      <?php endif; ?>
      <?php if (count($popuprows) == 0) : ?>
        var popup = false;
      <?php else : ?>
        var popup = true;
      <?php endif; ?>
    </script>
  </div>
</body>
