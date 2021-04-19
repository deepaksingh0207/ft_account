<?php
class CustomersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("customers");
    }

    public function index() {
        
        try {
            
            $customers = $this->_model->getList();
            
            $this->_view->set('customers', $customers);
            $this->_view->set('title', 'Customer List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
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