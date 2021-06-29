<?php
class PaymentsController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("payments");
    }

    public function index() {
        
        try {
            
            $payments = $this->_model->list();
            $this->_view->set('payments', $payments);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function create() {
        try {
            $this->_view->set('title', 'Add Payment');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            $invoiceTbl = new InvoicesModel();
            $invoices = $invoiceTbl->getInvoiceIds();
            $this->_view->set('invoices', $invoices);
            
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                echo '<pre>'; print_r($data); exit;
                
                $paymentId = $this->_model->save($data);
                if($paymentId) {
                    $_SESSION['message'] = 'Payment added successfully';
                    header("location:". ROOT. "payments");
                } else {
                    $_SESSION['error'] = 'Fail to add payment';
                }

                
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