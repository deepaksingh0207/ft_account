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

  if (isset($_POST['db_action'])) {
      if (empty($_POST['site_email']))
          $_SESSION['err'][] = 2;
      if(!filter_var($_POST['site_email'], FILTER_VALIDATE_EMAIL)) 
          $_SESSION['err'][] = 2;
          
          if (empty($_POST['mobile']))
              $_SESSION['err'][] = 3;
          if (strlen($_POST['mobile']) != 10)
             $_SESSION['err'][] = 3;

      if (empty($_POST['admin_username']))
          $_SESSION['err'][] = 4;

          if (empty($_SESSION['err']) && $step == 3) {

          try {
			  
			  $db = new PDO("mysql:host=". $_POST['dbhost'], $_POST['dbuser'], $_POST['dbpwd'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  $stmt = $db->query('SHOW DATABASES');
 
			   //Fetch the columns from the returned PDOStatement
			   $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
 
			   if(!in_array(DB, $databases)) {
 			     $db->exec("CREATE DATABASE ".DB.";"); 
 			     $db->query("use ".DB.";");
 			     $_POST['dbname'] = DB;
 			    } else {
 			        $db->exec("DROP DATABASE ".DB.";");
 			        $db->exec("CREATE DATABASE ".DB.";");
 			        $db->query('use '.DB);
 			        $_POST['dbname'] = DB;
 			    }
               //Loop through the database list and print it out.
              $error = false;
              $success = true;

              /** Writing to database **/
			  $sqldata = parse(file_get_contents("sql/client_structure.sql"));
			  foreach($sqldata as $sql) {
				  $db->exec($sql);
			  }
              
			  $param = array("name" => $_POST['dbname']);
              writeConfigFile($param);
			  
              $user = (isset($_POST['admin_username'])) ? $_POST['admin_username'] : "";
              $company = (isset($_POST['company'])) ? $_POST['company'] : "";
              $mobile = (isset($_POST['mobile'])) ? $_POST['mobile'] : "";
              $site_email = (isset($_POST['site_email'])) ? $_POST['site_email'] : "";
              $password = (isset($_POST['pass'])) ? $_POST['pass'] : "";
              
              $db->exec("
				INSERT INTO `users` (
				  first_name, last_name, email, hash, company_name, mobile, verifiy_code, created_date
				  ) 
				VALUES
				  (
                    '',
                    '', 
					'" . sanitize($user) . "',
					'" . password_hash('ftspl'.$password.'ztdms', PASSWORD_DEFAULT) . "',
					'" . sanitize($company) . "',
					'" . sanitize($mobile) . "',
                    '" . base64_encode(time()) . "',
					'" . date('Y-m-d H:i:s') . "'
				  );");              
				  
              $db = null;
			  
              if (file_exists("../new_config.php")) {
                  cmsHeader();
                  include ("templates/finish.tpl.php");
                  cmsFooter();
                  exit;
              }
          }
          catch (PDOException $e) {
              $error = true;
              $_SESSION['msg'] = 'Could not connect to MySQL server<br> ' . $e->getMessage();
          }
      }
  }
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
