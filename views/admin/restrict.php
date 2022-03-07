<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-danger">401</h2>
        <div class="error-content">
          <h3><i class="mt-5 fas fa-exclamation-triangle text-danger"></i> Your Access is denied.</h3>
          <p>
            <a href="<?php echo ROOT; ?>">Return to dashboard</a> while your access is been reviewed.
          </p>
        </div>
      </div>
    </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>