<?php
class CreditnotesController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("creditnotes");
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
                        
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}