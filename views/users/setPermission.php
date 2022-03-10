<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid mt-2 pb-5">
          <form method="post">
            <div class="card">
              <div class="card-header">
                <b>User Acess Control List</b>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <?php foreach ($form as $x => $cont) : ?>
                  <tr>
                    <th><span class="firstcap"><?php echo $x ?></span></th>
                    <td>
                      <div class="row">
                        <?php foreach ($cont as $y) : ?>
                        <div class="col-sm-12 col-md-3 col-lg-3 my-2">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="id_<?php echo $x ?>_<?php echo $y ?>" name="controller[<?php echo $x ?>][<?php echo $y ?>]">
                                <label for="id_<?php echo $x ?>_<?php echo $y ?>">
                                <span class="firstcap"><?php echo $y ?></span>
                                </label>
                              </div>
                        </div>
                        <?php endforeach; ?>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </table>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  Apply
                </button>
                <a href="<?php echo ROOT; ?>admin/" class="btn btn-primary">
                  Back
                </a>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
    <script>
      <?php if (is_array($accesslist) || is_object($accesslist)) : ?>
        <?php foreach($accesslist as $access) : ?>
        $('#id_<?php echo $access['controller'] ?>_<?php echo $access['action'] ?>').prop('checked', true);
        <?php endforeach; ?>
      <?php endif; ?>
      $(document).ready(function() {
        $('.firstcap').each(function(i, obj) {
          $(this).text(firstcap($(this).text()))
        });
      });
    </script>