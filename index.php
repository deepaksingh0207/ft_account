<?php
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(__FILE__));

define ('ROOT', DS . 'ft_account' . DS);
//define ('ROOT', DS);

date_default_timezone_set("Asia/Kolkata");

ini_set ('display_errors', 1);

if (! extension_loaded('sapnwrfc')) {
//    throw new \Exception('Extension "sapnwrfc" not loaded. #installation');
}

require_once HOME . DS . 'app.php';
require_once HOME . DS . 'config.php';
if (file_exists(HOME . DS . 'new_config.php')) {
    require_once HOME . DS . 'new_config.php';
}
require_once HOME . DS . 'utilities' . DS . 'bootstrap.php';

function __autoload($class)  {
    if (file_exists(HOME . DS . 'utilities' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS . 'utilities' . DS . strtolower($class) . '.php';
    } else if (file_exists(HOME . DS . 'models' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS . 'models' . DS . strtolower($class) . '.php';
    } else if (file_exists(HOME . DS . 'controllers' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS . 'controllers'  . DS . strtolower($class) . '.php';
    }else if (file_exists(HOME . DS . 'reports' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS. 'vendor/autoload.php';
        require_once HOME . DS . 'reports' . DS . strtolower($class) . '.php';
    }
    
}