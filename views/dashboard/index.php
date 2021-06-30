<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          
          <div class="row">
            <div class="col-12">
              <div class="card card-default">
                <div class="card-body">
                  <?php $report->render(); ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>
