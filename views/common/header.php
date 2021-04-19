<html lang="en">

<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="FTSPL" content="" />
  <link rel="shortcut icon" href="<?php echo ROOT ?>assets/brand/icon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <title>F. T. Help & Support</title>


  <?php if ($controller == 'users' && ($action == 'login')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/google_font.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <?php endif; ?>


  <?php if ($controller == 'customers' && ($action == 'create')) : ?>
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/css/google_font.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/dist/css/adminlte.min.css" />
  <!-- new_customer -->
  <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/bs-stepper/css/bs-stepper.min.css" />
    <link rel="stylesheet" href="<?php echo ROOT; ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"/>
    <script src="<?php echo ROOT; ?>assets/css/new_customer.css"></script>
    <!-- new_customer -->
    <script src="<?php echo ROOT; ?>assets/js/htmlinclude.js"></script>
<?php endif; ?>
  <script>
    var baseUrl = '<?php echo HOST . ROOT ?>';
  </script>

</head>