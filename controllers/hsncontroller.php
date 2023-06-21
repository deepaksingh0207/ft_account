<?php
class HsnController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("hsn");
    }

    public function index() {
        
        try {
            
            $hsn = $this->_model->getList();
            
            $this->_view->set('hsn', $hsn);
            $this->_view->set('title', 'HSN List');
            if(!empty($_POST)) {
                $data = $_POST;
                // echo '<pre>'; print_r($data); exit;
                if($this->_model->save($data)) {
                    $_SESSION['message'] = 'Hsn added successfully';
                    header("location:". ROOT. "hsn"); 
                } else {
                    $_SESSION['error'] = 'Fail to add HSN';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    public function view($id) {
        
        try {
            
            $hsn = $this->_model->get($id);
            
            $this->_view->set('hsn', $hsn);
            $this->_view->set('title', 'HSN Detail');
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function edit($id) {
        
        try {
            
            $hsn = $this->_model->get($id);
            
            $this->_view->set('hsn', $hsn);
            $this->_view->set('title', 'HSN Edit');            
            
            if(!empty($_POST)) {
                $data = $_POST;
                if($this->_model->update($id, $data)) {
                    $_SESSION['message'] = 'HSN updated successfully';
                    header("location:". ROOT. "hsn");
                } else {
                    $_SESSION['error'] = 'Fail to update HSN';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function create() {
        try {
            $this->_view->set('title', 'Create HSN');            
            if(!empty($_POST)) {
                $data = $_POST;
                echo '<pre>'; print_r($data); exit;
                if($this->_model->save($data)) {
                    $_SESSION['message'] = 'Hsn added successfully';
                    header("location:". ROOT. "hsn"); 
                } else {
                    $_SESSION['error'] = 'Fail to add HSN';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function getDetails($id) {
        if($id) {
            $hsn = $this->_model->get($id);
            echo json_encode($hsn);
        } else {
            $hsn = $this->_model->getList();
            echo json_encode($hsn);
        }
    }
}