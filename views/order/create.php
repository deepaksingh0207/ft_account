<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
      <div ftsolutions="menu.html"></div>
      <div class="content-wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
        <div class="content-header">
          <div class="container">
            <div class="row mb-2">
              <div class="col-12">
                <form
                  action=""
                  method="post"
                  id="quickForm"
                  novalidate="novalidate"
                >
                <input type="hidden" id="id_tr" name="trid" value=''>
                <input type="hidden" id="id_taxval" name="taxval" value=''>
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">New Sales Order</div>
                      <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-primary">
                          Record
                        </button>
                        <a href="index.html" class="btn btn-sm btn-default"
                          >Cancel</a
                        >
                      </div>
                    </div>
                    <div class="card-body" id="order" style="display: block">
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="customerid_id">Customer : </label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select
                            class="form-control ftsm"
                            name="customerid"
                            id="customerid_id"
                          >
                            <option value=""></option>
                            <option value="1">User A</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="date_id">Date :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <input
                            type="date"
                            class="form-control ftsm"
                            name="date"
                            id="date_id"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="quote_number_id">Quote Number :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select
                            class="form-control ftsm"
                            name="quote_number"
                            id="quote_number_id"
                          >
                            <option value=""></option>
                            <option value="1">10000</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="terms_id">Terms :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select
                            class="form-control ftsm"
                            name="terms"
                            id="terms_id"
                          >
                            <option value=""></option>
                            <option value="1">COD</option>
                            <option value="2">Pay in days</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="days_id">Days :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <input
                            type="tel"
                            class="form-control ftsm"
                            name="days"
                            id="days_id"
                            minlength="1"
                            minlength="3"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="tracking_id">Tracking Ref No :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <input
                            type="text"
                            class="form-control ftsm"
                            name="tracking"
                            id="tracking_id"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="customer_id">Customer PO No. :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <input
                            type="text"
                            class="form-control ftsm"
                            name="customer"
                            id="customer_id"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="salesperson_id"></label>
                          Salesperson :
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select
                            class="form-control ftsm"
                            name="salesperson"
                            id="salesperson_id"
                          >
                            <option value=""></option>
                            <option value="">prashant</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="ship_id">Ship By:</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select
                            class="form-control ftsm"
                            name="shipby"
                            id="shipby_id"
                          >
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="tax_id">Tax :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <select class="form-control" name="tax" id="tax_id">
                            <option value=""></option>
                            <option value="0">Default</option>
                            <option value="1">Exempt</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="bill_id">Bill To :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <textarea
                            class="form-control"
                            name="bill"
                            id="bill_id"
                            cols="30"
                            rows="2"
                          ></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="ship_id">Ship To :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <textarea
                            class="form-control"
                            name="ship"
                            id="ship_id"
                            cols="30"
                            rows="2"
                          ></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="comment_id">Comments :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <textarea
                            class="form-control"
                            name="comment"
                            id="comment_id"
                            cols="30"
                            rows="2"
                          ></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-lg-2">
                          <label for="pvtcomment_id">Private Comments :</label>
                        </div>
                        <div class="col-sm-12 col-lg-3 form-group">
                          <textarea
                            class="form-control"
                            name="pvtcomment"
                            id="pvtcomment_id"
                            cols="30"
                            rows="2"
                          ></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 table-responsive">
                          <table class="table text-center">
                            <thead>
                              <tr>
                                <th>Qty</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Tax</th>
                                <th>Total</th>
                                <th>Delete</th>
                              </tr>
                            </thead>
                            <tbody id="orderlist">
                              <!-- <tr id="1">
                                <td>
                                  <input
                                    type="number"
                                    class="form-control ftsm"
                                    name="quantity1"
                                    id="id_quantity1"
                                  />
                                </td>
                                <td>
                                  <input
                                    class="form-control ftsm"
                                    list="item1_list"
                                    name="item1"
                                    id="id_item1"
                                    placeholder="Type or select..."
                                  />
                                  <datalist id="item1_list">
                                    <option value="a"></option>
                                    <option value="b"></option>
                                  </datalist>
                                </td>
                                <td>
                                  <input
                                    class="form-control ftsm"
                                    list="description1_list"
                                    name="description1"
                                    id="id_description1"
                                    placeholder="Type or select..."
                                  />
                                  <datalist id="description1_list">
                                    <option value="a"></option>
                                    <option value="b"></option>
                                  </datalist>
                                </td>
                                <td>
                                  <input
                                    type="number"
                                    class="form-control ftsm"
                                    name="unitprice1"
                                    id="id_unitprice1"
                                  />
                                </td>
                                <td>
                                  <select
                                    class="form-control ftsm"
                                    name="tax1"
                                    id="id_tax1"
                                  >
                                    <option value=""></option>
                                    <option value="0">None</option>
                                  </select>
                                </td>
                                <td>₹<span id="id_total1">0.00</span></td>
                                <td>
                                  <i
                                    class="fas fa-minus-circle trash"
                                    style="color: red"
                                    value="1"
                                  ></i>
                                </td>
                              </tr> -->
                            </tbody>
                          </table>
                          <hr />
                        </div>
                        <div class="col-11">
                          <div class="row">
                            <div class="col-sm-6 col-md-2 mb-2 align-center">
                              <button type="button" id="add_item" class="btn btn-block btn-sm btn-default">
                                Add Item
                              </button>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-2">
                              <button type="button" class="btn btn-block btn-sm btn-default">
                                Add Flat Discount
                              </button>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-2">
                              <button type="button" class="btn btn-block btn-sm btn-default">
                                Add Percentage Discount
                              </button>
                            </div>
                            <div class="col-sm-6 col-md-3 mb-2">
                              <button type="button" class="btn btn-block btn-sm btn-default">
                                Add Discount per Item
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 text-right">
                          <b>Subtotal : </b>₹
                          <span id="subtotal_id">0.00</span>
                        </div>
                        <div class="col-12 text-right">
                          <b>Total : </b>₹
                          <span id="total">0.00</span>
                        </div>
                      </div>
                    </div>
                    <div
                      class="card-body p-3 text-center"
                      id="trash"
                      style="display: none"
                    >
                      <p>Are you sure you want to delete?</p>
                      <button type="button" class="killrow btn btn-danger">
                        Delete
                      </button>
                      <button type="button" class="order btn btn-light">Cancel</button>
                    </div>
                    <div class="card-footer">
                      <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-primary">
                          Record
                        </button>
                        <a href="index.html" class="btn btn-sm btn-default"
                          >Cancel</a
                        >
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
        </div>
      </div>
      <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
          <strong>
            Copyright &copy; 2019
            <a href="http://www.futuretecsol.com/">F.T. Solutions Pvt. Ltd.</a>
            | All Rights Reserved. |
            <a href="http://www.futuretecsol.com/privacy-policy/">
              Privacy Policy
            </a>
          </strong>
        </div>
        <strong>&nbsp;</strong>
      </footer>
    </div>