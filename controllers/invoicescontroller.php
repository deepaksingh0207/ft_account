<?php
include 'vendor/phpqrcode/qrlib.php';
class InvoicesController extends Controller
{

    public function __construct($model, $action)
    {
        parent::__construct($model, $action);
        $this->_setModel("invoices");
    }

    public function index()
    {

        try {

            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            //  echo '<pre>'; print_r($customers);exit;
            //$invoices = $this->_model->getList();
            //$this->_view->set('invoices', $invoices);
            $this->_view->set('title', 'Invoice List');
            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function creditNotesItemByOrderId($orderId)
    {
        $creditnotesItemList = new CreditnotesModel();
        $creditLists = $creditnotesItemList->creditNoteListByOrderId($orderId);

        if ($creditLists && !empty($creditLists)) {
            echo json_encode($creditLists);
        } else {

            echo json_encode(['message' => 'No credit notes found for this invoice.']);
        }
    }

    public function create()
    {
        try {
            $this->_view->set('title', 'Create Invoice');

            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);

            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);

            if (!empty($_POST)) {
                $data = $_POST;
                // echo '<pre>'; print_r($data);
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
                $invoiceeData['payment_term'] = isset($data['payment_term']) ? $data['payment_term'] : null;
                $invoiceeData['pay_percent'] = isset($data['pay_percent']) ? $data['pay_percent'] : null;
                $invoiceeData['payment_description'] = isset($data['payment_description']) ? $data['payment_description'] : null;
                $invoiceeData['remarks'] = $data['remarks'];
                $invoiceeData['due_date'] = $data['due_date'];
                $invoiceeData['exchange_rate'] = $data['exchangerate'];

                //$invoiceeData['invoice_no'] = $this->genInvoiceNo();
                $invoiceeData['invoice_no'] = $data['invoice_no'];
                $invoiceeData['hide_po'] = isset($data['hidepo']) ? ($data['hidepo'] == "on" ? 1 : 0) : 0;
                // echo '<pre>'; print_r($invoiceeData); exit;
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

                foreach ($data['order_details'] as $item) {
                    $orderItem = array();
                    $orderItem['order_item_id'] = $item['order_item_id'];
                    $orderItem['order_payterm_id'] = $item['order_payterm_id'];
                    $orderItem['item'] = $item['item'];
                    if ($isProformaInvoice == false) {
                        $orderItem['proforma_invoice_item_id'] = $item['proforma_invoice_item_id'];
                    }
                    $orderItem['description'] = $item['description'];
                    $orderItem['qty'] = $item['qty'];
                    $orderItem['uom_id'] = $item['uom_id'];
                    $orderItem['unit_price'] = $item['unit_price'];
                    $orderItem['total'] = $item['total'];
                    $orderItem['hsn_id'] = $item['hsn_id'];

                    $invoiceItems[] = $orderItem;
                }

                if ($isProformaInvoice) {
                    $tblProformaInvoice = new ProformaInvoicesModel();
                    // echo '<pre>'; print_r($invoiceeData); exit;
                    $invoiceId = $tblProformaInvoice->save($invoiceeData);
                    if ($invoiceId) {
                        $tblInvoiceItem = new ProformaInvoiceItemsModel();
                        foreach ($invoiceItems as $invoiceItem) {
                            $invoiceItem['proforma_invoice_id'] = $invoiceId;
                            $tblInvoiceItem->save($invoiceItem);
                        }

                        $this->geninv($invoiceId, true, true, $invoiceeData['hide_po']);

                        $_SESSION['message'] = 'Invoice added successfully';
                        header("location:" . ROOT . "invoices");
                    } else {
                        $_SESSION['error'] = 'Fail to add invoice';
                    }
                } else {

                    $invoiceId = $this->_model->save($invoiceeData);
                    if ($invoiceId) {
                        $tblInvoiceItem = new InvoiceItemsModel();
                        $tblPayments = new PaymentsModel();
                        foreach ($invoiceItems as $invoiceItem) {
                            if ($isProformaInvoice == false && $invoiceItem['proforma_invoice_item_id'] != 0) {
                                $tblPayments->upd_paytrm_inv_id($invoiceItem['proforma_invoice_item_id'], $invoiceId);
                            }
                            $invoiceItem['invoice_id'] = $invoiceId;
                            $tblInvoiceItem->save($invoiceItem);
                        }

                        // $this->geninv($invoiceId, true, false, $invoiceeData['hide_po']);

                        // $this->postEinvoiceRequest($invoiceId);

                        $_SESSION['message'] = 'Invoice added successfully';
                        header("location:" . ROOT . "invoices");
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

    public function view($id)
    {
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

    public function getTaxesRate($customerId)
    {
        try {
            $customer = new CustomersModel();
            $customer = $customer->get($customerId);

            $company = new CompanyModel();
            $company = $company->get(1);

            $itMaster = new ItMasterModel();
            $itMaster = $itMaster->get(1);


            $result = array();
            //   $result['cnt_code'] = $customer['cnt_code'];
            if ($customer['state'] == $company['state']) {
                $result['state'] = 'same';
                $result['cgst'] = $itMaster['cgst'];
                $result['sgst'] = $itMaster['sgst'];
            } else {
                $result['state'] = 'other';
                $result['igst'] = $itMaster['igst'];
            }
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function geninv($invoiceId = null, $proformaSwitch = false, $createpdf = false, $hidepo = false)
    {
        $dataItem = array();
        $invoice = array();
        $invoiceItems = array();
        $tblProformaInvoice = new ProformaInvoicesModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $customerTbl = new CustomersModel();
        $orderTable = new OrdersModel();
        $orderItemsTable = new OrderItemsModel();
        $company = new CompanyModel();
        $hsn = new HsnModel();
        $totalbr = 10;
        if (!empty($_POST)) {
            $data = $_POST;
            if (!$invoiceId) {
                $invoiceId = ($this->_model->getLastId() + 1);
            }
            $proformaSwitch = (isset($data['proforma']) && $data['proforma'] == 1) ? true : false;
            $nri = (isset($data['nri']) && $data['nri'] == 1) ? true : false;

            $hidepo = isset($data['hidepo']) ? ($data['hidepo'] == "on" ? true : false) : false;

            $invoice['invoice_no'] = $data['invoice_no'];
            $invoice['group_id'] = $data['group_id'];
            $invoice['customer_id'] = $data['customer_id'];
            $invoice['order_id'] = $data['order_id'];
            // $invoice['invoice_date'] = date('Y/m/d');
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
            $invoice['exchange_rate'] = isset($data['exchangerate']) ? $data['exchangerate'] : null;
            $invoice['payment_term'] = isset($data['payment_term']) ? $data['payment_term'] : null;
            $invoice['pay_percent'] = isset($data['pay_percent']) ? $data['pay_percent'] : null;
            $invoice['payment_description'] = isset($data['payment_description']) ? $data['payment_description'] : null;
            $invoice['hide_po'] = $hidepo;
            $invoice['remarks'] = $data['remarks'];

            foreach ($data['order_details'] as $item) {
                $orderItem = array();
                $orderItem['order_item_id'] = $item['order_item_id'];
                $orderItem['order_payterm_id'] = $item['order_payterm_id'];
                $orderItem['item'] = $item['item'];
                $orderItem['description'] = $item['description'];
                $orderItem['qty'] = $item['qty'];
                $orderItem['uom_id'] = $item['uom_id'];
                $orderItem['hsn_id'] = $item['hsn_id'];
                $orderItem['unit_price'] = $item['unit_price'];
                $orderItem['total'] = $item['total'];
                if ($item['total'] > 0) {
                    $invoiceItems[] = $orderItem;
                    $totalbr--;
                }
            }
        } else {
            $invoice = $this->_model->get($invoiceId);
            $hidepo = $invoice['hide_po'];
            $invoiceItems = $this->_model->getInvoiceItem($invoiceId);
            if ($proformaSwitch && $invoiceId) {
                $invoice = $tblProformaInvoice->get($invoiceId);
                $invoiceItems = $tblProformaInvoice->getInvoiceItem($invoiceId);
            }
            foreach ($invoiceItems as $item) {
                $totalbr--;
            }
        }

        $company = $company->get(1);

        $customer = $customerTbl->get($invoice['customer_id']);

        $customer2 = $customerTbl->get($invoice['bill_to']);

       
        $customerShipTo = $customerTbl->get($invoice['ship_to']);
        $nri = $customer['country'] == '101' ? false : true;
        $order = $orderTable->get($invoice['order_id']);
        $oderItems = $orderTable->getOrderItem($invoice['order_id']);
            // echo '<pre>'; print_r($order['currency_code']);

        $hide_qty = true;
        foreach ($invoiceItems as $key => $item) {
            $oderItems = $orderItemsTable->get($item['order_item_id']);
            if (in_array($oderItems['order_type'], array(4, 6, 7, 99))) {
                $hide_qty = false;
            }
        }

        $print_uom_qty = '<th class="bb2 w-135">HSN Code</th><th class="bb2 txtc">Qty.</th><th class="bb2 txtc">Unit</th>';
        if ($hide_qty) {
            $print_uom_qty = '<th class="bb2 w-135">HSN Code</th><th class="bb2 txtc"></th><th class="bb2 txtc"></th>';
        }
        $dataItem = $invoiceItems;
        $irn = '';
        $slt = '';
        $qrcode = '';
        $irndt = '';
        $currencyCode = $order['currency_code'] ?? 'INR';
        $irnrec = $invoiceIrnTbl->getByInvoiceId($invoiceId);

        if (count($irnrec) && !$proformaSwitch) {
            $totalbr -= 2;
            $irn = '<tr><td colspan="2" class="bn2"><b>IRN No: ' . $irnrec['irn_no'] . '</b></td></tr>';
            $irndt = '<tr><td class="blt2r"><b>IRN Date: ' . $irnrec['ack_date'] . '</b></td>';

            if ($nri) {
                $slt = '<td class="brt2l"><b>Supply Type: EXPWOP</b></td></tr>';
            } else {
                $slt = '<td class="brt2l"><b>Supply Type: B2B</b></td></tr>';
            }
            $file = ROOT . "assets/qr_code/" . $irnrec['ack_no'] . ".png";
            if (!file_exists("assets/qr_code/" . $irnrec['ack_no'] . ".png")) {
                QRcode::png($irnrec['signed_qrcode'], "assets/qr_code/" . $irnrec['ack_no'] . ".png", 'L', 150, 1);
            }
            $qrcode = '<img src="' . $file . '" title="QR Code" width="150px" />';
        }

        $br = "<tr><td colspan='6'>";
        for ($i = 1; $i < ($totalbr / 2 - 1); $i++) {
            $br .= '<br>';
        }
        $br .= "</td></tr>";
        $vars = array(
            "{{IRN}}" => $irn,
            "{{IRN_DATE}}" => $irndt,
            "{{SLT}}" => $slt,
            "{{QR_CODE}}" => $qrcode,
            "{{INV_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
            "{{COMPANY_BILLTO}}" => addressmaker($company['address']),
            "{{BILLTO_ADDRESS}}" => addressmaker($company['address'], 6),
            "{{COMP_TEL}}" => $company['contact'],
            "{{COMP_PAN}}" => $company['pan'],
            "{{COMP_SAC}}" => $company['sac'],
            "{{COMP_GSTIN}}" => $company['gstin'],
            "{{COMP_BANK}}" => $company['bank_name'],
            "{{COMP_ACCNO}}" => $company['account_no'],
            "{{COMP_IFSC}}" => $company['ifsc_code'],
            "{{COMP_SWIFT}}" => $company['swift_code'],
            "{{PO_NO}}" => "Purchase Order No.: " . $invoice['po_no'],
            "{{ORDER_TYPE}}" => $print_uom_qty,
            "{{PO_DATE}}" => date('d/m/Y', strtotime($order['order_date'])),
            "{{CUST_ADDRESS}}" => "<b>" . $customer2['name'] . "</b><br />" . addressmaker($customer2['address'], 3),
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{DECLARATION}}" => getdeclaration($customer['declaration'], $totalbr),
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $nri ? '' : $customer['pan'],
            "{{CUST_GST}}" => $nri ? '' : $customer2['gstin'],
            "{{CUST_SHIPTO}}" => "<b>" . $customer['name'] . "</b><br />" . addressmaker($customerShipTo['address'], 3),
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($invoice['invoice_total'], 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['invoice_total'], $nri, $currencyCode),
            "{{REST_BR}}" => $br,
            "{{NRI}}" => $nri ? "hide" : '',
            "{{NONNRI}}" => $nri ? "" : 'hide',
            "{{CURRENCY}}" => $nri ? $order['currency_code'] : 'INR',
            "{{TOTAL_TERMS}}" => $nri ? "invoice Amount" : 'value including taxes',
            "{{PAY_TERM}}" => 'Against Invoice within 30 days',
            "{{GROSS_AMOUNT}}" => $nri ? 'Gross Amount : ' . number_format((float)$invoice['exchange_rate'] * $invoice['invoice_total'], 2) . ' INR' : '',
            "{{EXCHANGE_RATE}}" => $nri ? 'Exchange Rate : 1 ' . $order['currency_code'] .  ' = ' . number_format((float)$invoice['exchange_rate'], 2) . ' INR' : '',
        );

        if ($proformaSwitch) {
            $vars["{{INV_NO}}"] = "PI No.: PI" . $invoice['invoice_no'];
            $vars["{{TITLE}}"] = "PROFORMA INVOICE";
        } else {
            $vars["{{INV_NO}}"] = $nri ? "Invoice No: " . $invoice['invoice_no'] : "Invoice No: " . $invoice['invoice_no'];
            if (!$nri) {
                $vars["{{TITLE}}"] = "TAX INVOICE";
            } else {
                $vars["{{TITLE}}"] = "TAX CUM EXPORT INVOICE";
            }
        }

        if ($hidepo) {
            $vars["{{PO_NO}}"] = "Purchase Order No.: As per mail";
        }

        $orderBaseTotal = 0.00;
        $itemList = '';
        $keys = array_key_last($dataItem);
        // echo '<pre>'; print_r($keys); exit;
        foreach ($dataItem as $key => $item) {
            $hsncode = $hsn->get($item['hsn_id']);
            $oderItems = $orderItemsTable->get($item['order_item_id']);
            if ($keys == $key && 0 == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pb-1 pt-1">' . ($key + 1) . '</td><td class="pb-1 pt-1">' . $item['description'] . '</td><td class="txtc pb-1 pt-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pb-1 pt-1"></td><td class="pb-1 pt-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pb-1 pt-1">' . $item['qty'] . '</td><td class="txtc pb-1 pt-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pb-1 pt-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else if ($keys == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pb-1">' . ($key + 1) . '</td><td class=" pb-1">' . $item['description'] . '</td><td class="txtc pb-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pb-1"></td><td class="pb-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pb-1">' . $item['qty'] . '</td><td class="txtc pb-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pb-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else if (0 == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pt-1">' . ($key + 1) . '</td><td class=" pt-1">' . $item['description'] . '</td><td class="txtc pt-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pt-1"></td><td class="pt-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pt-1">' . $item['qty'] . '</td><td class="txtc pt-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pt-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else {
                $itemList .= '<tr class="txtsmr"><td class="txtc">' . ($key + 1) . '</td><td>' . $item['description'] . '</td><td class="txtc">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td></td><td></td>';
                } else {
                    $itemList .= '<td class="txtc">' . $item['qty'] . '</td><td class="txtc">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc">' . number_format($item['total'], 2) . '</td></tr>';
            }
            $orderBaseTotal += $item['total'];
        }

        // echo '<pre>'; print_r($itemList); exit;

        if ($nri || in_array($order['order_type'], array(6))) {
            $vars["{{TDS}}"] = "";
        } else {
            $vars["{{TDS}}"] = "<li>TDS should be Deduct @10% As per Sec.194J.</li>";
        }
        $taxName = '';
        $taxesLayout = '';
        if (!$nri) {
            if (intval($invoice['igst'])) {
                $taxName = "IGST @ 18%";
                $taxesLayout = number_format($invoice['igst'], 2);
            } else {
                $taxName = "CGST @ 9%<br />SGST @ 9%";
                $taxesLayout = number_format($invoice['cgst'], 2) . '<br />' . number_format($invoice['sgst'], 2);
            }
        } else {
            $taxName = "GST";
            $taxesLayout = "-";
        }

        $vars["{{GST_LABEL}}"] = $taxName;
        $vars["{{GST_VALUE}}"] = $taxesLayout;
        $vars["{{ITEM_LIST}}"] = $itemList;
        $vars["{{ORDER_TOTAL}}"] = number_format($orderBaseTotal, 2);
        $vars["{{URL}}"] = ROOT;


        $messageBody = strtr(file_get_contents('./assets/mail_template/invoiceTemplate.html'), $vars);

        if (!$createpdf) {
            echo $messageBody;
        } else {
            require_once HOME . DS . 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->WriteHTML($messageBody);
            $mpdf->SetHTMLFooter('<hr style="margin: 0px 0px 0px 0px;" />
            <p style="text-align: center;font-size: small;">
            ' . footeraddress($company['address']) . ' Tel.: ' . $company['contact'] . '<br />
            Email: account@fts-pl.com Website: http://www.fts-pl.com
            </p>');
            if ($proformaSwitch) {
                $mpdf->Output('pdf/proforma_' . $invoice['invoice_no'] . '.pdf', 'F');
            } else {
                $mpdf->Output('pdf/invoice_' . $invoice['invoice_no'] . '.pdf', 'F');
            }
        }
    }

    public function gencbn($creditNoteId = null, $proformaSwitch = false, $createpdf = false, $hidepo = false)
    {
        $dataItem = array();
        $invoice = array();
        $invoiceItems = array();
        $tblProformaInvoice = new ProformaInvoicesModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $customerTbl = new CustomersModel();
        $CreditNoteItemTbl = new CreditNotesModel();
        $orderTable = new OrdersModel();
        $orderItemsTable = new OrderItemsModel();
        $company = new CompanyModel();
        $hsn = new HsnModel();
        $totalbr = 10;
        $nri = '';
        $invoice = $CreditNoteItemTbl->get($creditNoteId);
        // $invoice = $this->_model->get(107);
        $hidepo = $invoice['hide_po'];
        // $invoiceItems = $this->_model->getInvoiceItemForCreditNote($invoiceId);
        $invoiceItems = $CreditNoteItemTbl->getCreditNoteItem($creditNoteId);
        //  echo '<pre>'; print_r($invoice);
        if ($proformaSwitch && $creditNoteId) {
            $invoice = $tblProformaInvoice->get($invoice['invoice_id']);
            $invoiceItems = $tblProformaInvoice->getInvoiceItem($invoice['invoice_id']);
        }
        foreach ($invoiceItems as $item) {
            $totalbr--;
        }

        $company = $company->get(1);
        $customer = $customerTbl->get($invoice['customer_id']);
        $customerShipTo = $customerTbl->get($invoice['ship_to']);
        $nri = $customer['country'] == '101' ? false : true;
        $order = $orderTable->get($invoice['order_id']);
        
        $oderItems = $orderTable->getOrderItem($invoice['order_id']);
        $hide_qty = true;

        foreach ($invoiceItems as $key => $item) {
            $oderItems = $orderItemsTable->get($item['order_item_id']);
            if (in_array($oderItems['order_type'], array(4, 6, 7, 99))) {
                $hide_qty = false;
            }
        }

        $print_uom_qty = '<th class="bb2 w-135">HSN Code</th><th class="bb2 txtc">Qty.</th><th class="bb2 txtc">Unit</th>';
        if ($hide_qty) {
            $print_uom_qty = '<th class="bb2 w-135">HSN Code</th><th class="bb2 txtc"></th><th class="bb2 txtc"></th>';
        }
        $dataItem = $invoiceItems;
        // echo '<pre>'; print_r($invoice);
        $irn = '';
        $slt = '';
        $qrcode = '';
        $irndt = '';
        $currencyCode = $order['currency_code'] ?? 'INR';
        $irnrec = $CreditNoteItemTbl->getByCreditNoteId($creditNoteId);
        //   echo '<pre>'; print_r($irnrec);exit;
        if (count($irnrec) && !$proformaSwitch) {
            $totalbr -= 2;
            $irn = '<tr><td colspan="2" class="bn2"><b>IRN No: ' . $irnrec['irn_no'] . '</b></td></tr>';
            $irndt = '<tr><td class="blt2r"><b>IRN Date: ' . $irnrec['ack_date'] . '</b></td>';

            if ($nri) {
                $slt = '<td class="brt2l"><b>Supply Type: EXPWOP</b></td></tr>';
            } else {
                $slt = '<td class="brt2l"><b>Supply Type: B2B</b></td></tr>';
            }
            $file = ROOT . "assets/qr_code/" . $irnrec['ack_no'] . ".png";
            if (!file_exists("assets/qr_code/" . $irnrec['ack_no'] . ".png")) {
                QRcode::png($irnrec['signed_qrcode'], "assets/qr_code/" . $irnrec['ack_no'] . ".png", 'L', 150, 1);
            }
            $qrcode = '<img src="' . $file . '" title="QR Code" width="150px" />';
        }
        $br = "<tr><td colspan='6'>";
        for ($i = 1; $i < ($totalbr / 2 - 1); $i++) {
            $br .= '<br>';
        }
        $br .= "</td></tr>";

        $vars = array(
            "{{IRN}}" => $irn,
            "{{IRN_DATE}}" => $irndt,
            "{{SLT}}" => $slt,
            "{{QR_CODE}}" => $qrcode,
            "{{CREDIT_NOTE_DATE}}" => date('d/m/Y', strtotime($invoice['credit_date'])),
            "{{COMPANY_BILLTO}}" => addressmaker($company['address']),
            "{{BILLTO_ADDRESS}}" => addressmaker($company['address'], 6),
            "{{COMP_TEL}}" => $company['contact'],
            "{{COMP_PAN}}" => $company['pan'],
            "{{COMP_SAC}}" => $company['sac'],
            "{{COMP_GSTIN}}" => $company['gstin'],
            "{{COMP_BANK}}" => $company['bank_name'],
            "{{COMP_ACCNO}}" => $company['account_no'],
            "{{COMP_IFSC}}" => $company['ifsc_code'],
            "{{COMP_SWIFT}}" => $company['swift_code'],
            "{{PO_NO}}" => "Invoice No.: " . $invoice['invoice_no'],
            "{{ORDER_TYPE}}" => $print_uom_qty,
            "{{INVOICE_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
            "{{CUST_ADDRESS}}" => "<b>" . $customer['name'] . "</b><br />" . addressmaker($customer['address'], 3),
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{DECLARATION}}" => getdeclaration($customer['declaration'], $totalbr),
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $nri ? '' : 'PAN No.: ' . $customer['pan'],
            "{{CUST_GST}}" => $nri ? '' : 'GST No.: ' . $customer['gstin'],
            "{{CUST_SHIPTO}}" => "<b>" . $customer['name'] . "</b><br />" . addressmaker($customerShipTo['address'], 3),
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($invoice['credit_note_total'], 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($invoice['credit_note_total'], $nri, $currencyCode),
            "{{REST_BR}}" => $br,
            "{{CURRENCY}}" => $nri ? $order['currency_code'] : 'INR',
            "{{TOTAL_TERMS}}" => $nri ? "Amount" : 'value including taxes',
            "{{PAY_TERM}}" => 'Against Invoice within 30 days',
            "{{GROSS_AMOUNT}}" => $nri ? 'Gross Amount : ' . number_format((float)$invoice['exchange_rate'] * $invoice['credit_note_total'], 2) . ' INR' : '',
            "{{EXCHANGE_RATE}}" => $nri ? 'Exchange Rate : 1 ' . $order['currency_code'] .  ' = ' . number_format((float)$invoice['exchange_rate'], 2) . ' INR' : '',
            "{{FOREIGN_CURRENCY}}" => $order['currency_code'],
        );

        $vars["{{CREDIT_NO}}"] = $nri ? "Credit Note No: CR-" . $invoice['credit_note_no'] : "Credit Note No : CR-" . $invoice['credit_note_no'];
        if (!$nri) {
            $vars["{{TITLE}}"] = "CREDIT NOTE";
        } else {
            $vars["{{TITLE}}"] = "TAX CUM EXPORT CREDIT NOTE";
        }

        if ($hidepo) {
            $vars["{{PO_NO}}"] = "Purchase Order No.: As per mail";
        }
        $orderBaseTotal = 0.00;
        $itemList = '';
        $keys = array_key_last($dataItem);
        foreach ($dataItem as $key => $item) {
            $hsncode = $hsn->get($invoice['hsn_id']);
            $oderItems = $orderItemsTable->get($item['order_item_id']);
            // print_r($item);
            if ($keys == $key && 0 == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pb-1 pt-1">' . ($key + 1) . '</td><td class="pb-1 pt-1">' . $item['description'] . '</td><td class="txtc pb-1 pt-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pb-1 pt-1"></td><td class="pb-1 pt-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pb-1 pt-1">' . $item['qty'] . '</td><td class="txtc pb-1 pt-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pb-1 pt-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else if ($keys == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pb-1">' . ($key + 1) . '</td><td class=" pb-1">' . $item['description'] . '</td><td class="txtc pb-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pb-1"></td><td class="pb-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pb-1">' . $item['qty'] . '</td><td class="txtc pb-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pb-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else if (0 == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pt-1">' . ($key + 1) . '</td><td class=" pt-1">' . $item['description'] . '</td><td class="txtc pt-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td class="pt-1"></td><td class="pt-1"></td>';
                } else {
                    $itemList .= '<td class="txtc pt-1">' . $item['qty'] . '</td><td class="txtc pt-1">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc pt-1">' . number_format($item['total'], 2) . '</td></tr>';
            } else {
                $itemList .= '<tr class="txtsmr"><td class="txtc">' . ($key + 1) . '</td><td>' . $item['description'] . '</td><td class="txtc">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5))) {
                    $itemList .= '<td></td><td></td>';
                } else {
                    $itemList .= '<td class="txtc">' . $item['qty'] . '</td><td class="txtc">' . number_format($item['unit_price'], 2) . '</td>';
                }
                $itemList .= '<td class="txtc">' . number_format($item['total'], 2) . '</td></tr>';
            }
            $orderBaseTotal += $item['total'];
        }

        //echo '<pre>'; print_r($item['igst']);

        if (in_array($order['order_type'], array(6))) {
            $vars["{{TDS}}"] = "";
        } else {
            $vars["{{TDS}}"] = "<li>TDS should be Deduct @10% As per Sec.194J.</li>";
        }

        $taxName = '';
        $taxesLayout = '';

        if (!$nri) {

            if ($invoice['igst'] > 0) {
                $taxName = "IGST @ 18%";
                $taxesLayout = number_format($invoice['igst'], 2);
            } else {
                $taxName = "CGST @ 9%<br />SGST @ 9%";
                $taxesLayout = number_format($invoice['cgst'], 2) . '<br />' . number_format($invoice['sgst'], 2);
            }
        } else {
            $taxName = "GST";
            $taxesLayout = "-";
        }

        $vars["{{GST_LABEL}}"] = $taxName;
        $vars["{{GST_VALUE}}"] = $taxesLayout;
        $vars["{{ITEM_LIST}}"] = $itemList;
        $vars["{{ORDER_TOTAL}}"] = number_format($orderBaseTotal, 2);
        $vars["{{URL}}"] = ROOT;
        $messageBody = strtr(file_get_contents('./assets/mail_template/creditNoteTemplate.html'), $vars);
        if (!$createpdf) {
            echo $messageBody;
        } else {
            require_once HOME . DS . 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->WriteHTML($messageBody);
            $mpdf->SetHTMLFooter('<hr style="margin: 0px 0px 0px 0px;" />
            <p style="text-align: center;font-size: small;">
            ' . footeraddress($company['address']) . ' Tel.: ' . $company['contact'] . '<br />
            Email: account@fts-pl.com Website: http://www.fts-pl.com
            </p>');
            if ($proformaSwitch) {
                $mpdf->Output('pdf/proforma_' . $invoice['invoice_no'] . '.pdf', 'F');
            } else {
                $mpdf->Output('pdf/invoice_' . $invoice['invoice_no'] . '.pdf', 'F');
            }
        }
    }

    function sendMail($invoice, $customer)
    {

        $sentMailTo = array();
        $sentMailTo = FXD_EMAIL_IDS;
        $sentMailTo[] = $customer['email'];

        try {
            $mailer = $this->_utils->getMailer();
            $message = (new Swift_Message("Invoice copy #$invoice[invoice_no] against PO $invoice[po_no]"))
                ->setContentType("text/html")
                ->setFrom([HD_MAIL_ID => HD_NAME])
                ->setTo($sentMailTo)
                ->setBcc(FXD_EMAIL_IDS)
                ->setBody("Hi Sir/Mam, <br><br> PFA invoice <br><br><br><br> Regards,<br>Account")
                ->attach(
                    Swift_Attachment::fromPath('./pdf/invoice_' . $invoice['invoice_no'] . '.pdf')->setContentType('application/pdf')
                );

            // Send the message
            $result = $mailer->send($message);
            echo $result;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function getDetails($invoiceId)
    {
        $invoice = $this->_model->get($invoiceId);

        $paymentTbl = new PaymentsModel();
        $payments = $paymentTbl->getDetailsByInvoiceId($invoiceId);
        $paidAmount = 0;
        $payment = array();

        if (count($payments)) {
            foreach ($payments as $row) {
                $paidAmount += $row['allocated_amt'];
                if (intval($row['tds_percent'])) {
                    $payment = $row;
                }
            }
            if (empty($payment)) {
                $payment = $payments[0];
            }
            $payment['paid_amount'] = $paidAmount;
            $payment['balance_amt'] = $payment['receivable_amt'] - $paidAmount;
            unset($payment['allocated_amt']);
        }

        $invoice['payments'] = $payment;

        echo json_encode($invoice);
    }

    public function getInvoiceIdsByCustomer($custId)
    {
        $invoice = $this->_model->getInvoiceIdsByCustomer($custId);
        echo json_encode($invoice);
    }

    private function genInvoiceNo()
    {
        $newInvoiceNo = '';
        $prefix = date('Y');

        $lastRecord = $this->_model->getLastRecord();
        if ($lastRecord) {
            $lastInvoiceNo = $lastRecord['invoice_no'];

            if (!empty($lastInvoiceNo)) {
                $inv = substr($lastInvoiceNo, -3);
                $prevprx = substr($lastInvoiceNo, 0, 4);

                $inv = ($inv + 1);
                if ($prevprx != $prefix) {
                    $inv = '001';
                }
                $newInvoiceNo = $prefix . str_pad($inv, 3, 0, STR_PAD_LEFT);
            } else {
                $newInvoiceNo = $prefix . '001';
            }
        } else {
            $newInvoiceNo = $prefix . '001';
        }

        return $newInvoiceNo;
    }

    public function search()
    {
        $invoices = $this->_model->getList($_POST);
        // echo '<pre>'; print_r($invoices); exit;

        $result = array();
        $result['draw'] = 1;
        $result['data'] = array();
        $result['recordsTotal'] = count($invoices);
        $result['recordsFiltered'] = count($invoices);

        foreach ($invoices as $invoice) {
            $tmp = array();
            $tmp[] = $invoice['id'];
            $tmp[] = date('d, M Y', strtotime($invoice['invoice_date']));
            $tmp[] = $invoice['invoice_no'];
            $tmp[] = $invoice['po_no'];
            $tmp[] = $invoice['customer_name'];
            $tmp[] = $invoice['sales_person'];
            $tmp[] = $invoice['invoice_total'];
            $tmp[] = $invoice['customer_country'];
            $result['data'][] = $tmp;
        }
        echo json_encode($result);
        exit;
    }

    public function invoice_validty()
    {
        if (!empty($_POST)) {
            if ($t = $this->_model->check_invoice_validty($_POST['invoice_no'])) {
                echo 0;
            } else {
                echo 1;
            }
        } else {
            echo 0;
        }
    }

    public function check_invoice_validty($invoice_no = null)
    {
        if ($t = $this->_model->check_invoice_validty($invoice_no)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function proforma_validty()
    {
        if (!empty($_POST)) {
            if ($t = $this->_model->proformaFieldRecord('invoice_no', $_POST['invoice_no'])) {
                echo 0;
            } else {
                echo true;
            }
        } else {
            echo false;
        }
    }

    public function delete($invoiceNo)
    {
        $row = $this->_model->getByInvoiceNo($invoiceNo);

        if (!empty($row)) {
            $paymentTbl = new PaymentsModel();
            $payments = $paymentTbl->getDetailsByInvoiceId($row['id']);

            //print_r($payments); exit;

            if (empty($payments)) {
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

    //einvoice 
    function getEinvoiceAuthToken()
    {
        $url = EINVOICE_URL . 'eivital/dec/v1.04/auth?';
        $params = array('aspid' => ASP_ID, 'password' => EINVOICE_PASSWORD, 'user_name' => EINVOICE_USERNAME, 'Gstin' => GST_NO, 'eInvPwd' => EINVPWD);
        $url = $url . http_build_query($params);

        // echo '<pre>'; print_r($url);

        $response = $this->sendRequest('GET', $url, $params);
        $data = json_decode($response, true);
        // print_r($data);
        return $data;
    }

    function updateCreditNote($invoiceIrnId, $creditnote = null)
    {
        $invoiceIrnTbl = new InvoiceIrnModel();
        $irnrec = $invoiceIrnTbl->updateCreditNote($invoiceIrnId, $invoiceId);
        $data = json_decode($irnrec, true);
        return $data;
    }


    function postEinvoiceRequest($invoiceId, $invoiceNo = 0)
    {
        $hsn = new HsnModel();
        $customerList = new CustomersModel();
        $invoiceItemTbl = new InvoiceItemsModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $company = new CompanyModel();
        $company = $company->get(1);

        $invoice = $this->_model->getByID($invoiceId);
        if ($invoiceNo != 0) {
            $invoice['invoice_no'] = $invoiceNo;
            $invoice['invoice_date'] = date('Y/m/d');
        }
        // echo '<pre>'; print_r($invoiceNo); exit;
        $this->_model->update($invoiceId, $invoice);
        $dataItem = $invoiceItemTbl->getListByInvoiceId($invoiceId);
        $customer = $customerList->get($invoice['customer_id']);
        $authToken = $this->getEinvoiceAuthToken();
        $url = EINVOICE_URL . 'eicore/dec/v1.03/Invoice?';

        //  echo '<pre>'; print_r($customer['country_name']); exit;

        if ($authToken['Status'] == 1) {
            $params = array('aspid' => ASP_ID, 'password' => EINVOICE_PASSWORD, 'user_name' => EINVOICE_USERNAME, 'Gstin' => GST_NO, 'AuthToken' => $authToken['Data']['AuthToken']);
            $url = $url . http_build_query($params);


            $request = array();
            $request['VERSION'] = '1.1';
            $request['TRANDTLS']['TAXSCH'] = 'GST';
            $request['TRANDTLS']['SUPTYP'] = 'B2B';
            $request['TRANDTLS']['REGREV'] = 'N';

            //Invoice no
            //Docdtails
            $request['DOCDTLS']['TYP'] = 'INV';
            if ($invoiceNo != 0) {
                $request['DOCDTLS']['NO'] = $invoiceNo;
            } else {
                $request['DOCDTLS']['NO'] = $invoice['invoice_no'];
            }
            $request['DOCDTLS']['DT'] = date('d/m/Y');

            //FTSPL Details seller
            $request['SELLERDTLS']['GSTIN'] = GST_NO;
            $request['SELLERDTLS']['LGLNM'] = $company['name'];
            $request['SELLERDTLS']['TRDNM'] = $company['name'];
            $request['SELLERDTLS']['ADDR1'] = substr($company['address'], 0, 100);
            $request['SELLERDTLS']['ADDR2'] = null;
            $request['SELLERDTLS']['LOC'] = 'INDIA';
            $request['SELLERDTLS']['PIN'] = (int)$company['pincode'];
            $request['SELLERDTLS']['STCD'] = substr($company['gstin'], 0, 2);
            $request['SELLERDTLS']['PH'] = null;
            $request['SELLERDTLS']['EM'] = null;

            //Client Details
            $request['BUYERDTLS']['GSTIN'] = $customer['gstin'];
            $request['BUYERDTLS']['LGLNM'] = $customer['name'];
            $request['BUYERDTLS']['TRDNM'] = $customer['name'];
            $request['BUYERDTLS']['POS'] = substr($customer['gstin'], 0, 2);
            $request['BUYERDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['BUYERDTLS']['ADDR2'] = null;
            $request['BUYERDTLS']['LOC'] = 'INDIA';
            $request['BUYERDTLS']['PIN'] = (int)$customer['pincode'];
            $request['BUYERDTLS']['STCD'] = substr($customer['gstin'], 0, 2);
            $request['BUYERDTLS']['PH'] = null;
            $request['BUYERDTLS']['EM'] = null;

            $request['DISPDTLS']['NM'] = $company['name'];
            $request['DISPDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['DISPDTLS']['ADDR2'] = null;
            $request['DISPDTLS']['LOC'] = 'INDIA';
            $request['DISPDTLS']['PIN'] = (int)$company['pincode'];
            $request['DISPDTLS']['STCD'] = substr($company['gstin'], 0, 2);

            //Item list
            $request['ITEMLIST'] = array();

            foreach ($dataItem as $key => $item) {
                $tmp = array();
                $hsncode = $hsn->get($item['hsn_id']);
                $tmp['SLNO'] = (string)$key;
                $tmp['PRDDESC'] = $item['description'];
                $tmp['ISSERVC'] = substr($hsncode['code'], 0, 2) == '99' ? 'Y' : 'N';
                $tmp['HSNCD'] = $hsncode['code'];
                $tmp['BARCDE'] = null;
                $tmp['QTY'] = (float)$item['qty'];
                $tmp['FREEQTY'] = 0;
                $tmp['UNIT'] = 'NOS';
                $tmp['UNITPRICE'] = (float)$item['unit_price'];
                $tmp['TOTAMT'] = (float)$item['total'];
                $tmp['DISCOUNT'] = 0;
                $tmp['PRETAXVAL'] = 0;
                $tmp['ASSAMT'] = (float)$item['total'];
                $tmp['GSTRT'] = 18;
                if ($invoice['igst'] > 0) {
                    $tmp['IGSTAMT'] = number_format((float)($item['total'] * $tmp['GSTRT']) / 100, 2, '.', '');
                    $tmp['CGSTAMT'] = 0;
                    $tmp['SGSTAMT'] = 0;
                } else {
                    $tmp['IGSTAMT'] = 0;
                    $tmp['CGSTAMT'] = number_format((float)($item['total'] * ($tmp['GSTRT'] / 100)) / 2, 2, '.', '');
                    $tmp['SGSTAMT'] = number_format((float)($item['total'] * ($tmp['GSTRT'] / 100)) / 2, 2, '.', '');
                }
                $tmp['CESRT'] = 0;
                $tmp['CESAMT'] = 0;
                $tmp['CESNONADVLAMT'] = 0;
                $tmp['STATECESRT'] = 0;
                $tmp['STATECESAMT'] = 0;
                $tmp['STATECESNONADVLAMT'] = 0;
                $tmp['OTHCHRG'] = 0;
                $tmp['TOTITEMVAL'] = number_format((float)$item['total'] + $tmp['IGSTAMT'] + $tmp['CGSTAMT'] + $tmp['SGSTAMT'], 2, '.', '');
                $tmp['ORDLINEREF'] = null;
                $tmp['ORGCNTRY'] = null;

                $request['ITEMLIST'][] = $tmp;
            }

            //Value detail
            $request['VALDTLS']['ASSVAL'] = (float)$invoice['sub_total'];
            $request['VALDTLS']['CGSTVAL'] = (float)$invoice['cgst'];
            $request['VALDTLS']['SGSTVAL'] = (float)$invoice['sgst'];
            $request['VALDTLS']['IGSTVAL'] = (float)$invoice['igst'];
            $request['VALDTLS']['CESVAL'] = 0;
            $request['VALDTLS']['STCESVAL'] = 0;
            $request['VALDTLS']['RNDOFFAMT'] = 0;
            $request['VALDTLS']['TOTINVVAL'] = number_format((float)$invoice['invoice_total'], 2, '.', '');
            $request['VALDTLS']['TOTINVVALFC'] = number_format((float)$invoice['invoice_total'], 2, '.', '');

            $request['EXPDTLS']['SHIPBNO'] = null;
            $request['EXPDTLS']['SHIPBDT'] = null;
            $request['EXPDTLS']['PORT'] = null;
            $request['EXPDTLS']['REFCLM'] = null;
            $request['EXPDTLS']['FORCUR'] = null;
            $request['EXPDTLS']['CNTCODE'] = null;
            $request['EXPDTLS']['EXPDUTY'] = 0;

            $request['EWBDTLS']['TRANSID'] = null;
            $request['EWBDTLS']['TRANSNAME'] = null;
            $request['EWBDTLS']['TRANSMODE'] = null;
            $request['EWBDTLS']['DISTANCE'] = 0;
            $request['EWBDTLS']['TRANSDOCNO'] = null;
            $request['EWBDTLS']['TRANSDOCDT'] = null;
            $request['EWBDTLS']['VEHNO'] = null;
            $request['EWBDTLS']['VEHTYPE'] = null;


            // echo '<pre>'; print_r($request); exit;
            //echo $url;
            $response = $this->sendRequest('POST', $url, $request);
            $data = json_decode($response, true);

            //echo '<pre>'; print_r($data); print_r($url);

            if ($data['Status']) {
                $newdata = json_decode($data['Data'], true);
                $irn_invoice = array();
                $irn_invoice['invoice_id'] = $invoiceId;
                if ($invoiceNo != 0) {
                    $irn_invoice['invoice_no'] = $invoiceNo;
                } else {
                    $irn_invoice['invoice_no'] = $invoice['invoice_no'];
                }
                $irn_invoice['irn_no'] = $newdata['Irn'];
                $irn_invoice['ack_no'] = $newdata['AckNo'];
                $irn_invoice['ack_date'] = $newdata['AckDt'];
                $irn_invoice['signed_invoice'] = $newdata['SignedInvoice'];
                $irn_invoice['signed_qrcode'] = $newdata['SignedQRCode'];
                $irn_invoice['status'] = 1;
                $irnInvoiceId = $invoiceIrnTbl->save($irn_invoice);

                // $path variable store the location where to  
                // store image and $file creates directory name 
                $path = "assets/img/";
                $file = $path . $newdata['AckNo'] . ".png";

                // Generates QR Code and Stores it in directory given 
                QRcode::png($newdata['SignedQRCode'], $file, 'L', 150, 1);

                echo $irnInvoiceId;
            } else {
                echo $response;
            }
        } else {
            echo $authToken['ErrorDetails'][0]['ErrorMessage'];
        }
    }

    function exportPostEinvoiceRequest($invoiceId, $invoiceNo = 0)
    {
        $hsn = new HsnModel();
        $customerList = new CustomersModel();
        $invoiceItemTbl = new InvoiceItemsModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $company = new CompanyModel();
        $company = $company->get(1);

        $invoice = $this->_model->getByID($invoiceId);
        if (!empty($invoiceNo)) {
            $invoice['invoice_no'] = $invoiceNo;
            $invoice['invoice_date'] = date('Y/m/d');
        }
        // print_r($invoice);
        $this->_model->update($invoiceId, $invoice);
        $dataItem = $invoiceItemTbl->getListByInvoiceId($invoiceId);
        $customer = $customerList->get($invoice['customer_id']);
        $authToken = $this->getEinvoiceAuthToken();
        $url = EINVOICE_URL . 'eicore/dec/v1.03/Invoice?';

        //  echo '<pre>'; print_r($customer); exit;

        if ($authToken['Status'] == 1) {
            $params = array('aspid' => ASP_ID, 'password' => EINVOICE_PASSWORD, 'user_name' => EINVOICE_USERNAME, 'Gstin' => GST_NO, 'AuthToken' => $authToken['Data']['AuthToken']);
            $url = $url . http_build_query($params);

            // echo '<pre>'; print_r($invoiceNo); exit;

            $request = array();
            $request['VERSION'] = '1.1';
            $request['TRANDTLS']['TAXSCH'] = 'GST';
            $request['TRANDTLS']['SUPTYP'] = 'EXPWOP';
            $request['TRANDTLS']['REGREV'] = 'N';

            //Invoice no
            //Docdtails
            // echo '<pre>'; print_r($invoiceNo); exit;

            $request['DOCDTLS']['TYP'] = 'INV';
            if ($invoiceNo != 0) {
                $request['DOCDTLS']['NO'] = $invoiceNo;
            } else {
                $request['DOCDTLS']['NO'] = $invoice['invoice_no'];
            }
            $request['DOCDTLS']['DT'] = date('d/m/Y');

            //FTSPL Details seller
            $request['SELLERDTLS']['GSTIN'] = GST_NO;
            $request['SELLERDTLS']['LGLNM'] = $company['name'];
            $request['SELLERDTLS']['TRDNM'] = null;
            $request['SELLERDTLS']['ADDR1'] = substr($company['address'], 0, 100);
            $request['SELLERDTLS']['ADDR2'] = null;
            $request['SELLERDTLS']['LOC'] = 'INDIA';
            $request['SELLERDTLS']['PIN'] = (int)$company['pincode'];
            $request['SELLERDTLS']['STCD'] = substr($company['gstin'], 0, 2);
            $request['SELLERDTLS']['PH'] = null;
            $request['SELLERDTLS']['EM'] = null;

            //Client Details
            // $request['BUYERDTLS']['GSTIN'] = $customer['gstin'];
            $request['BUYERDTLS']['GSTIN'] = 'URP';
            $request['BUYERDTLS']['LGLNM'] = $customer['name'];
            $request['BUYERDTLS']['TRDNM'] = $customer['name'];
            $request['BUYERDTLS']['POS'] = '96';
            $request['BUYERDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['BUYERDTLS']['ADDR2'] = null;
            $request['BUYERDTLS']['LOC'] = $customer['country_name'];
            $request['BUYERDTLS']['PIN'] = (int)$customer['pincode'];
            $request['BUYERDTLS']['STCD'] = '96';
            $request['BUYERDTLS']['PH'] = null;
            $request['BUYERDTLS']['EM'] = null;

            $request['DISPDTLS']['NM'] = $company['name'];
            $request['DISPDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['DISPDTLS']['ADDR2'] = null;
            $request['DISPDTLS']['LOC'] = $customer['country_name'];
            $request['DISPDTLS']['PIN'] = (int)$company['pincode'];
            $request['DISPDTLS']['STCD'] = substr($company['gstin'], 0, 2);

            //Item list
            $request['ITEMLIST'] = array();

            foreach ($dataItem as $key => $item) {
                $tmp = array();
                $hsncode = $hsn->get($item['hsn_id']);
                $tmp['SLNO'] = (string)$key;
                $tmp['PRDDESC'] = $item['description'];
                $tmp['ISSERVC'] = substr($hsncode['code'], 0, 2) == '99' ? 'Y' : 'N';
                $tmp['HSNCD'] = $hsncode['code'];
                $tmp['BARCDE'] = null;
                $tmp['QTY'] = (float)$item['qty'];
                $tmp['FREEQTY'] = 0;
                $tmp['UNIT'] = 'OTH';
                $tmp['UNITPRICE'] = (float)$item['unit_price'];
                $tmp['TOTAMT'] = ((float)$item['total']) * ($invoice['exchange_rate']);
                $tmp['DISCOUNT'] = 0;
                $tmp['PRETAXVAL'] = 0;
                $tmp['ASSAMT'] = ((float)$item['total']) * ($invoice['exchange_rate']);
                $tmp['GSTRT'] = 0;
                $tmp['CGSTAMT'] = 0;
                $tmp['SGSTAMT'] = 0;
                $tmp['IGSTAMT'] = 0;

                $tmp['CESRT'] = 0;
                $tmp['CESAMT'] = 0;
                $tmp['CESNONADVLAMT'] = 0;
                $tmp['STATECESRT'] = 0;
                $tmp['STATECESAMT'] = 0;
                $tmp['STATECESNONADVLAMT'] = 0;
                $tmp['OTHCHRG'] = 0;
                $tmp['TOTITEMVAL'] = number_format((float)$item['total'] * (float)$invoice['exchange_rate'], 2, '.', '');

                $tmp['ORDLINEREF'] = null;
                $tmp['ORGCNTRY'] = null;

                $request['ITEMLIST'][] = $tmp;
            }

            //Value detail
            $request['VALDTLS']['ASSVAL']  = number_format((float)$invoice['invoice_total'] * (float)$invoice['exchange_rate'], 2, '.', '');
            $request['VALDTLS']['CGSTVAL'] = 0;
            $request['VALDTLS']['SGSTVAL'] = 0;
            $request['VALDTLS']['IGSTVAL'] = 0;
            $request['VALDTLS']['CESVAL'] = 0;
            $request['VALDTLS']['STCESVAL'] = 0;
            $request['VALDTLS']['RNDOFFAMT'] = 0;
            $request['VALDTLS']['TOTINVVAL'] = number_format((float)$invoice['invoice_total'] * (float)$invoice['exchange_rate'], 2, '.', '');
            $request['VALDTLS']['TOTINVVALFC'] = 0;

            $request['EXPDTLS']['SHIPBNO'] = null;
            $request['EXPDTLS']['SHIPBDT'] = null;
            $request['EXPDTLS']['PORT'] = null;
            $request['EXPDTLS']['REFCLM'] = null;
            $request['EXPDTLS']['FORCUR'] = null;
            $request['EXPDTLS']['CNTCODE'] = $customer['cnt_code'];
            $request['EXPDTLS']['EXPDUTY'] = 0;

            // echo '<pre>'; print_r($request);exit;
            // $request['EWBDTLS']['TRANSID'] = null;
            // $request['EWBDTLS']['TRANSNAME'] = null;
            // $request['EWBDTLS']['TRANSMODE'] = null;
            // $request['EWBDTLS']['DISTANCE'] = 0;
            // $request['EWBDTLS']['TRANSDOCNO'] = null;
            // $request['EWBDTLS']['TRANSDOCDT'] = null;
            // $request['EWBDTLS']['VEHNO'] = null;
            // $request['EWBDTLS']['VEHTYPE'] = null;
            //echo $url;
            // echo '<pre>'; print_r($request);exit;
            $response = $this->sendRequest('POST', $url, $request);
            $data = json_decode($response, true);

            //echo '<pre>'; print_r($data); print_r($url);

            if ($data['Status']) {
                $newdata = json_decode($data['Data'], true);
                $irn_invoice = array();
                $irn_invoice['invoice_id'] = $invoiceId;
                if (!empty($invoiceNo)) {
                    $irn_invoice['invoice_no'] = $invoiceNo;
                } else {
                    $irn_invoice['invoice_no'] = $invoice['invoice_no'];
                }
                $irn_invoice['irn_no'] = $newdata['Irn'];
                $irn_invoice['ack_no'] = $newdata['AckNo'];
                $irn_invoice['ack_date'] = $newdata['AckDt'];
                $irn_invoice['signed_invoice'] = $newdata['SignedInvoice'];
                $irn_invoice['signed_qrcode'] = $newdata['SignedQRCode'];
                $irn_invoice['status'] = 1;
                $irnInvoiceId = $invoiceIrnTbl->save($irn_invoice);

                // $path variable store the location where to  
                // store image and $file creates directory name 
                $path = "assets/img/";
                $file = $path . $newdata['AckNo'] . ".png";

                // Generates QR Code and Stores it in directory given 
                QRcode::png($newdata['SignedQRCode'], $file, 'L', 150, 1);

                echo $irnInvoiceId;
            } else {
                echo $response;
            }
        } else {
            echo $authToken['ErrorDetails'][0]['ErrorMessage'];
        }
    }


    function exportPostCreditNoteRequest($creditNoteId, $credit_note_no = 0)
    {
        $hsn = new HsnModel();
        $customerList = new CustomersModel();
        // $invoiceItemTbl = new InvoiceItemsModel();
        $creditNotes = new CreditNotesModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $company = new CompanyModel();
        $company = $company->get(1);

        $invoice = $creditNotes->getByID($creditNoteId);
        $dataItem = $creditNotes->getListBycreditNoteId($creditNoteId);
        //  echo '<pre>'; print_r($dataItem);exit;
        $customer = $customerList->get($invoice['customer_id']);
        $authToken = $this->getEinvoiceAuthToken();
        $url = EINVOICE_URL . 'eicore/dec/v1.03/Invoice?';
        if ($authToken['Status'] == 1) {
            $params = array('aspid' => ASP_ID, 'password' => EINVOICE_PASSWORD, 'user_name' => EINVOICE_USERNAME, 'Gstin' => GST_NO, 'AuthToken' => $authToken['Data']['AuthToken']);
            $url = $url . http_build_query($params);



            $request = array();
            $request['VERSION'] = '1.1';

            $request['TRANDTLS']['TAXSCH'] = 'GST';
            $request['TRANDTLS']['SUPTYP'] = 'EXPWOP';
            $request['TRANDTLS']['REGREV'] = 'N';

            //Invoice no
            $request['DOCDTLS']['TYP'] = 'CRN';
            $request['DOCDTLS']['NO'] = $invoice['credit_note_no'];
            $request['DOCDTLS']['DT'] = date('d/m/Y');

            //FTSPL Details
            $request['SELLERDTLS']['GSTIN'] = GST_NO;
            $request['SELLERDTLS']['LGLNM'] = $company['name'];
            $request['SELLERDTLS']['TRDNM'] = null;
            $request['SELLERDTLS']['ADDR1'] = substr($company['address'], 0, 100);
            $request['SELLERDTLS']['ADDR2'] = null;
            $request['SELLERDTLS']['LOC'] = 'INDIA';
            $request['SELLERDTLS']['PIN'] = (int)$company['pincode'];
            $request['SELLERDTLS']['STCD'] = substr($company['gstin'], 0, 2);
            $request['SELLERDTLS']['PH'] = null;
            $request['SELLERDTLS']['EM'] = null;

            //Client Details
            $request['BUYERDTLS']['GSTIN'] = 'URP';
            $request['BUYERDTLS']['LGLNM'] = $customer['name'];
            $request['BUYERDTLS']['TRDNM'] = $customer['name'];
            $request['BUYERDTLS']['POS'] = '96';
            $request['BUYERDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['BUYERDTLS']['ADDR2'] = null;
            $request['BUYERDTLS']['LOC'] = $customer['country_name'];
            $request['BUYERDTLS']['PIN'] = (int)$customer['pincode'];
            $request['BUYERDTLS']['STCD'] = '96';
            $request['BUYERDTLS']['PH'] = null;
            $request['BUYERDTLS']['EM'] = null;

            // $request['DISPDTLS']['NM'] = $company['name'];
            // $request['DISPDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            // $request['DISPDTLS']['ADDR2'] = null;
            // $request['DISPDTLS']['LOC'] = 'INDIA';
            // $request['DISPDTLS']['PIN'] = (int)$company['pincode'];
            // $request['DISPDTLS']['STCD'] = substr($company['gstin'], 0, 2);

            //Item list
            $request['ITEMLIST'] = array();
            foreach ($dataItem as $key => $item) {
                $tmp = array();
                $hsncode = $hsn->get($item['hsn_id']);
                $tmp['SLNO'] = (string)$key;
                $tmp['PRDDESC'] = $item['description'];
                $tmp['ISSERVC'] = substr($hsncode['code'], 0, 2) == '99' ? 'Y' : 'N';
                $tmp['HSNCD'] = $hsncode['code'];
                $tmp['BARCDE'] = null;
                $tmp['QTY'] = (float)$item['qty'];
                $tmp['FREEQTY'] = 0;
                $tmp['UNIT'] = 'OTH';
                $tmp['UNITPRICE'] = (float)$item['unit_price'];
                $tmp['TOTAMT'] = (float)$item['total'];
                $tmp['DISCOUNT'] = 0;
                $tmp['PRETAXVAL'] = 0;
                $tmp['ASSAMT'] = (float)$item['total'];
                $tmp['GSTRT'] = 0;
                $tmp['CGSTAMT'] = 0;
                $tmp['SGSTAMT'] = 0;
                $tmp['IGSTAMT'] = 0;

                $tmp['CESRT'] = 0;
                $tmp['CESAMT'] = 0;
                $tmp['CESNONADVLAMT'] = 0;
                $tmp['STATECESRT'] = 0;
                $tmp['STATECESAMT'] = 0;
                $tmp['STATECESNONADVLAMT'] = 0;
                $tmp['OTHCHRG'] = 0;
                $tmp['TOTITEMVAL'] = number_format((float)$item['total'], 2, '.', '');
                $tmp['ORDLINEREF'] = null;
                $tmp['ORGCNTRY'] = null;

                $request['ITEMLIST'][] = $tmp;
            }

            //Value detail
            $request['VALDTLS']['ASSVAL'] = (float)$invoice['sub_total'];
            $request['VALDTLS']['CGSTVAL'] = 0;
            $request['VALDTLS']['SGSTVAL'] = 0;
            $request['VALDTLS']['IGSTVAL'] = 0;
            $request['VALDTLS']['CESVAL'] = 0;
            $request['VALDTLS']['STCESVAL'] = 0;
            $request['VALDTLS']['RNDOFFAMT'] = 0;
            $request['VALDTLS']['TOTINVVAL'] = number_format((float)$invoice['credit_note_total'], 2, '.', '');
            $request['VALDTLS']['TOTINVVALFC'] = number_format((float)$invoice['credit_note_total'], 2, '.', '');

            $request['EXPDTLS']['SHIPBNO'] = null;
            $request['EXPDTLS']['SHIPBDT'] = null;
            $request['EXPDTLS']['PORT'] = null;
            $request['EXPDTLS']['REFCLM'] = null;
            $request['EXPDTLS']['FORCUR'] = null;
            $request['EXPDTLS']['CNTCODE'] = $customer['cnt_code'];
            $request['EXPDTLS']['EXPDUTY'] = 0;

            $request['EWBDTLS']['TRANSID'] = null;
            $request['EWBDTLS']['TRANSNAME'] = null;
            $request['EWBDTLS']['TRANSMODE'] = null;
            $request['EWBDTLS']['DISTANCE'] = 0;
            $request['EWBDTLS']['TRANSDOCNO'] = null;
            $request['EWBDTLS']['TRANSDOCDT'] = null;
            $request['EWBDTLS']['VEHNO'] = null;
            $request['EWBDTLS']['VEHTYPE'] = null;


            //   echo '<pre>'; print_r($request); 
            $response = $this->sendRequest('POST', $url, $request);
            $data = json_decode($response, true);
            // echo '<pre>'; print_r($data);exit;
            if ($data['Status']) {
                $this->_model->cancelAllIRN($creditNoteId);
                $newdata = json_decode($data['Data'], true);
                // echo '<pre>'; print_r($newdata);exit;
                $irn_invoice = array();
                $irn_invoice['invoice_id'] = $invoice['invoice_id'];
                $irn_invoice['invoice_no'] = $invoice['invoice_no'];
                $irn_invoice['credit_note_id'] = $creditNoteId;
                $irn_invoice['credit_note_no'] = $invoice['credit_note_no'];
                $irn_invoice['irn_no'] = $newdata['Irn'];
                $irn_invoice['ack_no'] = $newdata['AckNo'];
                $irn_invoice['ack_date'] = $newdata['AckDt'];
                $irn_invoice['signed_invoice'] = $newdata['SignedInvoice'];
                $irn_invoice['signed_qrcode'] = $newdata['SignedQRCode'];
                $irn_invoice['status'] = 1;
                $irnInvoiceId = $invoiceIrnTbl->saveCreditNoteIrn($irn_invoice);
                $path = "assets/img/";
                $file = $path . $newdata['AckNo'] . ".png";

                // Generates QR Code and Stores it in directory given 
                QRcode::png($newdata['SignedQRCode'], $file, 'L', 150, 1);
                echo $irnInvoiceId;
            } else {
                echo $response;
            }
        } else {
            echo $authToken['ErrorDetails'][0]['ErrorMessage'];
        }
    }


    function postCreditNoteRequest($creditNoteId, $credit_note_no = 0)
    {
        $hsn = new HsnModel();
        $customerList = new CustomersModel();
        // $invoiceItemTbl = new InvoiceItemsModel();
        $creditNotes = new CreditNotesModel();
        $invoiceIrnTbl = new InvoiceIrnModel();
        $company = new CompanyModel();
        $company = $company->get(1);

        $invoice = $creditNotes->getByID($creditNoteId);
        $dataItem = $creditNotes->getListBycreditNoteId($creditNoteId);

        //  echo '<pre>'; print_r($dataItem);exit;
        $customer = $customerList->get($invoice['customer_id']);
        $authToken = $this->getEinvoiceAuthToken();
        $url = EINVOICE_URL . 'eicore/dec/v1.03/Invoice?';
        if ($authToken['Status'] == 1) {
            $params = array('aspid' => ASP_ID, 'password' => EINVOICE_PASSWORD, 'user_name' => EINVOICE_USERNAME, 'Gstin' => GST_NO, 'AuthToken' => $authToken['Data']['AuthToken']);
            $url = $url . http_build_query($params);



            $request = array();
            $request['VERSION'] = '1.1';

            $request['TRANDTLS']['TAXSCH'] = 'GST';
            $request['TRANDTLS']['SUPTYP'] = 'B2B';
            $request['TRANDTLS']['REGREV'] = 'N';

            //Invoice no
            $request['DOCDTLS']['TYP'] = 'CRN';
            $request['DOCDTLS']['NO'] = 'CR' . $invoice['credit_note_no'];
            $request['DOCDTLS']['DT'] = date('d/m/Y');

            //FTSPL Details
            $request['SELLERDTLS']['GSTIN'] = GST_NO;
            $request['SELLERDTLS']['LGLNM'] = $company['name'];
            $request['SELLERDTLS']['TRDNM'] = $company['name'];
            $request['SELLERDTLS']['ADDR1'] = substr($company['address'], 0, 100);
            $request['SELLERDTLS']['ADDR2'] = null;
            $request['SELLERDTLS']['LOC'] = 'INDIA';
            $request['SELLERDTLS']['PIN'] = (int)$company['pincode'];
            $request['SELLERDTLS']['STCD'] = substr($company['gstin'], 0, 2);
            $request['SELLERDTLS']['PH'] = null;
            $request['SELLERDTLS']['EM'] = null;

            //Client Details
            $request['BUYERDTLS']['GSTIN'] = $customer['gstin'];
            $request['BUYERDTLS']['LGLNM'] = $customer['name'];
            $request['BUYERDTLS']['TRDNM'] = $customer['name'];
            $request['BUYERDTLS']['POS'] = substr($customer['gstin'], 0, 2);
            $request['BUYERDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['BUYERDTLS']['ADDR2'] = null;
            $request['BUYERDTLS']['LOC'] = 'INDIA';
            $request['BUYERDTLS']['PIN'] = (int)$customer['pincode'];
            $request['BUYERDTLS']['STCD'] = substr($customer['gstin'], 0, 2);
            $request['BUYERDTLS']['PH'] = null;
            $request['BUYERDTLS']['EM'] = null;

            $request['DISPDTLS']['NM'] = $company['name'];
            $request['DISPDTLS']['ADDR1'] = substr($customer['address'], 0, 100);
            $request['DISPDTLS']['ADDR2'] = null;
            $request['DISPDTLS']['LOC'] = 'INDIA';
            $request['DISPDTLS']['PIN'] = (int)$company['pincode'];
            $request['DISPDTLS']['STCD'] = substr($company['gstin'], 0, 2);

            //Item list
            $request['ITEMLIST'] = array();
            foreach ($dataItem as $key => $item) {
                $tmp = array();
                $hsncode = $hsn->get($item['hsn_id']);
                $tmp['SLNO'] = (string)$key;
                $tmp['PRDDESC'] = $item['description'];
                $tmp['ISSERVC'] = substr($hsncode['code'], 0, 2) == '99' ? 'Y' : 'N';
                $tmp['HSNCD'] = $hsncode['code'];
                $tmp['BARCDE'] = null;
                $tmp['QTY'] = (float)$item['qty'];
                $tmp['FREEQTY'] = 0;
                $tmp['UNIT'] = 'NOS';
                $tmp['UNITPRICE'] = (float)$item['unit_price'];
                $tmp['TOTAMT'] = (float)$item['total'];
                $tmp['DISCOUNT'] = 0;
                $tmp['PRETAXVAL'] = 0;
                $tmp['ASSAMT'] = (float)$item['total'];
                $tmp['GSTRT'] = 18;
                if ($invoice['igst'] > 0) {
                    $tmp['IGSTAMT'] = number_format((float)($item['total'] * $tmp['GSTRT']) / 100, 2, '.', '');
                    $tmp['CGSTAMT'] = 0;
                    $tmp['SGSTAMT'] = 0;
                } else {
                    $tmp['IGSTAMT'] = 0;
                    $tmp['CGSTAMT'] = number_format((float)($item['total'] * ($tmp['GSTRT'] / 100)) / 2, 2, '.', '');
                    $tmp['SGSTAMT'] = number_format((float)($item['total'] * ($tmp['GSTRT'] / 100)) / 2, 2, '.', '');
                }
                $tmp['CESRT'] = 0;
                $tmp['CESAMT'] = 0;
                $tmp['CESNONADVLAMT'] = 0;
                $tmp['STATECESRT'] = 0;
                $tmp['STATECESAMT'] = 0;
                $tmp['STATECESNONADVLAMT'] = 0;
                $tmp['OTHCHRG'] = 0;
                $tmp['TOTITEMVAL'] = number_format((float)$item['total'] + $tmp['IGSTAMT'] + $tmp['CGSTAMT'] + $tmp['SGSTAMT'], 2, '.', '');
                $tmp['ORDLINEREF'] = null;
                $tmp['ORGCNTRY'] = null;

                $request['ITEMLIST'][] = $tmp;
            }

            //Value detail
            $request['VALDTLS']['ASSVAL'] = (float)$invoice['sub_total'];
            $request['VALDTLS']['CGSTVAL'] = (float)$invoice['cgst'];
            $request['VALDTLS']['SGSTVAL'] = (float)$invoice['sgst'];
            $request['VALDTLS']['IGSTVAL'] = (float)$invoice['igst'];
            $request['VALDTLS']['CESVAL'] = 0;
            $request['VALDTLS']['STCESVAL'] = 0;
            $request['VALDTLS']['RNDOFFAMT'] = 0;
            $request['VALDTLS']['TOTINVVAL'] = number_format((float)$invoice['credit_note_total'], 2, '.', '');
            $request['VALDTLS']['TOTINVVALFC'] = number_format((float)$invoice['credit_note_total'], 2, '.', '');

            $request['EXPDTLS']['SHIPBNO'] = null;
            $request['EXPDTLS']['SHIPBDT'] = null;
            $request['EXPDTLS']['PORT'] = null;
            $request['EXPDTLS']['REFCLM'] = null;
            $request['EXPDTLS']['FORCUR'] = null;
            $request['EXPDTLS']['CNTCODE'] = null;
            $request['EXPDTLS']['EXPDUTY'] = 0;

            $request['EWBDTLS']['TRANSID'] = null;
            $request['EWBDTLS']['TRANSNAME'] = null;
            $request['EWBDTLS']['TRANSMODE'] = null;
            $request['EWBDTLS']['DISTANCE'] = 0;
            $request['EWBDTLS']['TRANSDOCNO'] = null;
            $request['EWBDTLS']['TRANSDOCDT'] = null;
            $request['EWBDTLS']['VEHNO'] = null;
            $request['EWBDTLS']['VEHTYPE'] = null;


            //   echo '<pre>'; print_r($request); 
            $response = $this->sendRequest('POST', $url, $request);
            $data = json_decode($response, true);
            // echo '<pre>'; print_r($data);exit;
            if ($data['Status']) {
                $this->_model->cancelAllIRN($creditNoteId);
                $newdata = json_decode($data['Data'], true);
                // echo '<pre>'; print_r($newdata);exit;
                $irn_invoice = array();
                $irn_invoice['invoice_id'] = $invoice['invoice_id'];
                $irn_invoice['invoice_no'] = $invoice['invoice_no'];
                $irn_invoice['credit_note_id'] = $creditNoteId;
                $irn_invoice['credit_note_no'] = $invoice['credit_note_no'];
                $irn_invoice['irn_no'] = $newdata['Irn'];
                $irn_invoice['ack_no'] = $newdata['AckNo'];
                $irn_invoice['ack_date'] = $newdata['AckDt'];
                $irn_invoice['signed_invoice'] = $newdata['SignedInvoice'];
                $irn_invoice['signed_qrcode'] = $newdata['SignedQRCode'];
                $irn_invoice['status'] = 1;
                $irnInvoiceId = $invoiceIrnTbl->saveCreditNoteIrn($irn_invoice);
                $path = "assets/img/";
                $file = $path . $newdata['AckNo'] . ".png";

                // Generates QR Code and Stores it in directory given 
                QRcode::png($newdata['SignedQRCode'], $file, 'L', 150, 1);
                echo $irnInvoiceId;
            } else {
                echo $response;
            }
        } else {
            echo $authToken['ErrorDetails'][0]['ErrorMessage'];
        }
    }

    function sendRequest($method, $url, $data)
    {
        // print_r($method);print_r($url);print_r($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',));

        if (strtoupper($method) == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $info = curl_errno($ch) > 0 ? array("curl_error_" . curl_errno($ch) => curl_error($ch)) : curl_getinfo($ch);
        //print_r($response);
        curl_close($ch);
        return $response;
    }



    function cancelEinvoice($irn)
    {
        $authToken = $this->getEinvoiceAuthToken();


        if ($authToken['Status'] == 1) {
            $params = array(
                'aspid' => ASP_ID,
                'password' => EINVOICE_PASSWORD,
                'user_name' => EINVOICE_USERNAME,
                'Gstin' => GST_NO,
                'AuthToken' => $authToken['Data']['AuthToken']
            );

            $url = EINVOICE_URL . 'eicore/dec/v1.03/Cancel?' . http_build_query($params);

            $request = array(
                'IRN' => $irn,
                'CnlRsn' => '1',
                'CnlRem' => 'Invoice created by mistake',
                // 'CnlDt' => date('d/m/Y') 
            );
            $response = $this->sendRequest('POST', $url, $request);

            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "Invalid response from API: " . $response;
                return;
            }

            if ($data['Status']) {
                echo "E-invoice cancelled successfully.";
            } else {
                echo "Cancellation failed: " . $data['ErrorDetails'][0]['ErrorMessage'];
            }
        } else {
            echo "Auth Error: " . $authToken['ErrorDetails'][0]['ErrorMessage'];
        }
    }


    function cancelEinvoiceRequest($Id)
    {
        try {
            $invoiceirn = $this->_model->getListByInvoiceId($Id);
            $invoiceirn['status'] = 0;
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}
// Jthayil Start
function getdeclaration($val, $brcount)
{
    if ($val != "") {
        return "<tr><td colspan='6'><b>Declaration</b><br>" . $val . "<br></td></tr>";
    }
    $br = "<tr><td colspan='6'><br>";
    for ($i = 1; $i < ($brcount / 2); $i++) {
        $br .= '<br>';
    }
    $br .= "</td></tr>";
    // print_r(($brcount/2));
    return $br;
}

function addressmaker($val, $firstLineBreak = 2)
{
    $pieces = explode(",", $val);
    $maxlen = 0;
    $skippiece = 0;
    $jar = "";
    // echo '<pre>';print_r($pieces); print_r(count($pieces));
    for ($x = 0; $x < count($pieces); $x++) {
        if ($x <= $firstLineBreak) {
            // print_r("0.".$x);
            $jar = $jar . $pieces[$x] . ", ";
            if ($x == $firstLineBreak) {
                $maxlen = strlen($jar);
                $jar = $jar . "<br>";
            }
        } else if ($x == $skippiece) {
            // print_r(" 1.".$x);
            $skippiece = 0;
        } else if ($x == count($pieces) - 1) {
            // print_r(" 2.".$x);
            $jar = $jar . $pieces[$x];
        } else {
            // print_r(" 3.".$x);
            if ($x + 1 <= count($pieces) - 1 && strlen($pieces[$x]) + strlen($pieces[$x + 1]) <= $maxlen + 3) {
                if ($x + 1 == count($pieces) - 1) {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x + 1] . ".";
                } else {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x + 1] . ",<br>";
                }
                $skippiece = $x + 1;
            } else {
                $jar = $jar . $pieces[$x] . ",<br>";
            }
        }
    }
    // print_r($jar);
    return $jar;
}

function footeraddress($val)
{
    $pieces = explode(",", $val);
    $maxlen = 0;
    $skippiece = 0;
    $jar = "";
    for ($x = 0; $x < count($pieces); $x++) {
        if ($x <= 3) {
            $jar = $jar . $pieces[$x] . ", ";
            if ($x == 3) {
                $maxlen = strlen($jar);
                $jar = $jar . "<br>";
            }
        } else if ($x == $skippiece) {
            $skippiece = 0;
        } else if ($x == count($pieces) - 1) {
            $jar = $jar . $pieces[$x];
        } else {
            if ($x + 1 <= count($pieces) - 1 && strlen($pieces[$x]) + strlen($pieces[$x + 1]) <= $maxlen + 3) {
                if ($x + 1 == count($pieces) - 1) {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x + 1] . ".";
                } else {
                    $jar = $jar . $pieces[$x] . ", " . $pieces[$x + 1] . ",<br>";
                }
                $skippiece = $x + 1;
            } else {
                $jar = $jar . $pieces[$x] . ",<br>";
            }
        }
    }
    return $jar;
}
// End