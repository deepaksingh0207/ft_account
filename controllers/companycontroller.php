<?php
class CompanyController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("company");
    }

    public function index() {
        
        try {
            
            $companies = $this->_model->getList();
            
            $this->_view->set('customers', $companies);
            $this->_view->set('title', 'Company List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function view($id) {
        
        try {
            
            $customer = $this->_model->get($id);
            
            $this->_view->set('customer', $customer);
            $this->_view->set('title', 'Customer Detail');
            
            $states = new StatesModel();
            $state = $states->get($customer['state']);
            
            $this->_view->set('state', $state);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function edit($id) {
        
        try {
            
            $states = new StatesModel();
            $states = $states->list();

            $this->_view->set('states', $states);

            $customer = $this->_model->get($id);
            
            $this->_view->set('customer', $customer);
            $this->_view->set('title', 'Company Edit');
            
            if(!empty($_POST)) {
                $data = $_POST;
                if($this->_model->update($id, $data)) {
                    $_SESSION['message'] = 'Company updated successfully';
                    header("location:". ROOT. "company/view/$id");
                } else {
                    $_SESSION['error'] = 'Fail to add company';
                }
            }
            
            
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
                    $_SESSION['message'] = 'Company added successfully';
                    header("location:". ROOT. "company"); 
                } else {
                    $_SESSION['error'] = 'Fail to add company';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function getDetails($id) {
        if($id) {
            $customer = $this->_model->get($id);
            echo json_encode($customer);
        } else {
            echo false;
        }
    }
}