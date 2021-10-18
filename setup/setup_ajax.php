<?php

define("_WOJO", true);
define('DEBUG', true);
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set("Asia/Kolkata");

if (strlen(session_id()) < 1)
    session_start();
    
    //$password =  'ftspl'.'pass1234'.'ztdms';
    //echo password_hash($password, PASSWORD_DEFAULT);
    
require_once ("functions.php");

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
    
define("CMS_DS", DIRECTORY_SEPARATOR);
define("BASE", dirname(__file__));
define("DDPBASE", str_replace('setup', '', BASE));
define("DB", 'db_ztdms_client');

function setUserLoginDetail($data) {
    $output = array();
    if($data['pass'] != $data['repass']) {
        $output['status'] = 0;
        $output['message'] = 'password and repassword mismatch';
    } else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $output['status'] = 0;
        $output['message'] = 'Please enter valid email address';
    } else {
        $_SESSION['user'] = $data;
        $output['status'] = 1;
        $output['message'] = 'Detail saved';
    }
    
    return $output;
}

function setUserProfileDetail($data) {
    $output = array();
    if(!isset($_SESSION['user'])) {
        $output['status'] = 0;
        $output['message'] = 'Admin login details not provided';
    } else {
        $_SESSION['user'] = array_merge($_SESSION['user'], $data);
        $output['status'] = 1;
        $output['message'] = 'Detail saved';
    }
    
    return $output;
}

function placeholders($text, $count=0, $separator=","){
    $result = array();
    if($count > 0){
        for($x=0; $x<$count; $x++){
            $result[] = $text;
        }
    }
    return implode($separator, $result);
}

