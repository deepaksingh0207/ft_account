<div id="fullwindow">
<header class="clearfix">Reset Password </header>
	  	<div class="line"></div>
	  	<div id="content">
	  	
<form action="<?php echo ROOT ?>admin/change" method="post" id="form_change">
  <div id="inner">
  <aside>
        <?php include HOME . DS . 'includes' . DS . 'menu.inc.php'; ?>
  </aside>
    <div class="middle"></div>
    <main>
      
      <?php if(isset($err_msg)) : ?>
      <div class="error"><?php echo $err_msg?></div>
      <?php endif; ?>
      <table class="data forms">
      <tr>
          <td>Old Password:</td>
          <td><input type="password" name="old_pass" id="old_pass">
          <span class="err" id="err5">Please enter old password</span></td>
        </tr>
        <tr>
          <td>new Password:</td>
          <td><input type="password" name="pass" id="pass">
          <span class="err" id="err5">Please enter password</span></td></td>
        </tr>
        <tr>
          <td>Re-enter Password:</td>
          <td><input type="password" name="repass" id="repass">
          <span class="err" id="err6">Password mismatch</span></td></td>
        </tr>
      </table>
    </main>
  </div>
  <footer class="clearfix">
    <div id="buttons">
      <button type="submit" class="button" name="changeForm">Submit</button>
    </div>
  </footer>
  
  
      
</form>

