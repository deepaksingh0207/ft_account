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
                      Update Customer
                    </h3>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-sm vip" title="Activates only on changes.">
                        Update
                      </button>
                      <a href="<?php echo ROOT; ?>customers/view/<?php echo $customer['id'] ?>"
                        class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                  <div class="card-body p-3">

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_customergroup"> Customer Group </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control fc ftsm" name="group_id" id="id_customergroup">
                          <option value=""></option>
                          <?php foreach ($groups as $group) : ?>
                            <option value="<?php echo $group['id'] ?>" <?php echo ($customer['group_id'] == $group['id'])
                                                                          ? 'selected="selected"' : '' ?>>
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
                        <input type="text" class="form-control fc ftsm alphaonly" name="name" id="id_customername"
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
                        <label for="id_address"> Address </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <textarea class="form-control fc ftsm" name="address" id="id_address" cols="30" rows="3"><?php echo trim($customer['address']) ?></textarea>
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pincode"> Pincode </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control fc ftsm numberonly" name="pincode" id="pincode_id"
                          maxlength="7" minlength="6" pattern="^[0-9]{6}$" value="<?php echo $customer['pincode'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="country_id">Country</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control ftsm select2" name="country" id="country_id">
                          <option value="">Select Country</option>
                          <?php foreach ($countries as $country) : ?>
                            <option value="<?php echo $country['id']; ?>" data-code="<?php echo $country['country_code']; ?>" <?php echo ($country['id'] == $customer['country']) ? 'selected' : ''; ?>>
                              <?php echo $country['country_name']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="cnt_code" id="cnt_code" value="">
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_address"> State </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <!-- <select class="form-control fc ftsm select2" name="state" id="state_id"> -->
                        <select class="form-control fc ftsm select2" name="state">
                          <option value="">&nbsp;</option>
                          <?php foreach ($states as $state) : ?>
                            <option value="<?php echo $state['id'] ?>" <?php echo ($customer['state'] == $state['id']) ? 'selected="selected"' : ''; ?>>
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
                        <input type="text" class="form-control fc ftsm" name="pan" id="id_pan"
                          pattern="^[A-Z]{5}[0-9]{4}[A-Z]{1}+$" minlength="10" maxlength="10"
                          value="<?php echo $customer['pan'] ?>" />
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

                    <!-- ------currency dropdown----- -->
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="currency_id">Currency :</label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <select class="form-control" id="currency" name="for_cur">
                          <option value="">Select Currency</option>
                          <?php foreach ($currencies as $currency) : ?>

                            <option
                              value="<?php echo ($currency['code']); ?>" data-code="<?php echo ($currency['code']); ?>" data-symbol="<?php echo ($currency['symbol']); ?>"<?php echo ($currency['symbol'] === $customer['symbol']) ? 'selected="selected"' : ''; ?>>
                              <?php echo ($currency['name']); ?> (<?php echo ($currency['code']); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_pphone"> Phone (primary) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="pphone" id="id_pphone" pattern="^[0-9]+$"
                          minlength="8" maxlength="11" value="<?php echo $customer['pphone'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_sphone"> Phone (alternative) </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="aphone" id="id_sphone" pattern="^[0-9]+$"
                          minlength="8" maxlength="11" value="<?php echo $customer['aphone'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_fax"> Fax </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group numberonly">
                        <input type="tel" class="form-control fc ftsm" name="fax" minlength="10" maxlength="15" id="id_fax"
                          value="<?php echo $customer['fax'] ?>" />
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
                        <label for="id_managername"> Manager Name </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control fc ftsm alphaonly" name="managername"
                          id="id_managername" value="<?php echo $customer['managername'] ?>" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_manageremail"> IT Manager Email </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="email" class="form-control fc ftsm" name="manageremail" id="id_manageremail"
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $customer['manageremail'] ?>" style="text-transform: lowercase" />
                      </div>
                    </div>
                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_managerphone"> Manager's Contact </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="tel" class="form-control ftsm" name="managerphone" id="id_managerphone" pattern="^[0-9]+$"
                          minlength="8" maxlength="10" value="<?php echo $customer['managerphone'] ?>" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_addinfo"> Additional Info </label>
                      </div>
                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="text" class="form-control ftsm" name="remark"
                          value="<?php echo $customer['remark'] ?>" id="id_addinfo" />
                      </div>
                    </div>

                    <div class="row mx-1">
                      <div class="col-sm-12 col-lg-2">
                        <label for="id_declaration"> Declaration </label>
                      </div>
                      <div class="col-sm-12 col-lg-6 form-group">
                        <textarea name="declaration" id="id_declaration" class="form-control" rows="4"><?php echo $customer['declaration'] ?></textarea>
                      </div>
                    </div>

                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm vip" title="Activates only on changes.">
                      Update
                    </button>
                    <a href="<?php echo ROOT; ?>customers/view/<?php echo $customer['id'] ?>"
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
                        <h4 class="modal-title">Update Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you confirm to new edit record?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="form.submit()">
                          Update
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