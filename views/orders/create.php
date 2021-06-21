<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form method="post" id="quickForm" novalidate="novalidate">
                <input type="hidden" id="id_tr" name="trid" value="" />
                <div class="card">

                  <div class="card-header">
                    <div class="card-title">New Sales Order</div>
                    <div class="text-right" id="id_cardheader">
                      <button type="submit" class="btn btn-sm btn-primary" title="All fields are mandatory.">
                        Record
                      </button>
                      <a href="<?php echo ROOT; ?>orders" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_customergroup">
                          Customer Group :
                        </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" name="group_id" id="id_group_id">
                          <option value=""></option>
                          <?php foreach ($groups as $group) : ?>
                          <option value="<?php echo $group['id'] ?>">
                            <?php echo $group['name'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="bill_id">
                          Bill To :
                        </label>
                      </div>

                      <div class="col-sm-10 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="bill_to" id="bill_id" />
                      </div>

                      <div class="col-sm-2 col-lg-1 form-group">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addmodel"
                          id="billaddbtn">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="ship_id">Ship To :</label>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="ship_to" id="ship_id" />
                      </div>

                      <div class="col-sm-2 col-lg-1 form-group">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addmodel"
                          id="shipaddbtn">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="bill_id">
                          Customer Name:
                        </label>
                      </div>

                      <div class="col-sm-10 col-lg-3 form-group">
                        <input type="hidden" class="form-control ftsm" name="customer_id" id="id_customer_id" />
                        <span id="id_customertext"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2 pt-1">
                        <label for="date_id">Date :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="date" class="form-control ftsm" name="order_date" id="date_id" value="" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="customer_id">Customer PO No. :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm numberonly" name="po_no" id="id_po_no" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="salesperson_id">Contact Person :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm alphaonly" name="sales_person"
                          id="salesperson_id" />
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="comment_id">Comments :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control" name="remarks" id="comment_id" cols="30" rows="2"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_ordertype">
                          Order Type :
                        </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" name="ordertype" id="id_ordertype">
                          <option value="">&nbsp;</option>
                          <?php foreach ($orderTypes as $orderType) : ?>
                          <option value="<?php echo $orderType['id'] ?>">
                            <?php echo $orderType['title'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row field" style="display: none;">
                      <div class="col-12 table-responsive">
                        <table class="table text-center mb-0">
                          <thead>
                            <tr>
                              <th class="min100">Item</th>
                              <th class="min100">Description</th>
                              <th class="minmax150">Qty</th>
                              <th class="minmax150">Unit of Measure</th>
                              <th class="min100">Unit Price</th>
                              <th class="min100">Total</th>
                              <th class="min100">Delete</th>
                            </tr>
                          </thead>
                          <tbody id="orderlist">
                          </tbody>
                        </table>
                        <hr class="mt-0">
                      </div>
                      <div class="col-12">
                        <div class="row">
                          <div class="col-6 mb-2">
                            <button type="button" id="add_item" class="btn btn-primary btn-sm">
                              ADD ITEM
                            </button>
                          </div>
                          <div class="col-6 mb-2">
                            <div class="col-12 text-right">
                              <input type="hidden" name="ordersubtotal" id="id_ordersubtotal" value="0.0">
                              <b>Sub Total : &nbsp; &nbsp; &nbsp;</b>
                              <span id="subtotal">0.00</span>
                            </div>
                            <div class="col-12 text-right" id="sgstdiv" style="display: none">
                              <input type="hidden" name="sgst" id="id_sgst" value="0.0" />
                              <b>SGST <span id="sgstpercent"></span>% : &nbsp; &nbsp; &nbsp;</b>
                              <span id="sgstvalue">0.00</span>
                            </div>
                            <div class="col-12 text-right" id="cgstdiv" style="display: none">
                              <input type="hidden" name="cgst" id="id_cgst" value="0.0" />
                              <b>CGST <span id="cgstpercent"></span>% : &nbsp; &nbsp; &nbsp;</b>
                              <span id="cgstvalue">0.00</span>
                            </div>
                            <div class="col-12 text-right" id="igstdiv" style="display: none">
                              <input type="hidden" name="igst" id="id_igst" value="0.0" />
                              <b>IGST <span id="igstpercent"></span>% : &nbsp; &nbsp; &nbsp;</b>
                              <span id="igstvalue">0.00</span>
                            </div>
                          </div>
                        </div>
                        <hr>
                      </div>
                    </div>

                    <div class="row field mb-5" style="display: none;">
                      <div class="col-12 text-right">
                        <input type="hidden" name="ordertotal" id="id_ordertotal" value="0.0">
                        <b>Total : &nbsp; &nbsp; &nbsp;</b>
                        <span id="total">0.00</span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 table-responsive" id="id_project">
                      </div>
                      <div class="col-12" id="id_projectsummary">
                        
                      </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <div class="text-right" id="id_cardfooter">
                      <button type="submit" class="btn btn-sm btn-primary" title="All fields are mandatory.">
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
                        <p>Are you confirm to add new order.?</p>
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

        <!-- Modal Start -->
        <button type="button" id="modelactivate" style="display: none" data-toggle="modal" data-target="#modal-default">
        </button>
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
                <p>
                  Please confirm deleting action of this record?
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
            </div>
          </div>
        </div>

        <div class="modal fade" id="addmodel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="mylabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div id="addhead">
                  <!-- <table class="table table-hover" style="border: 1px solid lightgrey;">
                    <thead>
                      <th></th>
                      <th>Customer Code</th>
                      <th>Customer Name</th>
                      <th>Ship To Address</th>
                    </thead>
                    <tbody id="addbody">
                    </tbody>
                  </table> -->
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary billtoclick" data-dismiss="modal">Select</button>
              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>