<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pb-5">
          <div class="row mt-3">
            <div class="col-12">
              <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <?php include HOME . DS . 'includes' . DS . 'masters.inc.php'; ?>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="states" role="tabpanel" aria-labelledby="state_tab">
                     
                      <div class="table-responsive">
                        <table id="state_list" class="table table-striped">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>States</th>
                              <th>Country</th>
                              <th style="width: 100px"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if($states && count($states)) : foreach ($states as $state) : ?>
                            <tr>
                              <td class="id customer" data-id="<?php echo $state['id']?>">
                                <?php echo $state['id']?>
                              </td>
                              <td class="name customer" data-id="<?php echo $state['id']?>">
                                <?php echo $state['name']?>
                              </td>
                              <td class="" data-id="<?php echo $state['country_name']?>">
                                <?php echo $state['country_name']?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-primary btn-sm groupy"
                                  data-id="<?php echo $state['id']?>" data-name="<?php echo $state['name']?>">
                                  Edit
                                </button>
                              </td>
                            </tr>
                            <?php endforeach; endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</body>