<?php
class AdminController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("admin");
    }

    public function index() {
        
        try {
            $users = $this->_model->getUserList();
            
            $this->_view->set('users', $users);
            $this->_view->set('title', 'ACL');
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function acl($id) {
        // $router = service('router'); 
        // $controller  = $router->controllerName();
        // $method = $router->methodName();
        // $logger = service('logger');
        // $routes = service('routes');
        // echo '<pre>'; print_r($controller); exit;
        
        try {
            $accesslist = $this->_model->get($id);
            if(!empty($_POST)) {
                $data = $_POST;
                
                // echo '<pre>'; print_r($data); exit;
                
                foreach(array_keys($data['controller']) as $controller) {
                    $accessrecord = array();
                    $accessrecord['user'] = $id;
                    $accessrecord['controller'] = $controller;
                    // echo '<pre>'; print_r($controller); exit;
                    
                    foreach(array_keys($data['controller'][$controller]) as $actions) {
                        // echo '<pre>'; print_r($accessrecord); exit;
                        $accessrecord['action'] = $actions;
                        $this->_model->save($accessrecord);
                    }
                }
                foreach($accesslist as $row) {
                    // echo '<pre>'; print_r($row["id"]); exit;
                    $this->_model->delete($row["id"]);
                }
                $accesslist = $this->_model->get($id);
            }
            
            $this->_view->set('accesslist', $accesslist);
            $this->_view->set('title', 'ACL');

            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function restrict(){
        try {
            $this->_view->set('title', 'Access Denied');
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}