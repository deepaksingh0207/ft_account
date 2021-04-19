<?php

class Controller {
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $_modelBaseName;
    protected $_session;
    protected $_utils;
    
    

    public function __construct($model, $action) {
        $this->_controller = ucwords(__CLASS__);
        $this->_action = $action;
        $this->_modelBaseName = $model;
        $this->_session = App::session();
        $this->_utils = App::utils();
         
        if(!file_exists(HOME . DS.'new_config.php')) {
            header("location:" .ROOT. "setup");
            exit;
        }
        
        if(!$this->_session->get('signed_in') && !in_array($action, array('login', 'forgot', 'reset'))) {
            header("location:" .ROOT. "users/login");
            exit;
        }
        
        
        
        
        $this->_view = new View(HOME . DS . 'views' . DS . strtolower($this->_modelBaseName) . DS . $action . '.php');
        $this->_view->set("title", "Support Portal");
        
        $this->_view->set("controller", strtolower($model));
        $this->_view->set("action", strtolower($action));
        
        $this->_view->set("user_name", $this->_session->get('cust_name'));
        
        $this->_view->set('PRIORITY', $this->_utils->getPriority());
        $this->_view->set('INSTANCE', $this->_utils->getSystem());
        $this->_view->set('STATUS', $this->_utils->getStatus());
        
        //echo $this->_session->get('is_admin'); exit;
        $this->_view->set('is_admin', $this->_session->get('is_admin'));
        $this->_view->set('user', $this->_session->get('user'));
        
        
    }

    protected function _setModel($modelName) {
        $modelName .= 'Model';
        $this->_model = new $modelName();
    }

    protected function _setView($viewName) {
        $this->_view = new View(HOME . DS . 'views' . DS . strtolower($this->_modelBaseName) . DS . $viewName . '.php');
    }
    
    
    protected function _clear() {
        unset($_SESSION['success_msg']);
        unset($_SESSION['error_msg']);
    }

}