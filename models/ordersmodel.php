<?php

class OrdersModel extends Model {
    
    
    public function getList($filter = array()) {
        //$sql = "select * from orders where 1=1 order by updated_date desc";
        $where = ' WHERE 1=1 and orders.status=1 ';
        
        $fieldVal = array();

        if(!empty($filter)) {
            foreach($filter as $key => $val) {
                if(!empty(trim($val)))  {
                    if($key == 'status') {
                        $key = "orders.$key";
                        $fieldVal[] = $val;
                    }
                    
                    if($key == 'startdate') {
                        $where .= " and orders.order_date >= ? ";
                        $fieldVal[] = $val;
                    } 
                    if($key == 'enddate') {
                        $where .= " and orders.order_date <= ? ";
                        $fieldVal[] = $val;
                    }

                    if($key == 'customer_id') { 
                        $where .= " and orders.customer_id= ? ";
                        $fieldVal[] = $val;
                    }
                    
                    if(is_array($val)){
                        $where .= " and $key in (".implode(',', array_filter($val)).") ";
                    }
                }
            }
        }

        $sql = "select orders.*, customers.name customer_name from orders 
        join customers on (orders.customer_id = customers.id) $where order by updated_date desc";

        //echo $sql;

        $this->_setSql($sql);
        $user = $this->getAll($fieldVal);
        
        return $user;
    }
    
    public function get($id) {
        $sql = "select * from orders where id = ? limit 1";
        $this->_setSql($sql);
        $order = $this->getRow(array($id));
        if (empty($order)){
            return false;
        }
        return $order;
    }

    public function getOrderItem($id) {
        $sql = "select * from order_items where order_id = ? ";
        $this->_setSql($sql);
        $items = $this->getAll(array($id));
        if (empty($items)){
            return false;
        }
        return $items;
    }

    public function getOrderListByCustomer($id) {
        /*$sql = "select o.id, o.po_no, it.item from orders o
            join (select max(item) item, order_id from order_items group by order_id) as it on (it.order_id = o.id)
            where customer_id = ? "; */

            $sql = "select o.id, o.po_no, it.item, COALESCE(payments,0) payments, ordertotal
from orders o
left join (select SUM(COALESCE(received_amt, 0)) payments, order_id FROM `customer_payments` group by order_id) as s on (s.order_id = o.id)
join (select max(item) item, order_id from order_items group by order_id) as it on (it.order_id = o.id)
where customer_id = ? and status = 1 
having ordertotal > payments";

        $this->_setSql($sql);
        $user = $this->getAll(array($id));
        if (empty($user)){
            return false;
        }
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
        
        $sql = "INSERT INTO orders (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function getLastId() {
        $sql = "select id from orders order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function getRecordsByField($field, $val) {
        $sql = "select orders.*, customers.name customer_name from orders join customers on (orders.customer_id = customers.id) where 1=1 and orders.status = 1 and $field = ? order by updated_date desc ";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function getPaymentDoneInvoices($orderId) {
        
      /*$sql = "select  DISTINCT customer_payments.id, invoice_no, CONCAT_WS('', payment_description, invoice_items.description) description, received_amt as invoice_total,
      payment_date,cheque_utr_no, utr_file
      from customer_payments
      join invoices  on (invoices.id = customer_payments.invoice_id) 
      LEFT JOIN (
  SELECT
    * 
  FROM invoice_items 
  LIMIT 1
) invoice_items ON invoice_items.invoice_id = invoices.id and invoices.status = 1
      where customer_payments.order_id=?"; */

      $sql = "select cp.payment_date, cp.cheque_utr_no, cp.received_amt, cp.utr_file, pt.basic_value, pt.gst_amount, pt.invoice_amount, tds_percent, PT.allocated_amt, inv.invoice_no, inv.id  from customer_payments as cp
      inner join payments as pt on cp.id = pt.customer_payment_id
      inner join invoices as inv on inv.id = pt.invoice_id
      where pt.order_id=?";

        $this->_setSql($sql);
        $data = $this->getAll(array($orderId));

        if (empty($data)){
            return false;
        }
        return $data;
    }

    public function getPendingInvoices($orderId) {
        /*$sql = "select DISTINCT invoices.*, order_id, CONCAT_WS('', payment_description, invoice_items.description) description , invoice_total from 
        invoices 
        left join invoice_items on (invoice_items.invoice_id = invoices.id)
        where order_id=? and invoices.id NOT IN ( select invoice_id from payments where order_id=? )";*/

        $sql = "select DISTINCT invoices.*, CONCAT_WS('', payment_description, invoice_items.description) description , invoice_total, IFNULL(max(payments.tds_deducted),0) as tds_deducted, IFNULL(max(payments.tds_percent),0) as tds_percent, invoices.invoice_total - IFNULL(sum(payments.allocated_amt),0) - IFNULL(tds_deducted, 0) as balance from invoices left outer join invoice_items on (invoice_items.invoice_id = invoices.id) left join payments on (payments.invoice_id = invoices.id) where invoices.order_id=? and 
        invoices.id NOT IN ( select invoice_id from payments where balance_amt <= tds_deducted and order_id=? ) group by invoices.id";
        
        /*$sql = "select DISTINCT invoices.id, invoice_no, order_id, CONCAT_WS('', payment_description, invoice_items.description) description , (invoice_total - (select IF(sum(received_amt) IS NULL,0, sum(received_amt))  from customer_payments where order_id=? and invoice_id = invoices.id)) as invoice_total
        from invoices 
        LEFT JOIN (
  SELECT
    * 
  FROM invoice_items 
  LIMIT 1
) invoice_items ON invoice_items.invoice_id = invoices.id
        where order_id=? and status = 1 and invoices.invoice_total != (select IF(sum(received_amt) IS NULL,0, sum(received_amt)) from customer_payments where order_id=? and invoice_id = invoice_items.invoice_id )";

        */

        $this->_setSql($sql);
        $data = $this->getAll(array($orderId, $orderId));

        if (empty($data)){
            return false;
        }
        return $data;
    }
    
}