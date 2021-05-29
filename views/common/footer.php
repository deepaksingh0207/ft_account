
<?php if ($controller == 'users') : ?>
  
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/customerindex.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/companyindex.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/edit_customer.js?<?php echo time(); ?>"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/new_customer.js"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_order.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/orderindex.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_invoice.js?<?php echo time(); ?>"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/invoiceindex.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'create') || ($action == 'edit') || ($action == 'view')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/new_company.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/edit_company.js?<?php echo time(); ?>"></script>
<?php endif; ?>

</body>

</html>