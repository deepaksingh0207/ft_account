<?php
class OrdersController extends Controller
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
            
            $states = new StatesModel();
            $states = $states->list();

            $this->_view->set('states', $states);
            
            if(!empty($_POST)) {
                $data = $_POST;
                if($this->_model->save($data)) {
                    $_SESSION['message'] = 'Customer added successfully';
                    header("location:". ROOT. "customers"); 
                } else {
                    $_SESSION['error'] = 'Fail to add customer';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}