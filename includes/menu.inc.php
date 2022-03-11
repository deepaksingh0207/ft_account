<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
</nav>

<aside class="main-sidebar sidebar-dark-lightblue elevation-4">
  <a href="<?php echo ROOT; ?>" class="brand-link">
    <img src="<?php echo ROOT; ?>assets/img/icon.png" alt="AdminLTE Logo" class="brand-image" style="opacity: 0.8" />
    <span class="brand-text font-weight-light">FT Solutions Pvt. Ltd.</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <?php if(in_array('dashboard_index', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>dashboard" class="nav-link" id="menu_dashboard">
            <i class="far fa-chart-bar"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <?php endif; ?>
        <?php if(in_array('dashboard', $_SESSION['controller']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item report">
          <a href="#" class="nav-link reportlink" id="menu_reports">
            <i class="far fa-file"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" id="report_menu" style="display: none;">
            <?php if(in_array('dashboard_report', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/report" class="nav-link" id="menu_report">
                <i class="fas fa-chart-line"></i>
                <p>Report</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(in_array('dashboard_orderSummary', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/ordersummary" class="nav-link" id="menu_ordersummary">
                <i class="fas fa-chart-pie"></i>
                <p>Order Summary</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(in_array('dashboard_expiredpo', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/expiredpo" class="nav-link" id="menu_expiredpo">
              <i class="fas fa-arrow-down"></i>
                <p>Expired PO</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>
        <?php if(in_array('orders', $_SESSION['controller']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item order">
          <a href="#" class="nav-link orderlink" id="menu_order">
            <i class="fas fa-mail-bulk"></i>
            <p>
              Order Category
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" id="neworder_menu" style="display: none;">
            <?php if(in_array('orders_index', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>orders/" class="nav-link" id="menu_neworder">
                <i class="fas fa-envelope-open"></i>
                <p>List Orders</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(in_array('orders_list', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>orders/list" class="nav-link" id="menu_list">
                <i class="fas fa-envelope-open-text"></i>
                <p>List Open POs</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>
        <?php if(in_array('invoices_index', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>invoices" class="nav-link" id="menu_invoices">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>
              Invoice
            </p>
          </a>
        </li>
        <?php endif; ?>
        <?php if(in_array('payments_index', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>payments" class="nav-link" id="menu_payment">
            <i class="far fa-handshake"></i>
            <p>
              Payment
            </p>
          </a>
        </li>
        <?php endif; ?>
        <?php if(in_array('customers_index', $_SESSION['menu']) || in_array('customergroups', $_SESSION['menu']) || in_array('company', $_SESSION['menu']) or $_SESSION['is_admin']) : ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>customergroups" class="nav-link" id="menu_master">
            <i class="fa fa-border-all"></i>
            <p>
              Masters
            </p>
          </a>
        </li>
        <?php endif; ?>
        <?php if($_SESSION['is_admin']) : ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>users/" class="nav-link" id="menu_users">
            <i class="fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>users/logout" class="nav-link">
            <i class="fas fa-power-off"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>