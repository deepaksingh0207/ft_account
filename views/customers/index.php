<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">View Customers</div>
                <div class="card-body p-3" id="list" style="display: block">
                  <table id="example1" class="table table-striped">
                    <thead class="text-center">
                      <tr>
                        <th></th>
                        <th>Customer</th>
                        <th>Contact Person</th>
                        <th>GSTIN</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <?php if (is_array($customers) || is_object($customers)) : ?>
                      <?php foreach ($customers as $customer) : ?>
                      <tr
                        data-href="<?php echo ROOT; ?>customers/view/<?php echo $customer['id'] ?>"
                      >
                        <td></td>
                        <td class="sublist"><?php echo $customer['name'] ?></td>
                        <td class="sublist">
                          <?php echo $customer['contact_person'] ?>
                        </td>
                        <td class="sublist">
                          <?php echo $customer['gstin'] ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
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
              <form action="" method="post" class="text-center mb-0">
                <div class="modal-header">
                  <h4 class="modal-title">Confirm Delete</h4>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete ?</p>
                  <input
                    type="hidden"
                    id="trashid"
                    name="deactivate"
                    value=""
                  />
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                  </button>
                  <a class="list btn btn-light btn-sm" data-dismiss="modal"
                    >Cancel</a
                  >
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
