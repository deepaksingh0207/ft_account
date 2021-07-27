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