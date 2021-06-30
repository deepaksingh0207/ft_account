<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title" style="line-height: 2.2">
                    Invoice Payments
                  </h3>
                  <div class="text-right">
                    <!-- <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                        Edit
                      </button> -->
                    <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body p-3">
                  <div class="row mx-1 justify-content-center">
                    <div class="col-6">
                      <div class="card">
                        <div class="card-body">
                          <div class="text-bold my-1">
                            Customer Group :
                          </div>
                          <div class="text-bold my-1">
                            Customer :
                          </div>
                          <div class="text-bold my-1">
                            Remarks :
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="card">
                        <div class="card-body">
                          <div class="text-bold my-1">
                            Payment Date :
                          </div>
                          <div class="text-bold my-1">
                            Cheque/UTR no. :
                          </div>
                          <div class="text-bold my-1">
                            Received Amt :
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <table class="table text-center">
                            <thead>
                              <tr>
                                <th>
                                  Invoice Number
                                </th>
                                <th>
                                  Invoice Amount
                                </th>
                                <th>
                                  Allocated Amount
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
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
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>