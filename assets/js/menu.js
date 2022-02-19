$(document).ready(function () {
  var urlpath = window.location.pathname
  var parts = urlpath.split("/");
  
  // Development
  var menu = parts[2];
  var submenu = parts[3];
  
  // Production
  // var menu = parts[1];
  // var submenu = parts[2];
  
  if (menu == 'invoices') {
    $("#menu_invoices").addClass("active");
  }
  if (menu == 'company') {
    $("#menu_company").addClass("active");
  }
  if (menu == 'customers') {
    $("#menu_customers").addClass("active");
  }
  if (menu == 'orders') {
    $("#menu_orders").addClass("active");
  }
  if (menu == 'group') {
    $("#menu_group").addClass("active");
  }
  if (menu == 'payments') {
    $("#menu_payment").addClass("active");
  }
  if (menu == 'dashboard') {
    if (submenu == 'report') {
      $("#menu_report").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else if (submenu == 'ordersummary') {
      $("#menu_ordersummary").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else if (submenu == 'expiredpo') {
      $("#menu_expiredpo").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else {
      $("#menu_dashboard").addClass("active");
    }
  }
  if (menu == 'settings') {
    $("#menu_settings").addClass("active");
  }
});
