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
            
            if(!empty($_POST)) {
                $data = $_POST;
                
                //echo '<pre>'; print_r($data); exit;

                /*
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
                
                */
                
                //print_r($orderItems);
                //print_r($data); exit;
                $invoiceId = $this->_model->save($data);
                if($invoiceId) {
                    $this->generateInvoice($invoiceId);
                    /*
                    $tblInvoiceItem = new InvoiceItemsModel();
                    foreach($orderItems as $orderItem) {
                        $orderItem['invoice_id'] = $invoiceId;
                        $tblInvoiceItem->save($orderItem);
                    } */

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
            
            $customerList = new CustomersModel();
            $customer = $customerList->get($invoice['customer_id']);
            $this->_view->set('customer', $customer);
            
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
        
        $invoice = $this->_model->get($invoiceId);
        
        $customer = new CustomersModel();
        $customer = $customer->get($invoice['customer_id']);
        
        $orderTable = new OrdersModel();
        $order = $orderTable->get($invoice['order_id']);
        $oderItems = $orderTable->getOrderItem($invoice['order_id']);
        
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
            "{{CUST_ADDRESS}}" =>$customer['name']."<br />". $invoice['bill_to'],
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $customer['pan'],
            "{{CUST_GST}}" => $customer['gstin'],
            "{{CUST_SHIPTO}}" => $invoice['ship_to'],
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($invoice['invoice_total'], 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['invoice_total']),
        );
        
        $orderBaseTotal = 0.00;
        $itemList = '';
        foreach($oderItems as $key => $item) {
            $itemList .= '<tr>
            <td>'.($key+1).'</td>
            <td>'.$item['item'].'</td>
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