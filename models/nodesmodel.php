<?php

class NodesModel extends Model {
    
    public function nodeList() {
        $sql = "select * from nodes";
        $this->_setSql($sql);
        $nodes = $this->getAll();
        
        if (empty($nodes)){
            return false;
        }
        return $nodes;
    }
    
    public function get($id) {
        $sql = "select * from nodes where id = ? limit 1";
        $this->_setSql($sql);
        $user = $this->getRow(array($id));
        if (empty($user)){
            return false;
        }
        return $user;
    }
    
    
    public function update($id, $updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update nodes set ";
        
        foreach ($fields as $field) {
            $sql .= " $field = ?,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " where id = ? ";
        
        $data = array_values($updateRecord);
        $data[] = $id;
        
        $sth = $this->_db->prepare($sql);
        
        return $sth->execute($data);
    }
    
    public function updateAll($updateRecord) {
        
        $fields = array_keys($updateRecord);
        
        $sql = "update nodes set ";
        
        foreach ($fields as $field) {
            $sql .= " $field = ?,";
        }
        $sql = substr($sql, 0, -1);
        
        $data = array_values($updateRecord);
        
        $sth = $this->_db->prepare($sql);
        
        return $sth->execute($data);
    }
    
    function placeholders($text, $count=0, $separator=","){
        $result = array();
        if($count > 0){
            for($x=0; $x<$count; $x++){
                $result[] = $text;
            }
        }
        return implode($separator, $result);
    }
    
    
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
    
    public function checkByField($field, $value) {
        $sql = "select * from nodes where $field = ? limit 1";
        $this->_setSql($sql);
        $row = $this->getRow(array($value));
        if (empty($row)){
            return false;
        }
        return true;
    }
    
    
}