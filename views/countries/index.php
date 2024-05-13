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
                    <div class="tab-pane fade show active" id="countries" role="tabpanel" aria-labelledby="country_tab">
                      <form method="post" id="country" class="mb-0">
                        <div class="row">
                          <div class="col-sm-12 col-lg-4 form-group">
                            <input type="text" class="form-control ftsm" required="" name="name" id="id_group_id" />
                          </div>
                          <div class="col-sm-12 col-lg-2">
                            <div class="btn-group"> <button type="submit" id="add" class="btn btn-default">
                                Add </button> <button type="submit" id="update" style="display: none"
                                class="btn btn-default"> Update </button> <a href="' + baseUrl + 'countries" id="cancel"
                                class="btn btn-default"> Cancel </a> </div>
                          </div>
                        </div>
                      </form>
                      <div class="table-responsive">
                        <table id="country_list" class="table table-striped">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>countries</th>
                              <th style="width: 100px"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if($countries && count($countries)) : foreach ($countries as $country) : ?>
                            <tr>
                              <td class="id customer" data-id="<?php echo $country['id']?>">
                                <?php echo $country['id']?>
                              </td>
                              <td class="name customer" data-id="<?php echo $country['id']?>">
                                <?php echo $country['country_name']?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-primary btn-sm groupy"
                                  data-id="<?php echo $country['id']?>" data-name="<?php echo $country['country_name']?>">
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