<?php

class InvoiceIrnModel extends Model {
    
    
    public function getList() {
        $sql = "select * from invoice_irns where 1=1 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from invoice_irns where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function getListByInvoiceId($invoiceId) {
        $sql = "select * from invoice_irns where invoice_id = ? order by id desc";
        $this->_setSql($sql);
        $user = $this->getAll(array($invoiceId));
        if (empty($user)){
            return false;
        }
        return $user;
    }

    public function getListBycreditNoteId($creditNoteId) {
        $sql = "select * from credit_note_irns where credit_note_id = ? order by id desc";
        $this->_setSql($sql);
        $user = $this->getAll(array($creditNoteId));
        if (empty($user)){
            return false;
        }
        return $user;
    }

    public function getByInvoiceId($id) {
        $sql = "select * from invoice_irns where status=1 and invoice_id = ?";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return [];
        }
        return $user;
    }

    public function getByCreditId($id) {
        $sql = "select * from invoice_irns where credit_note is not null and status=1 and invoice_id = ?";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){ return []; }
        return $user;
    }

    public function deleteByInvoiceId($invoiceId) {
        $sql = "delete from invoice_irns where invoice_id = ?";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($invoiceId));
    }

    public function cancelIrnByInvoice($invoiceId) {
        $sql = "update invoice_irns set status = 0 where invoice_id = ?";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($invoiceId));
    }

    public function cancelIrnByIrn($id) {
        $sql = "update invoice_irns status = 0 where id = ?";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($id));
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update users set ";
        
        foreach ($fields as $field) { $sql .= " $field = ?,"; }
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
        
        $sql = "INSERT INTO invoice_irns (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }

    public function saveCreditNoteIrn($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO credit_note_irns (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }

    public function getListByOrderId($orderId) {
        $sql = "select invoice_irns.*  from invoice_irns IR
        join invoices I on (I.id = IR.invoice_id) where I.order_id = ? and I.status = 1";
        $this->_setSql($sql);
        $user = $this->getAll(array($orderId));
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
}