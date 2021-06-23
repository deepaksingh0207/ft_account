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
            $this->_view->set('title', 'Create Invoice');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                //echo '<pre>'; print_r($data); exit;

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
                

                foreach($data['item'] as $key => $item) {
                    $row = array();
                    $row['item'] = $data['item'][$key];
                    $row['description'] = $data['description'][$key];
                    $row['qty'] = $data['qty'][$key];
                    $row['uom_id'] = $data['uom'][$key];
                    $row['unit_price'] = $data['unit_price'][$key];
                    $row['total'] = $data['total'][$key];

                    $invoiceItems[] = $row;
                }
                
                

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
    
    public function generateInvoice($invoiceId) {
        
        $dataItem = array();
        
        $invoice = $this->_model->get($invoiceId);
        $invoiceItem = $this->_model->getInvoiceItem($invoiceId);
        
        $customerTbl = new CustomersModel();
        $customer = $customerTbl->get($invoice['customer_id']);
        
        $customerShipTo = $customerTbl->get($invoice['ship_to']);
        
        $orderTable = new OrdersModel();
        $order = $orderTable->get($invoice['order_id']);
        $oderItems = $orderTable->getOrderItem($invoice['order_id']);
        
        $descriptionAppendTxt = '';
        if(in_array($order['order_type'], array(1, 3, 4))) {
            $dataItem = $invoiceItem;
        } else if($order['order_type']  == 2) {
            $row = array();
            $row['description'] = $oderItems[0]['description'].'<br />'.$invoice['payment_description'];
            $row['qty'] = $invoice['pay_percent'];
            $row['unit_price'] = $invoice['order_total'];
            $row['total'] = $invoice['sub_total'];
            
            $dataItem[] = $row;
            
        } else {
            $dataItem =  $oderItems;
        }
        
        $company = new CompanyModel();
        $company = $company->get(1);
        
        
        $vars = array(
            "{{INV_NO}}" => $invoiceId,
            "{{INV_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
            "{{COMPANY_BILLTO}}" => $company['address'],
            "{{COMP_TEL}}" => $company['contact'],
            "{{COMP_PAN}}" => $company['pan'],
            "{{COMP_SAC}}" => $company['sac'],
            "{{COMP_GSTIN}}" => $company['gstin'],
            "{{COMP_BANK}}" => $company['bank_name'],
            "{{COMP_ACCNO}}" => $company['account_no'],
            "{{COMP_IFSC}}" => $company['ifsc_code'],
            "{{PO_NO}}" => $invoice['po_no'],
            "{{PO_DATE}}" => date('d/m/Y', strtotime($order['order_date'])),
            "{{CUST_ADDRESS}}" =>$customer['name']."<br />". $customer['address'],
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $customer['pan'],
            "{{CUST_GST}}" => $customer['gstin'],
            "{{CUST_SHIPTO}}" => $customerShipTo['address'],
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($invoice['invoice_total'], 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['invoice_total']),
        );
        
        $orderBaseTotal = 0.00;
        $itemList = '';
        foreach($dataItem as $key => $item) {
            $itemList .= '<tr>
            <td>'.($key+1).'</td>
            <td>'.$item['description'].'</td>
            <td>'.$item['qty'].'</td>
            <td>'.number_format($item['unit_price'], 2).'</td>
            <td>'.number_format($item['total'], 2).'</td>
            </tr>';
            
            $orderBaseTotal += $item['total'];
        }
        
        $taxesLayout = '';
        if((int)$invoice['igst']) {
            $taxesLayout = '<tr class="text-right bb">
            <td style="text-align: right; width: 94%">
              IGST @ 18% &nbsp; &nbsp;'.number_format($invoice['igst']).'
            </td>
          </tr><tr>
          <td colspan="5" style="padding: 0px">
            <hr style="padding: 0px; margin: 0px" />
          </td>
        </tr>';
        } else {
            $taxesLayout = '<tr>
            <td style="text-align: right; width: 94%">
              CGST @ 9% &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.number_format($invoice['cgst'], 2).'
              <br />
              SGST @ 9% &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.number_format($invoice['sgst'], 2).'
            </td>
          </tr>
          <tr>
            <td colspan="5" style="padding: 0px">
              <hr style="padding: 0px; margin: 0px" />
            </td>
          </tr>';
        }
        
        $vars["{{TAX_LAYOUT}}"] = $taxesLayout;
        $vars["{{ITEM_LIST}}"] = $itemList;
        $vars["{{ORDER_TOTAL}}"] = number_format($orderBaseTotal, 2);
        
        $messageBody = strtr(file_get_contents('./assets/mail_template/invoice_template.html'), $vars);
        
        require_once HOME . DS. 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf->WriteHTML($messageBody);
        $mpdf->Output('pdf/invoice_'.$invoice['id'].'.pdf', 'F');
        
        
        $this->sendMail($invoice, $customer);
    }
    
    function sendMail($invoice, $customer) {
        
        $sentMailTo = array();
        $sentMailTo = FXD_EMAIL_IDS;
        $sentMailTo[] = $customer['email'];
        
        try {
            $mailer = $this->_utils->getMailer();
            $message = (new Swift_Message("Invoice copy #$invoice[id] against PO $invoice[po_no]" ))
            ->setContentType("text/html")
            ->setFrom([HD_MAIL_ID => HD_NAME])
            ->setTo($sentMailTo)
            ->setBcc(FXD_EMAIL_IDS)
            ->setBody("Hi Sir/Mam, <br><br> PFA invoice <br><br><br><br> Regards,<br>Account")
            ->attach(
                Swift_Attachment::fromPath('./pdf/invoice_'.$invoice['id'].'.pdf')->setContentType('application/pdf')
                );
            
            // Send the message
            $result = $mailer->send($message);
            
            echo $result;
        } catch (Exception $e) {
            
            print_r($e);
            
        }
    }
    
}