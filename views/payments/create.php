<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pb-5">
                    <form action="" method="POST" id="id_quickForm" novalidate="novalidate">
                        <div class="card my-3">
                            <div class="card-header">
                                <h3 class="card-title" style="line-height: 2.2">
                                    Add New Payments
                                </h3>
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
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                Pending Payments
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Invoice No
                                                            </th>
                                                            <th>Description</th>
                                                            <th>Payment Date</th>
                                                            <th>UTR No</th>
                                                            <th>Attachment</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="id_pending">
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                Cleared Payments
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
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
                                                    <tbody id="id_cleared">
                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>