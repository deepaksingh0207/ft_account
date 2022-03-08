<?php
class UsersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("users");
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
            //echo '<pre>'; print_r($user); exit;
            if($user) {
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
            } else {
                $this->_view->set("err_msg", ' Incorrect login details');
            }
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

    public function setPermission() {
        $directory = 'controllers';
        $controllers = array_diff(scandir($directory), array('..', '.'));

        $xcludeController = ['controller', 'users', 'company', 'dashboard'];
        $xcludeActions = ['view'];
        $actions = ['create', 'edit', 'delete'];
        foreach ($controllers as &$controller) {
            $controller = str_replace('controller.php', '', $controller);
        }

        $controllers = array_filter(array_diff($controllers, $xcludeController));
        sort($controllers);

        $this->_view->set('controllers', $controllers);
        $this->_view->set('actions', $actions);

        exit;
    }
    
}