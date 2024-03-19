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
            
            //$orders = $this->_model->getList();
            //$this->_view->set('orders', $orders);

            $this->_view->set('title', 'Order List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }

    public function list() {
        
        try {
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            //$orders = $this->_model->getList();
            //$this->_view->set('orders', $orders);

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

            // echo '<pre>'; print_r($items); exit;
            $this->_view->set('items', $items);
            
            $tblOrderPayterm = new OrderPaytermsModel();
            $payterms = $tblOrderPayterm->getPaytermByOrderId($id);
            $this->_view->set('payterms', $payterms);
            
            $invoiceModel = new InvoicesModel();
            // $invoices = $invoiceModel->getInvoicesOfOrder($id);
            // Jthayil 22 Feb
            $invoices = $invoiceModel->getPaymentOfInvoices($id);
            // Jthayil End
            
            $customerTbl = new CustomersModel();
            $customer = $customerTbl->get($order['customer_id']);
            $this->_view->set('customer', $customer);
            
            $customerShipTo = $customerTbl->get($order['ship_to']);
            $this->_view->set('shipToAddress', $customerShipTo['address']);
            
            if($invoices) {
                foreach($invoices as &$invoice) {
                    $invoice['invoice_date'] = date('d M Y', strtotime($invoice['invoice_date']));
                }
            }
            $this->_view->set('invoices', $invoices);
            
            // JThayil 22 Feb
            $summary = $this->_model->getOrderViewSummary($id);
            $this->_view->set('summary', $summary);
            // JThayil End

            
            $paymentDone = $this->_model->getPaymentDoneInvoices($id);
            $this->_view->set('paymentDone', $paymentDone);

            
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
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                // echo '<pre>';print_r($data); exit;

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
                if(isset($data['open_po'])){ $orderData['open_po'] = 1; }

                $orderData['user_id'] = $this->_session->get('user_id'); // created by user

                
                // if($data['ordertype'] == 1 || $data['ordertype'] == 3) {
                //     $orderData['po_from_date'] = $data['po_from_date'];
                //     $orderData['po_to_date'] = $data['po_to_date'];
                // }
                
                if(!empty($_FILES)){
                    //Get the temp file path
                    $tmpFilePath = $_FILES['upload_po']['tmp_name'];
                    
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFileName = time().'_'. $_FILES['upload_po']['name'];
                        $newFilePath =  "./order_po/".$newFileName;
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $orderData['po_file'] = $newFileName;
                        }
                    }
                }

                
                /*
                if($orderData['order_type'] == 2 || $orderData['order_type'] == 1) {
                    foreach($data['ptitem'] as $key => $item) {
                        $row = array();
                        $row['item'] = $data['ptitem'][$key];
                        $row['description'] = $data['paymentterm'][$key];
                        $row['qty'] = $data['ptqty'][$key];
                        $row['uom_id'] = $data['ptuom'][$key];
                        $row['unit_price'] = $data['ptunit_price'][$key];
                        $row['total'] = $data['pttotal'][$key];
                        $orderPayTerms[] = $row;
                    }
                }
                
                
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

                */


                // echo '<pre>';
                // print_r($orderItems);
                // print_r($orderPayTerms);
                // exit;
                //print_r($data); exit;
                $orderId = $this->_model->save($orderData);
                if($orderId) {

                    $tblOrderItem = new OrderItemsModel();
                    $tblOrderPaymentTerm = new OrderPaytermsModel();

                    foreach($data['order_details'] as $item) {
                        $orderItem = array();
                        $orderItem['item'] = $item['item'];
                        $orderItem['description'] = $item['description'];
                        $orderItem['qty'] = $item['qty'];
                        $orderItem['uom_id'] = $item['uom_id'];
                        $orderItem['unit_price'] = $item['unit_price'];
                        $orderItem['total'] = $item['total'];
                        $orderItem['order_id'] = $orderId;
                        $orderItem['order_type'] = $item['ordertype'];

                        if($item['ordertype'] == 1 || $item['ordertype'] == 3) {
                            $orderItem['po_from_date'] = $item['po_from_date'];
                            $orderItem['po_to_date'] = $item['po_to_date'];
                        }

                        $orderItemId = $tblOrderItem->save($orderItem);

                        if($orderItem['order_type'] == 2 || $orderItem['order_type'] == 1 || $orderItem['order_type'] == 3 || $orderItem['order_type'] == 7) {
                            foreach($item['payment_term'] as $orderPayTerm) {
                                $orderPayTerm['order_id'] = $orderId;
                                $orderPayTerm['order_item_id'] = $orderItemId;
                                $tblOrderPaymentTerm->save($orderPayTerm);
                            }
                        }
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

    public function openpo() {
        try {
            $this->_view->set('title', 'Create Order');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                // echo '<pre>';print_r($data); exit;

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
                if(isset($data['open_po'])){ $orderData['open_po'] = 1; }

                $orderData['user_id'] = $this->_session->get('user_id'); // created by user

                
                // if($data['ordertype'] == 1 || $data['ordertype'] == 3) {
                //     $orderData['po_from_date'] = $data['po_from_date'];
                //     $orderData['po_to_date'] = $data['po_to_date'];
                // }
                
                if(!empty($_FILES)){
                    //Get the temp file path
                    $tmpFilePath = $_FILES['upload_po']['tmp_name'];
                    
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFileName = time().'_'. $_FILES['upload_po']['name'];
                        $newFilePath =  "./order_po/".$newFileName;
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $orderData['po_file'] = $newFileName;
                            
                        }
                    }
                }

                
                /*
                if($orderData['order_type'] == 2 || $orderData['order_type'] == 1) {
                    foreach($data['ptitem'] as $key => $item) {
                        $row = array();
                        $row['item'] = $data['ptitem'][$key];
                        $row['description'] = $data['paymentterm'][$key];
                        $row['qty'] = $data['ptqty'][$key];
                        $row['uom_id'] = $data['ptuom'][$key];
                        $row['unit_price'] = $data['ptunit_price'][$key];
                        $row['total'] = $data['pttotal'][$key];
                        $orderPayTerms[] = $row;
                    }
                }
                
                
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

                */


                // echo '<pre>';
                // print_r($orderItems);
                // print_r($orderPayTerms);
                // exit;
                //print_r($data); exit;
                $orderId = $this->_model->save($orderData);
                if($orderId) {

                    $tblOrderItem = new OrderItemsModel();
                    $tblOrderPaymentTerm = new OrderPaytermsModel();

                    foreach($data['order_details'] as $item) {
                        $orderItem = array();
                        $orderItem['item'] = $item['item'];
                        $orderItem['description'] = $item['description'];
                        $orderItem['qty'] = $item['qty'];
                        $orderItem['uom_id'] = $item['uom_id'];
                        $orderItem['unit_price'] = $item['unit_price'];
                        $orderItem['total'] = $item['total'];
                        $orderItem['order_id'] = $orderId;
                        $orderItem['order_type'] = $item['ordertype'];

                        if($item['ordertype'] == 1 || $item['ordertype'] == 3) {
                            $orderItem['po_from_date'] = $item['po_from_date'];
                            $orderItem['po_to_date'] = $item['po_to_date'];
                        }

                        $orderItemId = $tblOrderItem->save($orderItem);

                        if($orderItem['order_type'] == 2 || $orderItem['order_type'] == 1 || $orderItem['order_type'] == 3 || $orderItem['order_type'] == 7) {
                            foreach($item['payment_term'] as $orderPayTerm) {
                                $orderPayTerm['order_id'] = $orderId;
                                $orderPayTerm['order_item_id'] = $orderItemId;
                                $tblOrderPaymentTerm->save($orderPayTerm);
                            }
                        }
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

    // JThayil 25 Feb
    public function renew($id) {
        try {
            $dorder = $this->_model->get($id);
            $order = $this->_model->renew_header($id);            
            $this->_view->set('order', $order);
            
            $customerList = new CustomersModel();
            $customer = $customerList->get($order['customer_id']);
            $this->_view->set('customer', $customer);
            
            $tblOrderItem = new OrderItemsModel();
            $items = $tblOrderItem->getItemByOrderId($id);
            
            $this->_view->set('items', $items);
            // echo '<pre>'; print_r($items); exit;

            if(!empty($_POST)) {
                $data = $_POST;
                // echo '<pre>';print_r($data); exit;

                $orderId = $data['order_id'];
                if($orderId) {
                    $tblOrderItem = new OrderItemsModel();
                    $tblOrderPaymentTerm = new OrderPaytermsModel();

                    foreach($data['order_details'] as $item) {
                        $orderItem = array();
                        $orderItem['item'] = $item['item'];
                        $orderItem['description'] = $item['description'];
                        $orderItem['qty'] = $item['qty'];
                        $orderItem['uom_id'] = $item['uom_id'];
                        $orderItem['unit_price'] = $item['unit_price'];
                        $orderItem['total'] = $item['total'];
                        $orderItem['order_id'] = $orderId;
                        $orderItem['order_type'] = $item['ordertype'];

                        if(in_array($item['ordertype'], array(1, 3))) {
                            $orderItem['po_from_date'] = $item['po_from_date'];
                            $orderItem['po_to_date'] = $item['po_to_date'];
                        }

                        $orderItemId = $tblOrderItem->save($orderItem);

                        if(in_array($orderItem['order_type'], array(1, 2, 3, 7))) {
                            foreach($item['payment_term'] as $orderPayTerm) {
                                $orderPayTerm['order_id'] = $orderId;
                                $orderPayTerm['order_item_id'] = $orderItemId;$tblOrderPaymentTerm->save($orderPayTerm);
                            }
                        }
                    }

                    $dorder["sub_total"] = $dorder["sub_total"] + $data["ordersubtotal"];
                    $dorder["sgst"] = $dorder["sgst"] + $data["sgst"];
                    $dorder["cgst"] = $dorder["cgst"] + $data["cgst"];
                    $dorder["igst"] = $dorder["igst"] + $data["igst"];
                    $dorder["ordertotal"] = $dorder["ordertotal"] + $data["ordertotal"];
                    $this->_model->update($id, $dorder);
                    
                    $_SESSION['message'] = 'Order added successfully';
                    header("location:". ROOT. "orders". "/list"); 
                } else {
                    $_SESSION['error'] = 'Fail to add order';
                }
            }

            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    // JThayil End

    // JThayil 28 Feb
    public function edit($id) {
        try {
            
            $order = $this->_model->renew_header($id);            
            $this->_view->set('order', $order);
            
            $customerList = new CustomersModel();
            $customer = $customerList->get($order['customer_id']);
            $this->_view->set('customer', $customer);
            
            $tblOrderItem = new OrderItemsModel();
            $items = $tblOrderItem->getItemByOrderId($id);
            
            $this->_view->set('items', $items);
            // echo '<pre>'; print_r($items); exit;

            if(!empty($_POST)) {
                $data = $_POST;
                // echo '<pre>';print_r($data); exit;
                
                $orderId = $data['order_id'];
                if($orderId) {
                    $tblOrderItem = new OrderItemsModel();
                    $tblOrderPaymentTerm = new OrderPaytermsModel();

                    foreach($data['order_details'] as $item) {
                        $orderItem = array();
                        $orderItem['item'] = $item['item'];
                        $orderItem['description'] = $item['description'];
                        $orderItem['qty'] = $item['qty'];
                        $orderItem['uom_id'] = $item['uom_id'];
                        $orderItem['unit_price'] = $item['unit_price'];
                        $orderItem['total'] = $item['total'];
                        $orderItem['order_id'] = $orderId;
                        $orderItem['order_type'] = $item['ordertype'];
                        $orderItem['id'] = $item['id'];

                        if(in_array($orderItem['order_type'], array(1, 3))) {
                            $orderItem['po_from_date'] = $item['po_from_date'];
                            $orderItem['po_to_date'] = $item['po_to_date'];
                        }

                        if ($item['id'] > 0){
                            $tblOrderItem->update($item['id'], $orderItem);
                            $orderItemId = $item['id'];
                        }
                        else {$orderItemId = $tblOrderItem->save($orderItem);}
                        // echo '<pre>';print_r($data); exit;

                        if(in_array($orderItem['order_type'], array(1, 2, 3, 7))) {
                            foreach($item['payment_term'] as $orderPayTerm) {
                                $orderTerm = array();
                                $orderTerm['order_id'] = $orderId;
                                $orderTerm['order_item_id'] = $orderItemId;
                                $orderTerm['item'] = $orderPayTerm['item'];
                                $orderTerm['description'] = $orderPayTerm['description'];
                                $orderTerm['qty'] = $orderPayTerm['qty'];
                                $orderTerm['uom_id'] = $orderPayTerm['uom_id'];
                                $orderTerm['unit_price'] = $orderPayTerm['unit_price'];
                                $orderTerm['total'] = $orderPayTerm['total'];

                                if ($orderPayTerm['id'] > 0) {
                                    $tblOrderPaymentTerm->update($orderPayTerm['id'], $orderTerm);
                                }
                                else {
                                    $tblOrderPaymentTerm->save($orderTerm);
                                }
                            }
                        }
                    }

                    $order = $this->_model->get($id);
                    $order['ordertotal'] = $data['ordertotal'];
                    $order['igst'] = $data['igst'];
                    $order['sub_total'] = $data['ordersubtotal'];
                    $order['tax_rate'] = $data['taxrate'];
                    
                    if ($orderId > 0) {
                        $this->_model->update($orderId, $order);
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
    // JThayil End

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
            
            $payTermTbl = new OrderPaytermsModel();
            $paymentTerms = $payTermTbl->getPaytermByOrderId($id);
            
            
            $invoiceItemModel = new InvoiceItemsModel();
            foreach($oderItems as &$oderItem) {
                $result = $invoiceItemModel->getInvoiceQtyOfItem($oderItem['id']);
                $oderItem['bal_qty'] = ($oderItem['qty'] - $result);
                $oderItem['bal_total'] = ($oderItem['bal_qty'] * $oderItem['unit_price']);
                
            }
            
            foreach($invoices as &$invoice) {
                $invoice['payment_term'] = $invoice['payment_term'] ? $invoice['payment_term'] : '-';
                $invoice['pay_percent'] = $invoice['pay_percent'] ? $invoice['pay_percent'] : '-';
            }

            // JThayil 16.Nov Start
            $proformaModel = new ProformaInvoicesModel();
            $proformas = $proformaModel->getInvoicesOfOrder($id);
            
            if($proformas) {
                foreach($proformas as &$proforma) {
                    $proforma['invoice_date'] = date('d M Y', strtotime($proforma['invoice_date']));
                }
            }

            $proformaInvoiceItemModel = new ProformaInvoiceItemsModel();
           

            foreach($proformas as &$proforma) {
                $proforma['payment_term'] = $proforma['payment_term'] ? $proforma['payment_term'] : '-';
                $proforma['pay_percent'] = $proforma['pay_percent'] ? $proforma['pay_percent'] : '-';
            }
            // End
            
            $result = array();
            $result['order'] = $order;
            $result['items'] = $oderItems;
            $result['invoices'] = $invoices;
            $result['invoice_items'] = $invoiceItemModel->getListByOrderId($id);
            // JThayil 16.Nov Start
            $result['proforma'] = $proformas;
            $result['proforma_items'] = $proformaInvoiceItemModel->getListByOrderId($id);
            // End
            $result['payment_term'] = $paymentTerms;
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

    public function po_validty() {
        $resp = false;
        if(!empty($_POST)) {
            $t = $this->_model->getRecordsByField('po_no', $_POST['po_no']);
            if(!t) { $resp = true; }
        }
        echo $resp;
    }

    public function search() {
        
        $orders = $this->_model->getList($_POST);
        
        $result = array(); 
        $result['draw'] = 1;
        $result['data'] = array();
        $result['recordsTotal'] = count($orders);
        $result['recordsFiltered'] = count($orders);

        foreach($orders as $order) {
            $tmp = array();
            $tmp[] = $order['id'];
            $tmp[] = date('d, M Y',strtotime($order['order_date']));
            $tmp[] = $order['po_no'];
            $tmp[] = $order['customer_name'];
            $tmp[] = $order['sales_person'];
            $tmp[] = $order['ordertotal'];
            $result['data'][] = $tmp;
        }

        echo json_encode($result);
        exit;
    }

    public function searchopenpo() {
        
        $orders = $this->_model->getPOList($_POST);
        
        $result = array(); 
        $result['draw'] = 1;
        $result['data'] = array();
        $result['recordsTotal'] = count($orders);
        $result['recordsFiltered'] = count($orders);

        foreach($orders as $order) {
            $tmp = array();
            $tmp[] = $order['id'];
            $tmp[] = date('d, M Y',strtotime($order['order_date']));
            $tmp[] = $order['po_no'];
            $tmp[] = $order['customer_name'];
            $tmp[] = $order['sales_person'];
            $tmp[] = $order['ordertotal'];
            $result['data'][] = $tmp;
        }

        

        echo json_encode($result);
        exit;
    }

    function getInvoicesForPayments($id) {
        if($id) {
            $paymentDone = $this->_model->getPaymentDoneInvoices($id);
            $paymentProforma = $this->_model->getPendingProforma($id);
            $paymentPending = $this->_model->getPendingInvoices($id);

            echo json_encode(array('payment_completed' => $paymentDone, 'payment_pending' => $paymentPending, 'payment_proforma' => $paymentProforma));
        }  else {echo false;}
    }
}