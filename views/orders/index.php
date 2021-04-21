<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">
    <div class="content-wrapper">
      <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
      <section class="content">
        <div class="container">
          <br />
          <div class="row">
            <div class="col-12">
              <div class="card card-primary card-tabs">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-lg-2 form-group">
                      <label for="id_period1"> Period : </label>
                      <select class="form-control fc ftsm mt-0" name="period" id="id_period1">
                        <option value="1">All</option>
                        <option value="2">Custom Period</option>
                        <option value="3">Today</option>
                        <option value="4">Yesterday</option>
                        <option value="5">Today</option>
                        <option value="6">This Week</option>
                        <option value="7">Last Week</option>
                        <option value="8">This Month</option>
                        <option value="9">Last Month</option>
                      </select>
                    </div>
                    <div class="col-sm-12 col-lg-5">
                      <div class="row">
                        <div class="col-sm-12 col-lg-6">
                          <label for="id_startdate1"> Start Date :</label>
                          <input type="date" class="form-control ftsm" name="startdate" id="id_startdate1" />
                        </div>
                        <div class="col-sm-12 col-lg-6">
                          <label for="id_enddate1"> End Date :</label>
                          <input type="date" class="form-control ftsm" name="enddate" id="id_enddate1" />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customer1"> Customer : </label>
                      <select class="form-control fc ftsm mt-0" name="customer" id="id_customer1">
                        <option value=""></option>
                        <option value="">Customer A</option>
                      </select>
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-2">
                      <br>
                      <button class="btn btn-sm btn-primary update" type="button" id="1">Update</button>
                      <a href="<?php echo ROOT; ?>orders/create" class="btn btn-sm btn-primary">
                        Add New Order
                      </a>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                      <table id="w" class="table table-hover table-striped">
                        <thead>
                          <tr>
                            <th>DATE</th>
                            <th>ORDER</th>
                            <th>QUOTE</th>
                            <th>CUSTOMER</th>
                            <th>SALESPERSON</th>
                            <th>AMOUNT</th>
                            <th>CREATE INVOICE</th>
                            <th>EDIT</th>
                            <th>PDF</th>
                            <th>PRINT</th>
                            <th>DELETE</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr id="{{ #orderid here }}">
                            <td>1</td>
                            <td>200</td>
                            <td>1000</td>
                            <td>Balram</td>
                            <td>Prashant</td>
                            <td>20000</td>
                            <td>10001</td>
                            <td><i class='fas fa-pen edit' value='1'></i></td>
                            <td><i class='far fa-file-pdf pdf' value='1'></i></td>
                            <td><i class='fas fa-print print' value='1'></i></td>
                            <td><i class='fas fa-minus-circle delete' value='1'></i></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br><br>
        </div>
        <!-- Modal Start -->
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
                  <button type="button" class="btn btn-danger btn-sm killrow">
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
        <!-- Modal End -->
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div