function createUserAndNode($record, $data) {
    $output = array();
    try {
        
        $db = new PDO("mysql:host=". $record['dbhost'], $record['dbuser'], $record['dbpwd'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $db->query('SHOW DATABASES');
        
        //Fetch the columns from the returned PDOStatement
        $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if(!in_array(DB, $databases)) {
            $db->exec("CREATE DATABASE ".DB.";");
            $db->query("use ".DB.";");
            $record['dbname'] = DB;
        } else {
            $db->exec("DROP DATABASE ".DB.";");
            $db->exec("CREATE DATABASE ".DB.";");
            $db->query('use '.DB);
            $record['dbname'] = DB;
        }
        
        /** Writing to database **/
        $sqldata = parse(file_get_contents("sql/client_structure.sql"));
        foreach($sqldata as $sql) {
            $db->exec($sql);
        }
        
        $param = array("name" => $record['dbname']);
        writeConfigFile($param);
        
        $firstName = (isset($record['first_name'])) ? $record['first_name'] : "";
        $lastName = (isset($record['last_name'])) ? $record['last_name'] : "";
        $user = (isset($record['email'])) ? $record['email'] : "";
        $company = (isset($record['company'])) ? $record['company'] : "";
        $mobile = (isset($record['mobile'])) ? $record['mobile'] : "";
        $site_email = (isset($record['site_email'])) ? $record['site_email'] : "";
        $password = (isset($record['pass'])) ? $record['pass'] : "";
        
        $db->exec("
				INSERT INTO `users` (
				  first_name, last_name, email, hash, company_name, mobile, verifiy_code, created_date
				  )
				VALUES
				  (
                    '" . sanitize($firstName) . "',
                    '" . sanitize($lastName) . "',
					'" . sanitize($user) . "',
					'" . password_hash('ftspl'.$password.'ztdms', PASSWORD_DEFAULT) . "',
					'" . sanitize($company) . "',
					'" . sanitize($mobile) . "',
                    '" . base64_encode(time()) . "',
					'" . date('Y-m-d H:i:s') . "'
				  );");
        
        //$db = null;
        
        if (file_exists("../new_config.php")) {
            $tmpLicense = genTempLicense();
            /*foreach($data as $key => $row) {
                
                $data[$key] = json_decode($row, true);
                $data[$key]['license_key'] = $tmpLicense;
                $data[$key]['machine_id'] = getMachineId();
                $data[$key]['status'] = 'inactive';
                $data[$key]['created_date'] = date('Y-m-d H:i:s');
            } */
            
            $insert_values = array();
            $datafields = array_keys($data[0]);
            $question_marks = array();
            foreach($data as $d){
                $question_marks[] = '('  . placeholders('?', sizeof($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            
            $sql = "INSERT INTO nodes (" . implode(",", $datafields ) . ") VALUES " .
                implode(',', $question_marks);
                
                $stmt = $db->prepare ($sql);
                if($stmt->execute($insert_values)) {
                    //setConfig($data);
                    $output['status'] = 1;
                    $output['message'] = 'Detail saved';
                    getUser();
                } else {
                    $output['status'] = 0;
                    $output['message'] = 'Fail to save nodes';
                }
                
        } else {
            $output['status'] = 0;
            $output['message'] = 'Fail to create config';
        }
    }
    catch (PDOException $e) {
        $output['status'] = 0;
        $output['message'] = $e->getMessage();
        //$_SESSION['msg'] = 'Could not connect to MySQL server<br> ' . $e->getMessage();
    }
    
    return $output;
}

function getUser() {
    require_once '../new_config.php';
    
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';
    $db = new PDO($dsn, DB_USER, DB_PASS);
    
    $sql = "select * from users where email = ? limit 1";
    $sth = $db->prepare($sql);
    $sth->execute(array($_SESSION['user']['email']));
    $user = $sth->fetch();
    
    if($user) {
        unset($user['hash']);
        $_SESSION['signed_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $user;
    } 
    
    rename("../setup", "../fail_set");
    
}

function genTempLicense() {
    return md5(time());
}

function getMachineId() {
    $machine = shell_exec("blkid -o value -s UUID");
    return trim($machine);
}

function setConfig($data) {
    
    $row = $data[0];
    
    $content = "----- tdms req license -----
HARDWARE-KEY=$row[machine_id]
EXP=".time()."
USR=".base64_encode(serialize($_SESSION['user']))."
TMPLICKEY=".$row['license_key']."
NODEKEY=".base64_encode(serialize($data));
    
        $confile = 'license_req.txt';
        $handle = fopen($confile, 'w');
        fwrite($handle, $content);
        fclose($handle);
    //echo $content;
}


function downloadConfigFile() { 
    if(file_exists('license_req.txt')) {
        $content = file_get_contents('license_req.txt');
        echo $content;
    } 
}

function setConfigData($data) {
    $valid = true;
    
    if(!class_exists('SAPNWRFC\Connection'))  {
        $output['status'] = 0;
        $output['message'] = 'Library missing';
    }  else {
    
        $tmpLicense = genTempLicense();
        $machine = getMachineId();
        foreach($data as $key => $row) {
            $data[$key] = json_decode($row, true);
            $data[$key]['license_key'] = $tmpLicense;
            $data[$key]['machine_id'] = $machine;
            $data[$key]['status'] = 'inactive';
            $data[$key]['created_date'] = date('Y-m-d H:i:s');
            
            $config = [
                'ashost' => $data[$key]['server_ip'],
                'sysnr'  => $data[$key]['instance_no'],
                'client' => $data[$key]['client'],
                'user'   => $data[$key]['username'],
                'passwd' => $data[$key]['password'],
            ];
           
            $connCheck = checkSapConnection($config);
            $output = $connCheck;
            if($connCheck['status'] == 0) {
                $valid = false;
                break;
            }
        }
        
        if($valid) {
            setConfig($data);
            $output['status'] = 1;
            $output['message'] = 'Detail saved';
        } 
    }
    
    return $output;
}

function checkSapConnection($config) {
        $output = array();
        try {
            $c = new SapConnection($config);
            $output['status'] = 1;
            $output['message'] = 'success';
        } catch(SapException $ex) {
            $error = $ex->getErrorInfo();
            $output['status'] = 0;
            $output['message'] = 'Server ' .$config['ashost']. ':: ' . $error['message'];
        }
        
        return $output;
}


function checkLicenseValidity($file) {
    $content  = file_get_contents($file["license"]["tmp_name"]);
    
    $results = array();
    $data = preg_split("/\n/", $content);
    
    foreach($data as $row) {
        $t = explode("=", $row);
        if(count($t) > 1) {
            if($t[0] == 'USR') {
                $results[$t[0]] = unserialize(base64_decode($t[1]));
            } else if($t[0] == 'NODEKEY') {
                $results[$t[0]] = unserialize(base64_decode($t[1]));
            } else {
                $results[$t[0]] = trim($t[1]);
            }
        }
    }
    
    $output = array();
    if(!isset($results['CK'])) {
        $output = array("status"=>0, "message"=>"Please upload valid license");
    } else if(!password_verify('license-'.$_SESSION['user']['email'], $results['CK'])) {
        $output = array("status"=>0, "message"=>"Please upload valid license");
    }else if(!isset($_SESSION['user']['email']) || $_SESSION['user']['email'] != $results['USR']['email']) {
        $output = array("status"=>0, "message"=>"invalid lincense", "redirect" => true);
    } else {
        $output = createUserAndNode($_SESSION['user'], $results['NODEKEY']);
    }
    
    return $output;
    
    
}


if(isset($_GET['action'])) {
    $output = array();
    switch($_GET['action']) {
        case 'user_conf' :
            $output = setUserLoginDetail($_POST);
            echo json_encode($output);
            break;
        case 'profile_conf' :
            $output = setUserProfileDetail($_POST);
            echo json_encode($output);
            break;
        case 'node_conf' :
            if(!isset($_SESSION['user'])) {
                echo json_encode(array("status"=>0, "message"=>"incomplete setup", "redirect" => true));
                break;
            }
            //$output = createUserAndNode($_SESSION['user'], $_POST['nodeData']);
            $output = setConfigData($_POST['nodeData']);
            echo json_encode($output);
            break;
        case 'download' :
            //print_r($_POST['nodeData']); exit;
            echo downloadConfigFile();
            break;
        case 'upload_config' :
            if(!isset($_SESSION['user'])) {
                echo json_encode(array("status"=>0, "message"=>"incomplete setup", "redirect" => true));
            } else if(!isset($_FILES)) {
                echo json_encode(array("status"=>0, "message"=>"license key not found"));
            } else {
                $output = checkLicenseValidity($_FILES);
                echo json_encode($output);
            }
            break;
    }    
    
}


?>
