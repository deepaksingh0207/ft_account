<?php

class CustomerPaymentsModel extends Model {
        
    public function list() {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select C.name, P.* from customer_payments P join customers C on (C.id = P.customer_id) where P.status = 1 order by payment_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function get($id) {
        $sql = "select CG.name cust_group, C.name customer_name, P.* from customer_payments P 
        join customers C on (C.id = P.customer_id)
        join customer_groups CG on (CG.id = C.group_id)
         where P.id = ? and P.status = 1 limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        
        return $user;
    }
    
    public function getInvoiceIds() {
        $sql = "select id from customer_payments where and status = 1";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update customer_payments set ";
        
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
        
        $sql = "INSERT INTO customer_payments (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from customer_payments order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user['id'];
    }    
    
}