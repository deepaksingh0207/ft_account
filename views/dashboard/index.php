<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row mt-3">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-lg-2 form-group">
                      <label for="id_period"> Period : </label>
                      <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                        <option value="1">All</option>
                        <option value="2">Custom Period</option>
                        <option value="3">Today</option>
                        <option value="4">Yesterday</option>
                        <option value="5">Today</option>
                        <option value="6">This Week</option>
                        <option value="7">Last Week</option>
                        <option value="8">This Month</option>
                        <option value="9">Last Month</option>
                      </select>
                    </div>
                    <div class="col-sm-12 col-lg-5">
                      <div class="row">
                        <div class="col-sm-12 col-lg-6">
                          <label for="id_startdate"> Start Date :</label>
                          <input type="date" class="form-control ftsm" name="startdate" id="id_startdate"
                            disabled="True" />
                        </div>
                        <div class="col-sm-12 col-lg-6">
                          <label for="id_enddate"> End Date :</label>
                          <input type="date" class="form-control ftsm" name="enddate" id="id_enddate" disabled="True" />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-lg-2 form-group">
                      <label for="id_customer"> Customer : </label>
                      <select class="form-control fc ftsm select2 mt-0" name="customer" id="id_customer">
                        <option value=""></option>
                        <option value="">Customer A</option>
                      </select>
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-2">
                      <br />
                      <button class="btn btn-sm btn-primary update" type="button">
                        Update
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-lg-12">
                      <table id="example1" class="table table-striped  table-bordered">
                          <thead>
                            <tr>
                              <th rowspan="2">Customer</th>
                              <th colspan="3" class="text-center" style="border-bottom: 0px;">Invoice</th>
                              <th rowspan="2">Received Amount</th>
                              <th rowspan="2">Balance Amount</th>
                              <th rowspan="2">Due Date</th>
                              <th rowspan="2" rowspan="2">Ageing</th>
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
                            <tr data-href="<?php echo ROOT; ?>invoices/view/<?php echo $invoice['invoice_id'] ?>">
                              <td class="sublist align-middle text-center">
                                <?php echo $invoice['customer_name'] ?>
                              </td>
                              <td class="sublist align-middle text-center">
                                <?php echo $invoice['invoice_id'] ?>
                              </td>
                              <td class="sublist align-middle text-center">
                                <?php echo date('d, M Y', strtotime($invoice['invoice_date'])) ?>
                              </td>
                              <td class="sublist align-middle text-center">
                                <?php echo $invoice['invoice_amount'] ?>
                              </td>
                              <td class="sublist align-middle text-center">
                                <?php echo $invoice['recieved_amount'] ?>
                              </td>
                              <td class="sublist align-middle text-center">
                                <?php echo $invoice['balance_amount'] ?>
                              </td>
                              <td class="sublist align-middle text-center" id="due<?php echo $invoice['invoice_id'] ?>"><?php echo date('D, d M Y', strtotime($invoice['due_date'])) ?></td>
                              <td id="age<?php echo $invoice['invoice_id'] ?>"></td>
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
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    <script>
      var invoicelist = []
      <?php if (is_array($invoices) || is_object($invoices)) : ?>
      <?php foreach ($invoices as $invoice) : ?>
      invoicelist.push(<?php echo $invoice['invoice_id'] ?>);
      <?php endforeach; ?>
      <?php endif; ?>
    </script>