</div>
<script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>

<?php if ($controller == 'users') : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/js/index_dashboard.js"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/index_customer.js"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/edit_customer.js?<?php echo time(); ?>"></script>
<?php endif; ?>


<?php if ($controller == 'customers' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_customer.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customergroups' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_group.js?<?php echo time(); ?>"></script>
  <?php endif; ?>

<?php if ($controller == 'company' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/index_company.js"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_company.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'edit')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/edit_company.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_order.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/index_order.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_invoice.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/index_invoice.js"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'index')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/index_payment.js"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'create')) : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="<?php echo ROOT; ?>assets/js/new_payment.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
<script src="<?php echo ROOT; ?>assets/js/menu.js"></script>
</body>

</html>