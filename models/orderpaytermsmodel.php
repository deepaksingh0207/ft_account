<?php

class OrderPaytermsModel extends Model
{


    public function List()
    {
        $sql = "select * from order_payterms where 1=1 order by updated_date desc";
        $this->_setSql($sql);
        $user = $this->getAll();
        return $user;
    }

    // public function getPaytermByOrderId($id) {
    //     $sql = "select * from order_payterms where order_id=$id";
    //     $this->_setSql($sql);
    //     $user = $this->getAll();

    //     return $user;
    // }  

    public function getPaytermByOrderId($id)
    {
        $sql = "
            SELECT DISTINCT 
                order_payterms.*, 
                currencies.symbol AS currency_symbol
            FROM 
                order_payterms
            INNER JOIN 
                orders ON order_payterms.order_id = orders.id
            INNER JOIN 
                currencies ON orders.currency_code = currencies.code
            WHERE 
                order_payterms.order_id = :order_id";
                
        $this->_setSql($sql);
        $user = $this->getAll(['order_id' => $id]);

        return $user;
    }


    public function get($id)
    {
        $sql = "select * from order_payterms where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));

        return $user;
    }


    public function update($id, $updateRecord)
    {

        $fields = array_keys($updateRecord);

        $sql = "update order_payterms set ";

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

        $sql = "INSERT INTO order_payterms (" . implode(",", $datafields) . ") VALUES " .
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
        $sql = "select id from order_payterms order by id desc limit 1";
        $this->_setSql($sql);
        $user = $this->getrow();

        return $user;
    }
}
