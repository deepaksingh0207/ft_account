<div class="wrapper">
  <div class="main">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <main class="content">
      <div class="container-fluid p-0 leavelow">
        <div class="card m-2">
          <div class="card-body mb-5 table-responsive">
            <?php $report->render(); ?>
          </div>
        </div>
      </div>
    </main>

    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</div>
