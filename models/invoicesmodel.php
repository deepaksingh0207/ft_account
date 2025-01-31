<?php

class InvoicesModel extends Model
{


    public function getList($filter = array())
    {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $where = ' WHERE 1=1 and invoices.status=1 ';

        $fieldVal = array();
        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                if (!empty(trim($val))) {
                    if ($key == 'status') {
                        $key = "invoices.$key";
                    }

                    if ($key == 'startdate') {
                        $where .= " and invoices.invoice_date >= ? ";
                        $fieldVal[] = $val;
                    }
                    if ($key == 'enddate') {
                        $where .= " and invoices.invoice_date <= ? ";
                        $fieldVal[] = $val;
                    }

                    if ($key == 'customer_id') {
                        $where .= " and invoices.customer_id= ? ";
                        $fieldVal[] = $val;
                    }

                    if (is_array($val)) {
                        $where .= " and $key in (" . implode(',', array_filter($val)) . ") ";
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

    public function cancelAllIRN($id)
    {
        $sql = "update invoice_irns set status=0 where credit_note is not null and invoice_no = ?";
        $data[] = $id;
        $sth = $this->_db->prepare($sql);
        return $sth->execute($data);
    }

    public function get($id)
    {
        $sql = "SELECT I.*, OT.title as order_type
        FROM invoices I
        join orders O on (I.order_id = O.id)
        Join order_types OT ON (O.order_type = OT.id)
        where I.id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));

        return $user;
    }

    public function getByID($id)
    {
        $sql = "SELECT * FROM invoices where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        return $user;
    }

    public function getByInvoiceNo($invoiceNo)
    {
        $sql = "select * from invoices where invoice_no = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($invoiceNo));

        return $user;
    }

    public function getInvoiceIds()
    {
        $sql = "select id from invoices where status = 1 ";
        $this->_setSql($sql);
        $user = $this->getAll();

        return $user;
    }

    public function getInvoiceIdsByCustomer($customerId)
    {
        $sql = "select id from invoices where customer_id=$customerId";
        $this->_setSql($sql);
        $user = $this->getAll();

        return $user;
    }

    public function update($id, $updateRecord)
    {

        $fields = array_keys($updateRecord);

        $sql = "update invoices set ";

        foreach ($fields as $field) {
            $sql .= " $field = ?,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " where id = ?";

        $data = array_values($updateRecord);
        $data[] = $id;

        // echo '<pre>'; print_r($sql);

        $sth = $this->_db->prepare($sql);

        return $sth->execute($data);
    }

    public function save($data)
    {

        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();

        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));

        $sql = "INSERT INTO  invoices (" . implode(",", $datafields) . ") VALUES " .
            implode(',', $question_marks);


        //echo $sql; print_r($insert_values); exit;
        $stmt = $this->_db->prepare($sql);
        if ($stmt->execute($insert_values)) {
            return $this->_db->lastInsertId();
        } else {
            return false;
        }
    }

    //    ---------------save credit_notes-------------

    public function save_credit_note($data)
    {

        $insert_values = array();
        $mapped_data = [
            'invoice_id' => $data['invoice_details'][0]['invoice_id'],
            'credit_note_no' => $data['credit_no'],
            'credit_date' => $data['credit_note_date'],
            'order_id' => $data['invoice_details'][0]['order_id'],
            'hsn_id' => $data['invoice_details'][0]['hsn_code'],
            'igst' => !empty($data['igst']) ? $data['igst'] : 0,
            'cgst' => !empty($data['cgst']) ? $data['cgst'] : 0,
            'sgst' => !empty($data['sgst']) ? $data['sgst'] : 0,
            'credit_note_total' => !empty($data['credit_note_total']) ? $data['credit_note_total'] : 0,           

        ];

        $datafields = array_keys($mapped_data);
        $question_marks = array();
        $question_marks[] = '('  . $this->placeholders('?', sizeof($mapped_data)) . ')';
        $insert_values = array_merge($insert_values, array_values($mapped_data));

        $sql = "INSERT INTO credit_notes (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);

        $stmt = $this->_db->prepare($sql);
        if ($stmt->execute($insert_values)) {
            return $this->_db->lastInsertId();
        } else {
            return false;
        }
    }

    // --------------save credit_note_items--------------

    public function save_credit_note_items($credit_note_id, $invoice_items)
    {
        $insert_values = [];
        $question_marks = [];

        foreach ($invoice_items as $item) {
            $insert_values[] = $item['invoice_id'];
            $insert_values[] = $item['order_id'];
            $insert_values[] = $item['order_item_id'];
            $insert_values[] = $item['id'];
            $insert_values[] = $credit_note_id;
            $insert_values[] = $item['item'];
            $insert_values[] = $item['description'];
            $insert_values[] = $item['qty'];
            $insert_values[] = $item['unit_price'];
            $insert_values[] = $item['total'];

            $question_marks[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        }

        $sql = "INSERT INTO credit_note_items (invoice_id, order_id, order_item_id, invoice_item_id, credit_note_id, item, description, qty, unit_price, total) 
            VALUES " . implode(',', $question_marks);

        $stmt = $this->_db->prepare($sql);
        return $stmt->execute($insert_values);
    }




    public function save_irn($data)
    {

        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();

        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));

        $sql = "INSERT INTO invoice_irns (" . implode(",", $datafields) . ") VALUES " .
            implode(',', $question_marks);


