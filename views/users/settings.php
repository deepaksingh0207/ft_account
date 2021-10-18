<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row my-3">
            <div class="col-12">
              <form action="" method="post" id="quickForm" novalidate="novalidate">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Update GST Settings</div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary record" title="All fields are mandatory.">
                        Update
                      </button>
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>

                  <div class="card-body" id="order" style="display: block">

                    <div class="row">
                      <div class="col-sm-12 col-lg-1">
                        <label for="id_igst">
                          IGST :
                        </label>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="number" class="form-control" name="igst" id="id_igst">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-1">
                        <label for="id_igst">
                          CGST :
                        </label>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="number" class="form-control" name="cgst" id="id_cgst">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-lg-1">
                        <label for="id_igst">
                          SGST :
                        </label>
                      </div>

                      <div class="col-sm-12 col-lg-3 form-group">
                        <input type="number" class="form-control" name="sgst" id="id_sgst">
                      </div>
                    </div>
                    
                  </div>

                  <div class="card-footer">
                    <div class="text-right">
                      <button type="submit" class="btn btn-sm btn-primary record" title="All fields are mandatory.">
                        Update
                      </button>
                      <a href="<?php echo ROOT; ?>invoices" class="btn btn-default btn-sm">
                        Back
                      </a>
                    </div>
                  </div>
                </div>

                <button type="button" id="responsemodal" class="btn btn-default" data-toggle="modal"
                  data-target="#modal-sm" style="display: none"></button>

                <div class="modal fade" id="modal-sm">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure with the update?
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                          Close
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="form.submit()">Update</button>
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