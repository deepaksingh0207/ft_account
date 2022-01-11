<?php

class DashboardModel extends Model {
    
    public function getOrderSummary() {
        $sql = "select count(1)  no, sum(ordertotal) ORD_AMT FROM orders where status =1";
        $this->_setSql($sql);
        $row = $this->getRow();
        
        return $row;
    }

    public function getInvoiceSummary() {
        $sql = "select count(1) no, sum(invoice_total) INV_AMT FROM invoices where status =1";
        $this->_setSql($sql);
        $row = $this->getRow();
        
        return $row;
    }
    
    public function getPaymentSummary() {
        $sql = "select count(1) no, SUM(tds_deducted) TDS, sum(allocated_amt) AMT from payments where status = 1";
        $this->_setSql($sql);
        $row = $this->getRow();
        
        return $row;
    }
    
}