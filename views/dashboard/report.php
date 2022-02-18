<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-12 mt-3 mb-5">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <table id="example" class="table table-striped table-hover table-bordered" style="max-width: 100% !important;
                      font-size: 1vw;">
                        <thead>
                          <tr>
                            <th>
                              <label style="display: none;">Customer</label>
                              <input type="text" class="form-control form-control-sm" placeholder="Customer" />
                            </th>
                            <th>
                              <label style="display: none;">PO No</label>
                              <input type="text" class="form-control form-control-sm" placeholder="PO No" />
                            </th>
                            <th>Valid From</th>
                            <th style="min-width:70px">
                              <label style="display: none;">Valid TO</label>
                              <input type="text" class="form-control form-control-sm" placeholder="Valid TO" />
                            </th>
                            <th style="min-width:90px">
                              <label style="display: none;">Invoice No</label>
                              <input type="text" class="form-control form-control-sm" placeholder="Invoice No" />
                            </th>
                            <th>Description</th>
                            <th>
                              <label style="display: none;">Due Date</label>
                              <input type="text" class="form-control form-control-sm" placeholder="Due Date" />
                            </th>
                            <th>Invoice Amount</th>
                            <th>TDS Deducted</th>
                            <th>Allocated Amount</th>
                            <th>Received Amount</th>
                            <th>Balance Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($report as $row) : ?>
                          <tr data-href="<?php echo $row['Invoice No'] ?>">
                            <td>
                              <?php echo $row['Customer'] ?>
                            </td>
                            <td>
                              <?php echo $row['PO No'] ?>
                            </td>
                            <td>
                              <?php echo ($row['Valid From']) ? date('d/m/Y', strtotime($row['Valid From'])) : '' ?>
                            </td>
                            <td>
                              <?php echo ($row['Valid To']) ? date('d/m/Y', strtotime($row['Valid To'])) : '' ?>
                            </td>
                            <td>
                              <?php echo $row['Invoice No'] ?>
                            </td>
                            <td>
                              <?php echo $row['description'] ?>
                            </td>
                            <td>
                              <?php echo ($row['Invoice Due Date']) ? date('d/m/Y', strtotime($row['Invoice Due Date'])) : ''?>
                            </td>
                            <td>
                              <?php echo $row['Invoice Amount'] ?>
                            </td>
                            <td>
                              <?php echo $row['TDS Deducted'] ?>
                            </td>
                            <td>
                              <?php echo $row['allocated_amt'] ?>
                            </td>
                            <td>
                              <?php echo $row['Received Amount'] ?>
                            </td>
                            <td>
                              <?php echo $row['Balance Amount'] ?>
                            </td>
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
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>