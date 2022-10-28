<?php

class PaymentsModel extends Model {
    
    
    public function list() {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select * from payments order by created_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from payments where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        
        return $user;
    }
    
    public function getDetailsByInvoiceId($invoiceId) {
        //$sql = "select tds_percent, tds_deducted, receivable_amt, balance_amt, allocated_amt from payments where invoice_id = ?";
        $sql = "select tds_percent, tds_deducted, receivable_amt, balance_amt, allocated_amt, CP.payment_date, CP.cheque_utr_no
        from payments P
        join customer_payments CP ON (CP.id = P.customer_payment_id)
        where P.invoice_id = ? and CP.status = 1 ";
        $this->_setSql($sql);
        $user = $this->getAll(array($invoiceId));
        
        return $user;
    }
    
    
    public function getDetailsByPaymentId($paymentId) {
        $sql = "select orders.po_no, invoices.invoice_no, invoice_id, tds_percent, tds_deducted, receivable_amt, balance_amt - (select sum(tds_deducted) from payments where invoice_id=invoice_id) as balance_amt, allocated_amt from payments
        join invoices on (invoices.id = payments.invoice_id)
        join orders on (orders.id = payments.order_id)
        where customer_payment_id = ?";
        $this->_setSql($sql);
        $user = $this->getAll(array($paymentId));
        
        return $user;
    }
    
    public function getInvoiceIds() {
        $sql = "select id from invoices where status = 1";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update payments set ";
        
        foreach ($fields as $field) {
            $sql .= " $field = ?,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " where id = ?";
        
        $data = array_values($updateRecord);
        $data[] = $id;
        
        //echo '<pre>'; print_r($data);
        
        $sth = $this->_db->prepare($sql);
        
        return $sth->execute($data);
    }
    
    public function save($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO payments (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from payments order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user['id'];
    }    
    public function getRecordsByField($field, $val) {
        $sql = "select * from customer_payments  where 1=1 and $field = ? and status = 1";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)){
            return false;
        }
        return $data;
    }
}