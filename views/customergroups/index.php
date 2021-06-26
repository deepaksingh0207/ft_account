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
                        <button class="btn btn btn-primary" type="submit" id="update" style="display: none;"
                          formaction="">
                          Update
                        </button>
                        <button class="btn btn btn-primary" type="submit" id="add">
                          Add
                        </button>
                        <button type="reset" class="btn btn btn-primary" id="cancel">Cancel</button>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-12">
                      <table id="example1" class="table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Customer Group</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(count($customergroups)) : 
                        foreach ($customergroups as $groups) :
                        ?>
                          <tr class="groupy">
                            <td class="id">
                              <?php echo $groups['id']?>
                            </td>
                            <td class="name"><?php echo $groups['name']?></td>
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
              <form id="id_deleteform" method="post" class="text-center mb-0">
                <div class="modal-header">
                  <div class="modal-title">ORDER DELETE</div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>
                    This action is irreversible please confirm this delete?
                  </p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger btn-sm" id="modaldelete">
                    Delete
                  </button>
                  <button type="button" id="byemodal" class="btn btn-light btn-sm" data-dismiss="modal">
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>