<?php
class UsersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("users");
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

    public function login() {
        
        if($this->_session->get('signed_in')) {
            header("location:". ROOT. "customers"); 
            exit;
        }
        
        $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
        $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
        
        if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
              
        }
        
        if (!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
        }
        
        if($username && $password) {
            $user = $this->_model->login($username, $password);
            if($user) {
                
                $list = [];
                $contlist = $this->_model->getController($user['id']);
                if (is_array($contlist) || is_object($contlist)){
                foreach ($contlist as $value) { $list[] = $value['controller']; }}
                $this->_session->set('controller', $list);

                $list = [];
                $menulist = $this->_model->getmenu($user['id']);
                if (is_array($menulist) || is_object($menulist)){
                foreach ($menulist as $value) { $list[] = $value['menu']; }}
                $this->_session->set('menu', $list);

                $this->_session->set('action', $list);
                $this->_session->set('signed_in', true);
                $this->_session->set('user_id', $user['id']);
                $this->_session->set('is_admin', $user['admin']);
                $this->_session->set('user', $user);
                    
                    if($_POST["remember_me"]=='1' || $_POST["remember_me"]=='on')
                    {
                        $hour = time() + 3600 * 24 * 30;
                        setcookie('username', $_POST['username'], $hour);
                        setcookie('password', $_POST['password'], $hour);
                    }
                    
                    header("location:". ROOT. "dashboard"); 
                    exit;
            }
            else {$this->_view->set("err_msg", ' Incorrect login details');}
        }
            
        
        
        return $this->_view->output();
    }
    
    public function logout() {
        $this->_session->remove('signed_in');
        $this->_session->endSession();
        unset($_COOKIE['username']);
        unset($_COOKIE['password']);
        setcookie('username', "", time()-3600);
        setcookie('password', "", time()-3600);
        
        Header("location:".ROOT."incidents");
    }

    
    public function setPermission($id) {
        $controllersList = array_diff(scandir('controllers'), array('..', '.'));
        $cphp = 'controller.php';
        $skipController = [$cphp, 'users'.$cphp];
        $skipActions = ['__construct', 'create_old', 'getDetails', 'groupCustomers', 'getTaxesRate', 'generateInvoice', 'preview', 'getInvoiceIdsByCustomer','genInvoiceNo', 'invoice_validty', 'proforma_validty', 'getOrderListByCustomer', 'getdetails', 'getSearchResult', 'po_validty', 'search', 'searchopenpo', 'utr_validty'];
        $actionControllers = [];
        foreach ($controllersList as $controllerName) {
            if (!in_array($controllerName, $skipController, true)){
                $tempController = [];
                $controllerFile = __dir__.'\\'.$controllerName;
                $methodPrefix = 'public function ';
                                
                // escape special characters in the query
                $pattern = preg_quote($methodPrefix, '/');
                
                // search, and store all matching occurences in $matches
                if(preg_match_all("/^.*$pattern.*\$/m", file_get_contents($controllerFile), $matches)){
                    $actionsList =  explode($methodPrefix, implode("",$matches[0]));
                    foreach ($actionsList as $action) {
                        $actionName = preg_replace("/\s|\(.*/", "", $action);
                        if (!empty($actionName) && !in_array($actionName, $skipActions, true)){
                            $tempController[] = $actionName;
                        }
                    }
                }
                $actionControllers[str_replace($cphp, '', $controllerName)] = $tempController;
            }
        }
        // echo '<pre>'; print_r($actionControllers); exit;
        try {
            $accesslist = $this->_model->getacl($id);
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
                        $this->_model->save_acl($accessrecord);
                    }
                }
                foreach($accesslist as $row) {
                    // echo '<pre>'; print_r($row["id"]); exit;
                    $this->_model->delete_acl($row["id"]);
                }
                $accesslist = $this->_model->getacl($id);
            }
            $this->_view->set('form', $actionControllers);
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
    
    public function controllerActionList($id) {
        $controllersList = array_diff(scandir('controllers'), array('..', '.'));
        $cphp = 'controller.php';
        $skipController = [$cphp, 'users'.$cphp];
        $skipActions = [
            // '__construct', 'create_old', 'getDetails', 'groupCustomers', 'getTaxesRate', 'generateInvoice', 'preview', 'getInvoiceIdsByCustomer','genInvoiceNo', 'invoice_validty', 'proforma_validty', 'getOrderListByCustomer', 'getdetails', 'getSearchResult', 'po_validty', 'search', 'searchopenpo', 'utr_validty'
        ];
        $actionControllers = [];
        foreach ($controllersList as $controllerName) {
            if (!in_array($controllerName, $skipController, true)){
                $tempController = [];
                $controllerFile = __dir__.'\\'.$controllerName;
                $methodPrefix = 'public function ';
                                
                // escape special characters in the query
                $pattern = preg_quote($methodPrefix, '/');
                
                // search, and store all matching occurences in $matches
                if(preg_match_all("/^.*$pattern.*\$/m", file_get_contents($controllerFile), $matches)){
                    $actionsList =  explode($methodPrefix, implode("",$matches[0]));
                    foreach ($actionsList as $action) {
                        $actionName = preg_replace("/\s|\(.*/", "", $action);
                        if (!empty($actionName) && !in_array($actionName, $skipActions, true)){
                            $tempController[] = $actionName;
                        }
                    }
                }
                $actionControllers[str_replace($cphp, '', $controllerName)] = $tempController;
            }
        }
        echo '<pre>'; print_r($actionControllers); exit;
    }
}