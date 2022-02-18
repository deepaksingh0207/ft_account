<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 mt-3 mb-5">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered mb-0" id="example3" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:115px;">Company</th>
                                                <th>Customer PO</th>
                                                <th>Order Amount</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Item Amount</th>
                                                <th style="width:55px;">Order Date</th>
                                                <th style="width:55px;">Due Date</th>
                                                <th>Ageing</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (is_array($popuprows) || is_object($popuprows)) : ?>
                                            <?php foreach ($popuprows as $key=>$row) : ?>
                                            <tr data-href="<?php echo $row['id'] ?>">
                                                <td class="ordlist pointer align-middle">
                                                    <?php echo $row['name'] ?>
                                                </td>
                                                <td class="ordlist pointer align-middle">
                                                    <?php echo $row['po_no'] ?>
                                                </td>
                                                <td class="ordlist pointer align-middle">
                                                    <?php echo $row['ordertotal'] ?>
                                                </td>
                                                <?php if ($row['ageing'] < 11): ?>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['item'] ?>
                                                </td>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['description'] ?>
                                                </td>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['total'] ?>
                                                </td>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_from_date'] ?>
                                                </td>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_to_date'] ?>
                                                </td>
                                                <td style="background-color: #f67161;color: #FFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['ageing'] ?>
                                                </td>
                                                <?php elseif ($row['ageing'] < 21): ?>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['item'] ?>
                                                </td>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['description'] ?>
                                                </td>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['total'] ?>
                                                </td>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_from_date'] ?>
                                                </td>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_to_date'] ?>
                                                </td>
                                                <td style="background-color: #FFE77AFF;color: #2C5F2DFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['ageing'] ?>
                                                </td>
                                                <?php else: ?>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['item'] ?>
                                                </td>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['description'] ?>
                                                </td>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['total'] ?>
                                                </td>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_from_date'] ?>
                                                </td>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['po_to_date'] ?>
                                                </td>
                                                <td style="background-color: #2C5F2DFF;color: #FFE77AFF;"
                                                    class="ordlist pointer">
                                                    <?php echo $row['ageing'] ?>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
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