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
                      <a href="<?php echo ROOT; ?>payments/create" class="btn btn-sm btn-primary">
                        Add New Payment
                      </a>
                    </div>
                    <div class="col-12">
                      <table id="example1" class="table table-striped table-hover">
                        <thead class="text-center">
                          <tr>
                            <th></th>
                            <th>Customer</th>
                            <th>Cheque/UTR</th>
                            <th>Received Amt</th>
                            <th>Payment Date</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <?php if(count($payments)) :
                        foreach($payments as $payment) :
                        ?>
                          <tr data-href="payments/view/<?php echo $payment['id']?>">
                            <td></td>
                            <td class="sublist"><?php echo $payment['name']?></td>
                            <td class="sublist"><?php echo $payment['cheque_utr_no']?></td>
                            <td class="sublist"><?php echo $payment['received_amt']?></td>
                            <td class="sublist"><?php echo date('d, M Y', strtotime($payment['payment_date']))?></td>
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