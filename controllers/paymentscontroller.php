<?php
class PaymentsController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("payments");
    }

    public function index() {
        
        try {
            
            //$payments = $this->_model->list();
            
            $customerPayTbl = new CustomerPaymentsModel();
            $payments = $customerPayTbl->list();
            
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
                
                //echo '<pre>'; print_r($data); exit;
                $customerPayments = array();
                $customerPayments['group_id'] = $data['group_id'];
                $customerPayments['customer_id'] = $data['customer_id'];
                $customerPayments['order_id'] = $data['order_id'];
                $customerPayments['invoice_id'] = $data['invoice_id'];
                $customerPayments['payment_date'] = $data['payment_date'];
                $customerPayments['cheque_utr_no'] = $data['cheque_utr_no'];
                $customerPayments['received_amt'] = $data['received_amt'];
                $customerPayments['remarks'] = $data['remarks'];
                
                if(!empty($_FILES)){
                    //Get the temp file path
                    $tmpFilePath = $_FILES['utr_file']['tmp_name'];
                    
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFileName = time().'_'. $_FILES['utr_file']['name'];
                        $newFilePath =  "./utr_file/".$newFileName;
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $customerPayments['utr_file'] = $newFileName;
                            
                        }
                    }
                }

                $customerPayTbl = new CustomerPaymentsModel();
                $custPaymentId = $customerPayTbl->save($customerPayments);
                
                
                if($custPaymentId) {
                    echo json_encode(array("status"=>1, "message"=>"Payment added successfully"));
                    exit;
                    //$_SESSION['message'] = 'Payment added successfully';
                    //header("location:". ROOT. "payments");
                } else {
                    //$_SESSION['error'] = 'Fail to add payment';
                    echo json_encode(array("status"=>0, "message"=>"Fail to add payment"));
                    exit;
                }
            }
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    /*public function create() {
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
                
                //echo '<pre>'; print_r($data); exit;
                $customerPayments = array();
                $payments = array();
                
                $customerPayments['group_id'] = $data['group_id'];
                $customerPayments['customer_id'] = $data['customer_id'];
                $customerPayments['payment_date'] = $data['payment_date'];
                $customerPayments['cheque_utr_no'] = $data['cheque_utr_no'];
                $customerPayments['received_amt'] = $data['received_amt'];
                $customerPayments['remarks'] = $data['remarks'];
                
                $customerPayTbl = new CustomerPaymentsModel();
                $custPaymentId = $customerPayTbl->save($customerPayments);
                
                
                if($custPaymentId) {
                    if(isset($data['invoice_id'])) {
                        foreach($data['invoice_id'] as $key => $item) {
                            $row = array();
                            $row['customer_payment_id'] = $custPaymentId;
                            $row['invoice_id'] = $data['invoice_id'][$key];
                            $row['basic_value'] = $data['basic_value'][$key];
                            $row['gst_amount'] = $data['gst_amount'][$key];
                            $row['invoice_amount'] = $data['invoice_amount'][$key];
                            $row['tds_percent'] = $data['tds_percent'][$key];
                            $row['tds_deducted'] = $data['tds_deducted'][$key];
                            $row['receivable_amt'] = $data['receivable_amt'][$key];
                            $row['allocated_amt'] = $data['allocated_amt'][$key];
                            $row['balance_amt'] = $data['balance_amt'][$key];
                            //$payments[] = $row;
                            $this->_model->save($row);
                        }
                    }
                    
                    
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
    } */
    
    
    public function view($id) {
        try {
            
            $customerPayTbl = new CustomerPaymentsModel();
            $customerPayment = $customerPayTbl->get($id);
            $this->_view->set('customerPayment', $customerPayment);
            
            $invoicePayment = $this->_model->getDetailsByPaymentId($id);
            //print_r($invoicePayment); exit;
            $this->_view->set('invoicePayment', $invoicePayment);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    public function utr_validty() {
            if(!empty($_POST)) {
                if($t = $this->_model->getRecordsByField('cheque_utr_no', $_POST['cheque_utr_no'])) {
                    echo 0;
                } else {
                    echo true;
                }
            } else {
                echo false;
            }
        }    
}