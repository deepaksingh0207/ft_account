<?php

class InvoicesModel extends Model {
    
    
    public function getList($filter = array()) {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $where = ' WHERE 1=1 and invoices.status=1 ';
        
        $fieldVal = array();
        if(!empty($filter)) {
            foreach($filter as $key => $val) {
                if(!empty(trim($val)))  {
                    if($key == 'status') {
                        $key = "invoices.$key";
                    }
                    
                    if($key == 'startdate') {
                        $where .= " and invoices.invoice_date >= ? ";
                        $fieldVal[] = $val;
                    } 
                    if($key == 'enddate') {
                        $where .= " and invoices.invoice_date <= ? ";
                        $fieldVal[] = $val;
                    }

                    if($key == 'customer_id') { 
                        $where .= " and invoices.customer_id= ? ";
                        $fieldVal[] = $val;
                    }
                    
                    if(is_array($val)){
                        $where .= " and $key in (".implode(',', array_filter($val)).") ";
                    }
                }
            }
        }

        $sql = "select invoices.*, customers.name customer_name from invoices 
        join customers on (invoices.customer_id = customers.id) $where order by updated_date desc";

        //echo $sql;

        $this->_setSql($sql);
        $user = $this->getAll($fieldVal);
        
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

    public function getByInvoiceNo($invoiceNo) {
        $sql = "select * from invoices where invoice_no = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($invoiceNo));
        
        return $user;
    }
    
    public function getInvoiceIds() {
        $sql = "select id from invoices where status = 1 ";
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

    public function save_irn($data) {
        
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

    public function deleteInvoice($invoiceNo) {
        $sql = "delete from invoices where invoice_no = ? ";
        $stmt = $this->_db->prepare ($sql);
        return $stmt->execute(array($invoiceNo));
    }
    
    public function getLastId() {
        $sql = "select id as id from invoices 
        union select 0 as id order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();

        return $user['id'];
    }
    
    public function getInvoicesOfOrder($orderId) {
        $sql = "select * from invoices where order_id = $orderId and status = 1 order by id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();
        
        return $invoices;
    }

    // JThayil 22 Feb
    public function getPaymentOfInvoices($orderId) {
        $sql = "select * from invoices as i
        left join payments as p on i.id =p.invoice_id
        where i.order_id = $orderId and i.status = 1 order by i.id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();
        
        return $invoices;
    }
    // JThayil End
    public function getInvoiceItem($id) {
        $sql = "select * from invoice_items where invoice_id = ? ";
        $this->_setSql($sql);
        $items = $this->getAll(array($id));
        if (empty($items)){
            return false;
        }
        return $items;
    }
    
    public function getCustomerInvoiceList() {
        // JThayil 14 Feb Dashboard
        $sql = "select CG.name customer_group, C.name customer_name, I.po_no, I.id invoice_id, I.invoice_no, I.invoice_date, IFNULL(I.invoice_total, 0) invoice_amount, IFNULL(P.allocated_amt, 0) recieved_amount, IFNULL((invoice_total - IFNULL(P.allocated_amt, 0)), 0) balance_amount, tds_deducted, I.due_date
        from invoices I
        left join (select invoice_id, SUM(allocated_amt) allocated_amt,  SUM(tds_deducted) tds_deducted from payments group by invoice_id) P on (P.invoice_id = I.id)
        join customers C ON (I.customer_id = C.id)
        join customer_groups CG on (C.group_id = CG.id)
        where I.status = 1
        order by due_date asc";
        // JThayil 14 Feb End
        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)) {
            return false;
        }
    
        return $list;
    }

    public function getLastRecord() {
        $sql = "select id,invoice_no from invoices order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user;
    }

    public function getRecordsByField($field, $val) {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select * from invoices where 1=1 and $field = ? and status = 1 limit 1";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function proformaFieldRecord($field, $val) {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select * from proforma_invoices where 1=1 and $field = ? and status = 1 limit 1";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)){
            return false;
        }
        return $data;
    }
}