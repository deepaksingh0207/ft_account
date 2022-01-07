</div>
<!-- <script>
  var baseUrl = window.location.origin + '/' + window.location.href.split("/")[3] + '/';
</script> -->
<script src="<?php echo ROOT; ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js"></script>

<?php if ($controller == 'users') : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'dashboard' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/dashboard_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'customers' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
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
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/group_create.js?<?php echo time(); ?>"></script>

<?php endif; ?>

<?php if ($controller == 'company' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
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

<?php if ($controller == 'orders' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo ROOT ?>assets/plugins/toastr/toastr.min.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/o_create.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/o_validation.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'orders' && ($action == 'view')) : ?>
<script src="<?php echo ROOT; ?>assets/js/o_view.js"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/i_index.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'invoices' && ($action == 'create')) : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo ROOT; ?>assets/js/i_validation.js?<?php echo time(); ?>"></script>
<script src="<?php echo ROOT; ?>assets/js/i_create.js?<?php echo time(); ?>"></script>
<?php endif; ?>

<?php if ($controller == 'payments' && ($action == 'index')) : ?>
<!-- <script src="<?php echo ROOT; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/rg-1.1.4/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/datatables.min.js"></script>
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

<script src="<?php echo ROOT; ?>assets/js/custom.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
<script src="<?php echo ROOT; ?>assets/js/menu.js"></script>
</body>

</html>