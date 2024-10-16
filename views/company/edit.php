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
                      Edit Company Details
                    </h3>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-sm vip" title="Activates only on changes."
                        disabled>
                        Update
                      </button>
                      <a href="<?php echo ROOT; ?>company/view/<?php echo $customer['id'] ?>"
                        class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_companyname"> Company Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm alphaonly" name="name" id="id_companyname"
                          value="<?php echo $customer['name'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_contactperson"> Contact Person </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm alphaonly" name="contact_person"
                          id="id_contactperson" value="<?php echo $customer['contact_person'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_contact"> Contact </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="contact" id="id_contact"
                        minlength="8" maxlength="11" value="<?php echo $customer['contact'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_mobile"> Mobile </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="mobile" id="id_mobile"
                          pattern="[9,8,7,6]{1}[0-9]{9}" minlength="10" maxlength="10"
                          value="<?php echo $customer['mobile'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_fax"> Fax </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="fax" id="id_fax" minlength="10"
                          maxlength="15" value="<?php echo $customer['fax'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_email"> Email </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="email" id="id_email"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $customer['email'] ?>"
                          style="text-transform: lowercase" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pan"> PAN No. </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm pan" name="pan" id="id_pan"
                          pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" minlength="10" maxlength="10"
                          value="<?php echo $customer['pan'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_swift_code"> SWIFT Code </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="swift_code" id="id_swift_code" minlength="8" maxlength="10"
                          value="<?php echo $customer['swift_code'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_sac"> SAC </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="sac" id="id_sac"
                          value="<?php echo $customer['sac'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_gst"> GSTIN </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="gstin" id="id_gst" minlength="15"
                          maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}"
                          value="<?php echo $customer['gstin'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pincode"> Pincode </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control fc ftsm numberonly" name="pincode" id="id_pincode"
                          maxlength="6" minlength="6" pattern="^[0-9]{6}$" value="<?php echo $customer['pincode'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> Address </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control fc ftsm" name="address" id="id_address" cols="30" rows="3">
                        <?php echo $customer['address'] ?>
                    </textarea>
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_state"> State </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control fc ftsm select2" name="state" id="state_id">
                          <option value=""></option>
                          <?php foreach ($states as $state) : ?>
                          <option value="<?php echo $state['id'] ?>" <?php echo ($customer['state']==$state['id'])
                            ? 'selected="selected"' : '' ?>>
                            <?php echo $state['name'] ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_bank_name"> Bank's Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="bank_name" id="id_bank_name"
                          value="<?php echo $customer['bank_name'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_account_no"> Account Number </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control fc ftsm numberonly" name="account_no" id="id_account_no" minlength="10" value="<?php echo $customer['account_no'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_isfc_code"> IFSC Code </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm" name="ifsc_code" id="id_isfc_code"
                          maxlength="11" minlength="11" pattern="^[A-Z]{4}[0][A-Z0-9]{6}$"
                          value="<?php echo $customer['ifsc_code'] ?>" />
                      </div>
                    </div>

                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm vip" title="Activates only on changes."
                      disabled>
                      Update
                    </button>
                    <a href="<?php echo ROOT; ?>company/view/<?php echo $customer['id'] ?>"
                      class="btn btn-default btn-sm">
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
                        <h4 class="modal-title">Edit Company</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to edit this company record?</p>
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