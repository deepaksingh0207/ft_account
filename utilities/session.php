<?php

class Session {
    private $data = array();
    
    function __construct() {
        if (strlen(session_id()) < 1) {
            //session_regenerate_id();
            session_start();
        }
        
        $this->data = $_SESSION;
    }
    
    public function set($key, $val) {
        $_SESSION[$key] = $val;
    }
    
    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }
    
    public function getAll() {
        return $this->data = $_SESSION;
    }
    
    public function isExists($key) {
       return key_exists($key, $_SESSION) ? true : false;
    }
    
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;   
    }
    
    public function endSession() {  
        unset($_SESSION);
      session_destroy();
    }
}