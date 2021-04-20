<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">
    <div ftsolutions="menu.html"></div>
    <div class="content-wrapper">
      <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card card-default mt-3">
                <div class="card-header">View Customers</div>
                <div class="card-body p-3" id="list" style="display: block">
                  <table id="example1" class="table table-hover table-striped">
                    <thead class="text-center">
                      <tr>
                        <th>Customer</th>
                        <th>Contact Person</th>
                        <th>GSTIN</th>
                        
                        
                        
                        <!--  <th>Statement</th>
                        <th>Delete</th> -->
                      </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php foreach ($customers as $customer) : ?>
                      <tr data-href="new_customer.html">
                        <td class="sublist"><?php echo $customer['name']?></td>
                        <td class="sublist"><?php echo $customer['contact_person']?></td>
                        <td class="sublist"><?php echo $customer['gstin']?></td>
                        
                        
                        
                       <!-- <td data-href="new_customer.html">
                          <i class="far fa-file-alt statement"></i>
                        </td>
                        <td>
                          <i class="fas fa-trash-alt trash" id="1"></i>
                        </td> -->
                      </tr>
                      <?php endforeach; ?>
                      
                    </tbody>
                  </table>
                </div>
                <!-- <div class="card-body p-3" id="trash" style="display: none">
                  <form action="" method="post" class="text-center">
                    <p>Are you sure you want to delete?</p>
                    <input type="hidden" id="trashid" name="deactivate" />
                    <button type="submit" class="btn btn-danger">
                      Delete
                    </button>
                    <a class="list btn btn-light">Cancel</a>
                  </form>
                </div> -->
              </div>
            </div>
          </div>
        </div>
        <button type="button" id="modelactivate" style="display: none;" data-toggle="modal" data-target="#modal-default"></button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="" method="post" class="text-center mb-0">
                <div class="modal-header">
                  <h4 class="modal-title">Confirm Delete</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete ?</p>
                  <input type="hidden" id="trashid" name="deactivate" value="" />
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                  </button>
                  <a class="list btn btn-light btn-sm" data-dismiss="modal">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div>