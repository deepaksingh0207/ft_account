<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-sm-12 mt-3 mb-5">
              <div class="card card-primary card-tabs" style="min-height: 75vh;">
                <div class="card-body">
                  <div class="col-sm-12 col-lg-12">
                    <table id="example" class="table table-striped table-hover table-bordered" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>PO No</th>
                          <th>Valid From</th>
                          <th>Valid TO</th>
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
                        <tr>
                          <td>
                            <?php echo $row['name'] ?>
                          </td>
                          <td>
                            <?php echo $row['po_no'] ?>
                          </td>
                          <td>
                            <?php echo ($row['Valid From']) ? date('d/m/Y', strtotime($row['Valid From'])) : '' ?>
                          </td>
                          <td>
                            <?php echo ($row['Valid To']) ? date('d/m/Y', strtotime($row['Valid To'])) : '' ?>
                          </td>
                          <td>
                            <?php echo $row['ordertotal'] ?>
                          </td>
                          <td>
                            <?php echo $row['invoice_total'] ?>
                          </td>
                          <td>
                            <?php echo $row['received'] ?>
                          </td>
                          <td>
                            <?php echo $row['balance'] ?>
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
      </section>
    </div>
  </div>
  <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>