<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <form
                action=""
                method="POST"
                id="id_quickForm"
                novalidate="novalidate"
              >
                <div class="card card-default mt-3">
                  <div class="card-header">
                    <h3 class="card-title" style="line-height: 2.2">
                      Add New Customer
                    </h3>
                    <div class="text-right">
                      <button
                        type="submit"
                        class="btn btn-primary btn-sm vip"
                        disabled
                      >
                        Submit
                      </button>
                      <a
                        href="<?php echo ROOT; ?>customers"
                        class="btn btn-default btn-sm"
                      >
                        Back
                      </a>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_customername"> Customer Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control fc ftsm alphaonly"
                          name="name"
                          id="id_customername"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_contactperson"> Contact Person </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control fc ftsm alphaonly"
                          name="contact_person"
                          id="id_contactperson"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> Address </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea
                          class="form-control fc ftsm"
                          name="address"
                          id="id_address"
                          cols="30"
                          rows="3"
                        ></textarea>
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pincode"> Pincode </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="tel"
                          class="form-control fc ftsm numberonly"
                          name="pincode"
                          id="pincode_id"
                          maxlength="7"
                          minlength="6"
                          pattern="^[0-9]{6}$"
			  value=""
                        />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> State </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select
                          class="form-control fc ftsm select2"
                          name="state"
                          id="state_id"
                        >
                          <option value=""></option>
                          <?php foreach ($states as $state) : ?>
                          <option value="<?php echo $state['id'] ?>">
                            <?php echo $state['name'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pan"> PAN No. </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control fc ftsm pan"
                          name="pan"
                          id="id_pan"
                          pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                          minlength="10"
                          maxlength="10"
                          value=""
                        />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_gst"> GSTIN </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control fc ftsm"
                          name="gstin"
                          id="id_gst"
                          minlength="15"
                          maxlength="15"
                          pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pphone"> Phone (primary) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input
                          type="tel"
                          class="form-control fc ftsm"
                          name="pphone"
                          id="id_pphone"
                          pattern="[9,8,7,6]{1}[0-9]{9}"
                          minlength="10"
                          maxlength="10"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_sphone"> Phone (alternative) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input
                          type="tel"
                          class="form-control fc ftsm"
                          name="aphone"
                          id="id_sphone"
                          pattern="[9,8,7,6]{1}[0-9]{9}"
                          minlength="10"
                          maxlength="10"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_fax"> Fax </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input
                          type="tel"
                          class="form-control fc ftsm"
                          name="fax"
                          id="id_fax"
                          value=""
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_email"> Email </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control fc ftsm"
                          name="email"
                          id="id_email"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                          value=""
                          style="text-transform: lowercase"
                        />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_addinfo"> Additional Info </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input
                          type="text"
                          class="form-control ftsm"
                          name="remark"
                          id="id_addinfo"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button
                      type="submit"
                      class="btn btn-primary btn-sm vip"
                      disabled
                    >
                      Submit
                    </button>
                    <a
                      href="<?php echo ROOT; ?>customers"
                      class="btn btn-default btn-sm"
                    >
                      Back
                    </a>
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
                        <h4 class="modal-title">Add New Customer</h4>
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
                        <p>Are you confirm to add new customer?</p>
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
          <br /><br /><br />
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div>
