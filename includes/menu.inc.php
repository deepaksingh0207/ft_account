<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="index.html" class="navbar-brand">
      <img src="<?php echo ROOT; ?>assets/img/icon.png" alt="AdminLTE Logo" class="brand-image" />
      <span class="brand-text font-weight-light"> FT Solutions Pvt. Ltd. </span>
    </a>
    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="index.html" class="nav-link">Home</a>
        </li>
      </ul>
    </div>

    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="nav-item dropdown">
        <a
          id="dropdownSubMenu1"
          href="#"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          class="nav-link dropdown-toggle"
        >
          Menu
        </a>
        <ul
          aria-labelledby="dropdownSubMenu1"
          class="dropdown-menu border-0 shadow"
        >
          <li class="dropdown-submenu dropdown-hover">
            <a
              id="dropdownSubMenu2"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="dropdown-item dropdown-toggle"
            >
              Customer
            </a>
            <ul
              aria-labelledby="dropdownSubMenu2"
              class="dropdown-menu border-0 shadow"
            >
              <li>
                <a tabindex="-1" href="<?php echo ROOT; ?>customers/create" class="dropdown-item"> New Customer </a>
              </li>
              <li>
                <a tabindex="-1" href="<?php echo ROOT; ?>customers" class="dropdown-item"> List Customers </a>
              </li>

              <!-- <li class="dropdown-submenu">
                <a
                  id="dropdownSubMenu3"
                  href="#"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  class="dropdown-item dropdown-toggle"
                >
                  Link 5
                </a>
                <ul
                  aria-labelledby="dropdownSubMenu3"
                  class="dropdown-menu border-0 shadow"
                >
                  <li>
                    <a href="#" class="dropdown-item">Link 5</a>
                  </li>
                  <li>
                    <a href="#" class="dropdown-item">Link 6</a>
                  </li>
                </ul>
              </li> -->
            </ul>
          </li>
          <li class="dropdown-submenu dropdown-hover">
            <a
              id="dropdownSubMenu2"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="dropdown-item dropdown-toggle"
            >
              Orders
            </a>
            <ul
              aria-labelledby="dropdownSubMenu2"
              class="dropdown-menu border-0 shadow"
            >
              <li>
                <a tabindex="-1" href="new_order.html" class="dropdown-item"> New Order </a>
              </li>
              <li>
                <a tabindex="-1" href="list_order.html" class="dropdown-item"> List Orders </a>
              </li>
            </ul>
          </li>
          <li class="dropdown-submenu dropdown-hover">
            <a
              id="dropdownSubMenu2"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              class="dropdown-item dropdown-toggle"
            >
              Invoices
            </a>
            <ul
              aria-labelledby="dropdownSubMenu2"
              class="dropdown-menu border-0 shadow"
            >
              <li>
                <a tabindex="-1" href="new_invoice.html" class="dropdown-item"> New Invoice </a>
              </li>
              <li>
                <a tabindex="-1" href="list_invoice.html" class="dropdown-item"> List Invoices </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="index.html" class="nav-link">Log Off</a>
      </li>
      <li class="nav-item">
        <a href="index.html" class="nav-link">Help</a>
      </li>
    </ul>
  </div>
</nav>
