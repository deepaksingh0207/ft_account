<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-0 table-responsive">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Users Access Control List</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($users) || is_object($users)) : ?>
                      <?php foreach ($users as $user) : ?>
                      <tr data-href="<?php echo ROOT; ?>admin/acl/<?php echo $user['id'] ?>">
                        <td class="sublist">
                          <?php echo $user['name'] ?>
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
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>