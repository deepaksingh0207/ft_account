<?php
$controller = "admin";
$action = "index";
$query = null;
$query2 = null;

if (isset($_GET['load']))
{
$params = array();
$params = explode("/", $_GET['load']);

$controller = ucwords($params[0]);

if (isset($params[1]) && !empty($params[1]))
{
$action = $params[1];
}

if (isset($params[2]) && !empty($params[2]))
{
$query = $params[2];
}

if (isset($params[3]) && !empty($params[3]))
{
    $query2 = $params[3];
}
}

$modelName = $controller;
$controller .= 'Controller';
try {
    if(class_exists($controller)) {
        $load = new $controller($modelName, $action);
    } else {
        //die('Requested url not exists.');
        header("location:".ROOT."users/login");
        exit;
    }
}  catch (Exception $e) {
    echo $e;
}

if (method_exists($load, $action)) {
    $load->$action($query, $query2);
} else {
    die('Invalid method. Please check the URL.');
}
