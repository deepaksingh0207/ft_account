<html lang="en">

<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="FTSPL" content="" />
  <link rel="shortcut icon" href="<?php echo ROOT ?>assets/img/icon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <title>F. T. Help & Support</title>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/google_font.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/fontawesome-free/css/all.min.css" />
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


  <?php if ($controller == 'users' && ($action == 'login')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <?php endif; ?>


  <?php if ($controller == 'customers' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/bs-stepper/css/bs-stepper.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/new_customer.css" />
  <?php endif; ?>


  <?php if ($controller == 'customers' && ($action == 'index')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'create')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'index')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <?php endif; ?>

  <?php if ($controller == 'invoices' && ($action == 'create')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <?php endif; ?>

  <?php if ($controller == 'invoices' && ($action == 'index')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <?php endif; ?>

  <?php if ($controller == 'company' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/bs-stepper/css/bs-stepper.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <?php endif; ?>

</head>