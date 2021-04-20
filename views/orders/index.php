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
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#a" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Recorded</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#b" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Draft</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#c" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Draft & Recorded</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#d" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true">Recurring</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="a">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                      <div class="row">
                        <div class="col-sm-12 col-lg-2 form-group">
                          <label for="id_period"> Period : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value="">All</option>
                            <option value="">Custom Period</option>
                            <option value="">Today</option>
                            <option value="">Yesterday</option>
                            <option value="">Today</option>
                            <option value="">This Week</option>
                            <option value="">Last Week</option>
                            <option value="">This Month</option>
                            <option value="">Last Month</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-5">
                          <div class="row">
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> Start Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> End Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_period"> Customer : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value=""></option>
                            <option value="">Customer A</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 pt-2">
                          <br>
                          <button class="btn btn-sm btn-primary" type="button">Update</button>
                          <button class="btn btn-sm btn-primary" type="button">Add New Order</button>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                          <table class="table table-striped table-hover">
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
                              <tr>
                                <td>02/02/2021</td>
                                <td>200</td>
                                <td>1000</td>
                                <td>Balram</td>
                                <td>Prashant</td>
                                <td>20000</td>
                                <td>10001</td>
                                <td><i class="fas fa-pen"></i></td>
                                <td><i class="far fa-file-pdf"></i></td>
                                <td><i class="fas fa-print"></i></td>
                                <td><i class="fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="row">
                        <div class="col-sm-12 col-lg-2 form-group">
                          <label for="id_period"> Period : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value="">All</option>
                            <option value="">Custom Period</option>
                            <option value="">Today</option>
                            <option value="">Yesterday</option>
                            <option value="">Today</option>
                            <option value="">This Week</option>
                            <option value="">Last Week</option>
                            <option value="">This Month</option>
                            <option value="">Last Month</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-5">
                          <div class="row">
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> Start Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> End Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_period"> Customer : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value=""></option>
                            <option value="">Customer A</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 pt-2">
                          <br>
                          <button class="btn btn-sm btn-primary" type="button">Update</button>
                          <button class="btn btn-sm btn-primary" type="button">Add New Order</button>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                          <table class="table table-striped table-hover">
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
                              <tr>
                                <td>02/02/2021</td>
                                <td>200</td>
                                <td>1000</td>
                                <td>Balram</td>
                                <td>Prashant</td>
                                <td>20000</td>
                                <td>10001</td>
                                <td><i class="fas fa-pen"></i></td>
                                <td><i class="far fa-file-pdf"></i></td>
                                <td><i class="fas fa-print"></i></td>
                                <td><i class="fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                    <div class="row">
                        <div class="col-sm-12 col-lg-2 form-group">
                          <label for="id_period"> Period : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value="">All</option>
                            <option value="">Custom Period</option>
                            <option value="">Today</option>
                            <option value="">Yesterday</option>
                            <option value="">Today</option>
                            <option value="">This Week</option>
                            <option value="">Last Week</option>
                            <option value="">This Month</option>
                            <option value="">Last Month</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-5">
                          <div class="row">
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> Start Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> End Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_period"> Customer : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value=""></option>
                            <option value="">Customer A</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 pt-2">
                          <br>
                          <button class="btn btn-sm btn-primary" type="button">Update</button>
                          <button class="btn btn-sm btn-primary" type="button">Add New Order</button>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                          <table class="table table-striped table-hover">
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
                              <tr>
                                <td>02/02/2021</td>
                                <td>200</td>
                                <td>1000</td>
                                <td>Balram</td>
                                <td>Prashant</td>
                                <td>20000</td>
                                <td>10001</td>
                                <td><i class="fas fa-pen"></i></td>
                                <td><i class="far fa-file-pdf"></i></td>
                                <td><i class="fas fa-print"></i></td>
                                <td><i class="fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="d" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <div class="row">
                        <div class="col-sm-12 col-lg-2 form-group">
                          <label for="id_period"> Period : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value="">All</option>
                            <option value="">Custom Period</option>
                            <option value="">Today</option>
                            <option value="">Yesterday</option>
                            <option value="">Today</option>
                            <option value="">This Week</option>
                            <option value="">Last Week</option>
                            <option value="">This Month</option>
                            <option value="">Last Month</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-5">
                          <div class="row">
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> Start Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                              <label for="date_id"> End Date :</label>
                              <input type="date" class="form-control ftsm" name="date" id="date_id" />
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                          <label for="id_period"> Customer : </label>
                          <select class="form-control fc ftsm mt-0" name="period" id="id_period">
                            <option value=""></option>
                            <option value="">Customer A</option>
                          </select>
                        </div>
                        <div class="col-sm-12 col-lg-3 pt-2">
                          <br>
                          <button class="btn btn-sm btn-primary" type="button">Update</button>
                          <button class="btn btn-sm btn-primary" type="button">Add New Order</button>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                          <table class="table table-striped table-hover">
                            <thead>
                              <tr>
                              <th>SELECT REF.</th>
                                <th>CUSTOMER</th>
                                <th>AMOUNT</th>
                                <th>INTERVAL</th>
                                <th>FIRST</th>
                                <th>LAST RECORDED</th>
                                <th>NEXT SCHEDULED DATE</th>
                                <th>SCHEDULE</th>
                                <th>EDIT</th>
                                <th>PDF</th>
                                <th>PRINT</th>
                                <th>DELETE</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>02/02/2021</td>
                                <td>200</td>
                                <td>1000</td>
                                <td>Balram</td>
                                <td>Prashant</td>
                                <td>20000</td>
                                <td>10001</td>
                                <td>10001</td>
                                <td><i class="fas fa-pen"></i></td>
                                <td><i class="far fa-file-pdf"></i></td>
                                <td><i class="fas fa-print"></i></td>
                                <td><i class="fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br><br>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div