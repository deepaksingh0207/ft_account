<?php

class IncidentsModel extends Model
{
    public function getCustDetails($custId) {
        
        $sql = "SELECT * FROM customers WHERE id = ? order by id desc";
        
        $this->_setSql($sql);
        $customer = $this->getRow(array($custId));
        
        if (empty($customer)) {
            return false;
        }
        
        return $customer;
    }
    
    public function getList($custId = null, $filter = array()) {
        $where = ' WHERE 1=1 ';
        if($custId) {
            $where .= " and customer_id = $custId ";
        }
    
        if(!empty($filter)) {
            foreach($filter as $key => $val) {
                if(!empty($val))  {
                    if($key == 'status') {
                        $key = "C.$key";
                    }
                    
                    if($key == 'lastupdate') {
                        if($val !=0) {
                            if($val == 99) {
                                $where .= " and C.updated_date < SUBDATE(now(), INTERVAL 30 DAY)";
                            } else {
                                $where .= " and C.updated_date > SUBDATE(now(), INTERVAL $val DAY) ";
                            }
                            
                        }
                    } else {
                        $where .= " and $key in (".implode(',', array_filter($val)).") ";
                    }
                }
            }
        }
        
        
        $sql = "SELECT C.*, CU.cust_num,CU.cust_name  FROM complaints C  
        join customers CU on (CU.id = C.customer_id) $where order by updated_date desc";
        
        //echo $sql; exit;
        $this->_setSql($sql);
        $articles = $this->getAll();
    
        if (empty($articles)) {
            return false;
        }
        
        return $articles;
    }

    public function getComplain($id) {
        $sql = "SELECT C.*, CU.cust_name
        FROM
        complaints C
        join customers CU on (CU.id = C.customer_id) 
        WHERE C.id = ?";
        
        $this->_setSql($sql);
        $complainDetails = $this->getRow(array($id));
        
        if (empty($complainDetails)) {
            return false;
        }
    
        return $complainDetails;
    }
    
    public function getComplainReplies($id) {
        $sql = "SELECT *
        FROM
        complaint_replies CR
        WHERE complaint_id = ? order by created_date desc";
        
        $this->_setSql($sql);
        $complainreplies = $this->getAll(array($id));
        
        if (empty($complainreplies)) {
            return false;
        }
        
        return $complainreplies;
    }
    
    public function save($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO complaints (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function saveReply($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO complaint_replies (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update complaints set ";
        
        foreach ($fields as $field) {
            $sql .= " $field = ?,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " where id = ?";
        
        $data = array_values($updateRecord);
        $data[] = $id;
        
        $sth = $this->_db->prepare($sql);
        
        return $sth->execute($data);
    }
}   