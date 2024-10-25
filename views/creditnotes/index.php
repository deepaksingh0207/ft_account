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
                                    <table id="example1" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
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
                                                    <tr>
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

        <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                // Optional configurations
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
</body>