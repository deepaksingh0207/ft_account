<div class="wrapper">
  <div class="main">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <main class="content">
      <div class="container-fluid p-5">
        <form action="" method="post" class="needs-validation" novalidate>
          <div class="row">
            <div class="col-12">
              <div class="card login-box">
                <div class="card-header bbc py-0">
                  <h5 class="card-title mb-0">
                    <div class="row py-2">
                      <div class="col-2 card-title mt-2 mb-0 align-vert">
                        <h4>PROFILE</h4>
                      </div>
                      <div class="col-8 text-center p-0">
                        <img
                          alt="<?php echo $user['cust_name'] ?>"
                          src="<?php echo ROOT ?>assets/img/aarti-logo-color.svg"
                          style="max-width: 150px; max-height: 50px"
                        />
                      </div>

                      <div class="col-2 text-right align-vert">
                        <button
                          type="button"
                          id="edit"
                          class="btn btn-light text-right"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Edit"
                        >
                          <i class="align-middle" data-feather="edit-2"></i>
                        </button>
                        <button
                          type="submit"
                          id="submit_id"
                          class="btn btn-light text-right"
                          style="display: none"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Save"
                        >
                          <i class="align-middle" data-feather="save"></i>
                        </button>
                        <button
                          type="reset"
                          id="cancel"
                          class="btn btn-light text-right"
                          style="display: none"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Cancel"
                        >
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">
                        Company Number :
                      </div>
                      <div class="col-sm-12 col-md-9 mt-2">
                        <?php echo $user['cust_num'] ?>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Company Name :</div>
                      <div class="col-sm-12 col-md-9 mt-2">
                        <?php echo $user['cust_name'] ?>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Name :</div>
                      <div class="col-sm-12 col-md-9">
                        <div class="input-group has-validation">
                          <input
                            type="text"
                            class="form-control ftsm"
                            name="emp_name"
                            id="name_id"
                            value="<?php echo $user['emp_name'] ?>"
                            aria-describedby="inputGroupPrepend"
                            disabled
                            required
                          />
                          <div class="invalid-feedback">Name is mandatory</div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Mobile :</div>
                      <div class="col-sm-12 col-md-9">
                        <div class="input-group has-validation">
                          <input
                            type="tel"
                            class="form-control ftsm"
                            name="emp_mobile"
                            id="alt_tel_id"
                            value="<?php echo $user['emp_mobile'] ?>"
                            minlength="10"
                            maxlength="10"
                            aria-describedby="inputGroupPrepend"
                            disabled
                            required
                          />
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
                      <div class="col-sm-12 col-md-9 mt-2">
                        <?php echo $user['emp_email'] ?>
                      </div>
                    </div>
                  </li>

                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">System :</div>
                      <div class="col-sm-12 col-md-9 mt-2">
                        <?php echo implode(', ', json_decode($user['instances'], true)['ins']) ?>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-12 col-md-3 mt-2">Man Days :</div>
                      <div class="col-sm-12 col-md-9 mt-2">
                        <?php echo $user['man_days'] ? ' Yes' : 'No' ?>
                      </div>
                    </div>
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
