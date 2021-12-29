</div>
<script>
  var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
</script>
<script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>

<?php if ($controller == 'users') : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/dashboard_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/customer_index.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/customer_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/customer_edit.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customergroups' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/group_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
  <?php endif; ?>

<?php if ($controller == 'company' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/company_index.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/company_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/company_edit.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/o_index.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/o_validation.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/o_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'view')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/o_view.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/i_index.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/i_validation.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/i_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/p_index.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/p_create.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'view')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/p_view.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
<script src="<?php echo ROOT; ?>assets/js/menu.js"></script>
</body>

</html>