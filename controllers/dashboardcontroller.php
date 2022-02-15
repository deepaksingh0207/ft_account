<?php


class DashboardController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("invoices");
    }

    public function index() {
        
        try {

            $dashModel = new DashboardModel();

            $orderSumary = $dashModel->getOrderSummary(); 
            $invoiceSumary = $dashModel->getInvoiceSummary(); 
            $paymentSumary = $dashModel->getPaymentSummary();
            $popuprows = $dashModel->popupSummary();

            $this->_view->set('orderSumary', $orderSumary);
            $this->_view->set('invoiceSumary', $invoiceSumary);
            $this->_view->set('paymentSumary', $paymentSumary);
            
            
            $invoices = $this->_model->getCustomerInvoiceList(); 
            
            if($invoices) {
                foreach($invoices as &$invoice) {
                    
                    if(strtotime($invoice['due_date']) < strtotime('today')) {
                        $invoice['due_status'] = 'expired';
                    } else if(strtotime($invoice['due_date']) === strtotime('today')) {
                        $invoice['due_status'] = 'expire today';
                    } else if(strtotime($invoice['due_date']) > strtotime('today') &&
                    strtotime($invoice['due_date']) < strtotime('+7 days')
                    ) {
                        $invoice['due_status'] = 'expire soon';
                    } else {
                        $invoice['due_status'] = 'valid';
                    }
                }
            }
            $temp_popuprows = array();
            if($popuprows) {
                $temp_mergerow = array();
                $last_po = "";
                foreach($popuprows as &$row) {
                    if ($last_po == $row['po_no']) {
                        $tmp = array();
                        $tmp['item'] = $row['item'];
                        $tmp['description'] = $row['description'];
                        $tmp['total'] = $row['total'];
                        $tmp['po_from_date'] = date('d, M Y',strtotime($row['po_from_date']));
                        $tmp['po_to_date'] = date('d, M Y',strtotime($row['po_to_date']));
                        $tmp['ageing'] = $row['ageing'];
                        $temp_mergerow['sub'][] = $tmp;
                    } else {
                        if ($last_po != ""){
                            $temp_popuprows[] = $temp_mergerow;
                        }
                        $last_po = $row['po_no'];
                        $temp_mergerow['id'] =  $row['id'];
                        $temp_mergerow['name'] =  $row['name'];
                        $temp_mergerow['ordertotal'] =  $row['ordertotal'];
                        $temp_mergerow['po_no'] =  $row['po_no'];
                        $tmp = array();
                        $tmp['item'] = $row['item'];
                        $tmp['description'] = $row['description'];
                        $tmp['total'] = $row['total'];
                        $tmp['po_from_date'] = date('d, M Y',strtotime($row['po_from_date']));
                        $tmp['po_to_date'] = date('d, M Y',strtotime($row['po_to_date']));
                        $tmp['ageing'] = $row['ageing'];
                        $temp_mergerow['sub'][] = $tmp;
                    }
                }
                $temp_popuprows[] = $temp_mergerow;
            }
            $popuprows = $temp_popuprows;
            
            $this->_view->set('popuprows', $popuprows);
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

    public function report() {
        
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

    public function orderSummary() {
        
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
}