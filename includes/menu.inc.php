<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="<?php echo ROOT; ?>" class="navbar-brand">
      <img
        src="<?php echo ROOT; ?>assets/img/icon.png"
        alt="AdminLTE Logo"
        class="brand-image"
      />
      <span class="brand-text font-weight-light"> FT Solutions Pvt. Ltd. </span>
    </a>
    <button
      class="navbar-toggler order-1"
      type="button"
      data-toggle="collapse"
      data-target="#navbarCollapse"
      aria-controls="navbarCollapse"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"
            ><i class="fas fa-bars"></i
          ></a>
        </li>
      </ul>
    </div>

    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="nav-item dropdown">
        <a href="<?php echo ROOT; ?>users/logout" class="nav-link">
          <i class="fas fa-power-off mt-1"></i>
        </a>
      </li>
    </ul>
  </div>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo ROOT; ?>" class="brand-link" style="background-color: palevioletred;">
    <img
      src="<?php echo ROOT; ?>assets/img/icon.png"
      alt="AdminLTE Logo"
      class="brand-image"
      style="opacity: 0.8"
    />
    <span class="brand-text font-weight-light">FT Solutions Pvt. Ltd.</span>
  </a>
  <div class="sidebar">
  <nav class="mt-2">
    <ul
      class="nav nav-pills nav-sidebar flex-column"
      data-widget="treeview"
      role="menu"
      data-accordion="false"
    >
      <li class="nav-item">
        <a href="<?php echo ROOT; ?>company/view/1" class="nav-link">
          <i class="far fa-building"></i>
          <p>
            Company
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo ROOT; ?>customers" class="nav-link active">
          <i class="fas fa-users"></i>
          <p>
            Customer
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo ROOT; ?>orders" class="nav-link">
          <i class="fas fa-luggage-cart"></i>
          <p>
            Order
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo ROOT; ?>invoices" class="nav-link">
          <i class="fas fa-file-invoice-dollar"></i>
          <p>
            Invoice
          </p>
        </a>
      </li>
    </ul>
  </nav>
  </div>  
</aside>
