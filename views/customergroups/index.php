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
                  Customer Group
                </div>
                <div class="card-body">
                  <form method="post" id="id_quickForm">
                    <div class="row">
                      <div class="col-sm-12 col-lg-5 form-group">
                        <label for="id_group_id"></label>
                        <input type="text" class="form-control ftsm" required="" name="name" id="id_group_id"
                          value="" />
                      </div>
                      <div class="col-sm-12 col-lg-3 pt-2">
                        <div class="btn-group">
                          <button type="submit" id="add" class="btn btn-default" formaction="">
                            Add
                          </button>
                          <button type="submit" id="update" style="display: none;" class="btn btn-default"
                            formaction="">
                            Update
                          </button>
                          <button type="reset" id="cancel" class="btn btn-default" formaction="">
                            Cancel
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-12">
                      <table id="example1" class="table table-striped">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Customer Group</th>
                            <th style="width: 100px;"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if($customergroups && count($customergroups)) : 
                        foreach ($customergroups as $groups) :
                        ?>
                          <tr>
                            <td class="id customer" data-id="<?php echo $groups['id']?>">
                              <?php echo $groups['id']?>
                            </td>
                            <td class="name customer" data-id="<?php echo $groups['id']?>">
                              <?php echo $groups['name']?>
                            </td>
                            <td>
                              <button type="button" data-id="<?php echo $groups['id']?>"
                                data-name="<?php echo $groups['name']?>" class="btn btn-primary btn-sm groupy">
                                Edit
                              </button>
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
          </div>
        </div>
        <button type="button" id="modelactivate" style="display: none" data-toggle="modal" data-target="#modal-default">
        </button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">Customers</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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