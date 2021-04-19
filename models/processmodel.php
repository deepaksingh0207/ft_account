<?php

class ProcessModel extends Model {
    
    public function save($data) {
        
        $insert_values = array();
        $datafields = array_keys($data[0]);
        $question_marks = array();
        foreach($data as $d){
            $question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
            $insert_values = array_merge($insert_values, array_values($d));
        }
        
        $sql = "INSERT INTO nodes (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            $stmt = $this->_db->prepare ($sql);
            return $stmt->execute($insert_values);
    }
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update nodes set ";
        
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
    
    public function nodeList() {
        $params = array('active');
        $sql = "select * from nodes where status = ? and date_format(validity_end, '%Y-%m-%d') >= date_format(now(), '%Y-%m-%d')";
        $this->_setSql($sql);
        $user = $this->getAll($params);
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    
    public function getNodeByIds($params) {
        $question_marks = $this->placeholders('?', sizeof($params));
        $sql = "select * from nodes where id in ( $question_marks ) order by type ";
        $this->_setSql($sql);
        $user = $this->getAll($params);
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    public function saveProcess($data) {
        
        $insert_values = array();
        $datafields = array_keys($data);
        $question_marks = array();
        
        $question_marks[] = '('  . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_merge($insert_values, array_values($data));
        
        $sql = "INSERT INTO processes (" . implode(",", $datafields ) . ") VALUES " .
            implode(',', $question_marks);
            
            $stmt = $this->_db->prepare ($sql);
            if($stmt->execute($insert_values)) {
                return $this->_db->lastInsertId();
            } else {
                return false;
            }
    }
}