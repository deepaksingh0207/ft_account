$(document).ready(function () {
  var urlpath = window.location.pathname
  var parts = urlpath.split("/");
  var menu = parts[2];
  var submenu = parts[3];
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
    } else {
      $("#menu_dashboard").addClass("active");
    }
  }
  if (menu == 'settings') {
    $("#menu_settings").addClass("active");
  }
});
