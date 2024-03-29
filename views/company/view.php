<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul
                      class="nav nav-tabs"
                      id="custom-tabs-four-tab"
                      role="tablist"
                    >
                    <?php include HOME . DS . 'includes' . DS . 'masters.inc.php'; ?>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                      <div
                        class="tab-pane fade show active"
                        id="company"
                        role="tabpanel"
                        aria-labelledby="company_tab"
                      >
                      <div class="row">

                        <div class="col-sm-12 col-lg-2 align-center">
                          <h5>INFO</h5>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                          <div class="row justify-content-between">
                            <div class="col-5 my-2">
                              <b>Company Name:</b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['name'] ?>
                            </div>
                            <div class="col-5 my-2"">
                              <b>Contact Person : </b>
                            </div>
                            <div class=" col-7 my-2">
                              <?php echo $customer['contact_person'] ?>
                            </div>
                            <div class="col-5 my-2">
                              <b>Contact : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['contact'] ?>
                            </div>
                            <div class="col-5 my-2">
                              <b>Mobile : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['mobile'] ?>
                            </div>
                          </div>
                          <hr>
                        </div>
    
                        <div class="col-sm-12 col-lg-2 align-center">
                          <h5>BANK</h5>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                          <div class="row justify-content-between">
                            <div class="col-5 my-2">
                              <b>Bank Name : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['bank_name'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>Account No. : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['account_no'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>IFSC : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['ifsc_code'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>GSTIN : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['gstin'] ?>
                            </div>
                            
                            <div class="col-5 my-2">
                              <b>SWIFT Code : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['swift_code'] ?>
                            </div>
    
                          </div>
                          <hr>
                        </div>
    
                        <div class="col-sm-12 col-lg-2 align-center">
                          <h5>OTHER</h5>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                          <div class="row justify-content-between pb-4">
                            <div class="col-5 my-2">
                              <b>PAN No. </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['pan'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>SAC : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['sac'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>Fax : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['fax'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>Email : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['email'] ?>
                            </div>
    
                          </div>
                          <hr>
                        </div>
    
                        <div class="col-sm-12 col-lg-2 align-center">
                          <h5>CONTACT</h5>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                          <div class="row justify-content-between">
    
                            <div class="col-5 my-2">
                              <b>Address : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['address'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>Pincode : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $customer['pincode'] ?>
                            </div>
    
                            <div class="col-5 my-2">
                              <b>State : </b>
                            </div>
                            <div class="col-7 my-2">
                              <?php echo $state['name'] ?>
                            </div>
                          </div>
                          <hr>
                        </div>
                        
                        <div class="col-sm-12 col-lg-12 text-right">
                          <a href="<?php echo ROOT; ?>company/edit/<?php echo $customer['id'] ?>" class="btn btn-default">
                            <i class="fa fa-pencil-alt"></i> Edit
                          </a>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>