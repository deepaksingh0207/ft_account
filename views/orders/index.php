<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <div class="card">

            <div class="card-header">
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
                  <select class="form-control fc ftsm select2 mt-0" name="customer_id" id="id_customer">
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
                    <a href="<?php echo ROOT; ?>orders" type="button" class="btn btn-default">
                      Clear
                    </a>
                    <a href="<?php echo ROOT; ?>orders/create" type="button" class="btn btn-default">
                      New Order
                    </a>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-hover">

                <thead class="text-center">
                  <tr>
                    <th>Date</th>
                    <th style="max-width:200px;">Order</th>
                    <th style="max-width:250px;">Customer</th>
                    <th>Salesperson</th>
                    <th>Amount</th>
                  </tr>
                </thead>

                <tbody class="text-center">
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>