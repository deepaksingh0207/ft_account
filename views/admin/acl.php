<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <form method="post">
            <div class="card">
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                    <th>Page Access</th>
                    <th>List</th>
                    <th>Add</th>
                    <th>Edit</th>
                    <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Company</td>
                      <td></td>
                      <td></td>
                      <td>
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_company_edit" name="controller[company][edit]">
                          <label for="id_company_edit"></label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_company_detail" name="controller[company][detail]">
                          <label for="id_company_detail"></label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Customer Group</td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroups_list" name="controller[customergroups][list]">
                          <label for="id_customergroups_list">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroups_create" name="controller[customergroups][create]">
                          <label for="id_customergroups_create">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customergroups_edit" name="controller[customergroups][edit]">
                          <label for="id_customergroups_edit">
                          </label>
                        </div>
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Customer</td>
                      <td>
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_list" name="controller[customer][list]">
                          <label for="id_customer_list">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_create" name="controller[customer][create]">
                          <label for="id_customer_create">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_edit" name="controller[customer][edit]">
                          <label for="id_customer_edit">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_customer_detail" name="controller[customer][detail]">
                          <label for="id_customer_detail">
                          </label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Order</td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_orders_list" name="controller[orders][list]">
                          <label for="id_orders_list">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_orders_create" name="controller[orders][create]">
                          <label for="id_orders_create">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_orders_edit" name="controller[orders][edit]">
                          <label for="id_orders_edit">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_orders_detail" name="controller[orders][detail]">
                          <label for="id_orders_detail">
                          </label>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Invoice</td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_invoices_list" name="controller[invoices][list]">
                          <label for="id_invoices_list">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_invoices_create" name="controller[invoices][create]">
                          <label for="id_invoices_create">
                          </label>
                        </div>
                      </td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Payment</td>
                      <td></td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payments_create" name="controller[payments][create]">
                          <label for="id_payments_create">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payments_edit" name="controller[payments][edit]">
                          <label for="id_payments_edit">
                          </label>
                        </div>
                      </td>
                      <td>
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" id="id_payments_detail" name="controller[payments][detail]">
                          <label for="id_payments_detail">
                          </label>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
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