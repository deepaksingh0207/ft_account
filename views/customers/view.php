<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title" style="line-height: 2.2">
                    Customer Details
                  </h3>
                  <div class="text-right">
                    <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>"
                      class="btn btn-primary btn-sm">
                      Edit
                    </a>
                    <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                      Back
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customergroup"> <b>Customer Group</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $group['name'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_customername"> <b>Customer Name</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['name'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_contactperson"> <b>Contact Person</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['contact_person'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> <b>Address</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group" style="text-align: justify">
                      <?php echo $customer['address'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pincode"> <b>Pincode</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['pincode'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_address"> <b>State</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $state['name'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> <b>PAN No.</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['pan'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_gst"> <b>GSTIN</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['gstin'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_pphone"> <b>Phone (primary)</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $customer['pphone'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_sphone"> <b>Phone (alternative)</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $customer['aphone'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_fax"> <b>Fax</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group numberonly">
                      <?php echo $customer['fax'] ?>
                    </div>
                  </div>
                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_email"> <b>Email</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['email'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_managername"> <b>Manager's Name</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['managername'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_manageremail"> <b>Manager's Email</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['manageremail'] ?> 
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_managerphone"> <b>Manager's Phone</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['managerphone'] ?>
                    </div>
                  </div>

                  <div class="row mx-1">
                    <div class="col-sm-12 col-lg-2">
                      <label for="id_addinfo"> <b>Additional Info</b> </label>
                    </div>
                    <div class="col-sm-12 col-lg-3 form-group">
                      <?php echo $customer['remark'] ?>
                    </div>
                  </div>

                </div>
                <div class="card-footer text-right">
                  <a href="<?php echo ROOT; ?>customers/edit/<?php echo $customer['id'] ?>"
                    class="btn btn-primary btn-sm">
                    Edit
                  </a>
                  <a href="<?php echo ROOT; ?>customers" class="btn btn-default btn-sm">
                    Back
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>