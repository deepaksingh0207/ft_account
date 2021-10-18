<div id="wrap">
  <header class="clearfix">Reset Password</header>
  <div class="line"></div>
  <div id="content">
    <form
      action="<?php echo ROOT ?>admin/reset/<?php echo $id?>"
      method="post"
      id="form_reset"
    >
      <div id="inner">
        <div class="middle"></div>
        <main>
          <?php if(isset($err_msg)) : ?>
          <div class="error"><?php echo $err_msg?></div>
          <?php endif; ?>
          <table class="data forms">
            <tr>
              <td>new Password:</td>
              <td><input type="password" name="pass" id="pass" /></td>
            </tr>
            <tr>
              <td>Re-enter Password:</td>
              <td><input type="password" name="repass" id="repass" /></td>
            </tr>
          </table>
        </main>
      </div>
      <footer class="clearfix">
        <div id="buttons">
          <button type="submit" class="button" name="resetForm" onclick="">
            Submit
          </button>
        </div>
      </footer>
    </form>
  </div>
</div>
