<?php

class InvoicesModel extends Model {
    
    
    public function getList() {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select invoices.*, customers.name customer_name from invoices join customers on (invoices.customer_id = customers.id) where 1=1 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function get($id) {
        $sql = "SELECT I.*, OT.title as order_type
        FROM invoices I
        join orders O on (I.order_id = O.id)
        Join order_types OT ON (O.order_type = OT.id)
        where I.id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        
        return $user;
    }
    
    public function getInvoiceIds() {
        $sql = "select id from invoices ";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function getInvoiceIdsByCustomer($customerId) {
        $sql = "select id from invoices where customer_id=$customerId";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update orders set ";
        
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
        
        $sql = "INSERT INTO invoices (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from invoices order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user['id'];
    }
    
    
    public function getInvoicesOfOrder($orderId) {
        $sql = "select * from invoices where order_id = $orderId order by id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();
        
        return $invoices;
    }
    
    
    public function getInvoiceItem($id) {
        $sql = "select * from invoice_items where invoice_id = ? ";
        $this->_setSql($sql);
        $items = $this->getAll(array($id));
        if (empty($items)){
            return false;
        }
        return $items;
    }
    
    
}