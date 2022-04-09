<?php
class InvoicesController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("invoices");
    }

    public function index() {
        
        try {

            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);

            //$invoices = $this->_model->getList();
            //$this->_view->set('invoices', $invoices);
            $this->_view->set('title', 'Invoice List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    public function create() {
        try {
            $this->_view->set('title', 'Create Invoice');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                // echo '<pre>'; print_r($data); exit;

                $isProformaInvoice = (isset($data['proforma']) && $data['proforma'] == 1) ? true : false;

                $invoiceeData = array();
                $invoiceItems = array();
                
                $invoiceeData['group_id'] = $data['group_id'];
                $invoiceeData['customer_id'] = $data['customer_id'];
                $invoiceeData['order_id'] = $data['order_id'];
                $invoiceeData['invoice_date'] = $data['invoice_date'];
                $invoiceeData['po_no'] = $data['po_no'];
                $invoiceeData['sales_person'] = $data['sales_person'];
                $invoiceeData['bill_to'] = $data['bill_to'];
                $invoiceeData['ship_to'] = $data['ship_to'];
                $invoiceeData['order_total'] = $data['order_total'];
                $invoiceeData['sub_total'] = $data['sub_total'];
                $invoiceeData['sgst'] = $data['sgst'];
                $invoiceeData['cgst'] = $data['cgst'];
                $invoiceeData['igst'] = $data['igst'];
                $invoiceeData['invoice_total'] = $data['invoice_total'];
                
                $invoiceeData['payment_term'] = isset($data['payment_term']) ? $data['payment_term'] : null ;
                $invoiceeData['pay_percent'] = isset($data['pay_percent']) ? $data['pay_percent'] : null ;
                $invoiceeData['payment_description'] = isset($data['payment_description']) ? $data['payment_description'] : null ;
                
                $invoiceeData['remarks'] = $data['remarks'];
                $invoiceeData['due_date'] = $data['due_date'];
                //$invoiceeData['invoice_no'] = $this->genInvoiceNo();
                $invoiceeData['invoice_no'] = $data['invoice_no'];

                $invoiceeData['user_id'] = $this->_session->get('user_id'); // created by user
                
                
                
                /*
                if(isset($data['item'])) {
                    foreach($data['item'] as $key => $item) {
                        $row = array();
                        $row['order_item_id'] = $data['order_item_id'][$key];
                        $row['item'] = $data['item'][$key];
                        $row['description'] = $data['description'][$key];
                        $row['qty'] = $data['qty'][$key];
                        $row['uom_id'] = $data['uom'][$key];
                        $row['unit_price'] = $data['unit_price'][$key];
                        $row['total'] = $data['total'][$key];
    
                        $invoiceItems[] = $row;
                    }
                } */

                foreach($data['order_details'] as $item) {
                    $orderItem = array();
                    $orderItem['order_item_id'] = $item['order_item_id'];
                    $orderItem['order_payterm_id'] = $item['order_payterm_id'];
                    $orderItem['item'] = $item['item'];
                    if($isProformaInvoice == false) {
                        $orderItem['proforma_invoice_item_id'] = $item['proforma_invoice_item_id'];
                    }
                    $orderItem['description'] = $item['description'];
                    $orderItem['qty'] = $item['qty'];
                    $orderItem['uom_id'] = $item['uom_id'];
                    $orderItem['unit_price'] = $item['unit_price'];
                    $orderItem['total'] = $item['total'];

                    $invoiceItems[] = $orderItem;
                    
                }

                
                
                if($isProformaInvoice) {
                    $tblProformaInvoice = new ProformaInvoicesModel();
                    $invoiceId = $tblProformaInvoice->save($invoiceeData);
                    if($invoiceId) {
                        $tblInvoiceItem = new ProformaInvoiceItemsModel();
                        foreach($invoiceItems as $invoiceItem) {
                            $invoiceItem['proforma_invoice_id'] = $invoiceId;
                            $tblInvoiceItem->save($invoiceItem);
                        }
                        
                        $this->generateInvoice($invoiceId, true); 

                        $_SESSION['message'] = 'Invoice added successfully';
                        header("location:". ROOT. "invoices"); 
                    } else {
                        $_SESSION['error'] = 'Fail to add invoice';
                    }
                } else {
                    $invoiceId = $this->_model->save($invoiceeData);
                    if($invoiceId) {
                        $tblInvoiceItem = new InvoiceItemsModel();
                        foreach($invoiceItems as $invoiceItem) {
                            $invoiceItem['invoice_id'] = $invoiceId;
                            $tblInvoiceItem->save($invoiceItem);
                        }
                        
                        $this->generateInvoice($invoiceId); 

                        $_SESSION['message'] = 'Invoice added successfully';
                        header("location:". ROOT. "invoices"); 
                    } else {
                        $_SESSION['error'] = 'Fail to add invoice';
                    }
                }
                
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    
    public function view($id) {
        try {
            $this->_view->set('title', 'View Invoice');
            
            $invoice = $this->_model->get($id);
            $this->_view->set('invoice', $invoice);
            
            $invoiceItemTbl = new InvoiceItemsModel();
            $invoiceItems = $invoiceItemTbl->getListByInvoiceId($id);
            $this->_view->set('invoiceItems', $invoiceItems);
            
            $paymentTbl = new PaymentsModel();
            $payments = $paymentTbl->getDetailsByInvoiceId($id);
            
            $this->_view->set('payments', $payments);
            
            
            $customerTbl = new CustomersModel();
            $customer = $customerTbl->get($invoice['customer_id']);
            $this->_view->set('customer', $customer);
            
            $customerShipTo = $customerTbl->get($invoice['ship_to']);
            $this->_view->set('shipToAddress', $customerShipTo['address']);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    public function getTaxesRate($customerId) {
        try {
            $customer = new CustomersModel();
            $customer = $customer->get($customerId);
            
            $company = new CompanyModel();
            $company = $company->get(1);
            
            $itMaster = new ItMasterModel();
            $itMaster = $itMaster->get(1);
            
            
            $result = array();
            
            if($customer['state'] == $company['state']) {
                $result['state'] = 'same';
                $result['cgst'] = $itMaster['cgst'];
                $result['sgst'] = $itMaster['sgst'];
            } else {
                $result['state'] = 'other';
                $result['igst'] = $itMaster['igst'];
            }
            echo json_encode($result); exit;
            
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    // Jthayil Start 22 Dec
    public function generateInvoice($invoiceId, $proformaSwitch = false) {
        
        $dataItem = array();
        
        if ($proformaSwitch){
            $tblProformaInvoice = new ProformaInvoicesModel();
            $invoice = $tblProformaInvoice->get($invoiceId);
            $invoiceItems = $tblProformaInvoice->getInvoiceItem($invoiceId);
            // $invoice = $this->_model->get($invoiceId);
            // $invoiceItem = $this->_model->getInvoiceItem($invoiceId);
        }
        else{
            $invoice = $this->_model->get($invoiceId);
            $invoiceItems = $this->_model->getInvoiceItem($invoiceId);
        }    
    // End
        $customerTbl = new CustomersModel();
        $customer = $customerTbl->get($invoice['customer_id']);
        
        $customerShipTo = $customerTbl->get($invoice['ship_to']);
        
        $orderTable = new OrdersModel();
        $order = $orderTable->get($invoice['order_id']);
        $oderItems = $orderTable->getOrderItem($invoice['order_id']);
        $print_uom_qty= '<th>Qty./Unit</th>';
        
        if(in_array($order['order_type'], array(1,2, 3, 4, 5, 6, 7, 99))) {
            // Jthayil 12 jan 22 Start
            $tempInvoiceItem = [];
            foreach($invoiceItems as $tempItem)
            {
                if($tempItem['uom_id'] == 3)
                {
                    $print_uom_qty= '<th></th><th></th>';
                    $tempItem['qty'] = '';
                }
                array_push($tempInvoiceItem,$tempItem);
            }
            // End
            $dataItem = $tempInvoiceItem;
        } /*else if($order['order_type']  == 2 || $order['order_type']  == 1) {
            $row = array();
            //$row['description'] = $oderItems[0]['description'].'<br />'.$invoice['payment_description'];
            $row['description'] = $invoice['payment_description'];
            $row['qty'] = $invoice['pay_percent'];
            $row['unit_price'] = $invoice['order_total'];
            $row['total'] = $invoice['sub_total'];
            
            $dataItem[] = $row;
            
        } */else {
            $dataItem =  $oderItems;
        }

        $company = new CompanyModel();
        $company = $company->get(1);
        // echo print_r($invoiceItem);
        // echo '<pre>';print_r($invoice); exit;
        
        $vars = array(
            "{{INV_NO}}" => $invoice['invoice_no'],
            "{{INV_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
            "{{COMPANY_BILLTO}}" => addressmaker($company['address']),
            "{{BILLTO_ADDRESS}}" => $company['address'],
            "{{COMP_TEL}}" => $company['contact'],
            "{{COMP_PAN}}" => $company['pan'],
            "{{COMP_SAC}}" => $company['sac'],
            "{{COMP_GSTIN}}" => $company['gstin'],
            "{{COMP_BANK}}" => $company['bank_name'],
            "{{COMP_ACCNO}}" => $company['account_no'],
            "{{COMP_IFSC}}" => $company['ifsc_code'],
            "{{PO_NO}}" => $invoice['po_no'],
            "{{ORDER_TYPE}}" => $print_uom_qty,
            "{{PO_DATE}}" => date('d/m/Y', strtotime($order['order_date'])),
            "{{CUST_ADDRESS}}" =>"<b>" . $customer['name']."</b><br />". addressmaker($customer['address']),
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{DECLARATION}}" => getdeclaration($customer['declaration']),
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $customer['pan'],
            "{{CUST_GST}}" => $customer['gstin'],
            "{{CUST_SHIPTO}}" => "<b>" . $customer['name']."</b><br />". addressmaker($customerShipTo['address']),
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($invoice['invoice_total'], 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['invoice_total']),
        );
        
        $orderBaseTotal = 0.00;
        $itemList = '';
        if($tempItem['uom_id'] == 3)
            {
                foreach($dataItem as $key => $item) {
                    $itemList .= '<tr>
                <td >'.($key+1).'</td>
                <td >'.$item['description'].'</td>
                <td ></td><td ></td>
                <td style="text-align: right;">'.number_format($item['total'], 2).'</td>
                </tr>';
                    $orderBaseTotal += $item['total'];
                }
            } else {
            foreach($dataItem as $key => $item) {
                $itemList .= '<tr>
                <td >'.($key+1).'</td>
                <td >'.$item['description'].'</td>
                <td >'.$item['qty'].'</td>
                <td >'.number_format($item['unit_price'], 2).'</td>
                <td style="text-align: right;">'.number_format($item['total'], 2).'</td>
                </tr>';
                
                $orderBaseTotal += $item['total'];
            }
        }
        
        $taxesLayout = '';
        if((int)$invoice['igst']) {
            $taxesLayout = '<tr>
            <td style="text-align: right; width: 85%; border-bottom: 1px solid grey;">
            IGST @ 18%
            </td>
            <td style="text-align: right; width: 15%; border-bottom: 1px solid grey;">
            '.number_format($invoice['igst'], 2).'
            </td>
        </tr>';
        } else {
            $taxesLayout = '<tr>
            <td style="text-align: right; width: 85%;border-bottom: 1px solid grey;">
              CGST @ 9%<br />SGST @ 9%
            </td>
            <td style="text-align: right; width: 15%;border-bottom: 1px solid grey;">'.number_format($invoice['cgst'], 2).'
              <br />'.number_format($invoice['sgst'], 2).'
            </td>
          </tr>
          <tr>';
        }
        
        $vars["{{TAX_LAYOUT}}"] = $taxesLayout;
        $vars["{{ITEM_LIST}}"] = $itemList;
        $vars["{{ORDER_TOTAL}}"] = number_format($orderBaseTotal, 2);
        // JThayil 26 Dec Start
        if ($proformaSwitch){
        $messageBody = strtr(file_get_contents('./assets/mail_template/proforma_template.html'), $vars);
        }
        else{
        $messageBody = strtr(file_get_contents('./assets/mail_template/invoice_template.html'), $vars);
        }
        // End
        
        require_once HOME . DS. 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($messageBody);
        $mpdf->SetHTMLFooter('<hr style="margin: 10px 0px 0px 0px;" />
        <p style="text-align: center; ">
          '.footeraddress($company['address']).' Tel.: '.$company['contact'].'<br />
          Email: account@fts-pl.com Website: http://www.fts-pl.com
        </p>');
        $mpdf->Output('pdf/invoice_'.$invoice['invoice_no'].'.pdf', 'F');
        
        
        if(SEND_MAIL) {
            $this->sendMail($invoice, $customer);
        }
    }
    
    function sendMail($invoice, $customer) {
        
        $sentMailTo = array();
        $sentMailTo = FXD_EMAIL_IDS;
        $sentMailTo[] = $customer['email'];
        
        try {
            $mailer = $this->_utils->getMailer();
            $message = (new Swift_Message("Invoice copy #$invoice[invoice_no] against PO $invoice[po_no]" ))
            ->setContentType("text/html")
            ->setFrom([HD_MAIL_ID => HD_NAME])
            ->setTo($sentMailTo)
            ->setBcc(FXD_EMAIL_IDS)
            ->setBody("Hi Sir/Mam, <br><br> PFA invoice <br><br><br><br> Regards,<br>Account")
            ->attach(
                Swift_Attachment::fromPath('./pdf/invoice_'.$invoice['invoice_no'].'.pdf')->setContentType('application/pdf')
                );
            
            // Send the message
            $result = $mailer->send($message);
            
            echo $result;
        } catch (Exception $e) {
            
            print_r($e->getMessage());
            
        }
    }
        
    public function preview() {
        
        $dataItem = array();
        
        $invoiceId  = ($this->_model->getLastId() + 1);
        
        if(!empty($_POST)) {
            $data = $_POST;
            
            // echo '<pre>'; print_r($data); exit;
            
            $invoice = array();
            $invoiceItems = array();
            
            $isProformaInvoice = (isset($data['proforma']) && $data['proforma'] == 1) ? true : false;
            
            //$invoice['invoice_no'] = $this->genInvoiceNo();
            $invoice['invoice_no'] = $data['invoice_no'];
            $invoice['group_id'] = $data['group_id'];
            $invoice['customer_id'] = $data['customer_id'];
            $invoice['order_id'] = $data['order_id'];
            $invoice['invoice_date'] = $data['invoice_date'];
            $invoice['po_no'] = $data['po_no'];
            $invoice['sales_person'] = $data['sales_person'];
            $invoice['bill_to'] = $data['bill_to'];
            $invoice['ship_to'] = $data['ship_to'];
            $invoice['order_total'] = $data['order_total'];
            $invoice['sub_total'] = $data['sub_total'];
            $invoice['sgst'] = $data['sgst'];
            $invoice['cgst'] = $data['cgst'];
            $invoice['igst'] = $data['igst'];
            $invoice['invoice_total'] = $data['invoice_total'];
            
            $invoice['payment_term'] = isset($data['payment_term']) ? $data['payment_term'] : null ;
            $invoice['pay_percent'] = isset($data['pay_percent']) ? $data['pay_percent'] : null ;
            $invoice['payment_description'] = isset($data['payment_description']) ? $data['payment_description'] : null ;
            
            $invoice['remarks'] = $data['remarks'];

            foreach($data['order_details'] as $item) {
                $orderItem = array();
                $orderItem['order_item_id'] = $item['order_item_id'];
                $orderItem['order_payterm_id'] = $item['order_payterm_id'];
                $orderItem['item'] = $item['item'];
                $orderItem['description'] = $item['description'];
                $orderItem['qty'] = $item['qty'];
                $orderItem['uom_id'] = $item['uom_id'];
                $orderItem['unit_price'] = $item['unit_price'];
                $orderItem['total'] = $item['total'];

                if($item['total'] > 0) {
                    $invoiceItems[] = $orderItem;
                }
                
            }
        
            $customerTbl = new CustomersModel();
            $customer = $customerTbl->get($invoice['customer_id']);
            $customerShipTo = $customerTbl->get($invoice['ship_to']);
            
            $orderTable = new OrdersModel();
            $order = $orderTable->get($invoice['order_id']);
            $oderItems = $orderTable->getOrderItem($invoice['order_id']);
            $print_uom_qty= '<th>Qty./Unit</th>';
            
            if(in_array($order['order_type'], array(1,2, 3, 4, 5, 6, 7, 99))) {
                // Jthayil 12 Jan 22 Start
                $tempInvoiceItem = [];
                foreach($invoiceItems as $tempItem)
                {
                    if($tempItem['uom_id'] == 3)
                    {
                        $print_uom_qty= '<th></th><th></th>';
                        $tempItem['qty'] = '';
                    }
                    array_push($tempInvoiceItem,$tempItem);
                }
                // End
                $dataItem = $tempInvoiceItem;

            }/* else if($order['order_type']  == 2 || $order['order_type']  == 1) {
                $row = array();
                //$row['description'] = $oderItems[0]['description'].'<br />'.$invoice['payment_description'];
                $row['description'] = $invoice['payment_description'];
                $row['qty'] = $invoice['pay_percent'];
                $row['unit_price'] = $invoice['order_total'];
                $row['total'] = $invoice['sub_total'];
                
                $dataItem[] = $row;
                
            } */ else {
                $dataItem =  $oderItems;
            }
            
            $company = new CompanyModel();
            $company = $company->get(1);
            
            $vars = array(
                "{{INV_NO}}" => $invoice['invoice_no'],
                "{{INV_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
                "{{COMPANY_BILLTO}}" => addressmaker($company['address']),
                "{{BILLTO_ADDRESS}}" => $company['address'],
                "{{COMP_TEL}}" => $company['contact'],
                "{{COMP_PAN}}" => $company['pan'],
                "{{COMP_SAC}}" => $company['sac'],
                "{{COMP_GSTIN}}" => $company['gstin'],
                "{{COMP_BANK}}" => $company['bank_name'],
                "{{COMP_ACCNO}}" => $company['account_no'],
                "{{COMP_IFSC}}" => $company['ifsc_code'],
                "{{PO_NO}}" => $invoice['po_no'],
                "{{ORDER_TYPE}}" => $print_uom_qty,
                "{{PO_DATE}}" => date('d/m/Y', strtotime($order['order_date'])),
                "{{CUST_ADDRESS}}" =>"<b>" . $customer['name']."</b><br />". addressmaker($customer['address']),
                "{{CUST_TEL}}" => $customer['pphone'],
                "{{CUST_FAX}}" => $customer['fax'],
                "{{CUST_PAN}}" => $customer['pan'],
                "{{CUST_GST}}" => $customer['gstin'],
                "{{DECLARATION}}" => getdeclaration($customer['declaration']),
                "{{CUST_SHIPTO}}" => "<b>" . $customer['name']."</b><br />". addressmaker($customerShipTo['address']),
                "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
                "{{INV_TOTAL}}" => number_format($invoice['invoice_total'], 2),
                "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['invoice_total']),
            );
            
            $orderBaseTotal = 0.00;
            $itemList = '';
            if($tempItem['uom_id'] == 3)
            {
                foreach($dataItem as $key => $item) {
                    $itemList .= '<tr>
                <td >'.($key+1).'</td>
                <td >'.$item['description'].'</td>
                <td ></td><td ></td>
                <td style="text-align: right;">'.number_format($item['total'], 2).'</td>
                </tr>';
                    $orderBaseTotal += $item['total'];
                }
            } else {
                foreach($dataItem as $key => $item) {
                    $itemList .= '<tr>
                <td >'.($key+1).'</td>
                <td >'.$item['description'].'</td>
                <td >'.$item['qty'].'</td>
                <td >'.number_format($item['unit_price'], 2).'</td>
                <td style="text-align: right;">'.number_format($item['total'], 2).'</td>
                </tr>';
                    $orderBaseTotal += $item['total'];
                }
            }
            
            $taxesLayout = '';
            if((int)$invoice['igst']) {
                $taxesLayout = '<tr>
                <td style="text-align: right; width: 85%;border-bottom: 1px solid grey;">
                  IGST @ 18%
                </td>
                <td style="text-align: right; width: 15%;border-bottom: 1px solid grey;">'.number_format($invoice['igst'], 2).'</td>
              </tr>
              <tr>
              <td colspan="5" style="padding: 0px">
                <hr style="padding: 0px; margin: 0px" />
              </td>
            </tr>';
        } else {
            $taxesLayout = '<tr>
            <td style="text-align: right; width: 85%;border-bottom: 1px solid grey;">
              CGST @ 9%
              <br />
              SGST @ 9%
            </td>
            <td style="text-align: right; width: 15%;border-bottom: 1px solid grey;">
            '.number_format($invoice['cgst'], 2).'<br>'.number_format($invoice['sgst'], 2).'
            </td>
          </tr>
          <tr>';
            }
            
            $vars["{{TAX_LAYOUT}}"] = $taxesLayout;
            $vars["{{ITEM_LIST}}"] = $itemList;
            $vars["{{ORDER_TOTAL}}"] = number_format($orderBaseTotal, 2);
            
            if($isProformaInvoice) {
                $messageBody = strtr(file_get_contents('./assets/mail_template/proforma_preview_template.html'), $vars);
            } else {
                $messageBody = strtr(file_get_contents('./assets/mail_template/invoice_preview_template.html'), $vars);
            }
            echo $messageBody;
        }
        
    }
    
    public function getDetails($invoiceId) {
        $invoice = $this->_model->get($invoiceId);
        
        $paymentTbl = new PaymentsModel();
        $payments = $paymentTbl->getDetailsByInvoiceId($invoiceId);
        $paidAmount = 0;
        $payment = array();
        
        if(count($payments)) {
            foreach($payments as $row) {
                $paidAmount += $row['allocated_amt'];
                if(intval($row['tds_percent'])) {
                    $payment = $row;
                } 
            }
            if(empty($payment)) {
                $payment = $payments[0];
            }
            $payment['paid_amount'] = $paidAmount;
            $payment['balance_amt'] = $payment['receivable_amt'] - $paidAmount;
            unset($payment['allocated_amt']);
        }
        
        $invoice['payments'] = $payment;
        
        echo json_encode($invoice);
        
    }
    
    public function getInvoiceIdsByCustomer($custId) {
        $invoice = $this->_model->getInvoiceIdsByCustomer($custId);
        echo json_encode($invoice);
        
    }

    private function genInvoiceNo() {
        $newInvoiceNo = '';
        $prefix = date('Y');

        $lastRecord = $this->_model->getLastRecord();
        if($lastRecord) {
            $lastInvoiceNo = $lastRecord['invoice_no'];

            if(!empty($lastInvoiceNo)) {
                $inv = substr($lastInvoiceNo, -3);
                $prevprx = substr($lastInvoiceNo, 0, 4);

                $inv = ($inv + 1);
                if($prevprx != $prefix) {
                    $inv = '001';
                }
                $newInvoiceNo = $prefix.str_pad($inv, 3, 0, STR_PAD_LEFT);
            } else {
                $newInvoiceNo = $prefix.'001';
            }
        
        } else {
            $newInvoiceNo = $prefix.'001';
        }

        return $newInvoiceNo;



    }

    public function search() {

        $invoices = $this->_model->getList($_POST);
        
        $result = array(); 
        $result['draw'] = 1;
        $result['data'] = array();
        $result['recordsTotal'] = count($invoices);
        $result['recordsFiltered'] = count($invoices);

        foreach($invoices as $invoice) {
            $tmp = array();
            $tmp[] = $invoice['id'];
            $tmp[] = date('d, M Y',strtotime($invoice['invoice_date']));
            $tmp[] = $invoice['invoice_no'];
            $tmp[] = $invoice['po_no'];
            $tmp[] = $invoice['customer_name'];
            $tmp[] = $invoice['sales_person'];
            $tmp[] = $invoice['invoice_total'];
            $result['data'][] = $tmp;
        }

        

        echo json_encode($result);
        exit;
    }
    
    public function invoice_validty() {
        if(!empty($_POST)) {
             if($t = $this->_model->getRecordsByField('invoice_no', $_POST['invoice_no'])) {
                 echo 0;
             } else {
                echo true;
             }
        } else {
            echo false;
        }
    }

    public function proforma_validty() {
        if(!empty($_POST)) {
             if($t = $this->_model->proformaFieldRecord('invoice_no', $_POST['invoice_no'])) {
                 echo 0;
             } else {
                echo true;
             }
        } else {
            echo false;
        }
    }

    public function delete($invoiceNo) {
        $row = $this->_model->getByInvoiceNo($invoiceNo);

        if(!empty($row)) {
            $paymentTbl = new PaymentsModel();
            $payments = $paymentTbl->getDetailsByInvoiceId($row['id']);

            //print_r($payments); exit;

            if(empty($payments)) {
                $this->_model->deleteInvoice($invoiceNo);
                $invoiceItemTbl = new InvoiceItemsModel();
                $invoiceItemTbl->deleteByInvoiceId($row['id']);
                echo "<b><span style='color:green;'>invoice no. $invoiceNo deleted successfully!</span></b>";
            } else {
                echo "<b><span style='color:red;'>Record can't be deleted, have some payment records against invoice no. $invoiceNo.</span></b>";
            }
        } else {
            echo "<b><span style='color:red;'>No record for invoice no. $invoiceNo</span></b>";
        }


    }
}
// Jthayil Start
function getdeclaration($val) {
    if ($val != ""){
        return "<b>Declaration</b><br>" . $val;
    }else{
        return $val;
    }
}

function addressmaker($val) {
    $pieces = explode(",", $val);
    $maxlen = 0;
    $skippiece = 0;
    $jar = "";
    for ($x = 0; $x < count($pieces); $x++) {
        if ($x <= 2) {
            $jar = $jar . $pieces[$x] . ", ";
            if ($x == 2) {$maxlen = strlen($jar);$jar = $jar ."<br>";}
        } else if ($x == $skippiece){
            $skippiece = 0;
        } else if ($x == count($pieces)-1){
            $jar = $jar . $pieces[$x];
        } else {
            if ($x+1 <= count($pieces)-1 && strlen($pieces[$x]) + strlen($pieces[$x+1]) <= $maxlen + 3){
                if ($x+1 == count($pieces)-1){
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x+1] . ".";
                } else {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x+1] . ",<br>";
                }
                $skippiece = $x+1;
            } else {
                $jar = $jar . $pieces[$x] . ",<br>";
            }
        }
    }
    return $jar;
}

function footeraddress($val) {
    $pieces = explode(",", $val);
    $maxlen = 0;
    $skippiece = 0;
    $jar = "";
    for ($x = 0; $x < count($pieces); $x++) {
        if ($x <= 3) {
            $jar = $jar . $pieces[$x] . ", ";
            if ($x == 3) {$maxlen = strlen($jar);$jar = $jar ."<br>";}
        } else if ($x == $skippiece){
            $skippiece = 0;
        } else if ($x == count($pieces)-1){
            $jar = $jar . $pieces[$x];
        } else {
            if ($x+1 <= count($pieces)-1 && strlen($pieces[$x]) + strlen($pieces[$x+1]) <= $maxlen + 3){
                if ($x+1 == count($pieces)-1){
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x+1] . ".";
                } else {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x+1] . ",<br>";
                }
                $skippiece = $x+1;
            } else {
                $jar = $jar . $pieces[$x] . ",<br>";
            }
        }
    }
    return $jar;
}
// End