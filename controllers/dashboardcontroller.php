<?php


class DashboardController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("users");
    }

    public function index() {
        
        try {
            
            $report = new TopCustomerReport();
            $report->run();
            $this->_view->set("report",$report);
            
            $this->_view->set('title', 'Dashboard');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
}