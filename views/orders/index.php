<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-primary card-tabs">
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
                        <?php foreach ($customers as $customer) : ?>
                        <option value="<?php echo $customer['id'] ?>">
                          <?php echo $customer['name'] ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-2">
                      <button class="btn btn btn-primary update mt-4" type="button">
                        Update
                      </button>
                      <a href="<?php echo ROOT; ?>orders/create" class="btn btn btn-primary mt-4">
                        Add New Order
                      </a>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                      <table id="example1" class="table table-striped">
                        <thead class="text-center">
                          <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Salesperson</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody class="text-center"></tbody>
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