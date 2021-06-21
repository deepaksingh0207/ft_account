<?php
class OrdersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("orders");
    }

    public function index() {
        
        try {
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $orders = $this->_model->getList();
            
            $this->_view->set('orders', $orders);
            $this->_view->set('title', 'Order List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    public function view($id) {
        
        try {
            
            $order = $this->_model->get($id);            
            $this->_view->set('order', $order);
            
            $customerList = new CustomersModel();
            $customer = $customerList->get($order['customer_id']);
            $this->_view->set('customer', $customer);
            
            $tblOrderItem = new OrderItemsModel();
            $items = $tblOrderItem->getItemByOrderId($id);
            $this->_view->set('items', $items);
            
            $invoiceModel = new InvoicesModel();
            $invoices = $invoiceModel->getInvoicesOfOrder($id);
            
            if($invoices) {
                foreach($invoices as &$invoice) {
                    $invoice['invoice_date'] = date('d M Y', strtotime($invoice['invoice_date']));
                }
                $this->_view->set('invoices', $invoices);
            }
            
            
            $this->_view->set('title', 'Order View');
            
            
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
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            $ordTypeTbl = new OrderTypesModel();
            $orderTypes = $ordTypeTbl->list();
            $this->_view->set('orderTypes', $orderTypes);
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                //echo '<pre>';print_r($data); exit;

                $orderData = array();
                $orderItems = array();

                $orderData = array();
                $orderData['group_id'] = $data['group_id'];
                $orderData['customer_id'] = $data['customer_id'];
                $orderData['order_date'] = $data['order_date'];
                $orderData['po_no'] = $data['po_no'];
                $orderData['sales_person'] = $data['sales_person'];
                $orderData['bill_to'] = $data['bill_to'];
                $orderData['ship_to'] = $data['ship_to'];
                $orderData['order_type'] = $data['ordertype'];
                $orderData['sub_total'] = $data['ordersubtotal'];
                $orderData['sgst'] = $data['sgst'];
                $orderData['cgst'] = $data['cgst'];
                $orderData['igst'] = $data['igst'];
                $orderData['tax_rate'] = $data['taxrate'];
                $orderData['ordertotal'] = $data['ordertotal'];
                $orderData['remarks'] = $data['remarks'];
                
                
                
                
                foreach($data['item'] as $key => $item) {
                    $row = array();
                    $row['item'] = $data['item'][$key];
                    $row['description'] = $data['description'][$key];
                    $row['qty'] = $data['qty'][$key];
                    $row['uom_id'] = $data['uom'][$key];
                    $row['unit_price'] = $data['unit_price'][$key];;
                    $row['total'] = $data['total'][$key];

                    $orderItems[] = $row;
                }

                
                //print_r($orderItems);
                //print_r($data); exit;
                $orderId = $this->_model->save($orderData);
                if($orderId) {

                    $tblOrderItem = new OrderItemsModel();
                    foreach($orderItems as $orderItem) {
                        $orderItem['order_id'] = $orderId;
                        $tblOrderItem->save($orderItem);
                    }

                    $_SESSION['message'] = 'Order added successfully';
                    header("location:". ROOT. "orders"); 
                } else {
                    $_SESSION['error'] = 'Fail to add order';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function getOrderListByCustomer($id) {
        if($id) {
            $oders = $this->_model->getOrderListByCustomer($id);
            echo json_encode($oders);
        } else {
            echo false;
        }
    }

    public function getdetails($id) {
        if($id) {
            $order = $this->_model->get($id);
            $oderItems = $this->_model->getOrderItem($id);

            $invoiceModel = new InvoicesModel();
            $invoices = $invoiceModel->getInvoicesOfOrder($id);
            
            if($invoices) {
                foreach($invoices as &$invoice) {
                    $invoice['invoice_date'] = date('d M Y', strtotime($invoice['invoice_date']));
                }
            }
            
            $result = array();
            $result['order'] = $order;
            $result['items'] = $oderItems;
            $result['invoices'] = $invoices;
            echo json_encode($result);
        } else {
            echo false;
        }
    }
    
    public function getSearchResult() {
        if(!empty($_POST)) {
            $data = $_POST;
            
            $orders = $this->_model->getList();
            
            if($orders) {
                echo json_encode($orders);
            }
            
        }
    }
}