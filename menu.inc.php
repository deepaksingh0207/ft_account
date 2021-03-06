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
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>dashboard" class="nav-link" id="menu_dashboard">
            <i class="far fa-chart-bar"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item report">
          <a href="#" class="nav-link reportlink" id="menu_reports">
            <i class="far fa-file"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" id="report_menu" style="display: none;">
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/report" class="nav-link" id="menu_report">
                <i class="fas fa-chart-line"></i>
                <p>Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/ordersummary" class="nav-link" id="menu_ordersummary">
                <i class="fas fa-chart-pie"></i>
                <p>Order Summary</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>dashboard/expiredpo" class="nav-link" id="menu_expiredpo">
              <i class="fas fa-arrow-down"></i>
                <p>Expired PO</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>company/view/1" class="nav-link" id="menu_company">
            <i class="far fa-building"></i>
            <p>
              Company
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>customergroups" class="nav-link" id="menu_group">
            <i class="fas fa-users"></i>
            <p>
              Customer Group
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>customers" class="nav-link" id="menu_customers">
            <i class="fas fa-users"></i>
            <p>
              Customer
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>orders" class="nav-link" id="menu_orders">
            <i class="fas fa-luggage-cart"></i>
            <p>
              Order
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>invoices" class="nav-link" id="menu_invoices">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>
              Invoice
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>payments" class="nav-link" id="menu_payment">
            <i class="far fa-handshake"></i>
            <p>
              Payment
            </p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="#" class="nav-link active">
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-file-pdf"></i>
            <p>
              Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
              <a href="./index.html" class="nav-link active">
              <a href="./index.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <i class="fas fa-caret-right nav-icon"></i>
                <p>Export</p>
              </a>
            </li>
          </ul>
        </li> -->
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>settings" class="nav-link" id="menu_settings">
            <i class="fas fa-cog"></i>
            <p>
              Settings
            </p>
          </a>
        </li>
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