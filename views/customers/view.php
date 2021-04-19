<?php
$detailClass = 'col-lg-12';
$showForm = false;
$showApprovalForm = false;
$showAdminApprovalForm = false;
if (
    !$is_admin && $isMandayAllowed && (empty($complain['man_day_status']) || $complain['man_day_status'] != 1) &&
    (($complain['status'] == 3 && isset($complain['man_days']) && $complain['man_days'] > 0))
    ) {
        $detailClass = 'col-lg-8';
        $showApprovalForm = true;
    } else if ($is_admin && ($complain['status'] == 1 || $complain['status'] == 2) && $isMandayAllowed && $complain['man_day_status'] != 1) {
        $detailClass = 'col-lg-8';
        $showAdminApprovalForm = true;
    } else if (($is_admin && ($complain['status'] == 1 || $complain['status'] == 2)) ||
        (!$is_admin && $complain['status'] == 3) && (!(empty($complain['man_day_status']) || $complain['man_day_status'] != 1) ||
            !$isMandayAllowed)
        ) {
            $detailClass = 'col-lg-8';
            $showForm = true;
        }


//print_r($complain); exit;


?>

<div class="wrapper">
  <div class="main">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <!-- main frame -->
    <main class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12 col-md-8 <?php echo $detailClass ?> m-0 p-0">
            <div class="card">
              <div class="card-header pb-0 bbc">
                <h3 class="pl-2 text-left">
                  <b> <?php echo $complain['id'] . ' / ' . date('Y', strtotime($complain['created_date'])) . ' ' . $complain['subject'] ?> </b>
                </h3>
                <div class="mt-1 pl-2">
                  <!-- <span class="badge bg-primary rounded-pill">Primary</span> 
                        <span class="badge bg-secondary rounded-pill">NOT SENT TO SAP</span>
                        <!-- <span class="badge bg-success rounded-pill">Success</span>
                        <span class="badge bg-danger rounded-pill">Danger</span>
                        <span class="badge bg-warning rounded-pill">Warning</span>
                        <span class="badge bg-info rounded-pill">Info</span> -->
                </div>
                <ul class="nav nav-pills card-header-pills pull-right m-3" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link btn btn-lg mr-2 pb-2" href="<?php echo ROOT ?>fw/incidents/">
                      <i class="fa fa-chevron-left mr-1"></i>
                      Back
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#detail">
                      Details
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#communication">
                      Communication
                    </a>
                  </li>
                </ul>
              </div>
              <div class="card-body p-4 scroll">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="detail" role="tabpanel">
                    <div class="row ml-3">
                      <div class="col-sm-12 col-md-6 mb-1">
                        <div class="row">
                          <h5 class="card-title">INCIDENT DETAILS</h5>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Status
                            </div>
                            <div class="col-8 pl-0 text-black">
                              : <?php echo $STATUS[$complain['status']] ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              System
                            </div>
                            <div class="col-8 pl-0 text-black">
                              : <?php echo $INSTANCE[$complain['instance']] ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Priority
                            </div>
                            <div class="col-8 pl-0 text-black">
                              : <?php echo $PRIORITY[$complain['priority']] ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Component
                            </div>
                            <div class="col-8 pl-0 text-black">
                              : <?php echo ucfirst($complain['component']) ?>
                            </div>
                          </div>
                          <?php if ($complain['man_days']) : ?>
                            <div class="row">
                              <div class="col-4 pr-1 text-left">
                                Man Days
                              </div>
                              <div class="col-8 pl-0 text-black">
                                : <?php echo $complain['man_days'] ?>
                                &nbsp;&nbsp;<?php echo empty($complain['man_day_status']) ? '(Pending for approval)' : '' ?>
                                <?php echo $complain['man_day_status'] == 1 ? '(Approved)' : '' ?>
                              </div>
                            </div>
                          <?php endif; ?>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Reporter
                            </div>
                            <div class="col-8 pl-0 text-black">
                              :<?php echo ucfirst($complain['cust_emp_name']) ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Customer
                            </div>
                            <div class="col-8 pl-0 text-black">
                              :<?php echo $complain['cust_name'] ?>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-4 pr-1 text-left">
                              Created At
                            </div>
                            <div class="col-8 pl-0 text-black">
                              : <?php echo date('d.m.Y', strtotime($complain['created_date'])) ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6 mb-1">
                        <?php if (!empty($complain['impact'])) : ?>
                          <h5 class="card-title">
                            Business Impact
                            <span class="text-danger ml-2" style="font-style: italic">
                              <?php echo $PRIORITY[$complain['priority']] ?>
                            </span>
                          </h5>

                          <p>
                            <?php echo $complain['impact'] ?>
                          </p>
                        <?php endif ?>
                        <?php if (!empty($complain['attachment'])) :
                          $files = explode(',', $complain['attachment']);
                        ?>
                          <h5 class="card-title">ATTACHMENTS</h5>
                          <ol class="card-text ml-2">
                            <?php foreach ($files as $file) : ?>
                              <li>
                                <a href="<?php echo ROOT ?>uploads/<?php echo $file ?>" target="_blank"><?php echo $file ?></a>
                              </li>
                            <?php endforeach; ?>
                          </ol>
                        <?php endif; ?>
                        <br />
                      </div>
                      <div class="col-sm-12 col-md-12 mb-4">
                        <h5 class="card-title">Description</h5>
                        <p class="card-text text-black">
                          <?php echo $complain['description'] ?>
                        </p>
                      </div>
                      <?php if (!empty($complainReplies)) :
                        $reply = $complainReplies[0];
                      ?>
                        <div class="col-sm-12 col-md-12 mb-4">
                          <h5 class="card-title">Last Communication</h5>
                          <i>Updated <?php echo date('d.m.Y', strtotime($reply['created_date']))  ?> at <?php echo date('H:i', strtotime($reply['created_date'])) ?> by <?php echo $reply['reply_by'] ?></i>
                          <p class="card-text text-black">
                            <?php echo $reply['description'] ?>
                          </p>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="tab-pane fade mb-5" id="communication" role="tabpanel">
                    <?php if (!empty($complainReplies)) : ?>
                      <?php foreach ($complainReplies as $reply) : ?>
                        <div class="col-sm-12 col-md-12 mb-4">
                          <p class="card-text text-black">
                            <?php echo $reply['description'] ?>
                          </p>
                          <h5 class="text-secondary">
                            Updated <?php echo date('d.m.Y', strtotime($reply['created_date']))  ?> at <?php echo date('H:i', strtotime($reply['created_date'])) ?> by <?php echo $reply['reply_by'] ?>
                          </h5>
                          <?php if (!empty($reply['attachment'])) :
                            $files = explode(',', $reply['attachment']); ?>
                            <h5 class="text-danger">
                              <b>Attachments:</b>
                              <span class="text-secondary ml-2">
                                <?php foreach ($files as $file) : ?>
                                  <a href="<?php echo ROOT ?>uploads/<?php echo $file ?>" target="_blank"><?php echo $file ?></a> &nbsp;&nbsp;
                                <?php endforeach; ?>
                              </span>
                            </h5>
                          <?php endif; ?>
                          <hr />
                        </div>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <h2>No communication</h2>
                    <?php endif; ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if ($showForm) : ?>
            <div class="col-sm-12 col-md-4 col-lg-4 text-black p-0">
              <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate action="<?php echo ROOT ?>incidents/view/<?php echo $complain['id'] ?>">

                <input type="hidden" class="form-control" name="reply_by" value="<?php echo $complain['cust_emp_name'] ?>" />

                <input type="hidden" class="form-control" name="complaint_id" value="<?php echo $complain['id'] ?>" />
                <div class="card">
                  <div class="card-header pb-0 bbc">
                    <h3 class="pl-2 text-left">Send Update</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="reply_id">
                          Reply to: <span style="color: red">*</span>
                        </label>
                        <div class="input-group has-validation">
                          <textarea id="descp_id" name="description" class="form-control" aria-describedby="inputGroupPrepend" required></textarea>
                          <div class="invalid-feedback">
                          </div>
                        </div>
                        <div id="descp_warn" style="
                                display: none;
                                color: red;
                                font-size: smaller;
                              ">
                          Please provide a description.
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <?php if ($is_admin) : ?>
                            <label for="priority_id" class="form-label">
                              Status
                            </label>
                            <div class="input-group has-validation">
                              <select class="form-select" id="status_id" name="status">
                                <option selected value="">
                                  Select Status
                                </option>
                                <option value="2"><?php echo $STATUS[2] ?></option>

                              </select>
                              <div class="invalid-feedback">
                                Please select any one priority
                              </div>
                            </div>
                            <br />
                          <?php endif ?>

                          <label for="priority_id" class="form-label">
                            Priority
                          </label>
                          <div class="input-group has-validation">
                            <select class="form-select" id="priority_id" name="priority">
                              <option selected value="">
                                Select Priority
                              </option>
                              <?php foreach ($PRIORITY as $key => $val) : ?>
                                <option value="<?php echo $key ?>" <?php echo ($complain['priority'] == $key) ? 'selected=selected' : '' ?>><?php echo $val ?></option>
                              <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                              Please select any one priority
                            </div>
                          </div>
                          <br />
                          <div id="show_veryhigh" style="display: none">
                            <div class="input-group has-validation">
                              <textarea class="form-control" name="impact" id="remarks_id" cols="60" placeholder="Please state Business Impact" rows="5" aria-describedby="inputGroupPrepend"></textarea>
                              <div class="invalid-feedback">
                                Business Impact is mandatory.
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <label for="attach_id">Add Attachments : </label>
                          <div class="file-drop-area">
                            <span class="fake-btn">SELECT</span>
                            <span class="file-msg">OR DRAG AND DROP FILES HERE</span>

                            <input class="file-input" name="upload[]" id="attach_id" type="file" multiple>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <ul class="list-inline mt-2" style="float: right;">
                            <!-- <li class="list-inline-item">
                              <a href="#" class="btn btn-dark">Cancel</a>
                            </li> -->
                            <li class="list-inline-item">
                              <button type="submit" class="btn btn-dark" name="submit" id="submit_id" value="submit">
                                Submit
                              </button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
              </form>
            </div>
          <?php endif; ?>

          <?php if ($showAdminApprovalForm) : ?>
            <div class="col-sm-12 col-md-4 col-lg-4 text-black p-0">
              <form method="post" class="needs-validation" novalidate action="<?php echo ROOT ?>incidents/approval/<?php echo $complain['id'] ?>">

                <input type="hidden" class="form-control" name="reply_by" value="<?php echo $complain['cust_emp_name'] ?>" />

                <input type="hidden" class="form-control" name="complaint_id" value="<?php echo $complain['id'] ?>" />
                <div class="card">
                  <div class="card-header pb-0 bbc">
                    <h3 class="pl-2 text-left">Approval Effort Days</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="manday_id">
                          Effort Days: <span style="color: red">*</span>
                        </label>
                        <input type="number" maxlength="2" id="manday_id" name="man_days" value="<?php echo $complain['man_days'] ?>" class="form-control" aria-describedby="inputGroupPrepend" required></input>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="reply_id">
                          Remark: <span style="color: red">*</span>
                        </label>
                        <textarea name="description" class="form-control" aria-describedby="inputGroupPrepend" required></textarea>
                      </div>
                      <div id="descp_warn" style="
                                display: none;
                                color: red;
                                font-size: smaller;
                              ">
                        Please provide a remark.
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <ul class="list-inline mt-2" style="float: right;">
                          <!-- <li class="list-inline-item">
                              <a href="#" class="btn btn-dark">Cancel</a>
                            </li> -->
                          <li class="list-inline-item">
                            <button type="submit" class="btn btn-dark" name="submit" id="submit_id" value="submit">
                              Submit
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <?php endif; ?>

          <?php if ($showApprovalForm) : ?>
            <div class="col-sm-12 col-md-4 col-lg-4 text-black p-0">
              <form method="post" class="needs-validation" novalidate action="<?php echo ROOT ?>incidents/approval/<?php echo $complain['id'] ?>">

                <input type="hidden" class="form-control" name="reply_by" value="<?php echo $complain['cust_emp_name'] ?>" />

                <input type="hidden" class="form-control" name="complaint_id" value="<?php echo $complain['id'] ?>" />
                <div class="card">
                  <div class="card-header pb-0 bbc">
                    <h3 class="pl-2 text-left">Approval Effort Days</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="manday_id">
                          Effort Days: <span style="color: red">*</span>
                        </label>
                        <input type="number" maxlength="2" id="manday_id" name="man_days" value="<?php echo $complain['man_days'] ?>" <?php echo (!$is_admin) ? 'readonly' : '' ?> class="form-control" aria-describedby="inputGroupPrepend" required></input>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="reply_id">
                          Remark: <span style="color: red">*</span>
                        </label>
                        <textarea name="description" class="form-control" aria-describedby="inputGroupPrepend" required></textarea>
                      </div>
                      <div id="descp_warn" style="
                                display: none;
                                color: red;
                                font-size: smaller;
                              ">
                        Please provide a remark.
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <ul class="list-inline mt-2" style="float: right;">
                          <!-- <li class="list-inline-item">
                              <a href="#" class="btn btn-dark">Cancel</a>
                            </li> -->
                          <li class="list-inline-item">
                            <button type="submit" class="btn btn-dark" name="submit" id="submit_id" value=Accept>
                              Accept
                            </button>
                          </li>

                          <li class="list-inline-item">
                            <button type="submit" class="btn btn-dark" name="submit" id="submit_id" value="Reject">
                              Reject
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </main>
    <!-- main frame -->
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</div>