<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?> <!-- Header -->

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid mt-2 pb-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <table id="example3" class="table table-striped table-hover">
                                        <thead>
                                            <tr class="list">
                                                <th style="max-width:150px;">invoice No</th>
                                                <th style="max-width:150px;">Credit Note No</th>
                                                <th>Date</th>
                                                <th style="max-width:150px;">Item</th>
                                                <th style="max-width:250px;">Description </th>
                                                <th style="max-width:250px;">Qty </th>
                                                <th style="max-width:250px;">Unit Price </th>
                                                <th style="max-width:250px;">Total </th>
                                            </tr>
                                        </thead>
                                  
                                        <tbody>
                                            <?php if (isset($creditNoteItems) && is_array($creditNoteItems) && count($creditNoteItems) > 0): ?>
                                                <?php foreach ($creditNoteItems as $item): ?>
                                                    <tr class="list">
                                                        <input type="hidden" class="hidden-item-id" data-id="<?php echo $item['id']; ?>" data-country="<?php echo $item['country']; ?>" data-credit_note_id="<?php echo $item['credit_note_id'];  ?>">
                                                        <td style="max-width:150px;"><?php echo $item['invoice_no']; ?></td>
                                                        <td style="max-width:150px;"><?php echo $item['credit_note_no']; ?></td>
                                                        <td><?php echo $item['added_date']; ?></td>
                                                        <td style="max-width:150px;"><?php echo $item['item']; ?></td>
                                                        <td style="max-width:250px;"><?php echo $item['description']; ?></td>
                                                        <td style="max-width:250px;"><?php echo $item['qty']; ?></td>
                                                        <td style="max-width:250px;"><?php echo $item['unit_price']; ?></td>
                                                        <td style="max-width:250px;"><?php echo $item['total']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" style="text-align: center;">No data available in table</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="creditNoteModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <span class="close" data-dismiss="modal" aria-label="Close" style="font-size: 30px; cursor: pointer;text-align:end;margin-right: 10px;">&times;</span>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <button class="btn btn-info btn-block btn-flat py-3 generatecbn position-relative">
                                    <span id="loader" class="spinner" style="display:none">
                                        <img src="assets/img/load.gif" alt="Loading..." width="30px">
                                    </span>
                                    <i class="fas fa-file-invoice fa-lg"></i><br><br>Generate IRN
                                </button>
                            </div>
                            <div class="col-6 mb-2 col_cbncopy">


                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                    
                    </div> -->
                    <div class="modal-footer justify-content-between feeterr" style="color:red"></div>
                </div>
            </div>
        </div>

        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    </div>

</body>