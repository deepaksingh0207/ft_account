<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form method="post"
                id="quickForm"
                novalidate="novalidate">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
              <div class="card">
                <div class="card-header">Renew Order</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2" id="group_id" data-id="<?php echo $order['group_id'] ?>">
                      <b>Customer Group : </b>
                      <?php echo $order['customer_group'] ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                      <b>Customer PO No. :</b
                      ><?php echo $order['po_no'] ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                      <b>Customer : </b
                      ><?php echo $order['customer'] ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                      <b>Contact Person : </b
                      ><?php echo $order['contact_person'] ?>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                      <b>Bill To : </b
                      ><?php echo $order['bill_to'] ?>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                      <b>Ship To : </b
                      ><?php echo $order['ship_to'] ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                      <b>Date : </b
                      ><?php echo date('d, M Y', strtotime($order['order_date'])) ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                      <b>Attachment : </b
                      ><?php echo $order['attachment'] ?>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                      <div id="itemcard">
                        <div class="card" id="order_items_card">
                          <div class="card-header" id="order_items_cardheader">
                            <h3 class="card-title">Order Items</h3>
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
                                <tr>
                                  <td colspan="8" class="text-center">
                                    No Order Item
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="card-footer hide" id="order_items_cardfooter" style="display: none;"></div>
                        </div>
                        <div class="text-left m-2">
                          <button type="button" class="btn btn-primary" onclick="create()">
                            Add Order Item
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                      <div
                        class="card card-primary card-outline mb-0 hide"
                        id="add_order_card"
                      >
                        <div class="card-body p-0" id="add_order_cardbody">
                          <div class="card mb-0" id="add_order_item_card">
                            <div
                              class="card-header"
                              id="add_order_item_cardheader"
                            >
                              <div class="row">
                                <div
                                  class="col-sm-12 col-md-4 col-lg-4 form-group mb-0"
                                >
                                  <label for="order_type"></label>
                                  <select
                                    class="form-control"
                                    id="order_type"
                                    required=""
                                    aria-invalid="false"
                                  >
                                    <option value="">Select Order Type</option>
                                    <option value="1">
                                      On-Site Support Sale
                                    </option>
                                    <option value="2">Project Sale</option>
                                    <option value="3">AMC Support Sale</option>
                                    <option value="4">
                                      Man-days-Support Sale
                                    </option>
                                    <option value="5">SAP License Sale</option>
                                    <option value="6">Hardware Sale</option>
                                    <option value="7">Custom</option>
                                  </select>
                                </div>
                                <div
                                  class="col-sm-12 col-md-4 col-lg-4 row"
                                  id="col_from_date"
                                >
                                  <div class="col-4 mt-3 text-right">
                                    <label for="from_date">From Date :</label>
                                  </div>
                                  <div class="col-8 mt-2">
                                    <input
                                      type="date"
                                      class="form-control"
                                      id="from_date"
                                      required=""
                                      aria-invalid="false"
                                    />
                                  </div>
                                </div>
                                <div
                                  class="col-sm-12 col-md-4 col-lg-4 row"
                                  id="col_to_date"
                                >
                                  <div class="col-4 mt-3 text-right">
                                    <label for="to_date">Till Date :</label>
                                  </div>
                                  <div class="col-8 mt-2">
                                    <input
                                      type="date"
                                      class="form-control"
                                      id="to_date"
                                      required=""
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="card-body table-responsive hide p-0"
                              id="add_order_item_cardbody"
                              style=""
                            >
                              <table class="table text-center">
                                <thead>
                                  <tr>
                                    <th id="item_header">Item</th>
                                    <th id="description_header">Description</th>
                                    <th id="quantity_header">Total Months</th>
                                    <th id="uom_header">Unit of Measure</th>
                                    <th id="unitprice_header">Total Price</th>
                                  </tr>
                                </thead>
                                <tbody id="order_item_list">
                                  <tr id="order_item_1">
                                    <td
                                      class="form-group"
                                      id="orderitem_1_col_1"
                                    >
                                      <input
                                        type="text"
                                        data-id="1"
                                        class="form-control item capitalize"
                                        id="orderitem_1_val_1"
                                        placeholder="*Enter Item"
                                      />
                                    </td>
                                    <td
                                      class="form-group"
                                      id="orderitem_1_col_2"
                                    >
                                      <input
                                        type="text"
                                        data-id="1"
                                        class="form-control min150 desp capitalize"
                                        id="orderitem_1_val_2"
                                        placeholder="*Enter Description"
                                      />
                                    </td>
                                    <td
                                      class="form-group max150"
                                      id="orderitem_1_col_3"
                                    >
                                      <input
                                        type="number"
                                        data-id="1"
                                        class="form-control order_item_quantity numberonly"
                                        id="orderitem_1_val_3"
                                        min="1"
                                        step="1"
                                        aria-invalid="false"
                                      />
                                    </td>
                                    <td
                                      class="form-group min150"
                                      id="orderitem_1_col_4"
                                    >
                                      <span id="orderitem_1_txt_4">AU</span>
                                    </td>
                                    <td
                                      class="form-group max150"
                                      id="orderitem_1_col_35"
                                    >
                                      <input
                                        type="number"
                                        data-id="1"
                                        class="form-control order_item_unitprice"
                                        id="orderitem_1_val_5"
                                      />
                                      <input
                                        type="hidden"
                                        data-id="1"
                                        class="form-control rowtotal"
                                        id="orderitem_1_val_6"
                                      />
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div
                              class="card-footer hide"
                              id="add_order_item_cardfooter"
                              style="display: block"
                            >
                              <div class="row text-center">
                                <div class="col-3" id="col_sub_total">
                                  <b>Sub Total : </b>₹
                                  <span id="add_order_subtotal_val">0</span>
                                </div>
                                <div
                                  class="col-3 hide"
                                  id="col_sgst"
                                  style="display: block"
                                >
                                  <b
                                    >SGST <span id="add_order_sgst"></span>% : </b
                                  >₹
                                  <span id="add_order_sgst_val">0</span>
                                </div>
                                <div
                                  class="col-3 hide"
                                  id="col_cgst"
                                  style="display: block"
                                >
                                  <b
                                    >CGST <span id="add_order_cgst"></span>% : </b
                                  >₹
                                  <span id="add_order_cgst_val">0</span>
                                </div>
                                <div
                                  class="col-4 hide"
                                  id="col_igst"
                                  style="display: none"
                                >
                                  <b
                                    >IGST <span id="add_order_igst"></span>% : </b
                                  >₹
                                  <span id="add_order_igst_val">0</span>
                                </div>
                                <div class="col-3" id="col_total">
                                  <b>Total : </b>₹
                                  <span id="add_order_total_val">0</span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div
                            class="card mb-0 mt-3 hide"
                            id="payment_term_card"
                            style=""
                          >
                            <div
                              class="card-header"
                              id="payment_term_cardheader"
                            >
                              <b>Payment Term</b>
                            </div>
                            <div class="card-body" id="payment_term_cardbody">
                              <table class="table" id="table_1">
                                <thead>
                                  <tr>
                                    <th class="max100">Sr. No.</th>
                                    <th class="min100">Item Description</th>
                                    <th class="minmax150">Qty./Unit</th>
                                    <th class="min100">Unit Price</th>
                                    <th class="min100">Total Value</th>
                                  </tr>
                                </thead>
                                <tbody id="paymentterm_list_1">
                                  <tr id="orderitem_1_paymentterm_1">
                                    <td
                                      class="form-group"
                                      id="orderitem_1_paymentterm_1_col_1"
                                    >
                                      1
                                    </td>
                                    <td
                                      class="form-group"
                                      id="orderitem_1_paymentterm_1_col_3"
                                    >
                                      <input
                                        type="text"
                                        class="form-control paymentterm_description capitalize"
                                        id="orderitem_1_paymentterm_1_val_3"
                                        placeholder="*Enter Description"
                                      />
                                    </td>
                                    <td
                                      class="input-group"
                                      id="orderitem_1_paymentterm_1_col_4"
                                    >
                                      <input
                                        type="hidden"
                                        value="1"
                                        id="orderitem_1_paymentterm_1_val_4"
                                      />1 / AU
                                    </td>
                                    <td
                                      class="form-group max100"
                                      id="orderitem_1_paymentterm_1_col_5"
                                    >
                                      <input
                                        type="number"
                                        class="form-control paymentterm_unitprice"
                                        id="orderitem_1_paymentterm_1_val_5"
                                        readonly="readonly"
                                      />
                                    </td>
                                    <td
                                      class="form-group"
                                      id="orderitem_1_paymentterm_1_col_6"
                                    >
                                      <input
                                        type="hidden"
                                        class="form-control paymentterm_rowtotal"
                                        id="orderitem_1_paymentterm_1_val_6"
                                      /><span
                                        id="orderitem_1_paymentterm_1_txt_6"
                                        >₹0.00</span
                                      >
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div
                          class="card-footer text-right"
                          id="add_order_cardfooter"
                        >
                          <button
                            type="button"
                            class="btn btn-primary btn-sm showmain_card"
                            value="1"
                          >
                            Save Order Item
                          </button>
                          <button
                            type="button"
                            class="btn btn-primary btn-sm off"
                            value="0"
                          >
                            Close
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="hiddendata" style="display: none"></div>
                <div class="card-footer">
                  <div class="text-right" id="main_cardfooter">
                    <button type="submit" class="btn btn-sm btn-primary">
                      Record
                    </button>
                    <a href="\ft_account\orders" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
              </div>
              <button
                  type="button"
                  id="responsemodal"
                  class="btn btn-default"
                  data-toggle="modal"
                  data-target="#modal-sm"
                  style="display: none"
                ></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add New Order</h4>
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
                        <p>Are you confirm to add this order?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button
                          type="button"
                          class="btn btn-sm btn-default"
                          data-dismiss="modal"
                          aria-label="Close"
                        >
                          Close
                        </button>
                        <button
                          type="button"
                          class="btn btn-sm btn-primary"
                          onclick="form.submit()"
                        >
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
              <div class="modal-header">
                <div class="modal-title">ORDER DELETE</div>
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
                <p>Please confirm deleting action of this record?</p>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-sm killrow">
                  Delete
                </button>
                <button
                  type="button"
                  id="byemodal"
                  class="btn btn-light btn-sm"
                  data-dismiss="modal"
                >
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
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                  id="id_address_close"
                >
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
