<div class="card hide" id="add_order_card">
  <div class="card-header" id="add_order_cardheader">
    <div class="row">
      
      <div class="col-sm-12 col-lg-4 form-group">
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
  </div>

  <div class="card-body hide" id="add_order_cardbody">
    <div class="card" id="add_order_item_card">
      <div class="card-header" id="add_order_item_cardheader">Order Item</div>
      <div class="card-body" id="add_order_item_cardbody">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table text-center mb-0">
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
            <hr class="m-1" />
          </div>
          <div class="col-6 text-left">
            <div class="row">
              <div class="col-12">
                <small class="text-muted"><i>*Mandatory Fields</i></small>
              </div>
              <div class="col-12 mt-2 pl-4">
                <button
                  type="button"
                  id="add_order_item_button"
                  class="btn btn-primary btn-sm order"
                >
                  ADD ITEM
                </button>
              </div>
            </div>
          </div>
          <div class="col-6 text-right">
            <div>
              <b>Sub Total : &nbsp; &nbsp; &nbsp;</b>
              <input type="hidden" id="add_order_item_subtotal" />
              <span id="add_order_item_subtotal_txt">₹ 0.00</span>
            </div>
            <div id="sgstdiv">
              <input type="hidden" id="add_order_item_sgstcut" />
              <b
                >SGST <span id="add_order_item_sgstcut_txt"></span>% : &nbsp;
                &nbsp; &nbsp;</b
              >
              <span id="add_order_item_sgst_txt">₹ 0.00</span><br />
            </div>
            <div id="cgstdiv">
              <input type="hidden" id="add_order_item_cgstcut" />
              <b
                >CGST <span id="add_order_item_cgstcut_txt"></span>% : &nbsp;
                &nbsp; &nbsp;</b
              >
              <span id="add_order_item_cgst_txt">₹ 0.00</span><br />
            </div>
            <div id="igstdiv">
              <input type="hidden" id="add_order_item_igstcut" />
              <b
                >IGST <span id="add_order_item_igstcut_txt"></span>% : &nbsp;
                &nbsp; &nbsp;</b
              >
              <span id="add_order_item_igst_txt">₹ 0.00</span><br />
            </div>
            <div>
              <input type="hidden" id="add_order_item_total" />
              <b>Total : &nbsp; &nbsp; &nbsp;</b>
              <span id="add_order_item_total_txt">₹ 0.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card" id="payment_term_card">
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
      Save
    </button>
    <button
      type="button"
      class="btn btn-primary btn-sm showmain_card"
      value="0"
    >
      Cancel
    </button>
  </div>
</div>
