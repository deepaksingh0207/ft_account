<script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php if ($controller == 'users') : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/customerindex.js"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_customer.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_order.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/orderindex.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_invoice.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_invoice.js"></script>
<?php endif; ?>

</body>

</html>