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
    
    public function view($id) {
        
        try {
            
            $customer = $this->_model->get($id);
            
            $this->_view->set('customer', $customer);
            $this->_view->set('title', 'Customer Detail');
            
            $states = new StatesModel();
            $state = $states->get($customer['state']);
            $this->_view->set('state', $state);
            
            $groupTbl = new CustomerGroupsModel();
            $group = $groupTbl->get($customer['group_id']);
            $this->_view->set('group', $group);
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function edit($id) {
        
        try {
            
            $customer = $this->_model->get($id);
            
            $this->_view->set('customer', $customer);
            $this->_view->set('title', 'Customer Edit');
            
            $states = new StatesModel();
            $states = $states->list();
            $this->_view->set('states', $states);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                if($this->_model->update($id, $data)) {
                    $_SESSION['message'] = 'Customer updated successfully';
                    header("location:". ROOT. "customers/view/$id");
                } else {
                    $_SESSION['error'] = 'Fail to update customer';
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
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            
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

    public function getDetails($id) {
        if($id) {
            $customer = $this->_model->get($id);
            echo json_encode($customer);
        } else {
            echo false;
        }
    }
    
    public function groupCustomers($id) {
        if($id) {
            $customer = $this->_model->getCustomersByGroup($id);
            echo json_encode($customer);
        } else {
            echo false;
        }
    }
}