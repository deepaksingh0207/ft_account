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
}