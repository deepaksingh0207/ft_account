<?php
class PaymentsController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("payments");
    }

    public function index() {
        
        try {
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function create() {
        try {
            $this->_view->set('title', 'Add Payment');
            
            $invoiceTbl = new InvoicesModel();
            $invoices = $invoiceTbl->getInvoiceIds();
            $this->_view->set('invoices', $invoices);
            
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                //echo '<pre>'; print_r($data); exit;

                
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    
    public function view($id) {
        try {
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
}