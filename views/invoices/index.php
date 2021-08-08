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
                  <button class="btn btn-primary update mt-2" type="button">
                    <i class="fas fa-search my-1"></i>
                  </button>
                  <a href="<?php echo ROOT; ?>invoices/create" class="btn btn-primary mt-2">
                    New Invoice
                  </a>
                  <a href="<?php echo ROOT; ?>invoices" class="btn btn-primary mt-2">
                    Cancel
                  </a>
                </div>
                <div class="col-sm-12 col-lg-12 text-right">
                  
                </div>
                <div class="col-12 mt-3">
                  <table id="example1" class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Invoice No</th>
                        <th>Order/PO</th>
                        <th>Customer</th>
                        <th>Salesperson</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="button" id="modelpdf" style="display: none" data-toggle="modal" data-target="#modal-xl"></button>
        <div class="modal fade" id="modal-xl">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header" id="modal_header">
                Invoice
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body p-0" id="modal_body">
              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>