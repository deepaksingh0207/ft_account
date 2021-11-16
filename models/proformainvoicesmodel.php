<?php

class ProformaInvoicesModel extends Model {
    
    
    public function getList($filter = array()) {
        //$sql = "select * from proforma_invoices where 1=1 order by updated_date desc";
        $where = ' WHERE 1=1 ';
        
        $fieldVal = array();
        if(!empty($filter)) {
            foreach($filter as $key => $val) {
                if(!empty(trim($val)))  {
                    if($key == 'status') {
                        $key = "proforma_invoices.$key";
                    }
                    
                    if($key == 'startdate') {
                        $where .= " and proforma_invoices.invoice_date >= ? ";
                        $fieldVal[] = $val;
                    } 
                    if($key == 'enddate') {
                        $where .= " and proforma_invoices.invoice_date <= ? ";
                        $fieldVal[] = $val;
                    }

                    if($key == 'customer_id') { 
                        $where .= " and proforma_invoices.customer_id= ? ";
                        $fieldVal[] = $val;
                    }
                    
                    if(is_array($val)){
                        $where .= " and $key in (".implode(',', array_filter($val)).") ";
                    }
                }
            }
        }

        $sql = "select proforma_invoices.*, customers.name customer_name from proforma_invoices 
        join customers on (proforma_invoices.customer_id = customers.id) $where order by updated_date desc";

        //echo $sql;

        $this->_setSql($sql);
        $user = $this->getAll($fieldVal);
        
        return $user;
    }
    
    public function get($id) {
        $sql = "SELECT I.*, OT.title as order_type
        FROM proforma_invoices I
        join orders O on (I.order_id = O.id)
        Join order_types OT ON (O.order_type = OT.id)
        where I.id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        
        return $user;
    }
    
    public function getInvoiceIds() {
        $sql = "select id from proforma_invoices ";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    public function getInvoiceIdsByCustomer($customerId) {
        $sql = "select id from proforma_invoices where customer_id=$customerId";
        $this->_setSql($sql);
        $user = $this->getAll();
        
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update proforma_invoices set ";
        
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
        
        $sql = "INSERT INTO proforma_invoices (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from proforma_invoices order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user['id'];
    }
    
    
    public function getInvoicesOfOrder($orderId) {
        $sql = "select * from proforma_invoices where order_id = $orderId order by id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();
        
        return $invoices;
    }
    
    
    public function getInvoiceItem($id) {
        $sql = "select * from proforma_invoice_items where proforma_invoice_id = ? ";
        $this->_setSql($sql);
        $items = $this->getAll(array($id));
        if (empty($items)){
            return false;
        }
        return $items;
    }
    
    public function getCustomerInvoiceList() {
        $sql = "select CG.name customer_group, C.name customer_name, I.id invoice_id, I.invoice_date, IFNULL(I.invoice_total, 0) invoice_amount, IFNULL(P.allocated_amt, 0) recieved_amount, IFNULL((invoice_total - IFNULL(P.allocated_amt, 0)), 0) balance_amount, I.due_date
        from proforma_invoices I
        left join (select invoice_id, SUM(allocated_amt) allocated_amt from payments group by invoice_id) P on (P.invoice_id = I.id)
        join customers C ON (I.customer_id = C.id)
        join customer_groups CG on (C.group_id = CG.id)
        order by due_date asc";

        $this->_setSql($sql);
        $list = $this->getAll();
        
        if (empty($list)) {
            return false;
        }
    
        return $list;
    }

    public function getLastRecord() {
        $sql = "select id,invoice_no from proforma_invoices order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        
        return $user;
    }

    public function getRecordsByField($field, $val) {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select proforma_invoices.*, customers.name customer_name from proforma_invoices join customers on (proforma_invoices.customer_id = customers.id) where 1=1 and $field = ? order by updated_date desc";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)){
            return false;
        }
        return $data;
    }
    
}