<div class="card card-primary card-outline mb-0 hide" id="add_order_card">
  <div class="card-header" id="add_order_cardheader">
    <h3 class="card-title">Create Order</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool">
        <i class="fas fa-times off"></i>
      </button>
    </div>
  </div>

  <div class="card-body" id="add_order_cardbody">
    <div class="row">
      <div class="col-sm-12 col-lg-4 form-group mb-0">
        <label for="order_type">Select Order</label>
        <select class="form-control" id="order_type" required>
          <option value="">Select Order Type</option>
          <?php foreach ($ORDER_TYPE as $key =>
          $val) : ?>
          <option value="<?php echo $key ?>">
            <?php echo $val ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-12 col-lg-4 form-group" id="col_from_date"></div>
      <div class="col-sm-12 col-lg-4 form-group" id="col_to_date"></div>
    </div>

    <div class="card hide mt-2" id="add_order_item_card">
      <div class="card-header" id="add_order_item_cardheader">Order Item</div>
      <div class="card-body table-responsive p-0" id="add_order_item_cardbody">
        <table class="table text-center">
          <thead>
            <tr>
              <th id="item_header">Item</th>
              <th id="description_header">Description</th>
              <th id="quantity_header">Qty</th>
              <th id="uom_header">Unit of Measure</th>
              <th id="unitprice_header">Unit Price</th>
              <th id="total_header">Total</th>
              <th id="total_delete"></th>
            </tr>
          </thead>
          <tbody id="order_item_list"></tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="row text-center">
          <div class="col-3" id="col_sub_total">
            <b>Sub Total : </b>₹ 
            <span id="add_order_subtotal_val">0.00</span>
          </div>
          <div class="col-3 hide" id="col_sgst">
            <b>SGST <span id="add_order_sgst"></span>% : </b>₹ 
            <span id="add_order_sgst_val">0.00</span>
          </div>
          <div class="col-3 hide" id="col_cgst">
            <b>CGST <span id="add_order_cgst"></span>% : </b>₹ 
            <span id="add_order_cgst_val">0.00</span>
          </div>
          <div class="col-3 hide" id="col_igst">
            <b>IGST <span id="add_order_igst"></span>% : </b>₹ 
            <span id="add_order_igst_val">0.00</span>
          </div>
          <div class="col-3" id="col_total">
            <b>Total : </b>₹ 
            <span id="add_order_total_val">0.00</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-0 hide" id="payment_term_card">
      <div class="card-header" id="payment_term_cardheader">Payment Term</div>
      <div class="card-body" id="payment_term_cardbody"></div>
    </div>
  </div>

  <div class="card-footer text-right" id="add_order_cardfooter">
    <button
      type="button"
      class="btn btn-primary btn-sm showmain_card"
      value="1"
    >
      Save Order Item
    </button>
    <button type="button" class="btn btn-primary btn-sm off" value="0">
      Close
    </button>
  </div>
</div>
