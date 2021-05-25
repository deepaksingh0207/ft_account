<div class="wrapper">
  <div class="main">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <main class="content">
      <div class="container-fluid p-5">
        <form action="" method="post" class="needs-validation" novalidate>
          <div class="row justify-content-center">
            <div class="col-sm-12 col-md-6">
              <div class="card login-box">
                <div class="card-header bbc py-0">
                  <h5 class="card-title mb-0">
                    <div class="row text-center py-2">
                      <div class="col-sm-12 col-md-12 align-vert my-2">
                        <h4 class="m-0">NEW CUSTOMER</h4>
                      </div>
                    </div>
                  </h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Profile Image</div>
                      <div class="col-sm-12 col-md-8 mt-2">
                        <div class="file-drop-area" style="background-image: url(<?php echo ROOT ?>assets/img/bee.png); background-repeat: no-repeat; background-color: white; height: 100px;">
                          <span class="fake-btn">SELECT OR DRAG A IMAGE</span>
                          <span class="file-msg">( .png & .jpg files, 40 x 40 px )</span>
                          <input class="file-input" name="logo" id="attach_id" type="file" multiple>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Company :</div>
                      <div class="col-sm-12 col-md-8 mt-2">
                        <div class="input-group has-validation">
                          <input type="text" class="form-control ftsm" name="cust_name" id="name_id" aria-describedby="inputGroupPrepend" required />
                          <div class="invalid-feedback">
                            Company is mandatory
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">
                        Name :
                      </div>
                      <div class="col-sm-12 col-md-8 mt-2">
                        <div class="input-group has-validation">
                          <input type="text" class="form-control ftsm" name="emp_name" id="name_id" aria-describedby="inputGroupPrepend" required />
                          <div class="invalid-feedback">
                            Name is mandatory
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Mobile :</div>
                      <div class="col-sm-12 col-md-8 mt-2">
                        <div class="input-group has-validation">
                          <input type="tel" class="form-control ftsm" name="emp_mobile" id="alt_tel_id" minlength="10" maxlength="10" aria-describedby="inputGroupPrepend" required />
                          <div class="invalid-feedback">
                            Mobile number is mandatory
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Email :</div>
                      <div class="col-sm-12 col-md-8 mt-2">
                        <div class="input-group has-validation">
                          <input type="text" class="form-control ftsm" name="emp_email" id="name_id" aria-describedby="inputGroupPrepend" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                          <div class="invalid-feedback">
                            Email is mandatory
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">System :</div>
                      <div class="col-sm-12 col-md-3 mt-2">
                        <label class="form-check m-0">
                          <input type="checkbox" name="instances[]" class="form-check-input" value="dev" id="DEV" required>
                          <span class="form-check-label">DEV</span>
                        </label>
                      </div>
                      <div class="col-sm-12 col-md-3 mt-2">
                        <label class="form-check m-0">
                          <input type="checkbox" name="instances[]" class="form-check-input" value="qas" id="QAS" required>
                          <span class="form-check-label">QAS</span>
                        </label>
                      </div>
                      <div class="col-sm-12 col-md-3 mt-2">
                        <label class="form-check m-0">
                          <input type="checkbox" name="instances[]" class="form-check-input" value="prd" id="PRD" required>
                          <span class="form-check-label">PRD</span>
                        </label>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Man Days :</div>
                      <div class="col-sm-12 col-md-4 mt-2">
                        <label class="form-check">
                          <input name="man_days" id="yes" type="radio" value="1" class="form-check-input" required>
                          <span class="form-check-label">Yes</span>
                        </label>
                      </div>
                      <div class="col-sm-12 col-md-4 mt-2">
                        <label class="form-check">
                          <input name="man_days" id="no" type="radio" value="0" class="form-check-input" checked required>
                          <span class="form-check-label">No</span>
                        </label>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item text-right">
                    <button type="submit" id="submit_id" class="btn btn-lg btn-light mr-4">
                      <i class="align-middle" data-feather="save"></i>
                      Submit
                    </button>
                    <button type="reset" id="cancel" class="btn btn-lg btn-secondary align-vert">
                      <i class="fa fa-times"></i>
                      Cancel
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </form>
      </div>
    </main>

  </div>
</div>