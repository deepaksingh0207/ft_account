<?php
  /**
   * Safe Configuration
   *
   * @package Freelance Manager
   * @author wojoscripts.com
   * @copyright 2014
   * @version $Id: safe_config.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
?>
<?php
  
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=license_req.txt");

  $content = file_get_contents("license_req.txt");
          

echo $content;
?>