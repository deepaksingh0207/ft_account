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
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/toastr/toastr.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <?php if ($controller == 'admin' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>  
  
  <?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'dashboard' && ($action == 'report')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'dashboard' && ($action == 'ordersummary')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'dashboard' && ($action == 'expiredpo')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>
  
  <?php if ($controller == 'customergroups' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'customers' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/new_customer.css" />
  <?php endif; ?>
    
  <?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>
    
  <?php if ($controller == 'hsn' && ($action == 'index')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'users' && ($action == 'login')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/parallax.css" />
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'orders' && ($action == 'list')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'creditnotes' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>
  <?php if ($controller == 'company' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <?php if ($controller == 'payments' && ($action == 'index')) : ?>
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <?php endif; ?>

  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/custom.css" />
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="<?php echo ROOT ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script>$.widget.bridge('uibutton', $.ui.button)</script>
  <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
  var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
  function getRemote(remote_url, method = "GET", r_data = null, type = "json", convertapi = true) {
    var resp = $.ajax({ type: method, data: r_data, dataType: type, url: remote_url, async: false }).responseText;
    if (convertapi) { return JSON.parse(resp); }
    return resp;
  }
  </script>
</head>