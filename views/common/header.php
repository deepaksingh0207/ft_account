<html lang="en">

<head>
  <title>
    <?php echo $title; ?>
  </title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="FTSPL" content="" />
  <link rel="shortcut icon" href="<?php echo ROOT ?>assets/img/icon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <title>F. T. Help & Support</title>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/google_font.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.css"/>

  <?php if ($controller == 'customers' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/new_customer.css" />
  <?php endif; ?>

  <?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" /> -->
  <!-- <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <?php if ($controller == 'users' && ($action == 'login')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/parallax.css" />
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'create')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <?php if ($controller == 'company' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <?php if ($controller == 'payments' && ($action == 'index')) : ?>
  <!-- <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet"
    href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" /> -->
  <?php endif; ?>

  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>