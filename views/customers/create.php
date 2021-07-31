<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form action="" method="POST" id="id_quickForm" novalidate="novalidate">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title" style="line-height: 2.2">
                      Add New Customer
                    </h3>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                        Submit
                      </button>
                      <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                  <div class="card-body p-3">

                    <div class="row mx-1">
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

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_customername"> Customer Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm alphaonly capitalize" name="name" id="id_customername"
                          value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_contactperson"> Contact Person </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm alphaonly capitalize" name="contact_person"
                          id="id_contactperson" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> Address </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control ftsm" name="address" id="id_address" cols="30"
                          rows="3"></textarea>
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pincode"> Pincode </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control ftsm numberonly" name="pincode" id="pincode_id"
                          maxlength="6" minlength="6" pattern="^[0-9]{6}$" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> State </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm select2" name="state" id="state_id">
                          <option value="">&nbsp;</option>
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
                        <input type="text" class="form-control ftsm pan" name="pan" id="id_pan"
                          pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" minlength="10" maxlength="10" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_gst"> GSTIN </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm gst" name="gstin" id="id_gst" minlength="15"
                          maxlength="15" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pphone"> Phone (primary) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control ftsm" name="pphone" id="id_pphone" pattern="^[0-9]+$"
                          minlength="8" maxlength="10" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_sphone"> Phone (alternative) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control ftsm" name="aphone" id="id_sphone" pattern="^[0-9]+$"
                          minlength="8" maxlength="10" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_fax"> Fax </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control ftsm" name="fax" id="id_fax" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_email"> Email </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="email" id="id_email"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="" style="text-transform: lowercase" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_managername"> IT Manager Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm alphaonly capitalize" name="managername" id="id_managername"
                          value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_manageremail"> IT Manager Email </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="email" class="form-control ftsm" name="manageremail" id="id_manageremail"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="" style="text-transform: lowercase" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_managerphone"> IT Manager Contact </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control ftsm" name="managerphone" id="id_managerphone"
                          pattern="^[0-9]+$" minlength="8" maxlength="10" value="" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_addinfo"> Additional Info </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm capitalize" name="remark" id="id_addinfo" />
                      </div>
                    </div>

                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm vip" title="All fields are mandatory.">
                      Submit
                    </button>
                    <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <button type="button" id="responsemodal" class="btn btn-default" data-toggle="modal"
                  data-target="#modal-sm" style="display: none"></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add New Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to add new customer?</p>
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
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>