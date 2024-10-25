<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-lg-3">
                      <label for="id_startdate"> Start Date :</label>
                      <input type="date" class="form-control ftsm" name="startdate" id="id_startdate">
                    </div>
                    <div class="col-sm-12 col-lg-3">
                      <label for="id_enddate"> End Date :</label>
                      <input type="date" class="form-control ftsm" name="enddate" id="id_enddate">
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <label for="id_customer"> Customer : </label>
                      <select class="form-control fc ftsm select2 mt-0" name="customer" id="id_customer">
                        <option>Select Customer</option>
                        <?php foreach ($customers as $customer) : ?>
                          <option value="<?php echo $customer['id'] ?>">
                            <?php echo $customer['customer_name'] . ' (' . $customer['state_name'] . ')' ?>
                          </option>
                        <?php endforeach; ?>
                      </select>

                    </div>
                    <div class="col-sm-12 col-lg-3 mt-4">
                      <div class="btn-group mt-2">
                        <button type="button" class="btn btn-default update">
                          <i class="fas fa-search my-1"></i>
                        </button>
                        <a href="<?php echo ROOT; ?>payments" type="button" class="btn btn-default">
                          Clear
                        </a>
                        <a href="<?php echo ROOT; ?>payments/create" type="button" class="btn btn-default">
                          New Payment
                        </a>
                      </div>
                    </div>
                    <div class="col-12">
                      <table id="example1" class="table table-striped table-hover">
                        <thead class="text-center">
                          <tr>
                            <th>Customer</th>
                            <th>Invoice</th>
                            <th>Cheque/UTR</th>
                            <th>Received Amt</th>
                            <th>Payment Date</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <?php if (count($payments)) :
                            foreach ($payments as $payment) :
                          ?>
                              <tr data-href="payments/view/<?php echo $payment['id'] ?>">
                                <td class="sublist">
                                  <?php echo $payment['name'] ?>
                                </td>
                                <td class="sublist">
                                  <?php echo $payment['invoice_no'] ?>
                                </td>
                                <td class="sublist">
                                  <?php echo $payment['cheque_utr_no'] ?>
                                </td>
                                <td class="sublist">
                                  <?php echo $payment['received_amt'] ?>
                                </td>
                                <td class="sublist">
                                  <?php echo date('d, M Y', strtotime($payment['payment_date'])) ?>
                                </td>
                              </tr>

                          <?php endforeach;
                          endif;
                          ?>
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