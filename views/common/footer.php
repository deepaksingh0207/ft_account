</div>
<script>
  var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
</script>
<script src="<?php echo ROOT; ?>assets/js/menu.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- Datatable CDN RowMerge-->
<script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
<script src="http://cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>

<script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/toastr/toastr.min.js"></script>

<?php if ($controller == 'users' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/a_list.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'users' && ($action == 'login')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/dashboard_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'report')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/dashboard_report.js"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'ordersummary')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/dashboard_report.js"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'expiredpo')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/dashboard_expiredpo.js"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/customer_index.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/customer_create.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'edit')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/customer_edit.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'customergroups' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/group_create.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/company_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/company_create.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'edit')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/company_edit.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'view')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/company_view.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'list')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_list.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create' || $action == 'openpo')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_create.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_validation.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'renew')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/o_renew.js"></script>
<script src="<?php echo ROOT; ?>assets/js/o_validation_renew.js"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'edit')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/o_edit.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_validation_edit.js"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'view')) : ?>
<script src="<?php echo ROOT; ?>assets/js/o_view.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/i_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/i_validation.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/i_create.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'view')) : ?>
<script src="<?php echo ROOT; ?>assets/js/i_view.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'index')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/p_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/p_create.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'view')) : ?>
<script src="<?php echo ROOT; ?>assets/js/p_view.js"></script>
<?php endif; ?>

<script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
<script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
</body>

</html>