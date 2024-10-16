$(document).ready(function () {
  var e = window.location.pathname.split("/");

  // Cross Server
  if (e[1] == "ft_account") { var a = e[2]; var s = e[3]; }
  else { var a = e[1]; var s = e[2]; }

  if (a == 'orders') { $("#menu_orders").addClass("active"); }
  if (a == 'gstr') { $("#menu_gstr").addClass("active"); }
  if (a == 'invoices') { $("#menu_invoices").addClass("active"); }
  if (['customers', 'company', 'customergroups'].includes(a)) { $("#menu_master").addClass("active"); }
  if (a == 'payments') { $("#menu_payment").addClass("active"); }
  if (a == 'users') { $("#menu_users").addClass("active"); }
  if (a == 'orders') {
    $("#menu_order").addClass("active");
    $(".order").addClass('menu-is-opening menu-open');
    $(".orderlink").addClass("active");
    $("#neworder_menu").show();
    if (s == 'list' || s == 'openpo') { $("#menu_list").addClass("active"); }
    else { $("#menu_neworder").addClass("active"); }
  }
  if (a == 'dashboard') {
    if (s == 'report') {
      $("#menu_report").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else if (s == 'ordersummary') {
      $("#menu_ordersummary").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else if (s == 'expiredpo') {
      $("#menu_expiredpo").addClass("active");
      $("#report_menu").show();
      $(".report").addClass('menu-is-opening menu-open');
      $(".reportlink").addClass("active");
    } else { $("#menu_dashboard").addClass("active"); }
  }
  if (a == 'settings') { $("#menu_settings").addClass("active"); }
});
