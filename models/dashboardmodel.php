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

    public function popupSummary() {
        $sql = "select * from (select O.id, C.name, O.po_no, O.ordertotal, I.item, I.description, I.total, I.po_from_date, I.po_to_date, DATEDIFF(I.po_to_date, current_date) as ageing from orders O inner join order_items I on (O.id = I.order_id) inner join customers C on (O.customer_id = C.id) where I.order_type in (1, 3)) as a where ageing between 0 and 32 order by id, ageing;";

        $this->_setSql($sql);
        $list = $this->getAll();
        
        return $list;
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

    public function orderSummary() {
        $sql = "select C.name, O.po_no,O.po_from_date 'Valid From', O.po_to_date 'Valid To', O.ordertotal, invoice_total, sum(P.tds_deducted + P.allocated_amt) received,
        (ordertotal - sum(P.tds_deducted + P.allocated_amt)) balance
        from orders O
        Join customers C  on (O.customer_id = C.id)
        left Join (select Sum(invoice_total) invoice_total, order_id from invoices where status=1  GROUP by order_id) I on( I.order_id = O.id) 
        left Join payments P on (P.order_id = O.id and P.status = 1)
        where O.status = 1
        group by O.id
        having invoice_total > 0";

        $this->_setSql($sql);
        $list = $this->getAll();
        
        return $list;
    }
    
}