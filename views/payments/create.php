<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pb-5">
                    <form method="POST" id="quickForm" enctype="multipart/form-data">
                        <div class="card card-outline card-info mt-2">
                            <div class="card-header">
                                <h5 class="card-title">NEW PAYMENTS</h5>
                                <div class="card-tools">
                                    <button data-href="<?php echo ROOT; ?>payments" type="button" class="btn btn-tool"
                                        data-toggle="tooltip" data-placement="top" title="Back">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" data-placement="top" title="Expand/Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="id_group_id">
                                                Customer Group
                                            </label>
                                            <select name="group_id" id="id_group_id" class="form-control" required>
                                                <option selected>Select Customer Group</option>
                                                <?php foreach ($groups as $group) : ?>
                                                <option value="<?php echo $group['id'] ?>">
                                                    <?php echo $group['name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="id_customerid">Customer</label>
                                            <select class="form-control" name="customer_id" id="id_customerid" required>
                                                <option selected>Select Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="id_order_id">Customer PO No.</label>
                                            <select class="select2" multiple="multiple" name="order_id" id="id_order_id"
                                                data-placeholder="" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group m-0">
                                            <label for="id_payment_date">Payment Date</label>
                                            <input type="date" name="payment_date" id="id_payment_date"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="id_cheque_utr_no">UTR</label>
                                            <input type="text" name="cheque_utr_no" id="id_cheque_utr_no"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="id_received_amt">Received Amount</label>
                                            <input type="number" name="received_amt" id="id_received_amt"
                                                class="form-control rvdamt">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="id_utr_file">Attachment</label>
                                            <input type="file" name="utr_file" id="id_utr_file">
                                            </div>
                                        </div>
                                    
                                <div class="col-sm-12 col-lg-12 mb-3">
                                        <label for="id_remarks"></label>
                                        <textarea name="remarks" class="form-control" id="id_remarks" rows="1"
                                            placeholder="Remarks"></textarea>
                                    </div>
                                    
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="card" id="id_pendingpayments" style="display:none;">
                                            <div class="card-header">
                                                <h5 class="card-title">PENDING PAYMENTS</h5>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool pt-3"
                                                        data-card-widget="collapse" data-toggle="tooltip"
                                                        data-placement="top" title="Expand/Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" class="align-middle text-center">
                                                                Invoice No.
                                                            </th>
                                                            <th rowspan="2" class="align-middle text-center">
                                                                Description
                                                            </th>
                                                            <th colspan="4" class="text-center">
                                                                Amount
                                                            </th>
                                                            <th rowspan="2" class="align-middle text-center">
                                                                TDS %
                                                            </th>
                                                            <th rowspan="2" class="align-middle text-center">
                                                                Allocated Amount
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                            <th class="text-center">Base</th>
                                                            <th class="text-center">GST</th>
                                                            <th class="text-center">invoice</th>
                                                            <th class="text-center">Paid</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody_pendingpayment"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="card" id="id_clearedpayments" style="display:block;">
                                            <div class="card-header">
                                                <h5 class="card-title">CLEARED PAYMENTS</h5>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"></button>
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse" data-toggle="tooltip"
                                                        data-placement="top" title="Expand/Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Payment Date</th>
                                                            <th>Received Amount</th>
                                                            <th>UTR</th>
                                                            <th>Attachment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody_clearedpayment">
                                                    <tbody>
                                                    </tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="<?php echo ROOT; ?>payments"
                                        class="btn btn-default btn-sm bg-gradient-default" data-toggle="tooltip"
                                        data-placement="top" title="Back to Payment List">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-tool btn-sm bg-gradient-primary"
                                        data-toggle="tooltip" data-placement="top" title="Save Payment Details">
                                        SUBMIT
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <button type="button" id="modelpdf" style="display: none" data-toggle="modal"
                  data-target="#pdfmodal"></button>
        <div class="modal fade" id="pdfmodal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" id="modal_header">
                        UTR Attachment
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0" id="modal_body"></div>
                </div>
            </div>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>