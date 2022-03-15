<?php

class Controller {
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $_modelBaseName;
    protected $_session;
    protected $_utils;
    public $usermodel;
    

    public function __construct($model, $action) {
        $this->_controller = ucwords(__CLASS__);
        $this->_action = $action;
        $this->_modelBaseName = $model;
        $this->_session = App::session();
        $this->_utils = App::utils();
        $this->usermodel = new UsersModel;
        
        if(!file_exists(HOME . DS.'new_config.php')) {
            header("location:" .ROOT. "setup");
            exit;
        }

        if( !in_array($action, array('login', 'forgot', 'reset', 'restrict', 'logout')) )
        {
            if(!$this->_session->get('signed_in'))
            { header("location:" .ROOT. "users/login"); exit; }
            if(!$this->_session->get('is_admin')){
                $result = $this->usermodel->myaccess(intval($_SESSION['user_id']), strtolower($model), $action);
                if ( $result == false ) {
                    // No access
                    if (strtolower($model) == 'customergroups'){ // Check access to customers
                        $customerAccess = $this->usermodel->myaccess(intval($_SESSION['user_id']), 'customers', $action);
                        if ( $customerAccess == false) { // Check access to company
                            $companyAccess = $this->usermodel->myaccess(intval($_SESSION['user_id']), 'company', 'view');
                            if ( $companyAccess == false ) { header("location:" .ROOT. "users/restrict"); exit; }
                            else { header("location:" .ROOT. "company/view/1"); exit; }
                        } else { $header("location:" .ROOT. "customers"); exit; }
                    }
                    header("location:" .ROOT. "users/restrict"); exit;
                }
            }
        }

        $this->_view = new View(HOME . DS . 'views' . DS . strtolower($this->_modelBaseName) . DS . $action . '.php');
        $this->_view->set("title", "Accounts");
        $this->_view->set("controller", strtolower($model));
        $this->_view->set("action", strtolower($action));
        
        $this->_view->set("user_name", $this->_session->get('cust_name'));
        $this->_view->set('is_admin', $this->_session->get('is_admin'));
        $this->_view->set('user', $this->_session->get('user'));

        $this->_view->set('ORDER_TYPE', $this->_utils->getOrderType());
        $this->_view->set('UOM', $this->_utils->getUOM());       
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