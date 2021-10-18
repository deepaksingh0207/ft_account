  <div id="inner">
    <div class="middle"></div>
    <main>
    <form action="setup.php?step=3" method="post" id="form_license" enctype="multipart/form-data">
  
  <h2>Upload License Key</h2>
  
  <input type="button" onclick="document.location.href='safe_config.php'" value="Download license_req.txt">
  
  <p>Upload the downloaded config file to <a href="http://localhost:8888/ft_tdms_license/" target="_blank">F.T. Solotions's License generation portal</a>.
  <br />
  You will get license key and upload the new generated license key here. 
  </p>
  	<table class="data forms">
        <tr><td><input type="file" name="license"  required />
        </tr>	
      </table>
      
      <span class="error" id="err1" style="color: red; background-color:#FFFFFF;"></span>
      <br />
      <br />
      <footer class="clearfix">
    <div id="buttons">
      <button type="submit" class="button" name="licenseForm">Submit</button>
    </div>
  </footer>
  </div>
  </form>
    </main>
  </div>