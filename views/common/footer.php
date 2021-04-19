<?php if ($controller == 'users') : ?>
  <script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
    <!-- new_customer -->
    <script src="<?php echo ROOT; ?>assets/js/login.js?<?php echo time();?>"></script>
    <!-- new_customer -->
<?php endif; ?>


<?php if ($controller == 'users') : ?>
<script src="<?php echo ROOT; ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/dist/js/adminlte.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/dist/js/demo.js"></script>
    <link rel="stylesheet" href="assets/js/custom.js" />
    <!-- new_customer -->
    <script src="<?php echo ROOT; ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="<?php echo ROOT; ?>assets/js/new_customer.js"></script>
    <!-- new_customer -->
    <script>
      includeHTML();
      document.addEventListener("DOMContentLoaded", function () {
        window.stepper = new Stepper(document.querySelector(".bs-stepper"));
      });
    </script>
  <?php endif; ?>

</body>

</html>