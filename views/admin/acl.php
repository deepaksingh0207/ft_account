<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <form method="post">
            <div class="card">
              <div class="card-body">
                
                <div class="row">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Company</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_company_detail" name="controller[company][detail]">
                          <label for="id_company_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_company_edit" name="controller[company][edit]">
                          <label for="id_company_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Customer Group</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroup_list" name="controller[customergroup][list]">
                          <label for="id_customergroup_list">
                            List
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroup_edit" name="controller[customergroup][edit]">
                          <label for="id_customergroup_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroup_create" name="controller[customergroup][create]">
                          <label for="id_customergroup_create">
                            Create
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Customer</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_list" name="controller[customer][list]">
                          <label for="id_customer_list">
                            List
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_edit" name="controller[customer][edit]">
                          <label for="id_customer_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_create" name="controller[customer][create]">
                          <label for="id_customer_create">
                            Create
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_detail" name="controller[customer][detail]">
                          <label for="id_customer_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- 
                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Dashboard</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_dashboard_list" name="dashboard[list]">
                          <label for="id_dashboard_list">
                            List
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_dashboard_edit" name="dashboard[edit]">
                          <label for="id_dashboard_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_dashboard_create" name="dashboard[create]">
                          <label for="id_dashboard_create">
                            Create
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_dashboard_detail" name="dashboard[detail]">
                          <label for="id_dashboard_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                 -->

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Order</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_order_list" name="controller[order][list]">
                          <label for="id_order_list">
                            List
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_order_edit" name="controller[order][edit]">
                          <label for="id_order_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_order_create" name="controller[order][create]">
                          <label for="id_order_create">
                            Create
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_order_detail" name="controller[order][detail]">
                          <label for="id_order_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Invoice</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">

                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_invoice_list" name="controller[invoice][list]">
                          <label for="id_invoice_list">
                            List
                          </label>
                        </div>
                      </div>

                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_invoice_create" name="controller[invoice][create]">
                          <label for="id_invoice_create">
                            Create
                          </label>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <hr>

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Payment</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payment_edit" name="controller[payment][edit]">
                          <label for="id_payment_edit">
                            Edit
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payment_create" name="controller[payment][create]">
                          <label for="id_payment_create">
                            Create
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payment_detail" name="controller[payment][detail]">
                          <label for="id_payment_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 
                <hr>

                <div class="row mt-3">
                  <div class="col-sm-12 col-lg-3 mb-2">
                    <i><b>Users</b></i>
                  </div>
                  <div class="col-sm-12 col-lg-9">
                    <div class="row">
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_users_list" name="users[list]">
                          <label for="id_users_list">
                            List
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_users_create" name="users[create]">
                          <label for="id_users_create">
                            Create
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3 col-lg-3 mb-2">
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_users_detail" name="users[detail]">
                          <label for="id_users_detail">
                            Detail
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                 -->

              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  Apply
                </button>
                <a href="<?php echo ROOT; ?>admin/" class="btn btn-primary">
                  Back
                </a>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    <script>
      <?php if (is_array($accesslist) || is_object($accesslist)) : ?>
        <?php foreach ($accesslist as $access) : ?>
          $('#id_<?php echo $access['controller'] ?>_<?php echo $access['action'] ?>').prop('checked', true);
        <?php endforeach; ?>
      <?php endif; ?>
    </script>