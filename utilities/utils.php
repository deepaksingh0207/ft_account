<?php

class Utils {
    
    function __construct() {
    
    }
 
    function getRandomNumber() {
        return time();
    }
    
    function getMailer() {
        require_once HOME . DS. 'vendor/autoload.php';
        // Create the Transport
        //$transport = (new Swift_SmtpTransport(MAIL_TRANSPORT, 587))
        $transport = (new Swift_SmtpTransport(MAIL_TRANSPORT, 587, 'tls'))
        ->setUsername(HD_MAIL_ID)
        ->setPassword(HD_MAIL_PWD);
        
        $mailer = new Swift_Mailer($transport);
        
        return $mailer;
    }
    
    
    function getPriority($id = null, $val = null) {
        if($id) {
            return PRIORITY[$id];
        }
        if($val) {
            return array_search($val, PRIORITY);
        }
        return PRIORITY;
        
    }
    function getStatus($id = null, $val = null) {
        if($id) {
            return STATUS[$id];
        }
        if($val) {
            return array_search($val, STATUS);
        }
        return STATUS;
    }
    function getSystem($id = null, $val = null) {
        if($id) {
            return INSTANCE[$id];
        }
        if($val) {
            return array_search($val, INSTANCE);
        }
        return INSTANCE;
    }
    
}