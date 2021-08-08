<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <div class="card">
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
                  <button class="btn btn btn-primary update mt-2" type="button">
                    <i class="fas fa-search my-1"></i>
                  </button>
                  <a href="<?php echo ROOT; ?>orders/create" class="btn btn btn-primary mt-2">
                    New Order
                  </a>
                  <a href="<?php echo ROOT; ?>orders" class="btn btn btn-primary mt-2">
                    Cancel
                  </a>
                </div>
                <div class="col-12 mt-3">
                  <table id="example1" class="table table-striped table-hover">
                    <thead class="text-center">
                      <tr>
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
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>