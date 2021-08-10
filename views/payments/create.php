<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pb-5">
                    <form action="" method="POST" id="quickForm" novalidate="novalidate"  enctype="multipart/form-data">
                        <div class="card my-3">
                            <div class="card-header">
                                <h3 class="card-title" style="line-height: 2.2">
                                    Add New Payments
                                </h3>
                                <div class="text-right">
                                    <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <label for="id_customergroup">
                                            Customer Group :
                                        </label>
                                        <select class="form-control" name="group_id" id="id_group_id">
                                            <option value=""></option>
                                            <?php foreach ($groups as $group) : ?>
                                            <option value="<?php echo $group['id'] ?>">
                                                <?php echo $group['name'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <label for="customerid_id">Customer : </label>
                                        <select class="form-control" name="customer_id" id="customerid_id" disabled>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <label for="id_orderid">Customer PO No.:</label>
                                        <select name="order_id" id="id_orderid" class="form-control" disabled></select>
                                    </div>
                                    <div class="col-sm-12 col-lg-12">
                                        <label for="id_remarks"></label>
                                        <textarea name="remarks" class="form-control" id="id_remarks" cols="30" rows="1"
                                            placeholder="Type Your Remarks."></textarea>
                                    </div>
                                    <div class="col-sm-12 col-lg-12" id="colid_pending" style="display: none;">
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                Pending Payments
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead id="headid_pending">
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                Invoice No
                                                            </th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Payment Date & UTR No</th>
                                                            <th>Attachment</th>
                                                            <th></th>
                                                        </tr>
                                                        
                                                    </thead>
                                                    <tbody id="bodyid_pending">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-12" id="colid_cleared" style="display: none;">
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                Cleared Payments
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead id="headid_cleared">
                                                        <tr>
                                                            <th>
                                                                Invoice No
                                                            </th>
                                                            <th>Description</th>
                                                            <th>Payment Date</th>
                                                            <th>UTR No</th>
                                                            <th>Attachment</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bodyid_cleared">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="<?php echo ROOT; ?>payments" class="btn btn-default btn-sm">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="modelpdf" style="display: none;" data-toggle="modal" data-target="#pdfmodal"></button>
                        <div class="modal fade" id="pdfmodal">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header" id="modal_header">
                                        Confirm Payment
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modal_body"></div>
                                    <div class="modal-footer" id="modal_footer">
                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="modalclose">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-success btn-sm" id="modalsubmit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <button type="button" id="modelutr" style="display: none;" data-toggle="modal" data-target="#utrmodal"></button>
        <div class="modal fade" id="utrmodal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" id="utr_header">
                        Confirm Payment
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="utr_body"></div>
                </div>
            </div>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>