<form action method="post" id="profile_conf" novalidate="novalidate">
  <div id="inner">
    <div class="middle"></div>
    <main>
    	<h2>Company profile</h2>
      <input type="hidden" name="db_action" id="db_action" value="1">
      
      <input type="hidden" name="dbhost" value="localhost">
      <input type="hidden" name="dbuser" value="root">
      <input type="hidden" name="dbpwd" value="root">
      
      <table class="data forms">
      <tr>
          <td>First Name:</td>
          <td><input type="text" name="first_name" value="" id="t1" required>
          <span class="err" id="err1">Please enter first name</span></td>
        </tr>
        
        <tr>
          <td>Last Name:</td>
          <td><input type="text" name="last_name" value="" id="t2" required>
          <span class="err" id="err2">Please enter last name</span></td>
        </tr>
        <tr>
          <td>Company:</td>
          <td><input type="text" name="company" value="" id="t3" required>
          <span class="err" id="err3">Please enter company name</span></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input type="email" name="site_email"  id="t4" readonly value="<?php echo $_SESSION['user']['email']?>">
            <span class="err" id="err4">Please input correct email.</span></td>
        </tr>
        <tr>
          <td>Mobile:</td>
          <td><input type="tel" name="mobile" id="t5" required  maxlength="10" pattern="[9,8,7,6]{1}[0-9]{9}" oninvalid="this.setCustomValidity('Invalid mobile number')" oninput="this.setCustomValidity('')">
            <span class="err" id="err5">Please input correct mobile.</span></td>
        </tr>
      </table>
      
    </main>
  </div>
  <footer class="clearfix"> 
    <div id="buttons">
     <!--   <button type="button" class="button" onclick="document.location.href='setup.php?step=1';" name="back">Back</button>  -->
      &nbsp;&nbsp;
      <button type="submit" class="button" name="profileForm" >Next</button>
    </div>
  </footer>
</form>