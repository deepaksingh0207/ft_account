<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title" style="line-height: 2.2">
                Invoice Payments
              </h3>
              <div class="text-right">
                <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                  Back
                </a>
              </div>
            </div>
            <div class="card-body p-3">
              <div class="row mx-1">
                <div class="col-sm-12 col-lg-3">
                  <b>Customer Group : </b>
                  <?php echo $customerPayment['cust_group']?>
                </div>

                <div class="col-sm-12 col-lg-3">
                  <b>Customer : </b>
                  <?php echo $customerPayment['customer_name']?>
                </div>
                <?php if( $customerPayment['remarks'] ): ?>
                <div class="col-sm-12 col-lg-3">
                  <b>Remark</b>
                  <?php echo $customerPayment['remarks']?>
                </div>
                <?php endif; ?>

                <div class="col-12 mt-3">
                  <div class="card">
                    <div class="card-body">
                      <table class="table text-center">
                        <thead>
                          <tr>
                            <th>
                              Invoice Number
                            </th>
                            <th>
                              Allocated Amount
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(count($invoicePayment)) : 
                            foreach($invoicePayment as $payment) : ?>
                          <tr>
                            <td>
                              <a href="<?php echo ROOT; ?>invoices/view/<?php echo $payment['invoice_id']?>">
                                <?php echo $payment['invoice_id']?>
                              </a>
                            </td>
                            <td>
                              <?php echo $payment['allocated_amt']?>
                            </td>
                          </tr>
                          <?php 
                              endforeach;
                            endif;
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <!-- <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                    Edit
                  </button> -->
              <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                Back
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script>id =<? php echo $customerPayment['invoice_id'] ?></script>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>