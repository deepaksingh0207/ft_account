<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form method="post" id="quickForm" novalidate="novalidate" enctype="multipart/form-data" class="mb-0">
                <div class="card" id="main_card">
                  <div class="card-header">
                    <div class="card-title">New Sales Order</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body" id="main_cardbody">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Order Details</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-6">
                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="group_id"> Customer Group : </label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <select class="form-control" name="group_id" id="group_id">
                                  <option value=""></option>
                                  <?php foreach ($groups as $group) : ?>
                                  <option value="<?php echo $group['id'] ?>">
                                    <?php echo $group['name'] ?>
                                  </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="bill_to"> Bill To : </label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="input-group">
                                  <input type="text" class="form-control ftsm" placeholder="Search Address"
                                    name="bill_to" id="bill_to" readonly />
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                      data-target="#addmodel" id="billto_search_button">
                                      <i class="fas fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="ship_to">Ship To :</label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="input-group">
                                  <input type="text" class="form-control ftsm" placeholder="Search Address"
                                    name="ship_to" id="ship_to" readonly />
                                  <div class="input-group-append">
                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                      data-target="#addmodel" id="shipto_search_button">
                                      <i class="fas fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="customer_id"> Customer Name: </label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <input type="hidden" name="customer_id" id="customer_id" />
                                <input type="hidden" name="taxrate" id="taxrate" />
                                <span id="customer_name"></span>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="date_id">Date :</label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <input type="date" class="form-control ftsm" name="order_date" id="date_id" />
                              </div>
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="po_no">Customer PO No. :</label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <input type="text" class="form-control ftsm numberonly" name="po_no" id="po_no" />
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="sales_person">Contact Person :</label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <input type="text" class="form-control ftsm alphaonly" name="sales_person"
                                  id="sales_person" />
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="remarks">Comments :</label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <textarea class="form-control capitalize" name="remarks" id="remarks" cols="30"
                                  rows="3"></textarea>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="upload_po">
                                  Upload PO <small>( .pdf )</small>
                                </label>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                <input type="file" name="upload_po" id="upload_po" accept="application/pdf" required />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="itemcard" class="hide">
                      <div class="card" id="order_items_card">
                        <div class="card-header" id="order_items_cardheader">
                          <h3 class="card-title">
                            Order Items
                          </h3>
                          <div class="card-tools mt-2">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body p-0" id="order_items_cardbody">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Order Type</th>
                                <th>Qty</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="order_items">
                            </tbody>
                          </table>
                          <hr class="m-0">
                          <div class="text-center m-2">
                            <button type="button" class="btn btn-primary" onclick="create()">
                              Add New Item
                            </button>
                          </div>
                        </div>
                        <div class="card-footer hide" id="order_items_cardfooter">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <?php include 'create_orders.php';?>
                      </div>
                    </div>
                  </div>
                  <div id="hiddendata" style="display: none;"></div>
                  <div class="card-footer">
                    <div class="text-right" id="main_cardfooter">
                      <button type="submit" class="btn btn-sm btn-primary">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                </div>

                <button type="button" id="responsemodal" class="btn btn-default" data-toggle="modal"
                  data-target="#modal-sm" style="display: none"></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add New Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to add this order?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="form.submit()">
                          Add
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <button type="button" id="modelactivate" style="display: none" data-toggle="modal"
          data-target="#modal-default"></button>
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">ORDER DELETE</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Please confirm deleting action of this record?</p>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-sm killrow">
                  Delete
                </button>
                <button type="button" id="byemodal" class="btn btn-light btn-sm" data-dismiss="modal">
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="addmodel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="id_address_close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div id="addhead"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>