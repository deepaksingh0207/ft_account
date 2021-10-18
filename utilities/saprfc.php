<?php

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class SAPRFC {
    private static $conn;
    
    /*var $config = [
        'ashost' => '122.175.13.217',
        'sysnr'  => '07',
        'client' => '800',
        'user'   => 'userk1',
        'passwd' => 'vijayfiori',
    ]; */

    public static function connection($config) {
        
        if(class_exists('SAPNWRFC\Connection'))  {
            if (!self::$conn) {
                try {
                    self::$conn = new SapConnection($config);
                } catch(SapException $ex) {
                    //echo 'Exception: ' . $ex->getMessage() . PHP_EOL;
                    $error = $ex->getErrorInfo();
                    self::$conn = $error;
                }
            }
            
            return self::$conn;
        } else {
            self::$conn = false;
        }
    }   
    
    public static function ping() {
        return self::$conn->ping();
    }
    
}