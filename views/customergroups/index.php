<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row mt-3">
            <div class="col-12">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul
                    class="nav nav-tabs"
                    id="custom-tabs-four-tab"
                    role="tablist"
                  >
                  <?php include HOME . DS . 'includes' . DS . 'masters.inc.php'; ?>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="customergroup"
                      role="tabpanel"
                      aria-labelledby="customergroup_tab"
                    >
                      <table
                        id="customergroup_list"
                        class="table table-striped"
                      >
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Customer Group</th>
                            <th style="width: 100px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if($customergroups && count($customergroups)) : 
                                  foreach ($customergroups as $groups) :
                            ?>
                          <tr>
                            <td
                              class="id customer"
                              data-id="<?php echo $groups['id']?>"
                            >
                              <?php echo $groups['id']?>
                            </td>
                            <td
                              class="name customer"
                              data-id="<?php echo $groups['id']?>"
                            >
                              <?php echo $groups['name']?>
                            </td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-primary btn-sm groupy"
                                data-id="<?php echo $groups['id']?>"
                                data-name="<?php echo $groups['name']?>"
                              >
                                Edit
                              </button>
                            </td>
                          </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button
          type="button"
          id="modelactivate"
          style="display: none"
          data-toggle="modal"
          data-target="#modal-default"
        ></button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">Customers</div>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body p-0">
                <table class="table mb-0" id="customerbody"></table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>
