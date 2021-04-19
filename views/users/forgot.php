<div id="wrap">
<header class="clearfix">Forgot Password </header>
	  	<div class="line"></div>
	  	<div id="content">
	  	
<form action="<?php echo ROOT ?>admin/forgot" method="post" id="form_forgot">
  <div id="inner">
    <div class="middle"></div>
    <main>
      
      <?php 
      
      //if(!isset($_SESSION['success_msg'])):
      if(!isset($success_msg)): 
      
      ?>
      
      <?php if(isset($err_msg)) : ?>
      <div class="error"><?php echo $err_msg?></div>
      <?php endif; ?>
      <table class="data forms">
        <tr>
          <td style="width:40%">Email Id:</td>
          <td><input type="text" name="email" value="" id="user"></td>
        </tr>
      </table>
    </main>
  </div>
  <footer class="clearfix">
    <div id="buttons">
      <button type="submit" class="button" name="forgotForm" onclick="" >Submit</button>
    </div>
  </footer>
  <?php else: ?>
  <div class="success"><?php 
  //echo $_SESSION['success_msg'];
  echo $success_msg;
  
  ?>
  </div>
      <?php endif; ?>
</form>

