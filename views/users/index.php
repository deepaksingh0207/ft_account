<div class="wrapper">
  <div class="main">
    <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>

    <main class="content">
      <div class="container-fluid p-0 leavelow">
        <div class="card m-2">
          <div class="card-header">
            <a href="<?php echo ROOT ?>users/create" class="btn mybtn"
              >Add New Customer</a
            >
          </div>
          <div class="card-body mb-5 table-responsive">
            <table id="cust_list_table" class="table table-striped">
              <thead>
                <tr>
                  <th>Customer No.</th>
                  <th>Company</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email ID</th>
                  <th>System</th>
                  <th>Man Days</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($customers)) : foreach ($customers as $customer) : ?>
                <tr data-href='<?php echo ROOT ?>users/profile/<?php echo $customer['id']?>'>
                  <td class="t-1 clickable-row"><?php echo $customer['cust_num']?></td>
                  <td class="t-2 clickable-row"><?php echo $customer['cust_name']?></td>
                  <td class="t-1 clickable-row"><?php echo $customer['emp_name']?></td>
                  <td class="t-1 clickable-row"><?php echo $customer['emp_mobile']?></td>
                  <td class="t-1 clickable-row"><?php echo $customer['emp_email']?></td>
                  <td class="t-1 clickable-row"><?php echo $customer['instances']?></td>
                  <td class="t-1 clickable-row"><?php echo $customer['man_days']?></td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <?php include HOME . DS . 'includes' . DS . 'footer.inc.php'; ?>
  </div>
</div>
