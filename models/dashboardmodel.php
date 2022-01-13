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


    public function report() {
        $sql = "select C.name Customer, O.po_no 'PO No',O.po_from_date 'Valid From', O.po_to_date 'Valid To', I.invoice_no 'Invoice No', II.description, I.due_date 'Invoice Due Date',I.invoice_total 'Invoice Amount', P.tds_deducted 'TDS Deducted', P.allocated_amt,
        P.reced_amt 'Received Amount', P.bal_amt 'Balance Amount'
        from orders O
        inner join customers C on (O.customer_id = C.id)
        Left join invoices I on (I.order_id = O.id and I.status = 1)
        Left join invoice_items II on (II.invoice_id = I.id)
        Left join (
            select P.invoice_id, SUM(P.tds_deducted) tds_deducted, SUM(P.allocated_amt) allocated_amt,
        SUM(P.tds_deducted + P.allocated_amt) reced_amt, ( I.invoice_total- SUM(P.tds_deducted + P.allocated_amt)) bal_amt
        from payments P 
        join invoices I on (P.invoice_id = I.id and P.status = 1)
            group by P.invoice_id
        ) P on (P.invoice_id = I.id) 
        where O.status = 1";

        $this->_setSql($sql);
        $list = $this->getAll();
        
        return $list;

    }
    
}