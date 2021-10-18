<?php
  /**
   * Setup
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: setup.php, v1.00 2016-01-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);
  define('DEBUG', true);
  ini_set("display_errors", 1);
  
  date_default_timezone_set("Asia/Kolkata");
  
  if (! extension_loaded('sapnwrfc')) {
      //    throw new \Exception('Extension "sapnwrfc" not loaded. #installation');
  }
  
  if (strlen(session_id()) < 1)
      session_start();
      
  //$password =  'ftspl'.'pass1234'.'ztdms';
  //echo password_hash($password, PASSWORD_DEFAULT);
   
  require_once ("functions.php");
  $_SESSION['err'] = null;
  $_SESSION['msg'] = null;
  
  define("CMS_DS", DIRECTORY_SEPARATOR);
  define("BASE", dirname(__file__));
  define("DDPBASE", str_replace('setup', '', BASE));
  define("DB", 'db_ztdms_client');
    
  $_SERVER['REQUEST_TIME'] = time();
  $step = !isset($_GET['step']) ? 0 : (int)$_GET['step'];

  
?>
<?php cmsHeader(); ?>
<?php
  if (!$step):
      clearstatcache(); 
      include ("templates/configuration.tpl.php");
  elseif ($step == 1):
      include ("templates/profile.tpl.php");
  elseif ($step == 2):
      include ("templates/nodes.tpl.php");
  elseif ($step == 3):
      include ("templates/upload_license.tpl.php");
  else:
      echo '<p class="steperror">Incorrect step. Please follow installation instructions.</p?';
  endif;
?>
<?php cmsFooter(); ?>