        $stmt = $this->_db->prepare($sql);
        if ($stmt->execute($insert_values)) {
            return $this->_db->lastInsertId();
        } else {
            return false;
        }
    }

    public function deleteInvoice($invoiceNo)
    {
        $sql = "delete from invoices where invoice_no = ? ";
        $stmt = $this->_db->prepare($sql);
        return $stmt->execute(array($invoiceNo));
    }

    public function getLastId()
    {
        $sql = "select id as id from invoices 
        union select 0 as id order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();

        return $user['id'];
    }

    public function getInvoicesOfOrder($orderId)
    {
        $sql = "select * from invoices where order_id = $orderId and status = 1 order by id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();

        return $invoices;
    }

    // JThayil 22 Feb
    public function getPaymentOfInvoices($orderId)
    {
        $sql = "select * from invoices as i
        left join payments as p on i.id =p.invoice_id
        where i.order_id = $orderId and i.status = 1 order by i.id desc";
        $this->_setSql($sql);
        $invoices = $this->getAll();

        return $invoices;
    }
    // JThayil End
    public function getInvoiceItem($id)
    {
        $sql = "select * from invoice_items where invoice_id = ? ";
        $this->_setSql($sql);
        $items = $this->getAll(array($id));
        if (empty($items)) {
            return false;
        }
        return $items;
    }

    // get invoice items by inv_id and order_item_id

    public function getInvoiceItemm($invoiceId, $orderItemIds = [])
    {
        $sql = "SELECT * FROM invoice_items WHERE invoice_id = ?";

        if (!empty($orderItemIds)) {
            $placeholders = implode(',', array_fill(0, count($orderItemIds), '?'));
            $sql .= " AND order_item_id IN ($placeholders)";
            $params = array_merge([$invoiceId], $orderItemIds);
        } else {
            $params = [$invoiceId];
        }

        $this->_setSql($sql);
        $items = $this->getAll($params);

        if (empty($items)) {
            return false;
        }
        return $items;
    }



    public function getInvoiceItemForCreditNote($id)
    {
        $sql = "
              SELECT 
                invoice_items.*, 
                COALESCE(credit_note_items.qty, invoice_items.qty) AS qty,
                COALESCE(credit_note_items.unit_price, invoice_items.unit_price) AS unit_price,
            COALESCE(credit_note_items.total, invoice_items.total) AS total,
              credit_notes.igst,      
              credit_notes.cgst,      
              credit_notes.sgst,
              credit_notes.credit_note_total,     
              credit_notes.credit_note_no,
              credit_notes.credit_date
            FROM 
                invoice_items
            LEFT JOIN    
                credit_note_items 
            ON 
                invoice_items.id = credit_note_items.invoice_item_id
            LEFT JOIN 
              credit_notes 
           ON credit_note_items.credit_note_id = credit_notes.id
               WHERE 
                 invoice_items.invoice_id = ?";

        $this->_setSql($sql);
        $items = $this->getAll(array($id));

        if (empty($items)) {
            return false;
        }

        return $items;
    }



    public function getCustomerInvoiceList($filter = array())
    {
        $where = ' where I.status = 1';

        $fieldVal = array();
        if (!empty($filter)) {
            foreach ($filter as $key => $val) {
                if (!empty(trim($val))) {

                    if ($key == 'startdate') {
                        $where .= " and I.invoice_date >= ? ";
                        $fieldVal[] = $val;
                    }
                    if ($key == 'enddate') {
                        $where .= " and I.invoice_date <= ? ";
                        $fieldVal[] = $val;
                    }

                    if ($key == 'customer_id') {
                        $where .= " and C.id= ? ";
                        $fieldVal[] = $val;
                    }
                    // ---- add PO filter---- 
                    if ($key == 'po_no') {
                        $where .= " and O.po_no LIKE ? ";
                        $fieldVal[] = '%' . $val . '%';
                    }
                    // ---end----
                }
            }
        }

        $sql = "select * from (select C.name customer_name, I.invoice_no, I.invoice_date, IFNULL(I.invoice_total, 0) invoice_amount, IFNULL(tds_deducted,0) as tds_deducted, IFNULL(P.allocated_amt, 0) recieved_amount, IFNULL((invoice_total - IFNULL(P.allocated_amt, 0)), 0) - IFNULL(tds_deducted,0) balance_amount, I.due_date, I.id invoice_id, O.po_no from invoices I
        left join (select invoice_id, SUM(allocated_amt) allocated_amt,  SUM(tds_deducted) tds_deducted from payments group by invoice_id) P on (P.invoice_id = I.id)
        join customers C ON (I.customer_id = C.id)
        join customer_groups CG on (C.group_id = CG.id)
        join orders O ON (I.order_id = O.id)
        $where ) tmp where tmp.balance_amount > 0
        order by tmp.due_date asc";

        // echo '<pre>'; print_r($sql); exit;

        $this->_setSql($sql);
        $list = $this->getAll($fieldVal);

        if (empty($list)) {
            return false;
        }

        return $list;
    }

    public function getLastRecord()
    {
        $sql = "select id,invoice_no from invoices order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();

        return $user;
    }

    public function check_invoice_validty($val)
    {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "SELECT invoice_no FROM invoice_nos where invoice_no = ? limit 1;";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)) {
            return false;
        }
        return $data;
    }



    public function check_credit_note_validty($val)
    {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "SELECT credit_note_no FROM credit_notes  where credit_note_no = ? limit 1;";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)) {
            return false;
        }
        return $data;
    }


    public function getRecordsByField($field, $val)
    {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select * from invoices where 1=1 and $field = ? and status = 1 limit 1";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)) {
            return false;
        }
        return $data;
    }

    public function proformaFieldRecord($field, $val)
    {
        //$sql = "select * from invoices where 1=1 order by updated_date desc";
        $sql = "select * from proforma_invoices where 1=1 and $field = ? and status = 1 limit 1";
        $this->_setSql($sql);
        $data = $this->getAll(array($val));

        if (empty($data)) {
            return false;
        }
        return $data;
    }
}
