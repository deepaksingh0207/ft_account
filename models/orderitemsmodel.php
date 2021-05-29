<?php

class OrderItemsModel extends Model {
    
    
    public function getList() {
        $sql = "select * from order_items where 1=1 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        return $user;
    }
    
    public function getItemByOrderId($id) {
        $sql = "select * from order_items where order_id=$id";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from order_items where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update users set ";
        
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

        $sql = "INSERT INTO order_items (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from customers order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user;
    }
    
}