<?php


class DashboardController extends Controller
{

    public function __construct($model, $action)
    {
        parent::__construct($model, $action);
        $this->_setModel("invoices");
    }

    public function index()
    {
        $customerList = new CustomersModel();
        $customers = $customerList->getNameList();

        try {

            $dashModel = new DashboardModel();

            $orderSumary = $dashModel->getOrderSummary();
            $invoiceSumary = $dashModel->getInvoiceSummary();
            $paymentSumary = $dashModel->getPaymentSummary();
            $popuprows = $dashModel->popupSummary();
            // JThayil 22 Feb
            // $openpo = $dashModel->openpo();
            $report = $dashModel->orderSummary();
            // JThayil End

            $this->_view->set('orderSumary', $orderSumary);
            $this->_view->set('invoiceSumary', $invoiceSumary);
            $this->_view->set('paymentSumary', $paymentSumary);
            $this->_view->set('customers', $customers);


            $invoices = $this->_model->getCustomerInvoiceList();
            // echo '<pre>';
            // print_r($invoices);
            // echo '</pre>';
            // exit;

            if ($invoices) {

                foreach ($invoices as &$invoice) {
                    if (strtotime($invoice['due_date']) < strtotime('today')) {
                        $invoice['due_status'] = 'expired';
                    } else if (strtotime($invoice['due_date']) === strtotime('today')) {
                        $invoice['due_status'] = 'expire today';
                    } else if (strtotime($invoice['due_date']) > strtotime('today') && strtotime($invoice['due_date']) < strtotime('+7 days')) {
                        $invoice['due_status'] = 'expire soon';
                    } else {
                        $invoice['due_status'] = 'valid';
                    }
                }
            }

            if ($popuprows) {
                $temp_mergerow = array();
                foreach ($popuprows as &$row) {
                    $temp = array();
                    $temp['id'] =  $row['id'];
                    $temp['name'] =  $row['name'];
                    $temp['ordertotal'] =  $row['ordertotal'];
                    $temp['po_no'] =  $row['po_no'];
                    $temp['item'] = $row['item'];
                    $temp['description'] = $row['description'];
                    $temp['total'] = $row['total'];
                    $temp['po_from_date'] = date('d, M Y', strtotime($row['po_from_date']));
                    $temp['po_to_date'] = date('d, M Y', strtotime($row['po_to_date']));
                    $temp['ageing'] = $row['ageing'];
                    $temp_mergerow[] = $temp;
                }
                $popuprows = $temp_mergerow;
            }


            $this->_view->set('popuprows', $popuprows);
            // JThayil 22 Feb
            // $this->_view->set('opo', $openpo);
            $this->_view->set('reports', $report);
            // JThayil End
            //echo '<pre>'; print_r($invoices); exit;

            //$report = new TopCustomerReport();
            //$report->run();
            //$this->_view->set("report",$report);


            $this->_view->set('invoices', $invoices);
            $this->_view->set('title', 'Dashboard');


            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function search()
    {
        $temp = array();

        // Get filter parameters from POST request
        $filter = array(
            'startdate' => isset($_POST['startdate']) ? $_POST['startdate'] : '',
            'enddate' => isset($_POST['enddate']) ? $_POST['enddate'] : '',
            'customer_id' => isset($_POST['customer_id']) ? $_POST['customer_id'] : '',
            'po_no' => isset($_POST['po_no']) ? trim($_POST['po_no']) : ''
        );

        $invoices = $this->_model->getCustomerInvoiceList($filter);

        if ($invoices) {
            foreach ($invoices as &$invoice) {
                $tmp = $invoice;

                // Calculate due days
                $due_days = (strtotime($invoice['due_date']) - strtotime('today')) / (60 * 60 * 24);
                $tmp['due_status'] = $due_days;
                $temp[] = $tmp;
            }
        }

        $result = array();
        $result['draw'] = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $result['data'] = $temp;
        $result['recordsTotal'] = count($invoices);
        $result['recordsFiltered'] = count($invoices);


        echo json_encode($result);
        exit;
    }
    public function report()
    {

        try {

            $dashModel = new DashboardModel();

            $report = $dashModel->report();

            $this->_view->set('report', $report);

            $this->_view->set('title', 'Report');


            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function orderSummary()
    {

        try {

            $dashModel = new DashboardModel();

            $report = $dashModel->orderSummary();

            $this->_view->set('reports', $report);
            $this->_view->set('title', 'Orders');


            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function toggleMonitoringOrder($id)
    {

        try {
            // echo '<pre>'; print_r($id); exit;
            if ($id) {
                $tblOrder = new OrdersModel();
                $tblOrder->togglemonitor([$id]);
                $disable_monitor = $tblOrder->get($id);
                echo json_encode($disable_monitor);
            } else {
                echo false;
            }
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function expiredpo()
    {

        try {

            $dashModel = new DashboardModel();

            $popuprows = $dashModel->popupSummary();

            $temp_mergerow = array();
            if ($popuprows) {
                foreach ($popuprows as &$row) {
                    $temp = array();
                    $temp['id'] =  $row['id'];
                    $temp['name'] =  $row['name'];
                    $temp['ordertotal'] =  $row['ordertotal'];
                    $temp['po_no'] =  $row['po_no'];
                    $temp['item'] = $row['item'];
                    $temp['description'] = $row['description'];
                    $temp['total'] = $row['total'];
                    $temp['po_from_date'] = date('d, M Y', strtotime($row['po_from_date']));
                    $temp['po_to_date'] = date('d, M Y', strtotime($row['po_to_date']));
                    $temp['ageing'] = $row['ageing'];
                    $temp_mergerow[] = $temp;
                }
            }

            $popuprows = $temp_mergerow;

            $this->_view->set('popuprows', $popuprows);

            $this->_view->set('title', 'Expired PO');

            return $this->_view->output();
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}
