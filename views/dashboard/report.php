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
                  <div class="tab-content" id="custom-tabs-two-tabContent">
                        
                        <div class="col-sm-12 col-lg-12 mt-3">
                          <table id="example" class="table table-striped table-hover table-bordered" style="width: 100%;">
                            <thead>
                              <tr>
                                <th>Customer</th>
                                <th>PO No</th>
                                <th>Valid From</th>
                                <th>Valid TO</th>
                                <th>Invoice No</th>
                                <th>description</th>
                                <th>Due Date</th>
                                <th>Invoice Amount</th>
                                <th>TDS Deducted</th>
                                <th>Allocated Amount</th>
                                <th>Received Amount</th>
                                <th>Balance Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                              <?php foreach ($report as $row) : ?>
                                
                                <tr data-href="<?php echo $row['invoice_no'] ?>">
                                <td><?php echo $row['Customer'] ?></td>
                                <td><?php echo $row['PO No'] ?></td>
                                <td><?php echo ($row['Valid From']) ? date('d/m/Y', strtotime($row['Valid From'])) : '' ?></td>
                                <td><?php echo ($row['Valid To']) ? date('d/m/Y', strtotime($row['Valid To'])) : '' ?></td>
                                <td><?php echo $row['Invoice No'] ?></td>
                                <td><?php echo $row['description'] ?></td>
                                <td><?php echo ($row['Invoice Due Date']) ? date('d/m/Y', strtotime($row['Invoice Due Date'])) : ''?></td>
                                <td><?php echo $row['Invoice Amount'] ?></td>
                                <td><?php echo $row['TDS Deducted'] ?></td>
                                <td><?php echo $row['allocated_amt'] ?></td>
                                <td><?php echo $row['Received Amount'] ?></td>
                                <td><?php echo $row['Balance Amount'] ?></td>
                              
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
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
   