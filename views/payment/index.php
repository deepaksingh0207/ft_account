<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">Payment List</div>
                <div class="card-body p-3" id="list" style="display: block">
                  <table id="example1" class="table table-striped">
                    <thead class="text-center">
                      <tr>
                        <th></th>
                        <th>#</th>
                        <th>Basic Value</th>
                        <th>GST</th>
                        <th>Invoice Amt</th>
                        <th>TDS %</th>
                        <th>Net Amt</th>
                        <th>Payment Amt</th>
                        <th>Cheque</th>
                        <th>Received Amt</th>
                        <th>Allocated Amt</th>
                        <th>Balance Amt</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr data-href="<?php echo ROOT; ?>customers/view/<?php echo $customer['id'] ?>">
                        <td></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                        <td class="sublist"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>