<?php
class UsersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("users");
    }

    public function index() {
        
        try {
            
            $customers = $this->_model->getList();
            
            
            foreach ($customers as &$customer) {
                $customer['instances'] = implode(', ', json_decode($customer['instances'], true)['ins']);
                $customer['man_days'] = $customer['man_days'] ? 'Yes' : 'No';
            }
            
            $this->_view->set('customers', $customers);
            $this->_view->set('title', 'Customer List');
            
            
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
    
    public function forgot() {
     
        if (isset($_POST['forgotForm'])) {
            $user = $this->_model->login($_POST['email']);
            
            if($user) {
                if($user['status'] == 'lock') {
                    $this->_view->set("err_msg", 'user locked due to multiple fail attempt, please contact Admin.');
                } else {
                    $verfiyCode = md5(time());
                    $user['verifiy_code '] = $verfiyCode;
                    $user['verify_expire_time '] = date('Y-m-d H:i:s', strtotime("+1 day"));
                    if($this->_model->update($user['id'], $user)) {
                        $code = $user['id']."-".$verfiyCode;
                        //$encryption = openssl_encrypt($code, CIPHER,ENCRPT_DESCRPT_KEY, 0, IV);
                        echo $msg = "<a href='http://local.tdms.com:8888/admin/reset/".urlencode($code)."'>Click here</a> to reset password";
                        //echo $msg = "<a href='http://http://113.30.137.9/ft_tdms/admin/reset/".urlencode($code)."'>Click here</a> to reset password";
                        
                        $headers = "From: deepaksingh0207@gmail.com" . "\r\n";
                        if(mail($_POST['email'],"Reset password",$msg,$headers)) {
                            $this->_view->set("success_msg", 'Instruction mail has been sent to reset password.');
                            $this->_session->set("success_msg", 'Instruction mail has been sent. Please follow the step to reset password.');
                            //header("location:". ROOT. "admin/forgot");
                            //exit;
                            
                        }
                    } else {
                        $this->_view->set("err_msg", 'Something went wrong, please try again.');
                    }
                } 
            } else {
                $this->_view->set("err_msg", $_POST['email'] . ' is not associated with any account.');
            }
            
        }
        
        return $this->_view->output();
    }
    
    public function reset($query) {
        
        if (isset($_POST['resetForm'])) {
            $user = $this->_model->get($query);
            
            if($user) {
                if($user['status'] == 'lock') {
                    $this->_view->set("err_msg", 'user locked due to multiple fail attempt, please contact Admin.');
                } else {
                    $user['hash'] = password_hash(PREFIX.$_POST['pass'].POSTFIX, PASSWORD_DEFAULT);
                    $user['login_attempt'] = 0;
                    $user['verifiy_code '] = "";
                    $user['verify_expire_time '] = null;
                    if($this->_model->update($user['id'], $user)) {
                        $this->_session->set("success_msg", "Password updated successfully!");
                        header("location:". ROOT. "admin/login");
                        exit;
                    } else {
                        $this->_view->set("err_msg", 'Something went wrong, please try again.');
                    }
                }
            } else {
                $this->_view->set("err_msg", $_POST['email'] . ' is not associated with any account.');
            }
            
        } else {
            $data = explode("-", $query);
            $user = $this->_model->get($data[0]);
            
            if(!$user['verifiy_code'] == $data[1] || $user['verify_expire_time'] < date('Y-m-d : H:i:s') ) {
                $this->_view->set("err_msg", 'Link has been expired or invalid.');
            } 
            
            $this->_view->set("id", $data[0]);
        } 
        
        return $this->_view->output();
        
    }
    
    public function change() {
        
        if (isset($_POST['changeForm']) && !empty($_POST['pass']) && !empty($_POST['old_pass'])) {
            $user = $this->_model->get($this->_session->get("user_id"));
            if(password_verify(PREFIX.$_POST['old_pass'].POSTFIX, $user['hash'])) {
                $user = array();
                $user['hash'] = password_hash(PREFIX.$_POST['pass'].POSTFIX, PASSWORD_DEFAULT);
                $user['login_attempt'] = 0;
                $user['verifiy_code '] = "";
                $user['verify_expire_time '] = null;
                if($this->_model->update($this->_session->get("user_id"), $user)) {
                    $this->_session->set("success_msg", "Password updated successfully!");
                    $this->_session->endSession();
                    header("location:". ROOT. "users/login");
                    exit;
                } else {
                    $this->_view->set("err_msg", 'Something went wrong, please try again.');
                }
            } else {
                $this->_view->set("err_msg", 'Incorrect old password');
            }
            
        } 
        
        return $this->_view->output();
        
    }
    
    public function profile($id=null) {
        $userId = $this->_session->get("user_id");
        if($id) {
            $userId = $id;
        }
        $user = $this->_model->get($userId);
        if($id) 
        $this->_view->set('user', $user);
        
        return $this->_view->output();
    }
    
    public function create() {
        try {
            $this->_view->set('title', 'Create Customer');
            
            
            if(!empty($_POST)) {
                
                $data = $_POST;
                
                //print_r($data); exit;
                $fileUploaded = '';
                $system = new stdclass();
                $system->ins = $data['instances'];
                $data['instances'] = json_encode($system);
                
                
                if(!empty($_FILES)){
                    // Count # of uploaded files in array
                    
                        //Get the temp file path
                    $tmpFilePath = $_FILES['upload']['tmp_name'];
                        
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFilePath =  "./assets/img/" . $_FILES['logo']['name'];
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $fileUploaded = $_FILES['logo']['name'];
                            $data['logo'] = $fileUploaded;
                        }
                    }
                }
                
                $lastId = $this->_model->getLastId()['id'];
                $data['cust_num'] = "FTS/CU/".str_pad(($lastId+1), 6, 0, STR_PAD_LEFT);
                $data['password'] = "Pass@1234";
                
                
                $record = $this->_model->save($data);
                
                if($record) {
                    header("location:". ROOT. "users/");
                } else {
                    foreach($fileUploaded as $file) {
                        unlink($file);
                    }
                    
                    $output['status'] = 0;
                    $output['message'] = 'Record not saved';
                }
                
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}