<?php

class CustomersModel extends Model
{


    public function getList()
    {
        $sql = "select * from customers where 1=1 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)) {
            return false;
        }
        return $user;
    }

    public function getNameList()
    {
        // $sql = "select id, name from customers where 1=1 and status=1";
        $sql = "SELECT c.id, c.name AS customer_name, s.name AS state_name 
            FROM customers c
            JOIN states s ON c.state = s.id
            WHERE 1=1 AND c.status=1";

        $this->_setSql($sql);
        $user = $this->getAll();
        if (empty($user)) {
            return false;
        }
        return $user;  
    }

    public function get($id)
    {
        $sql = "select customers.*, countries.country_name, currencies.symbol from customers 
        left join countries on countries.id=customers.country 
        LEFT JOIN currencies ON currencies.code = customers.for_cur 
        where customers.id = ? limit 1";  
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)) {
            return false;
        }
        return $user;
    }
 
    public function update($id, $updateRecord)
    {

        $fields = array_keys($updateRecord);

        $sql = "update customers set ";

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

    public function save($data)
    {

        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();

        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));

        $sql = "INSERT INTO customers (" . implode(",", $datafields) . ") VALUES " .
            implode(',', $question_marks);


        $stmt = $this->_db->prepare($sql);
        if ($stmt->execute($insert_values)) {
            return $this->_db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getLastId()
    {
        $sql = "select id from customers order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();
        if (empty($user)) {
            return false;
        }
        return $user;
    }


    public function getCustomersByGroup($id)
    {
        // $sql = "select * from customers where group_id = ? ";
        $sql = "SELECT customers.*, s.name AS state_name, cur.symbol
            FROM customers 
            JOIN states s ON customers.state = s.id 
             JOIN currencies cur ON customers.for_cur = cur.code
            WHERE customers.group_id = ?";

        $this->_setSql($sql);
        $user = $this->getAll(array($id));
        if (empty($user)) {
            return false;
        }
        return $user;
    }
}
