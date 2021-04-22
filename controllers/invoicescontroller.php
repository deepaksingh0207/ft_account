<?php
class InvoicesController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("invoices");
    }

    public function index() {
        
        try {
            
            $invoices = $this->_model->getList();
            
            $this->_view->set('invoices', $invoices);
            $this->_view->set('title', 'Invoice List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function create() {
        try {
            $this->_view->set('title', 'Create Order');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();

            $this->_view->set('customers', $customers);
            
            if(!empty($_POST)) {
                $data = $_POST;

                $orderItems = array();

                foreach($data['item'] as $key => $item) {
                    $row = array();
                    $row['item'] = $data['item'][$key];
                    $row['qty'] = $data['qty'][$key];
                    $row['description'] = $data['description'][$key];
                    $row['unit_price'] = $data['unit_price'][$key];;
                    $row['tax'] = $data['tax'][$key];;
                    $row['total'] = $data['total'][$key];

                    $orderItems[] = $row;
                }

                unset($data['item'], $data['qty'], $data['description'], $data['unit_price'], $data['total'],
                $data['tax'], $data['trid'], $data['taxval']);

                //print_r($orderItems);
                //print_r($data); exit;
                $invoiceId = $this->_model->save($data);
                if($this->_model->save($data)) {

                    $tblInvoiceItem = new InvoiceItemsModel();
                    foreach($orderItems as $orderItem) {
                        $orderItem['invoice_id'] = $invoiceId;
                        $tblInvoiceItem->save($orderItem);
                    }

                    $_SESSION['message'] = 'Invoice added successfully';
                    header("location:". ROOT. "invoices"); 
                } else {
                    $_SESSION['error'] = 'Fail to add invoice';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}