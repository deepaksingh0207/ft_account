<?php

class CreditnotesController extends Controller
{
    private $creditnotesModel;
    public function __construct($model, $action)
    {
        parent::__construct($model, $action);
        $this->_setModel("invoices");

        $this->creditnotesModel = new CreditnotesModel();
    }


    public function index()
    {

        try {

            $creditNoteItems = $this->creditnotesModel->getList();

            $this->_view->set('creditNoteItems', $creditNoteItems);

            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }



    public function getInvoiceItems($invoiceId)
    {
        try {

            $invoiceItemTbl = new InvoiceItemsModel();
            $invoiceItems = $invoiceItemTbl->getListByInvoiceId_for_Creditnote($invoiceId);

            $resp = array(
                'status' => $invoiceItems !== false,
                'data' => $invoiceItems,
                'message' => $invoiceItems === false ? 'No data found' : 'Success'
            );
        } catch (Exception $e) {
            $resp = array(
                'status' => false,
                'data' => null,
                'message' => $e->getMessage()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($resp);
        exit;
    }


    // public function create()

    // {
    //     try {
    //     } catch (Exception $e) {
    //         echo "Application error:" . $e->getMessage();
    //     }
    // }

    public function credit_note_validty()
    {
        $status = 0;
        $message = "Credit No Found";
        $data = null;

        if (!empty($_POST)) {
            $credit_no = $_POST['credit_no'];
            if ($this->_model->check_credit_note_validty($credit_no)) {
                $status = 1;
                $message = "Credit No Not Found";
            }
        }

        echo json_encode(array('status' => $status, 'msg' => $message, 'data' => $data));
        exit();
    }


    public function check_credit_note_validty($credit_no = null)
    {
        if ($credit_no = $this->_model->check_credit_note_validty($credit_no)) {
            echo 0;
        } else {
            echo 1;
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

            if ($customer['country'] != '101') {
                // If country is not 101, GST part is not needed
                $result['gst'] = 'foreign_country';
            } else {

                if ($customer['state'] == $company['state']) {
                    $result['state'] = 'same';
                    $result['cgst'] = $itMaster['cgst'];
                    $result['sgst'] = $itMaster['sgst'];
                } else {
                    $result['state'] = 'other';
                    $result['igst'] = $itMaster['igst'];
                }
            }
            $resp = array('status' => true, 'data' => $result, 'message' => 'Success');
        } catch (Exception $e) {
            $resp = array('status' => false, 'data' => null, 'message' => $e->getMessage());
        }
        echo json_encode($resp);
        exit;
    }


    public function saveCreditNote()
    {
        if (!empty($_POST)) {
            $data = $_POST;
            $invoiceId = $data['invoice_details'][0]['invoice_id'];

            $credit_note_id = $this->_model->save_credit_note($data);

            if ($credit_note_id) {

                if ($this->_model->save_credit_note_items($credit_note_id, $data['invoice_details'])) {
                    echo json_encode(['status' => 'success', 'message' => 'Credit note and items added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add credit note items.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add credit note.']);
            }
            return;
        }
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }

    public function gencbn($invoiceId = null, $proformaSwitch = false, $createpdf = false, $hidepo = false)
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
        $nri = '';
        $totalbr = 10;
        if (!empty($_POST)) {
            $data = $_POST;
            //  echo '<pre>'; print_r($data);
            $invoiceId = $data['invoice_details'][0]['invoice_id'];
            $credit_note_total = $data['credit_note_total'];
            $credit_note_date = $data['credit_note_date'];
            $credit_no = $data['credit_no'];
         
            $igst = isset($data['igst']) && is_numeric($data['igst']) ? (float)$data['igst'] : null;
            $cgst = isset($data['cgst']) && is_numeric($data['cgst']) ? (float)$data['cgst'] : null;
            $sgst = isset($data['sgst']) && is_numeric($data['sgst']) ? (float)$data['sgst'] : null;


            $orderItemIds = array_column($data['invoice_details'], 'order_item_id');
            //  $invoiceItems = $this->_model->getInvoiceItem($invoiceId);
            $invoiceItems = $this->_model->getInvoiceItemm($invoiceId, $orderItemIds);
            foreach ($data['invoice_details'] as $formItem) {
                foreach ($invoiceItems as &$invoiceItem) {
                    if ($invoiceItem['invoice_id'] == $formItem['invoice_id'] && $invoiceItem['order_item_id'] == $formItem['order_item_id']) {
                        $invoiceItem['qty'] = $formItem['qty'];
                        $invoiceItem['unit_price'] = $formItem['unit_price'];
                        $invoiceItem['hsn_id'] = $formItem['hsn_code'];
                        $invoiceItem['item'] = $formItem['item'];
                        $invoiceItem['description'] = $formItem['description'];
                        $invoiceItem['total'] = $formItem['total'];
                    }
                }
            }

            $invoice = $this->_model->get($invoiceId);
            $hidepo = $invoice['hide_po'];
        }
        //  echo '<pre>'; print_r($invoiceItem);
        if ($proformaSwitch && $invoiceId) {
            $invoice = $tblProformaInvoice->get($invoiceId);
            $invoiceItems = $tblProformaInvoice->getInvoiceItem($invoiceId);
        }
        foreach ($invoiceItems as $item) {
            $totalbr--;
        }
        $company = $company->get(1);
        $customer = $customerTbl->get($invoice['customer_id']);
        $nri = $customer['country'] == '101' ? false : true;

        $customerShipTo = $customerTbl->get($invoice['ship_to']);
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
        // echo '<pre>'; print_r($dataItem);
        $irn = '';
        $slt = '';
        $qrcode = '';
        $irndt = '';
        $irnrec = $invoiceIrnTbl->getByCreditId($invoiceId);
        if (count($irnrec) && !$proformaSwitch) {
            $totalbr -= 2;
            $irn = '<tr><td colspan="2" class="bn2"><b>IRN No: ' . $irnrec['irn_no'] . '</b></td></tr>';
            $irndt = '<tr><td class="blt2r"><b>IRN Date: ' . $irnrec['ack_date'] . '</b></td>';
            $slt = '<td class="brt2l"><b>Supply Type: B2B</b></td></tr>';
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
            "{{CREDIT_NOTE_DATE}}" => date('d/m/Y', strtotime($credit_note_date)),
            "{{COMPANY_BILLTO}}" => creditAddressMaker($company['address']),
            "{{BILLTO_ADDRESS}}" => creditAddressMaker($company['address'], 6),
            "{{COMP_TEL}}" => $company['contact'],
            "{{COMP_PAN}}" => $company['pan'],
            "{{COMP_SAC}}" => $company['sac'],
            "{{COMP_GSTIN}}" => $company['gstin'],
            "{{COMP_BANK}}" => $company['bank_name'],
            "{{COMP_ACCNO}}" => $company['account_no'],
            "{{COMP_IFSC}}" => $company['ifsc_code'],
            "{{PO_NO}}" => "Invoice No.: " . $invoice['invoice_no'],
            "{{ORDER_TYPE}}" => $print_uom_qty,
            "{{INVOICE_DATE}}" => date('d/m/Y', strtotime($invoice['invoice_date'])),
            "{{CUST_ADDRESS}}" => "<b>" . $customer['name'] . "</b><br />" . creditAddressMaker($customer['address'], 3),
            "{{CUST_TEL}}" => $customer['pphone'],
            "{{DECLARATION}}" => getCreditDeclaration($customer['declaration'], $totalbr),
            "{{CUST_FAX}}" => $customer['fax'],
            "{{CUST_PAN}}" => $customer['pan'],
            "{{CUST_GST}}" => $customer['gstin'],
            "{{CUST_SHIPTO}}" => "<b>" . $customer['name'] . "</b><br />" . creditAddressMaker($customerShipTo['address'], 3),
            "{{CUST_CONT_PERSON}}" => $invoice['sales_person'],
            "{{INV_TOTAL}}" => number_format($credit_note_total, 2),
            "{{AMOUNT_WORD}}" => $this->_utils->AmountInWords($credit_note_total, $nri),
            "{{REST_BR}}" => $br,
            "{{TOTAL_TERMS}}" => $nri ? "Amount" : 'value including taxes',
            "{{PAY_TERM}}" => 'Against Invoice within 30 days',
            "{{GROSS_AMOUNT}}" => number_format($invoice['exchange_rate'] * $invoiceItem['total'], 2),
            "{{EXCHANGE_RATE}}" => number_format($invoice['exchange_rate'], 2),
            "{{FOREIGN_CURRENCY}}" => $customer['for_cur'],
        );
        $vars["{{CREDIT_NO}}"] = "Credit Note No: " . 'CR-' . $credit_no;
        $vars["{{TITLE}}"] = "CREDIT NOTE";

        if ($hidepo) {
            $vars["{{PO_NO}}"] = "Purchase Order No.: As per mail";
        }
        $orderBaseTotal = 0.00;
        $itemList = '';

        $keys = array_key_last($dataItem);
        foreach ($dataItem as $key => $item) {

            $hsncode = $hsn->get($item['hsn_id']);
            $oderItems = $orderItemsTable->get($item['order_item_id']);
            // echo '<pre>';  print_r($oderItems);
            //  echo '<pre>'; print_r($oderItems['order_type']);
            if ($keys == $key && 0 == $key) {
                $itemList .= '<tr class="txtsmr"><td class="txtc pb-1 pt-1">' . ($key + 1) . '</td><td class="pb-1 pt-1">' . $item['description'] . '</td><td class="txtc pb-1 pt-1">' . $hsncode['code'] . '</td>';
                if (in_array($oderItems['order_type'], array(1, 2, 3, 5,))) {
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
        if (in_array($order['order_type'], array(6))) {
            $vars["{{TDS}}"] = "";
        } else {
            $vars["{{TDS}}"] = "<li>TDS should be Deduct @10% As per Sec.194J.</li>";
        }
        $taxName = '';
        $taxesLayout = '';
     
        if (!$nri) {
            if ((int)$igst) {

                $taxName = "IGST @ 18%";
                $taxesLayout = number_format($igst, 2);
            } else {
                $taxName = "CGST @ 9%<br />SGST @ 9%";
                $taxesLayout = number_format($cgst, 2) . '<br />' . number_format($sgst, 2);
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
            json_encode([$messageBody]);
        }
    }
}
function getCreditDeclaration($val, $brcount)
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

function creditAddressMaker($val, $firstLineBreak = 2)
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

function creditFooterAddress($val)
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
