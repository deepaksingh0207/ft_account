<?php

class View
{
protected $_file;
protected $_data = array();

public function __construct($file)
{
$this->_file = $file;
}

public function setAll($value)
{
    $this->_data = $value;
}

public function set($key, $value)
{
$this->_data[$key] = $value;
}
    

public function get($key)
{
return $this->_data[$key];
}

public function output()
{
if (!file_exists($this->_file))
{
throw new Exception("Template " . $this->_file . " doesn't exist.");
}

extract($this->_data);

ob_start();
include HOME . DS . 'views' . DS . 'common/header.php';
include($this->_file);
include HOME . DS . 'views' . DS . 'common/footer.php';
$output = ob_get_contents();
ob_end_clean();
echo $output;

unset($_SESSION['message']);
unset($_SESSION['error']);
}
}