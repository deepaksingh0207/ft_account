<body class="hold-transition sidebar-collapse layout-top-nav">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <form action="" method="POST" id="quickForm" novalidate="novalidate">
                <div class="card card-default mt-3">
                  <div class="card-header">
                    <h3 class="card-title" style="line-height: 2.2">
                      Add New Customer
                    </h3>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary vip" disabled>
                        Submit
                      </button>
                      <button type="reset" class="btn btn-default">
                        Cancel
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="bs-stepper">
                      <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#logins-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" onclick="stepper.previous()">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Customer</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" onclick="stepper.next()">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                              Other information
                            </span>
                          </button>
                        </div>
                      </div>
                      <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="customername_id">
                                Customer Name
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="customername" id="customername_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="contactperson_id">
                                Contact Person
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="contactperson" id="contactperson_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="contactfirstname_id">
                                Contact First Name
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="contactfirstname" id="contactfirstname_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="address_id"> Address </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <textarea class="form-control fc ftsm" name="address" id="address_id" cols="30" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="vat_id">
                                VAT registration number
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="vat" id="vat_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="pphone_id"> Phone (primary) </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="tel" class="form-control fc ftsm" name="pphone" id="pphone_id" pattern="[789][0-9]{9}" minlength="10" maxlength="10" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="sphone_id">
                                Phone (alternative)
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="tel" class="form-control fc ftsm" name="sphone" id="sphone_id" pattern="[789][0-9]{9}" minlength="10" maxlength="10"/>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="fax_id"> Fax </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="tel" class="form-control fc ftsm" name="fax" id="fax_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="email_id"> Email </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="email" id="email_id" pattern="[a-z0-9.]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              <label for="addinfo_id">
                                Additional Info
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control fc ftsm" name="addinfo" id="addinfo_id" />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-2">
                              Active Customer
                            </div>
                            <div class="col-sm-12 col-lg-4">
                              <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                  <input type="checkbox" name="active" id="active_id" />
                                  <label for="active_id"> </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-12 text-right">
                              <a class="btn btn-default" onclick="stepper.next()">
                                Next &nbsp;
                                <i class="fas fa-chevron-right"></i>
                              </a>
                              <!-- <button
                                  class="btn btn-primary"
                                  onclick="stepper.next()"
                                >
                                  Next
                                </button> -->
                            </div>
                          </div>
                        </div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="shippingaddress_id">
                                Shipping Address
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <textarea class="form-control fc ftsm" name="shippingaddress" id="shippingaddress_id" cols="30" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="invoicethru_id">
                                Prefers Invoices By
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <select class="form-control fc ftsm" name="invoicethru" id="invoicethru_id" required>
                                <option value=""></option>
                                <option value="1">Email</option>
                                <option value="2">Fax</option>
                                <option value="3">Pay</option>
                                <option value="4">Record Only</option>
                                <option value="5">Print</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              Set tax exempt for this customer
                            </div>
                            <div class="col-sm-12 col-lg-3">
                              <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                  <input type="checkbox" name="exlutax" id="exlutax_id" />
                                  <label for="exlutax_id"> </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="paymentterms_id">
                                Payment Terms
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <select class="form-control fc ftsm" name="paymentterms" id="paymentterms_id">
                                <option value=""></option>
                                <option value="1">COD</option>
                                <option value="2">Pay in Days</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="ptdays_id">
                                Payment Terms Days
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input type="text" class="form-control ftsm" name="ptdays" id="ptdays_id" disabled />
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="salesperson_id">
                                Sales Person
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input class="form-control fc ftsm" list="salespersonlist" name="salesperson" id="salesperson_id" placeholder="Type or search..." />
                              <datalist id="salespersonlist">
                                <option value="Mr. X"></option>
                                <option value="Ms. Y"></option>
                              </datalist>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="customernotes_id">
                                Customer Notes:
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <textarea class="form-control fc ftsm" name="customernotes" id="customernotes_id" cols="30" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-sm-12 col-lg-3">
                              <label for="customergroup_id">
                                Customer Group
                              </label>
                            </div>
                            <div class="col-sm-12 col-lg-3 form-group">
                              <input class="form-control fc ftsm" list="customergrouplist" name="customergroup" id="customergroup_id" placeholder="Type or search..." />
                              <datalist id="customergrouplist">
                                <option value="Default"></option>
                              </datalist>
                            </div>
                          </div>
                          <div class="row mx-1">
                            <div class="col-12">
                              <a class="btn btn-default" onclick="stepper.previous()">
                                <i class="fas fa-chevron-left"></i>
                                &nbsp; Previous
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary vip" disabled>
                      Submit
                    </button>
                    <button type="reset" class="btn btn-default">
                      Cancel
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
      </section>
    </div>
  </div>